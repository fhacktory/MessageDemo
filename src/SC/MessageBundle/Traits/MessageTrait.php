<?php

namespace SC\MessageBundle\Traits;

use Doctrine\Common\Persistence\ObjectManager;
use SC\MessageBundle\Entity\Message;
use SC\MessageBundle\Entity\MessageRepository;
use SC\UserBundle\Entity\User;

trait MessageTrait
{
    /**
     * @param ObjectManager $em
     * @param User $user
     * @param User $contact
     * @param int $page
     * @return array
     */
    private function getMessages($em, $user, $contact, $page = 1)
    {
        /** @var MessageRepository $repository */
        $repository = $em->getRepository('SCMessageBundle:Message');

        $parameters = array(
            'user'      => 'contact',
            'contact'   => 'user',
        );

        $types = array();
        foreach($parameters as $from => $to) {
            $types[] = $repository->findBy(array(
                'from'  => $$from,
                'to'    => $$to,
            ), array(
                'createdAt' => 'ASC'
            ), Message::MESSAGES_PER_PAGE / 2, ($page - 1) * Message::MESSAGES_PER_PAGE / 2);
        }

        $messages = array();

        foreach($types as $type) {
            foreach($type as $message) {
                $messages[] = $message;
            }
        }

        uasort($messages, function($a, $b){
            /**
             * @var Message $a
             * @var Message $b
             */
            return ($a->getCreatedAt() < $b->getCreatedAt()) ? -1 : 1;
        });

        return $messages;
    }
}
