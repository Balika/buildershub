<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Region;
use App\Entity\Supplier;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\HubUtil;
use App\Utils\Slugger;
use App\Utils\StorePages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of IndexController
 *
 * @author Balika Edmond
 */
class StoreController extends BaseController {

    const SUPPLIER_STORE_TEMPLATE_PREFIX = 'store/supplier/';
    const STORE_GENERIC_PREFIX = 'store/pages/';
    const PAGE_SIZE = 12;
    const ADD_TO_CART = 'add';
    const REMOVE_FROM_CART = 'remove';
    const UPDATE_CART = 'update';
    const TAX_RATE = 17.5;

    protected $paginatorService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

    /**
     * @Route("store/index", name="store_index")   
     */
    public function index(Request $request) {
        return $this->render('store/index.html.twig', $this->loadIndexParams($request));
    }
    /**
     * @Route("store", name="store_index_redirect")   
     */
    public function indexRedirect(Request $request) {
        return $this->redirectToRoute('store_index');
    }

    private function loadIndexParams($request, $category = null) {
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findPaginatedProducts();
        $products = $this->paginatorService->getPaginatedEntity($request, $query);
        $topSuppliers = $this->getDoctrine()->getRepository(EntityConfig::SUPPLIER)->findAll();
        return [
            'products' => $products,
            'topSuppliers' => $topSuppliers,
            'featured' => $this->getFeaturedProducts(),
            'promotedProducts' => $this->getPromotedProducts(),
            'newArrivals' => $this->getNewProducts(),
            'category' => $category != null ? $category : $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findOneBy(['level' => Constants::TOP_LEVEL_CATEGORY, 'slug' => Constants::CONSTRUCTION_EQUIPMENT_SLUG]),
        ];
    }

    /**
     * @Route("store/product/{slug}", name="store_product_detail")
     */
    public function productDetail(Product $product, Request $request) {
        $region = $town = $subLocation = null;
        return $this->render('store/product.details.html.twig', array(
                    'region' => $region,
                    'town' => $town,
                    'product' => $product,
                    'category' => $product->getCategory(),
                    'relatedProducts' => $this->getRelatedProducts($product)
        ));
    }

    private function getRelatedProducts(Product $product) {
        return $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findRelatedProducts($product, $product->getSupplier(), null, $product->getCategories());
    }

    private function getFeaturedProducts($limit = 12) {
        return $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findFeaturedProducts(null, $limit);
    }

    private function getNewProducts($vendor = null, $limit = 12) {
        return $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findNewProducts($vendor, $limit);
    }

    private function getPromotedProducts($vendor = null, $limit = 6) {
        return $this->getDoctrine()->getRepository(EntityConfig::PROMOTED_PRODUCT)->findPromotedProducts($vendor, $limit);
    }

    

    /**
     * @Route(
     *  "/store/top-level-category-change/{id}",
     *  name="top_level_category_change", options={"expose"=true} 
     * )
     */
    public function topLevelCategoryChange(ProductCategory $category, Request $request) {
        return $this->render('store/index.html.twig', $this->loadIndexParams($request, $category));
    }

