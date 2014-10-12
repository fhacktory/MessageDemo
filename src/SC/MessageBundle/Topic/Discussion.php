<?php

namespace SC\MessageBundle\Topic;

use Doctrine\Common\Persistence\ObjectManager;
use JDare\ClankBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface as Conn;
use Ratchet\Wamp\Topic;
use SC\MessageBundle\Entity\Message;
use SC\UserBundle\Entity\User;
use SC\UserBundle\Traits\UserTrait;
use Symfony\Bundle\TwigBundle\TwigEngine;

class Discussion implements TopicInterface
{
    use UserTrait;

    /**
     * @var TwigEngine
     */
    private $templating;

    /**
     * @param ObjectManager $em
     * @param TwigEngine $templating
     */
    public function __construct(ObjectManager $em, TwigEngine $templating)
    {
        $this->em           = $em;
        $this->templating   = $templating;
    }

    /**
     * @param Conn $conn
     * @param Topic $topic
     * @return mixed|void
     */
    public function onSubscribe(Conn $conn, $topic)
    {
        try {
            $user = $this->getUser($conn);
            $contactId = $this->getContactIdFromTopic($topic, $user);

            echo sprintf(
                "%d subscribed to %d\n",
                $user->getId(),
                $contactId
            );

            return true;
        } catch(\Exception $e) {
            $conn->close();
            echo $e->getMessage().PHP_EOL;

            return false;
        }
    }

    /**
     * @param Conn $conn
     * @param Topic $topic
     * @return mixed|void
     */
    public function onUnSubscribe(Conn $conn, $topic)
    {
        $user = $this->getUser($conn);

        echo sprintf(
            "%d unsubscribed topic %s\n",
            $user->getId(),
            $topic->getId()
        );
    }

    /**
     * @param Conn $conn
     * @param Topic $topic
     * @param $event
     * @param array $exclude
     * @param array $eligible
     * @return mixed|void
     */
    public function onPublish(Conn $conn, $topic, $event, array $exclude, array $eligible)
    {
        try {
            if(!isset($event['message'])) {
                throw new \Exception('Message required');
            }

            $user = $this->getUser($conn);

            $contactId = $this->getContactIdFromTopic($topic, $user);
            $repository = $this->em->getRepository('SCUserBundle:User');
            $contact = $repository->find($contactId);

            if(!$contact) {
                throw new \Exception('Invalid contact');
            }

            $message = new Message();
            $message
                ->setContent($event['message'])
                ->setFrom($this->getUser($conn))
                ->setTo($contact);

            $this->em->persist($message);
            $this->em->flush();

            $view = $this->templating->render('SCMessageBundle:Message:show.html.twig', array(
                'user'      => $user,
                'message'   => $message,
            ));

            $topic->broadcast(array(
                'from'      => $user->getId(),
                'to'        => $contactId,
                'message'   => $view,
            ));

            echo sprintf(
                'message from %d saved and sent to %d',
                $user->getId(),
                $contactId
            );

            return true;
        } catch(\Exception $e) {
            echo $e->getMessage().PHP_EOL;

            return false;
        }
    }

    /**
     * @param Topic $topic
     * @param User $user
     * @throws \Exception
     * @return int
     */
    private function getContactIdFromTopic($topic, $user)
    {
        $parameters = explode('/', $topic->getId());
        $ids = explode('-', $parameters[1]);

        if (count($ids) !== 2) {
            throw new \Exception(sprintf(
                'Invalid input (%s), connection closed',
                $parameters[1]
            ));
        }

        if (!in_array($user->getId(), $ids)) {
            throw new \Exception(sprintf(
                '%d not in %s, connection closed',
                $user->getId(),
                implode(', ', $ids)
            ));
        }

        $contacts = $user->getContacts();
        $contactId = ($ids[0] == $user->getId())
            ? $ids[1]
            : $ids[0];

        if (!isset($contacts[$contactId])) {
            throw new \Exception(sprintf(
                '%d is not a contact of %d, connection closed',
                $contactId,
                $user->getId()
            ));
        }

        return $contactId;
    }
}
