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
 * Description of ProfileUtilityController
 *
 * @author Balika - BTL
 */
class StoreUtilityController extends BaseController {

    protected $engageService;
    protected static $regions;
    protected static $intextSubCategories;
    protected static $intextTopSuppliers;
    protected static $materialsSubCategories;
    protected static $materialsTopSuppliers;
    protected static $equipmentSubCategories;
    protected static $handToolsSubCategories;
    protected static $equipmentTopSuppliers;
    protected static $lightingSubCategories;
    protected static $sparePartsCities;
    protected static $topLevelCategories;
    protected $paginatorService;

    const STORE_FRAGMENT_PREFIX = 'store/fragments/';

    function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

    public function categoriesSidebar($template = 'sidebar.categories', ProductCategory $category = null, Region $region = null, Town $town = null, Supplier $supplier = null, $page = null, $categoryString = null) {
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'topLevelCategories' => $this->getTopLevelCategories(),
            'category' => $category,
            'region' => $region,
            'regions' => $template == 'generic.page.regions' || $template == 'supplier.regions' ? $this->getRegions() : [],
            'town' => $town,
            'supplier' => $supplier,
            'page' => $page,
            'categoryString' => $categoryString,
            'user' => $this->getUser()
        ]);
       // $response->setSharedMaxAge(3600);
        return $response;
    }

    public function midHeader($template = 'mid.header') {
        $form = $this->formService->createSearchForm();
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'topLevelCategories' => $this->getTopLevelCategories(),
            'form' => $form->createView()
        ]);
        $response->setSharedMaxAge(7200);
        return $response;
    }

    private function getTopLevelCategories() {
        if (self::$topLevelCategories == null || empty(self::$topLevelCategories)) {
            self::$topLevelCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findBy(['level' => Constants::TOP_LEVEL_CATEGORY], ['name' => 'ASC']);
        }
        return self::$topLevelCategories;
    }

    private function getRegions() {
        if (self::$regions == null || count(self::$regions) < 1) {
            self::$regions = $this->getDoctrine()->getRepository(EntityConfig::REGION)->findAll();
        }
        return self::$regions;
    }

    public function renderMainMenu($template = "main.menu") {
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'intextSubCategories' => $this->getIntextSubCategories(),
            'intextTopSuppliers' => $this->getIntextTopSuppliers(),
            'materialsSubCategories' => $this->getMaterialsSubCategories(),
            'materialsTopSuppliers' => $this->getMaterialsTopSuppliers(),
            'equipmentSubCategories' => $this->getEquipmentSubCategories(),
            'handToolsSubCategories' => $this->getHandToolsSubCategories(),
            'equipmentTopSuppliers' => $this->getEquipmentTopSuppliers(),
            'lightingSubCategories' => $this->getLightingSubCategories(),
            'sparePartsCities' => $this->getSparePartsCities()
        ]);
        $response->setSharedMaxAge(86400);
        return $response;
    }

    public function getIntextSubCategories() {
        if (self::$intextSubCategories == null || count(self::$intextSubCategories) < 1) {
            self::$intextSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(null, Constants::INTERIOR_EXTERIOR_DECOR_SLUG);
        }
        return self::$intextSubCategories;
    }

    public function getIntextTopSuppliers() {
        if (self::$intextTopSuppliers == null || count(self::$intextTopSuppliers) < 1) {
            $categories = [];
            foreach ($this->getIntextSubCategories() as $category) {
                $categories[] = $category->getId();
            }
            $loggedInUser = $this->getUser();
            self::$intextTopSuppliers = $this->getDoctrine()->getRepository(EntityConfig::TOP_SUPPLIERS)->findCategoryTopVendors($categories, $loggedInUser != null ? $loggedInUser->getUserProfile()->getRegion() : null, $loggedInUser != null ? $loggedInUser->getUserProfile()->getTown() : null);
        }
        return self::$intextTopSuppliers;
    }

    public function getMaterialsSubCategories() {
        if (self::$materialsSubCategories == null || count(self::$materialsSubCategories) < 1) {
            self::$materialsSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(null, Constants::MATERIALS_AND_SUPPLIES_SLUG);
        }
        return self::$materialsSubCategories;
    }

    public function getMaterialsTopSuppliers() {
        if (self::$materialsTopSuppliers == null || count(self::$materialsTopSuppliers) < 1) {
            $categories = [];
            foreach ($this->getMaterialsSubCategories() as $category) {
                $categories[] = $category->getId();
            }
            $loggedInUser = $this->getUser();
            self::$materialsTopSuppliers = $this->getDoctrine()->getRepository(EntityConfig::TOP_SUPPLIERS)->findCategoryTopVendors($categories, $loggedInUser != null ? $loggedInUser->getUserProfile()->getRegion() : null, $loggedInUser != null ? $loggedInUser->getUserProfile()->getTown() : null);
        }
        return self::$materialsTopSuppliers;
    }

    public function getEquipmentSubCategories() {
        if (self::$equipmentSubCategories == null || count(self::$equipmentSubCategories) < 1) {
            self::$equipmentSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(Constants::CONSTRUCTION_EQUIPMENT);
        }
        return self::$equipmentSubCategories;
    }

    public function getHandToolsSubCategories() {
        if (self::$handToolsSubCategories == null || count(self::$handToolsSubCategories) < 1) {
            self::$handToolsSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(Constants::HAND_TOOLS);
        }
        return self::$handToolsSubCategories;
    }

    public function getEquipmentTopSuppliers() {
        if (self::$equipmentTopSuppliers == null || count(self::$equipmentTopSuppliers) < 1) {
            $equipmentAndToolsCategories = array_merge($this->getEquipmentSubCategories(), $this->getHandToolsSubCategories());
            $categories = [];
            foreach ($equipmentAndToolsCategories as $category) {
                $categories[] = $category->getId();
            }
            $loggedInUser = $this->getUser();
            self::$equipmentTopSuppliers = $this->getDoctrine()->getRepository(EntityConfig::TOP_SUPPLIERS)->findCategoryTopVendors($categories, $loggedInUser != null ? $loggedInUser->getUserProfile()->getRegion() : null, $loggedInUser != null ? $loggedInUser->getUserProfile()->getTown() : null);
        }
        return self::$equipmentTopSuppliers;
    }

    public function getLightingSubCategories() {
        if (self::$lightingSubCategories == null || count(self::$lightingSubCategories) < 1) {
            self::$lightingSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(Constants::LIGHTING_AND_SECURITY);
        }
        return self::$lightingSubCategories;
    }

    public function getSparePartsCities() {
        if (self::$sparePartsCities == null || count(self::$sparePartsCities) < 1) {
            self::$sparePartsCities = $this->getDoctrine()->getRepository(EntityConfig::TOWN)->findBy(['isSparePartsHub' => TRUE]);
        }
        return self::$sparePartsCities;
    }

    public function supportedCategories($template = 'supported.categories') {
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'topLevelCategories' => $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findBy(['level' => Constants::TOP_LEVEL_CATEGORY], ['name' => 'ASC']),
            'user' => $this->getUser()
        ]);
        $response->setSharedMaxAge(7200);
        return $response;
    }

    public function topSuppliersByLocation($block = 'locationTopSuppliers', $region = null, $town = null) {
        $locationTopSuppliers = $this->getDoctrine()->getRepository(EntityConfig::TOP_SUPPLIERS)->findLocationTopVendors($region, $town);
        $topSuppliers = count($locationTopSuppliers) > 0 ? $locationTopSuppliers : $this->getDoctrine()->getRepository(EntityConfig::TOP_SUPPLIERS)->findTopSuppliers();
        $template = $this->get('twig')->loadTemplate("store/shared/content.block.html.twig");
        $categoriesBlock = $template->renderBlock($block, [
            'topSuppliers' => $topSuppliers
        ]);
        return new Response($categoriesBlock);
    }

    public function sidebarMostPopularProducts($template = 'most.popular.products', $supplier = null) {
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'popularProducts' => $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMostViewedProducts($supplier)
        ]);
        $response->setSharedMaxAge(600);
        return $response;
    }

    public function recommendedProducts(Request $request, $template = 'recommended.products', $categoryId = null, $regionId = null, $townId = null) {
        $user = $this->getUser();
        $category = $region = $town = null;
        if ($user) {
            $region = $user->getUserProfile()->getRegion();
            $town = $user->getUserProfile()->getTown();
        } else {
            if ($regionId) {
                $region = $this->getDoctrine()->getRepository(EntityConfig::REGION)->find($regionId);
            }
            if ($townId) {
                $region = $this->getDoctrine()->getRepository(EntityConfig::TOWN)->find($townId);
            }
        }
        if ($categoryId) {
            $category = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->find($categoryId);
        }
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->filterByLocationPaginated($category, $region, $town);
        $products = $this->paginatorService->getPaginatedEntity($request, $query, 18);
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'recommendedProducts' => $products
        ]);
        $response->setSharedMaxAge(600);
        return $response;
    }

    /**
     * @Route("ads-campaign/render-index-premium-ads", name="render_index_premium_ads", options={"expose":"true"})
     */
    public function renderIndexPremiumAds() {
        $premiumSlot = $this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::PREMIUM_PRODUCT]);
        $bids = $this->getDoctrine()->getRepository(EntityConfig::OPEN_BID)->findCurrentBids($premiumSlot->getEndingAt());
        $template = $this->get('twig')->loadTemplate("store/shared/content.block.html.twig");
        $topPremiumSlot = $template->renderBlock('indexTopPremiumSlot', ['bids' => array_slice($bids, 0, 2)]);
        $sidePremiumSlot = $template->renderBlock('indexSidePremiumSlot', ['bids' => array_slice($bids, 2, 2)]);
        $pagePremiumSlot = $template->renderBlock('indexPagePremiumSlot', ['bids' => array_slice($bids, 4, 2)]);
        return new JsonResponse(array(
            'topPremiumSlot' => $topPremiumSlot,
            'sidePremiumSlot' => $sidePremiumSlot,
            'pagePremiumSlot' => $pagePremiumSlot
        ));
    }

    public function recentlyViewedProducts(Request $request,$template="recommended.products", $supplierId = null) {
        $supplier = $this->getDoctrine()->getRepository(EntityConfig::SUPPLIER)->find($supplierId);
        $products = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMostViewedProducts($supplier);
         $response = $this->render(self::STORE_FRAGMENT_PREFIX.$template.Constants::TPL_SUFFIX, [
            'recommendedProducts' => $products
        ]);
         $response->setSharedMaxAge(600);
        return $response;
    }

    public function footerQuickLinks($template = 'footer.links') {
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'topLevelCategories' => $this->getTopLevelCategories()
        ]);
        $response->setSharedMaxAge(86400);
        return $response;
    }

    public function weeklyDeals($template= 'weekly.deals', $supplierId = null) {
        $supplier = $this->getDoctrine()->getRepository(EntityConfig::SUPPLIER)->find($supplierId);
        $weeklyDeals = $this->getDoctrine()->getRepository(EntityConfig::WEEKLY_DEAL)->findWeeklyDeals($supplier);        
        $response = $this->render(self::STORE_FRAGMENT_PREFIX.$template.Constants::TPL_SUFFIX, [
            'supplier' => $supplier,
            'weeklyDeals' => $weeklyDeals
        ]);
         //$response->setSharedMaxAge(3600);
        return $response;
    }

    public function renderSuppliersCombo($template = 'suppliers.combo') {
        $suppliers = $this->getDoctrine()->getRepository(EntityConfig::SUPPLIER)->findAll();
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'suppliers' => $suppliers
        ]);
       // $response->setSharedMaxAge(86400);
        return $response;
    }

    public function renderFeaturedCategory($template = 'featured.category') {
        $featuredCategory = $this->getDoctrine()->getRepository(EntityConfig::FEATURED_CATEGORY)->findOneBy(['isCurrent' => TRUE]);
        $products = [];
        $category = null;
        if ($featuredCategory) {
            $products = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findProducts(null, $featuredCategory->getCategory()); //null is supplier
            $category = $featuredCategory->getCategory();
        }
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'products' => $products,
            'category' => $category,
            'featuredCategory' => $featuredCategory
        ]);
        $response->setSharedMaxAge(3600);
        return $response;
    }

    public function renderSpecialFeature($template = 'special.feature') {
        $response = $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
        ]);
        $response->setSharedMaxAge(600);
        return $response;
    }

}
