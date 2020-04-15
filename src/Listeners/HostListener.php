<?php

namespace App\Listeners;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HostListener
 *
 * @author Balika
 */
use App\Model\AppInterface;
use App\Utils\EntityConfig;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;

class HostListener {

    private $doctrine;
    private $appManager;
    private $baseHost;
    private $router;

    const DEFAULT_SUB_DOMAIN = 'www';
    const HTTP_PREFIX = 'http://';
    const HOME_URI = "/";
    const HOME_ROUTE = "home";
    const HUBERNIZE_SECURE_PATH = "/apps/";

    public function __construct(Doctrine $doctrine, AppInterface $appManager, RouterInterface $router, $baseHost) {
        $this->doctrine = $doctrine;
        $this->appManager = $appManager;
        $this->baseHost = $baseHost;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event) {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        $currentHost = $request->getHttpHost();
        $subdomain = str_replace('.' . $this->baseHost, '', $currentHost);
        $currentRoute = $request->attributes->get('_route');
        if ($this->baseHost == $subdomain ||  ($subdomain == self::DEFAULT_SUB_DOMAIN && !$this->appManager->isHubernizeApp($request))) {//No subdomain or subdomain is 'www'           
            return;
        }
        if ($subdomain == self::DEFAULT_SUB_DOMAIN && $this->appManager->isHubernizeApp($request)) {
            $event->setResponse(new RedirectResponse($this->router->generate('home')));
            return;
        }
        if ($this->doctrine->getRepository(EntityConfig::COMPANY)->findOneBy(array('domain' => $subdomain))) {//valid company domain
            $this->appManager->setCurrentDomain($subdomain);
        } else {//subdomain exist but is not associated with a company
            throw new NotFoundHttpException(sprintf(
                    'No site for host "%s", subdomain "%s"', $this->baseHost, $subdomain
            ));
        }
    }

    /** elseif (!$this->appManager->isHubernizeApp($request)) {
      $url = str_replace($subdomain . '.', self::HTTP_PREFIX . self::DEFAULT_SUB_DOMAIN . '.', $currentHost . $request->getRequestUri());
      $event->setResponse(new RedirectResponse($url));
      return;
      } * */
}
