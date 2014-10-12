<?php

namespace SC\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MessageController extends Controller
{
    public function listAction()
    {
        $user = $this->getUser();

        if(!$user) {
            throw new AccessDeniedException();
        }

        $contacts = $user->getContacts();

        return $this->render(
            'SCMessageBundle:Message:list.html.twig',
            array(
                'user' => $user,
                'contacts' => $contacts,
            )
        );
    }

    public function popupsAction()
    {
        $user = $this->getUser();

        if(!$user) {
            throw new AccessDeniedException();
        }

        return $this->render(
            'SCMessageBundle:Message:popups.html.twig',
            array(

            )
        );
    }
}
