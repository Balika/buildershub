<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\ProductCategory;
use App\Entity\Region;
use App\Entity\Supplier;
use App\Entity\Town;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PortalUtilityController
 *
 * @author Balika - BTL
 */
class PortalUtilityController extends BaseController {

    protected $engageService;
    protected static $regions;
    protected static $materialsCategories;
    protected static $equipmentCategories;
    protected static $artisanCategories;
    protected static $professionalCategories;
    protected static $topLevelCategories;
    protected $paginatorService;

    const PORTAL_FRAGMENTS_PREFIX = "portal/fragments/";

    function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

   

    private function getTopLevelCategories() {
        if (self::$topLevelCategories == null || empty(self::$topLevelCategories)) {
            self::$topLevelCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findBy(['level' => Constants::TOP_LEVEL_CATEGORY], ['name' => 'ASC']);
        }
        return self::$topLevelCategories;
    }


    public function renderMenuLinks($template = "category.menu.links") {
        $response = $this->render(self::PORTAL_FRAGMENTS_PREFIX . $template . Constants::TPL_SUFFIX, $this->getMenuLinks($template));
        $response->setSharedMaxAge(604800); //One week
        return $response;
    }

    public function getMenuLinks($template) {
        $params = [];
        switch ($template) {
            case 'category.menu.links':
                $params = [
                    'materialCategories' => $this->getMaterialCategories(),
                    'equipmentCategories' => $this->getEquipmentCategories()
                ];
                break;
            case 'expertise.menu.links':
                $params = [
                    'artisanCategories' => $this->getArtisanCategories(),
                    'professionalCategories' => $this->getProfessionalCategories()
                ];
        }
        return $params;
    }

    public function renderHomeFragments($template = 'latest.news.intro') {
        $response = $this->render(self::PORTAL_FRAGMENTS_PREFIX . $template . Constants::TPL_SUFFIX, $this->getHomeFragementsParams($template));
        $response->setSharedMaxAge(600);
        return $response;
    }

    private function getHomeFragementsParams($template) {
        $params = [];
        switch ($template) {
            case 'latest.news.intro':
            case 'footer.posts':
                $params = [
                    'posts' => $this->getDoctrine()->getRepository(EntityConfig::BLOG_POST)->findAll()
                ];
                break;
            case 'top.suppliers.intro':
                $params = [
                    'topSuppliers' => $this->getDoctrine()->getRepository(EntityConfig::SUPPLIER)->findAll()
                ];
                break;
            case 'featured.builders':
                $params = [
                    'builders' => $this->getDoctrine()->getRepository(EntityConfig::BUILDER)->findBuilders()
                ];
                break;
        }
        return $params;
    }

    public function renderRegionsSidebar($page, $regionId = 0, $template='regions.sidebar') {
        $region = null;
        if ($regionId > 0) {
            $region = $this->getDoctrine()->getRepository(EntityConfig::REGION)->find($regionId);
        }
        $response = $this->render(self::PORTAL_FRAGMENTS_PREFIX.$template.Constants::TPL_SUFFIX, [
            'regions' => $this->getRegions(),
            'page' => $page,
            'selectedRegion' => $region
        ]);
        $response->setSharedMaxAge(3600);
        return $response;
    }

    public function getMaterialCategories() {
        if (self::$materialsCategories == null || count(self::$materialsCategories) < 1) {
            self::$materialsCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findMaterialsTopLevelCategories();
        }
        return self::$materialsCategories;
    }

    public function getEquipmentCategories() {
        if (self::$equipmentCategories == null || count(self::$equipmentCategories) < 1) {
            self::$equipmentCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findEquipmentTopLevelCategories();
        }
        return self::$equipmentCategories;
    }

    public function getArtisanCategories() {
        if (self::$artisanCategories == null || count(self::$artisanCategories) < 1) {
            self::$artisanCategories = $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->findByType(Constants::ARTISAN);
        }
        return self::$artisanCategories;
    }

    public function getProfessionalCategories() {
        if (self::$professionalCategories == null || count(self::$professionalCategories) < 1) {
            self::$professionalCategories = $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->findByType(Constants::CONSULTANT);
        }
        return self::$professionalCategories;
    }

    private function getRegions() {
        if (self::$regions == null || count(self::$regions) < 1) {
            self::$regions = $this->getDoctrine()->getRepository(EntityConfig::REGION)->findAll();
        }
        return self::$regions;
    }

}
