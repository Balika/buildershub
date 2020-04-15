<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Listeners;

use App\Utils\Constants;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use function GuzzleHttp\json_decode;

/**
 * Description of ClientRequestListener
 *
 * @author Balika
 */
class ClientRequestListener {

    private $accessKey;
    private $doctrine;
    private $sessionManager;

    public function __construct(SessionInterface $session, Doctrine $doctrine, RouterInterface $router, $accessKey) {
        $this->doctrine = $doctrine;
        $this->accessKey = $accessKey;
        $this->sessionManager = $session;
    }

    public function onKernelRequest(GetResponseEvent $event) {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
        if ($this->sessionManager->get('user_region') !== null) {
            $clientIP = $event->getRequest()->getClientIp();
            $json_encoded = file_get_contents(Constants::IP_STACK_BASE_URL . $clientIP . '?access_key=' . $this->accessKey);
            $json = json_decode($json_encoded, true);
            $this->sessionManager->set('user_region', $json['region_name']);
            $this->sessionManager->set('user_city', $json['region_name']);
        }

        /**
         * 1. ToDo Set User Current Location if user is logged in
         * 2. Set session value for user location for guest users
         */
    }

}
