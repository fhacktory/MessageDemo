<?php

namespace SC\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ContactController extends Controller
{
    public function listAction()
    {
        $user = $this->getUser();

        if(!$user) {
            throw new AccessDeniedException();
        }

        $contacts = $user->getContacts();

        return $this->render(
            'SCMessageBundle:Contact:list.html.twig',
            array(
                'contacts' => $contacts,
            )
        );
    }
}
