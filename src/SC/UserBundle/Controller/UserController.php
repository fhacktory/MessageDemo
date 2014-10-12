<?php

namespace SC\UserBundle\Controller;

use SC\UserBundle\Entity\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends Controller
{
    /**
     * @Route("/users", name="sc_contact_list")
     * @Template()
     */
    public function listAction()
    {
        $user = $this->getUser();

        if(!$user) {
            throw new AccessDeniedException();
        }

        /** @var UserRepository $repository */
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SCUserBundle:User');

        $users = $repository->findAll();
        $contacts = $this->getUser()->getContacts();

        return array(
            'users'     => $users,
            'contacts'  => $contacts,
        );
    }
}
