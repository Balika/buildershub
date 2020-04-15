<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileUtilityController
 *
 * @author Balika - BTL
 */
class EstateUtilityController extends BaseController {

    protected $engageService;
    protected $paginatorService;

    function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

    public function renderEstateMainMenu(Request $request) {
        $template = $this->get('twig')->loadTemplate("store/estates/estate.content.block.html.twig");
        $categoriesBlock = $template->renderBlock('estateMainMenu', [
        ]);
        return new Response($categoriesBlock);
    }

    public function renderMidHeader($block = 'midHeader') {
        $template = $this->get('twig')->loadTemplate("store/estates/estate.content.block.html.twig");
        $categoriesBlock = $template->renderBlock($block, [
        ]);
        return new Response($categoriesBlock);
    }

    public function renderPropertyFilterForm($block = 'propertyFilterForm', $page = null) {
        $form = $this->formService->createPropertyFilterForm();
        $template = $this->get('twig')->loadTemplate("store/estates/estate.content.block.html.twig");
        $categoriesBlock = $template->renderBlock($block, [
            'filterForm' => $form->createView(),
            'page' => $page
        ]);
        return new Response($categoriesBlock);
    }
    public function renderMostViewedProperties($block = 'mostViewedProperties') {    
         $properties = $this->getDoctrine()->getRepository(EntityConfig::PROPERTY)->findMostViewedProperties();
        $template = $this->get('twig')->loadTemplate("store/estates/estate.content.block.html.twig");
        $categoriesBlock = $template->renderBlock($block, [
            'mostViewed' => $properties,
            
        ]);
        return new Response($categoriesBlock);
    }

}
