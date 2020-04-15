<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\Hubernize;

use App\Services\AppManager;
use App\Utils\EntityConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of SuppliersController
 *
 * @author Balika Edmond
 */
class SuppliersController extends HubernizeBaseController {
    /**
     * @Route("apps/suppliers/list", 
     * name="hubernize_view_suppliers",
     * )
     */
    public function listSuppliers(AppManager $appManager, Request $request) {
        $subdomain = null;//$appManager->getCurrentDomain();
        $company = null;//$this->getDoctrine()->getRepository(EntityConfig::COMPANY)->findOneBy(['domain' => $subdomain]); //hubernize_dashboard
        return $this->render('hubernize/suppliers/list.suppliers.html.twig', [
                    'company' => $company,
                    'domain' => $subdomain
        ]);
    }

}
