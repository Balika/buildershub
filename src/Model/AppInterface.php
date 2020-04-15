<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Entity\Company;
use App\Entity\HubApp;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Balika
 */
interface AppInterface {

    public function getCurrentDomain();

    public function setCurrentDomain($currentDomain);

    public function getApps($isHubernized = TRUE, $onlyActive = TRUE);

    public function getAppMenus(HubApp $app);

    public function setRouterContext($domain);

    public function getHubernizeHome($domain);

    public function getHubernizeHost($domain);

    public function isHubernizeApp(Request $request);

    public function getApp($appCode);

    public function subscribeToApp(Company $company, HubApp $app, User $user);

    public function isSubscribedToApp(Company $company, HubApp $app);
}
