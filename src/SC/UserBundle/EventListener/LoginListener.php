<?php

namespace SC\UserBundle\EventListener;

use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class LoginListener implements EventSubscriberInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @param Session $session
     * @param SecurityContext $securityContext
     */
    public function __construct(Session $session, SecurityContext $securityContext)
    {
        $this->session = $session;
        $this->securityContext = $securityContext;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN  => 'onImplicitLogin',
            SecurityEvents::INTERACTIVE_LOGIN       => 'onSecurityInteractiveLogin',
        );
    }

    /**
     * @param UserEvent $event
     */
    public function onImplicitLogin(UserEvent $event)
    {
        $this->setSession($event->getUser());
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->setSession($event->getAuthenticationToken()->getUser());
    }

    /**
     * @param UserInterface $user
     */
    private function setSession($user)
    {
        $this->session->set('user', $user);
    }
}