    /**
     * @Route("/store/category/{slug}", name="category_view")    
     */
    public function categoryView(ProductCategory $category, Request $request) {
        $region = $town = $subLocation = null;
        if ($request->query->get('region')) {
            $regionSlug = $request->query->get('region');
            $region = $this->getDoctrine()->getRepository(EntityConfig::REGION)->findOneBy(['slug' => $regionSlug]);
        }
        if ($request->query->get('town')) {
            $townSlug = $request->query->get('town');
            $town = $this->getDoctrine()->getRepository(EntityConfig::TOWN)->findOneBy(['slug' => $townSlug]);
        }
        $form = $this->formService->createLocationFilter($region, $town);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locationFilter = $form->getData();
            $region = $locationFilter->getRegion();
            $town = $locationFilter->getBusinessLocation();
            $subLocation = $locationFilter->getSubLocation();
        }
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->filterByLocationPaginated($category, $region, $town, $subLocation);
        $products = $this->paginatorService->getPaginatedEntity($request, $query, 12);
        return $this->render('store/category.products.html.twig', [
                    'form' => $form->createView(),
                    'region' => $region,
                    'town' => $town,
                    'subLocation' => $subLocation,
                    'category' => $category,
                    'products' => $products
        ]);
    }

    /**
     * @Route("/store/supplier/{slug}", name="supplier_store_view", options={"expose"=true} )    
     */
    public function supplierStoreView(Supplier $supplier, Request $request) {
        $page = 'supplier.store.inner';
        if ($request->query->get('page')) {
            $page = $request->query->get('page');
        }
        return $this->render('store/supplier.store.html.twig', array_merge($this->loadSupplierDefaultsParams($supplier, $page), $this->getPageParams($supplier, $request)));
    }

    private function loadSupplierDefaultsParams($supplier, $page) {
        $template = self::SUPPLIER_STORE_TEMPLATE_PREFIX . $page . Constants::TPL_SUFFIX;
        return [
            'template' => $template,
            'page' => $page,
            'supplier' => $supplier,
            'promotedProducts' => $this->getPromotedProducts($supplier, 6)
        ];
    }

    private function getPageParams($supplier, Request $request) {
        $page = 'supplier.store.inner';
        if ($request->query->get('page')) {
            $page = $request->query->get('page');
        }
        $pagePrams = [];
        switch ($page) {
            case 'category':
                $category = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findOneBy(['slug' => $request->query->get('cat')]);
                $pagePrams = [
                    'category' => $category,
                    'products' => $this->getSuplierPaginatedProducts($request, $supplier, $category)
                ];
                break;
            case 'quotation-request':
                $quotationForm = $this->formService->createQuotationForm($supplier);
                $pagePrams = [
                    'quotationForm' => $quotationForm->createView()
                ];
                break;
            case 'pricelist-request':
                $pagePrams = [];
                break;
            case 'ratings':
                break;
            default:
                break;
        }
        return $pagePrams;
    }

    /**
     * @Route("/store/suppliers/list/{slug}", name="supplier_list", defaults={"slug":"none"})    
     */
    public function supplierList(Request $request, Region $region = null) {
        $town = $subLocation = null;
        if ($request->query->get('town')) {
            $townSlug = $request->query->get('town');
            $town = $this->getDoctrine()->getRepository(EntityConfig::TOWN)->findOneBy(['slug' => $townSlug]);
        }
        if ($request->query->get('area')) {
            $subLocation = $request->query->get('area');
        }
        $form = $this->formService->createLocationFilter($region, $town);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locationFilter = $form->getData();
            $region = $locationFilter->getRegion();
            $town = $locationFilter->getBusinessLocation();
            $subLocation = $locationFilter->getSubLocation();
        }
        $query = $this->getDoctrine()->getRepository(EntityConfig::SUPPLIER)->filterByLocationPaginated($region, $town, $subLocation);
        $suppliers = $this->paginatorService->getPaginatedEntity($request, $query);
        return $this->render('store/supplier.list.html.twig', [
                    'suppliers' => $suppliers,
                    'region' => $region,
                    'form' => $form->createView(),
                    'town' => $town,
                    'subLocation' => $subLocation
        ]);
    }

    /**
     * @Route("/store/categories/list", name="category_list")    
     */
    public function categoryList(Request $request, Region $region = null) {
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findPaginatedCategories();
        $categories = $this->paginatorService->getPaginatedEntity($request, $query);
        return $this->render('store/product.category.list.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/store/location/{slug}", name="shop_by_location", defaults={"slug":"none"})    
     */
    public function shopByLocation(HubUtil $util, Request $request, Region $region = null) {
        $category = $town = $subLocation = null;
        if ($request->query->get('category')) {
            $categorySlug = $request->query->get('category');
            $category = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findOneBy(['slug' => $categorySlug]);
        }
        if ($request->query->get('town')) {
            $townSlug = $request->query->get('town');
            $town = $this->getDoctrine()->getRepository(EntityConfig::TOWN)->findOneBy(['slug' => $townSlug]);
        }
        $form = $this->formService->createLocationFilter($region, $town, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locationFilter = $form->getData();
            $region = $locationFilter->getRegion();
            $category = $form->get('category')->getData();
            $town = $locationFilter->getBusinessLocation();
            $subLocation = $locationFilter->getSubLocation();
        }
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->filterByLocationPaginated($category, $region, $town, $subLocation);
        $products = $this->paginatorService->getPaginatedEntity($request, $query, 12);

        $popularProducts = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMostViewedProducts();
        return $this->render('store/location.products.html.twig', [
                    'form' => $form->createView(),
                    'region' => $region,
                    'town' => $town,
                    'regions'=>$util->getRegions(),
                    'subLocation' => $subLocation,
                    'popularProducts' => $popularProducts,
                    'category' => $category,
                    'products' => $products
        ]);
    }

    private function getLocationFilteredProducts($form, $request, $category = null) {
        $locationFilter = $form->getData();
        $region = $locationFilter->getRegion();
        $town = $locationFilter->getBusinessLocation();
        $subLocation = $locationFilter->getSubLocation();
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->filterByLocationPaginated($category, $region, $town, $subLocation);
        $products = $this->getPaginatedEntity($request, $query);
        return $products;
    }

   

    /**
     * @Route("/store/page/{page}/{categoryString}", name="generic_page_view")    
     */
    public function genericPageView($page, $categoryString, Request $request) {
        $category = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findOneBy(['slug' => $categoryString]);
        $template = self::STORE_GENERIC_PREFIX . $page . Constants::TPL_SUFFIX;
        $subCategory = $region = $town = $subLocation = null;
        if ($request->query->get('region')) {
            $regionSlug = $request->query->get('region');
            $region = $this->getDoctrine()->getRepository(EntityConfig::REGION)->findOneBy(['slug' => $regionSlug]);
        }
        if ($request->query->get('town')) {
            $townSlug = $request->query->get('town');
            $town = $this->getDoctrine()->getRepository(EntityConfig::TOWN)->findOneBy(['slug' => $townSlug]);
        }
        $form = $this->formService->createLocationFilter($region, $town, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locationFilter = $form->getData();
            $region = $locationFilter->getRegion();
            $subCategory = $form->get('category')->getData();
            $town = $locationFilter->getBusinessLocation();
            $subLocation = $locationFilter->getSubLocation();
        }
        return $this->render($template, array_merge($this->genericPageCommonParams($form, $category, $region, $town, $page, $categoryString, $subCategory, $subLocation), $this->genericPageParams($category, $region, $town, $page, $categoryString, $subCategory, $request)));
    }

    private function genericPageCommonParams($form, $category, $region, $town, $page, $categoryString, $subCategory, $subLocation) {
        return [
            'form' => $form->createView(),
            'region' => $region,
            'town' => $town,
            'page' => $page,
            'categoryString' => $categoryString,
            'category' => $category,
            'subCategory' => $subCategory,
            'subLocation' => $subLocation,
        ];
    }

    private function genericPageParams($category, $region, $town, $page, $categoryString, $subCategory, $request) {
        switch ($page) {
            case StorePages::LIST_ALL_PRODUCTS:
                $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->filterByLocationPaginated($category, $region, $town);
                break;
            case StorePages::MOST_POPULAR_PRODUCTS:
                $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMostViewedProductsPaginated($category, $region, $town);
                break;
            case StorePages::TOP_SUPPLIERS:
                //$query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMostViewedProductsPaginated($category, $region, $town);
                return ['suppliers' => []];
            case StorePages::AUCTION_HUB:
                //$query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMostViewedProductsPaginated($category, $region, $town);
                return ['auctions' => []];
            case StorePages::SPECIAL_REQUEST:
                //$query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMostViewedProductsPaginated($category, $region, $town);
                return ['requestForm' => []];
        }
        $products = $this->paginatorService->getPaginatedEntity($request, $query, 12);
        return [
            'products' => $products
        ];
    }

    
   

    private function getSuplierPaginatedProducts($request, $merchant = null, $category = null, $categories = null) {
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->productsFilterPaginated($merchant, $category);
        return $this->paginatorService->getPaginatedEntity($request, $query);
    }

    private function getPaginatedProducts($request, $merchant = null, $category = null, $categories = null) {
        $query = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findPaginatedProducts($merchant, $category, $categories);
        return $this->paginatorService->getPaginatedEntity($request, $query);
    }

    private function getPaginatedMerchants($request, $region = null) {
        $query = $this->getDoctrine()->getRepository(EntityConfig::SUPPLIER)->findPaginatedMerchants($region);
        return $this->paginatorService->getPaginatedEntity($request, $query);
    }

}
