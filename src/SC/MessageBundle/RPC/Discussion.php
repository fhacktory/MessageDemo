<?php

namespace SC\MessageBundle\RPC;

use Doctrine\Common\Persistence\ObjectManager;
use Ratchet\ConnectionInterface as Conn;
use SC\MessageBundle\Traits\MessageTrait;
use SC\UserBundle\Entity\User;
use SC\UserBundle\Traits\UserTrait;
use Symfony\Bundle\TwigBundle\TwigEngine;

class Discussion
{
    use UserTrait, MessageTrait;

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
     * @param \Ratchet\ConnectionInterface $conn
     * @param array $params
     * @return bool
     */
    public function page(Conn $conn, $params)
    {
        try {
            // Utilisateur connecté
            $user = $this->getUser($conn);

            // Contact sélectionné
            $repository = $this->em->getRepository('SCUserBundle:User');

            if(!isset($params['id'])) {
                throw new \Exception('Parameter "id" is required');
            }

            $contact = $repository->find($params['id']);

            if(!$contact) {
                throw new \Exception('Invalid parameter "id"');
            }

            // Page
            if(!$params['page']) {
                throw new \Exception('Parameter "page" required');
            }

            // Messages
            return $this->templating->render('SCMessageBundle:Message:discussion.html.twig', array(
                'user'      => $user,
                'messages'  => $this->getMessages(
                    $this->em,
                    $this->getUser($conn),
                    $contact,
                    $params['page']
                ),
            ));
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
