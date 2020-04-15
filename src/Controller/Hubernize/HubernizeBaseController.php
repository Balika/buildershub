<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\Hubernize;

use App\Model\AppInterface;
use App\Model\HubernizeFormInterface;
use App\Services\AppManager;
use App\Utils\EntityConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of HubernizeBaseController
 *
 * @author Balika BTL
 */
class HubernizeBaseController extends AbstractController {

    /**
     * @var AppManager 
     */
    protected $appManager;

    /**
     * @var HubernizeFormInterface 
     */
    protected $formService;
    protected static $company;

    public function __construct(AppInterface $appManager, HubernizeFormInterface $formService) {
        $this->appManager = $appManager;
        $this->formService = $formService;
    }

    protected function getCompany() {
        if (self::$company == null || self::$company->getDomain() != $this->getDomain() ) {
            self::$company = $this->getDoctrine()->getRepository(EntityConfig::COMPANY)->findOneBy(['domain' => $this->getDomain()]); //hubernize_dashboard
        }
        return self::$company;
    }

    protected function getDomain() {
        return $this->appManager->getCurrentDomain();
    }

    protected function getFragmentAsJSON($template, $params) {
        $engine = $this->get('templating');
        $content = $engine->render($template, $params);
        return new JsonResponse(['response' => $content]);
    }

    protected function getFragmentContent($template, $params, $age = 600) {
        $response = $this->render($template, $params);
        $response->setSharedMaxAge($age);
        return $response;
    }

}
