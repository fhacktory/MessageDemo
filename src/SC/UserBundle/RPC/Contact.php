<?php

namespace SC\UserBundle\RPC;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\Debug;
use Ratchet\ConnectionInterface as Conn;
use SC\UserBundle\Entity\User;

class Contact
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
     * @param \Ratchet\ConnectionInterface $conn
     * @param array $params
     * @return bool
     */
    public function toggle(Conn $conn, $params)
    {
        try {
            // Utilisateur connecté
            /** @var User $user */
            $user = $this->em->merge($conn->Session->get('user'));

            // Contact sélectionné
            $repository = $this->em->getRepository('SCUserBundle:User');

            if(!isset($params['id'])) {
                throw new \Exception('Parameter "id" is required');
            }

            $contact = $repository->find($params['id']);

            if(!$contact) {
                throw new \Exception('Invalid parameter "id"');
            }

            // Enregistrement
            if(!isset($params['isContact'])) {
                throw new \Exception('Parameter "isContact" is required');
            }

            if($params['isContact']) {
                $user->removeMyContact($contact);
                echo sprintf("%d removed %d\n", $user->getId(), $contact->getId());
            }

            else if(!$user->getMyContacts()->contains($contact)) {
                $user->addMyContact($contact);
                echo sprintf("%d added %d\n", $user->getId(), $contact->getId());
            }

            $this->em->persist($user);
            $this->em->flush();

            return true;
        } catch(\Exception $e) {
            echo sprintf(
                "%s in file %s on line %d\n",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );

            return false;
        }
    }
}
