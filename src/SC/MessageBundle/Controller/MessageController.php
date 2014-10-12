<?php

namespace SC\MessageBundle\Controller;

use SC\MessageBundle\Traits\MessageTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MessageController extends Controller
{
    use MessageTrait;

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

    public function discussionAction($contact)
    {
        return $this->render('SCMessageBundle:Message:discussion.html.twig', array(
            'user'      => $this->getUser(),
            'messages'  => $this->getMessages(
                $this->getDoctrine()->getManager(),
                $this->getUser(),
                $contact
            ),
        ));
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
