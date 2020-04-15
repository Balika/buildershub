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
 * Description of BlogController
 *
 * @author Balika Edmond
 */
class PortfolioController extends HubernizeBaseController {
    /**
     * @Route("apps/projects-portfolio/list", 
     * name="hubernize_list_projects",
     * )
     */
    public function listProjects(AppManager $appManager, Request $request) {
        $subdomain = $appManager->getCurrentDomain();
        $company = $this->getDoctrine()->getRepository(EntityConfig::COMPANY)->findOneBy(['domain' => $subdomain]); //hubernize_dashboard
        return $this->render('hubernize/portfolio/list.projects.html.twig', [
                    'company' => $company,
                    'domain' => $subdomain
        ]);
    }

}
