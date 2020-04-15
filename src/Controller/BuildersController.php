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
 * Description of BuildersController
 *
 * @author Balika 
 */
class BuildersController  extends BaseController{
    const BUILDERS_PAGE_PREFIX = 'builders/';
    protected $paginatorService;
    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

   /**
     * @Route("/builders/list/{slug}", name="find_builders", defaults={"slug":"none"})
    */
    public function findBuilders(Request $request, Region $region=null)
    {
        $category=$town=$subLocation=null;
        $page = $request->query->get('b-page')!=null ? $request->query->get('b-page'): 'artisans';
       // $qryPage = $request->query->get('page');
        if ($request->query->get('category')) {
            $categorySlug = $request->query->get('category');
            $category = $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->findOneBy(['slug' => $categorySlug]);
        }
        if ($request->query->get('town')) {
            $townSlug = $request->query->get('town');
            $town = $this->getDoctrine()->getRepository(EntityConfig::TOWN)->findOneBy(['slug' => $townSlug]);
        }
        $form = $this->createLocationFilter($region, $town, $category,$page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locationFilter = $form->getData();
            $region = $locationFilter->getRegion();
            $category = $form->get('category')->getData();
            $town = $locationFilter->getTown();
            $subLocation = $locationFilter->getSubLocation();
        }
        $query = $this->getDoctrine()->getRepository(EntityConfig::BUILDER)->findBuildersPaginated($page=='artisans' ? Constants::ARTISAN : Constants::PROFESSIONAL, $category,$region,$town,$subLocation);                                  
        $builders = $this->paginatorService->getPaginatedEntity($request,$query, 12); 
        
        $template = self::BUILDERS_PAGE_PREFIX.$page.Constants::TPL_SUFFIX;
        return $this->render('builders/builders.page.html.twig', [
            'page' => $page,
            'region'=>$region,
            'town'=>$town,
            'form'=>$form->createView(),
            'builders'=>$builders,
            'category'=>$category,
            'template'=>$template
        ]);
    }
    private function createLocationFilter($region = null, $town = null, $category = null, $page=null) {
        $profile = new UserProfile();
        $profile->setRegion($region);
        $profile->setTown($town);
        $form = $this->createForm(PortalLocationFilterType::class, $profile, ['category' => null,'page'=>$page]);
        return $form;
    }

}
