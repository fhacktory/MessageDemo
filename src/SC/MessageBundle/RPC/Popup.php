<?php

namespace SC\MessageBundle\RPC;

use Ratchet\ConnectionInterface as Conn;
use SC\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\TwigBundle\TwigEngine;

class Popup
{
    /**
     * @var ObjectManager
     */
    private $em;

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
        $this->em = $em;
        $this->templating = $templating;
    }

    /**
     * @param \Ratchet\ConnectionInterface $conn
     * @param array $params
     * @return bool
     */
    public function open(Conn $conn, $params)
    {
        try {
            // Contact sélectionné
            $repository = $this->em->getRepository('SCUserBundle:User');

            if(!isset($params['id'])) {
                throw new \Exception('Parameter "id" is required');
            }

            $contact = $repository->find($params['id']);

            if(!$contact) {
                throw new \Exception('Invalid parameter "id"');
            }

            $view = $this->templating->render(
                'SCMessageBundle:Message:popup.html.twig',
                array('contact' => $contact)
            );

            return $view;
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
