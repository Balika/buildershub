<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Services\FormService;
use App\Services\PersistenceService;
use App\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of BaseController
 *
 * @author Balika BTL
 */
class BaseController extends AbstractController {

    /**
     * @var PersistenceService 
     */
    protected $persistenceService;

    /**
     * @var FormService 
     */
    protected $formService;

    /**
     * @var Slugger 
     */
    protected $slugger;

    function __construct(FormService $formService, PersistenceService $persistenceService, Slugger $slugger) {
        $this->persistenceService = $persistenceService;
        $this->formService = $formService;
        $this->slugger = $slugger;
    }

    public function redirectToReferer(Request $request) {
        return $this->redirect(
                                $request
                                ->headers
                                ->get('referer')
        );
    }
    public function getCurrentRoute(Request $request) {
       return $request->get('_route');
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
