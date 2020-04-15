<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\Hubernize\HubernizeBaseController;
use App\Entity\Company;
use App\Model\AppInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AppsController
 *
 * @author Balika Edmond
 */
class AppsController extends HubernizeBaseController {
    
    
    /**
     *@Route("/hubernize/modules", name="list_apps")
     */
    public function index(Request $request) {        
        return $this->render('apps.html.twig', [
                'apps'=> $this->appManager->getApps()    
        ]);
    }
     /**
     * @Route("/module-subscription/equipment/{slug}", name="equipment_module_subscription")
     */
    public function subscribeToEquipmentModule(Company $company, Request $request, AppInterface $appManager) {
        $app = $appManager->getApp('EquiPack');
        $isSubscribed = $appManager->isSubscribedToApp($company, $app);               
        if(!$isSubscribed){
            $appManager->subscribeToApp($company, $app, $this->getUser());
            $isSubscribed = TRUE;
        }
        return $this->redirectToRoute('rental_firm_registration', ['slug'=>$company->getSlug(),'is-equipment-module-subscribed'=>$isSubscribed]);
    }
}
