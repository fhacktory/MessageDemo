<?php

namespace SC\UserBundle\Topic;

use Doctrine\Common\Persistence\ObjectManager;
use JDare\ClankBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface as Conn;
use Ratchet\Wamp\Topic;
use SC\UserBundle\Entity\User;

class Connection implements TopicInterface
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Conn $conn
     * @param Topic $topic
     * @return mixed|void
     */
    public function onSubscribe(Conn $conn, $topic)
    {
        $user = $this->getUser($conn);
        $user->setOnline(true);

        $this->em->persist($user);
        $this->em->flush();

        $this->broadcast($topic, $user);
    }

    /**
     * @param Conn $conn
     * @param Topic $topic
     * @return mixed|void
     */
    public function onUnSubscribe(Conn $conn, $topic)
    {
        $user = $this->getUser($conn);
        $user->setOnline(false);

        $this->em->persist($user);
        $this->em->flush();

        $this->broadcast($topic, $user);
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
        $this->onUnSubscribe($conn, $topic);
    }

    /**
     * @param Topic $topic
     * @param User $user
     */
    private function broadcast($topic, $user)
    {
        $topic->broadcast(array(
            'id'        => $user->getId(),
            'online'    => $user->isOnline(),
        ));
    }

    /**
     * @param Conn $conn
     * @return User
     */
    private function getUser($conn)
    {
        $user = $this->em->merge(
            $conn->Session->get('user')
        );

        $this->em->refresh($user);

        return $user;
    }
}
