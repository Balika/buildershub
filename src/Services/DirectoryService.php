<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Model\DirectoryInterface;
use App\Utils\EntityConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Description of FirmProfileService
 *
 * @author Balika
 */
class DirectoryService implements DirectoryInterface {

    /**
     * @var PersistenceService 
     */
    protected $persistenceService;

    /**
     * @var SessionInterface 
     */
    protected $sessionManager;

    /**
     *
     * @var KnpPaginatorWrapper 
     */
    protected $paginatorService;

    /**
     *
     * @var FormService 
     */
    protected $formService;

    function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, SessionInterface $session) {
        $this->persistenceService = $persistenceService;
        $this->paginatorService = $paginator;
        $this->formService = $formService;
        $this->sessionManager = $session;
    }

    public function listFirms(Request $request, $page, $region) {
        $category = $town = $subLocation = null;
        if ($request->query->get('category')) {
            $categorySlug = $request->query->get('category');
            $category = $this->persistenceService->getRepository(EntityConfig::CATEGORY)->findOneBy(['slug' => $categorySlug]);
        }
        if ($request->query->get('town')) {
            $townSlug = $request->query->get('town');
            $town = $this->persistenceService->getRepository(EntityConfig::TOWN)->findOneBy(['slug' => $townSlug]);
        }
        $form = $this->formService->createLocationFilter($region, $town, $category, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locationFilter = $form->getData();
            $region = $locationFilter->getRegion();
            //$category = $form->get('category')->getData();
            $town = $locationFilter->getBusinessLocation();
            $subLocation = $locationFilter->getSubLocation();
        }
        if($region == null){
            $region = $this->persistenceService->getRepository(EntityConfig::REGION)->findOneBy(['name'=>$this->sessionManager->get('user_region')]);
        }
        if($town == null){
            $town = $this->persistenceService->getRepository(EntityConfig::TOWN)->findOneBy(['name'=>$this->sessionManager->get('user_city')]);
        }
        $query = $this->persistenceService->getRepository($page == 'suppliers' ? EntityConfig::SUPPLIER : EntityConfig::FIRM)->filterByLocationPaginated($region, $town, $subLocation);
        $firms = $this->paginatorService->getPaginatedEntity($request, $query, 12);
        return [
            'page' => $page,
            'region' => $region,
            'town' => $town,
            'form' => $form->createView(),
            'firms' => $firms,
            'category' => $category           
        ];
    }

}
