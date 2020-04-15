<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Region;
use App\Entity\UserProfile;
use App\Form\Type\PortalLocationFilterType;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of SearchController
 *
 * @author Balika 
 */
class SearchController extends BaseController {

    const BUILDERS_PAGE_PREFIX = 'builders/';

    protected $paginatorService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

    /**
     * @Route("/store/search", name="search_store")
     */
    public function searchStore(Request $request) {
        $form = $this->formService->createSearchForm();
        $category = null;
        $form->handleRequest($request);
        $searchTerm = "";
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $searchTerm = $formData['searchTerm'];
            $categoryId = intval($request->request->get('categoryId'));
            if ($categoryId > 0) {
                $category = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->find($categoryId);
            }
        }
        $region=$town=null;
        $locationFilterForm = $this->formService->createLocationFilter();
        $locationFilterForm->handleRequest($request);
        if ($locationFilterForm->isSubmitted() && $locationFilterForm->isValid()) {
            $locationFilter = $locationFilterForm->getData();
            $region = $locationFilter->getRegion();
            $category = $locationFilterForm->get('category')->getData();
            $town = $locationFilter->getBusinessLocation();
        }

        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->searchProductsPaginated($searchTerm, $category);
        $products = $this->paginatorService->getPaginatedEntity($request, $query, 12);
        return $this->render('store/search.results.html.twig', [
                    'searchTerm' => $searchTerm,
                    'products' => $products,
                    'region' => $region,
                    'town' => $town,
                    'form' => $locationFilterForm->createView(),
                    'category' => $category
        ]);
    }

}
