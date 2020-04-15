<?php

namespace App\Services;

use App\Entity\AppSubscription;
use App\Entity\Company;
use App\Entity\HubApp;
use App\Entity\User;
use App\Model\AppInterface;
use App\Utils\EntityConfig;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppManager
 *
 * @author Balika
 */
class AppManager implements AppInterface {

    private $currentDomain;
    private $doctrine;
    protected $router;
    private $baseHost;

    const HUBERNIZE_SECURE_PATH = "/apps/";
    const HUBERNIZE_ROUTE = "hubernize_";
    const HTTP = "http://";
    const HTTPS = "https://";

    public function __construct(Doctrine $doctrine, RouterInterface $router, $baseHost) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->baseHost = $baseHost;
    }

    public function getCurrentDomain() {
        return $this->currentDomain;
    }

    public function setCurrentDomain($currentDomain) {
        $this->currentDomain = $currentDomain;
    }

    public function getApps($isHubernized = TRUE, $onlyActive = TRUE) {
        $criteria = $onlyActive ? ['isEnabled' => $onlyActive, 'isHubernized' => $isHubernized] : ['isHubernized' => $isHubernized];
        return $this->doctrine->getRepository(EntityConfig::HUB_APP)->findBy($criteria, ['rank' => 'ASC']);
    }
    public function getApp($appCode) {       
        return $this->doctrine->getRepository(EntityConfig::HUB_APP)->findOneBy(['code'=>$appCode]);
    }

    public function getAppMenus(HubApp $app) {
        return $this->doctrine->getRepository(EntityConfig::APP_MENU_ITEM)->findBy(['app' => $app]);
    }

    public function setRouterContext($domain) {
        $context = $this->router->getContext();
        $context->setHost($domain . '.' . $this->baseHost);
        $context->setScheme('https');
    }

    public function getHubernizeHome($domain) {
        return self::HTTP . $domain . '.' . $this->baseHost . '/apps/dashboard';
    }

    public function getHubernizeHost($domain) {
        return self::HTTP . $domain . '.' . $this->baseHost . self::HUBERNIZE_SECURE_PATH;
    }

    public function isHubernizeApp(Request $request) {
        $currentRoute = $request->attributes->get('_route');
        return (strpos($currentRoute, self::HUBERNIZE_ROUTE) !== FALSE);
        /**  if (!strpos($request->getUri(), self::HUBERNIZE_SECURE_PATH) !== FALSE) {
          $url = str_replace($subdomain . '.', self::HTTP_PREFIX . self::DEFAULT_SUB_DOMAIN . '.', $currentHost . $request->getRequestUri());
          $event->setResponse(new RedirectResponse($url));
          return;
          } */
    }
    public function subscribeToApp(Company $company, HubApp $app, User $user) {
        $subscription = new AppSubscription($app, $company, $user);
        $this->doctrine->getManager()->persist($subscription);
        $this->doctrine->getManager()->flush();
    }
    public function isSubscribedToApp(Company $company, HubApp $app) {      
       return $this->doctrine->getRepository(EntityConfig::APP_SUBSCRIPTION)->findOneBy(['company'=>$company, 'app'=>$app]) != NULL ? TRUE : FALSE ;
    }
}
