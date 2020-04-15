<?php
namespace App\Controller\Hubernize;

use App\Controller\Hubernize\HubernizeBaseController;
use App\Utils\EntityConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of BlogController
 *
 * @author Balika Edmond
 *
 * @Route("apps/")
 */
class HubernizeController extends HubernizeBaseController {   
    /**
     * @Route("dashboard", 
     * name="hubernize_dashboard"
     * )
     */
    public function dashboard(Request $request) {
        $subdomain = $this->appManager->getCurrentDomain();       
        $company = $this->getDoctrine()->getRepository(EntityConfig::COMPANY)->findOneBy(['domain' => $subdomain]); //hubernize_dashboard
        return $this->render('hubernize/hubernize.dashboard.html.twig', [
                    'company' => $company,  
                    'domain' => $subdomain
        ]);
    }
    

}
