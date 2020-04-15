<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SessionIdleHandler {

    protected $session;
    protected $tokenStorage;
    protected $router;
    protected $maxIdleTime;

    const API = 'api';
    const LOGIN_ROUTE='security_login_form';
    const SECURE_URL_PREFIX='admin';

    public function __construct(SessionInterface $session, TokenStorageInterface $tokenStorage, RouterInterface $router, $maxIdleTime = 0) {
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->maxIdleTime = $maxIdleTime;
    }
/**
    public function onKernelRequest(GetResponseEvent $event) {       
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        $uri = $request->getRequestUri();
        $timeOut = "";
        $currentRoute = $event->getRequest()->attributes->get('_route');
        $isSecureUri = strpos($uri, self::SECURE_URL_PREFIX);

        if ($this->maxIdleTime > 0 && $isSecureUri) {
            $lapse = time() - $this->session->getMetadataBag()->getLastUsed();
            if ($lapse > $this->maxIdleTime && $currentRoute!=self::LOGIN_ROUTE) {
                $timeOut = 'You have been logged out due to inactivity.';
                $this->session->invalidate();
                $this->tokenStorage->setToken(null);
                $event->setResponse(new RedirectResponse($this->router->generate('security_login_form', array('requestedUrl' => $uri, 'timeOut' => $timeOut))));
            }
        }        
    }
*/
    
}
