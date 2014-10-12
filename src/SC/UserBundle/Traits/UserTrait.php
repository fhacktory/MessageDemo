<?php

namespace SC\UserBundle\Traits;

use Doctrine\Common\Persistence\ObjectManager;
use Ratchet\ConnectionInterface;
use SC\UserBundle\Entity\User;

trait UserTrait
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
     * @param ConnectionInterface $conn
     * @return User
     */
    private function getUser(ConnectionInterface $conn)
    {
        $user = $this->em->merge(
            $conn->Session->get('user')
        );

        $this->em->refresh($user);

        return $user;
    }
}
