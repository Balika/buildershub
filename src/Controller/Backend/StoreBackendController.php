<?php

namespace App\Controller\Backend;

use App\Controller\BaseController;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductSaleOptions;
use App\Entity\StoreOptions;
use App\Entity\Supplier;
use App\Entity\Tag;
use App\Form\ProductSaleOptionsType;
use App\Form\StoreOptionsType;
use App\Form\TagType;
use App\Services\BackendTransactionService;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/store/admin/")
 * 
 */
class StoreBackendController extends BaseController {

    protected $productCategories;
    protected $nonStoreCategories;
    private static $equipmentSubCategories;
    private static $materialsSubCategories;
    private static $suppliesSubCategories;
    protected $storeAdminService;
   protected $paginatorService ;
   protected $transactionService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, Slugger $slugger, KnpPaginatorWrapper $paginator, BackendTransactionService $transactionService) {
        parent::__construct($formService, $persistenceService, $slugger);
       $this->paginatorService = $paginator;
       $this->transactionService = $transactionService;
    }

    /**
     * @Route("{slug}/dashboard", name="store_admin_dashboard")
     */
    public function businessPortalAction(Company $company, Request $request) {
        $preference = null; //$company->getPreference();        
        $feedback = '';
        if ($preference == null) {
            //$this->initCompanyPreferences($company);
            //$preference = $company->getPreference();//use updated preference to create form
        }
        return $this->render('store/admin/admin.dashboard.html.twig', array(
                    'supplier' => $company,
                    'feedback' => $feedback,
                        //'form' => $form->createView()
        ));
    }

    /**
     * @Route("{slug}/products", name="products")
     */
    public function productsAction(Company $company, Request $request) {
        $listMode = $request->query->get('list_mode');
        if ($listMode == null || $listMode == 'list') {
            $products = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findMerchantProducts($company);
        } else {
            $productsQry = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findAllQry($company);
            $products = $this->paginatorService->getPaginatedEntity($request, $productsQry, 20);
        }
        return $this->render('store/admin/products.html.twig', array(
                    'products' => $products,
                    'supplier' => $company,
                    'listMode' => $listMode
        ));
    }

    /**
     * @Route("{slug}/store/save-product-sale-options/{product_slug}", name="save_product_sales_options")
     * @ParamConverter("product", options={"mapping": {"product_slug": "slug"}})
     */
    public function saveProductSaleOptions(Company $company, Product $product, Request $request) {
        $optionsForm = $this->createProductSaleOptionsForm($product);
        $optionsForm->handleRequest($request);
        if ($optionsForm->isSubmitted() && $optionsForm->isValid()) {
            $options = $optionsForm->getData();
            $this->persistenceService->saveEntity($options);
            unset($optionsForm);
            $optionsForm = $this->createProductSaleOptionsForm($product);
        }
        return $this->redirectToRoute('edit_product', ['slug' => $company->getSlug(), 'product_slug' => $product->getSlug()]);
    }

    private function saveCompanyProductCategories(Supplier $supplier, array $categoryIds) {
        foreach ($categoryIds as $id) {
            $productCategory = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->find($id);
            $supplier->addProductCategory($productCategory);
        }
        $this->persistenceService->saveEntity($supplier);
    }

    /**
     * @Route("{slug}/add-product", name="add_product")
     */
    public function addProduct(Company $company, Request $request) {
        $product = new Product();
        $form = $this->formService->createProductForm($product, $company);
        $form->handleRequest($request);
        $isSaved = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setSupplier($company);
            $product->setUser($this->getUser());
            if ($form->get('publishProduct')->isClicked()) {
                $product->setEnabled(true);
            } else if ($form->get('preview')->isClicked()) {
                $product->setEnabled(false);
            } else if ($form->get('saveAsDraft')->isClicked()) {
                $product->setEnabled(false);
            }
            $this->saveProduct($product, $request);
            return $this->redirectToRoute("edit_product", array('slug' => $company->getSlug(), 'product_slug' => $product->getSlug()));
        }
        $isSparePart = false;
        $category = $product->getCategory();
        return $this->render('store/admin/product.form.html.twig', array(
                    'form' => $form->createView(),
                    'productCategories' => $category != null ? $category->getSubCategories() : [], //TODO: Refactor to pick only vendor product categories
                    'product' => $product,
                    'isSaved' => $isSaved,
                    'isSparePart' => $isSparePart,
                    'supplier' => $company
        ));
    }

    private function saveProduct(Product $product, Request $request) {
        $relatedProductsStr = $request->request->get('relatedProducts');
        $relatedProductsIds = explode(',', $relatedProductsStr);
        $product->setRelatedProducts($relatedProductsIds);
        $product->setCategories($request->request->get('selectedCategories'));
        $this->persistenceService->saveStoreEntity($product);
    }

    //################################# PRODUCT CATEGORIES RELATED METHODS ###############################
    /**
     * @Route("{slug}/product-categories", name="product_categories", defaults={"category_slug":"none"})
     * @ParamConverter("category", options={"mapping": {"category_slug": "slug"}})
     * 
     */
    public function productCategories(Supplier $supplier, Request $request, ProductCategory $category = null) {
        $form = $this->formService->createProductCategoryForm($category);
        if ($request->request->get('selectedCategories')) {
            $categoryIdsStr = $request->request->get('selectedCategories');
            $categoryIds = explode(',', $categoryIdsStr);
            if (count($categoryIds) > 0) {
                $this->saveCompanyProductCategories($supplier, $categoryIds);
            }
        }
        $form->handleRequest($request);
        $success = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $productCategory = $form->getData();
            $productCategory->setSupplier($supplier);
            $parentCategory = $productCategory->getParent();
            if($parentCategory!=null){
                $productCategory->setLevel($parentCategory->getLevel()+1);
            }else{
                $productCategory->setLevel(Constants::SECOND_LEVEL_CATEGORY);//Suppliers are not allowed to add top level categories
            }
            $this->saveCategory($productCategory);
            unset($form);
            $form = $this->formService->createProductCategoryForm();
            $success = true;
        }
        $params = array(
            'form' => $form->createView(),
            'success' => $success,
            'category' => $category,
            'supplier' => $supplier
        );
        return $this->render('store/admin/product.categories.html.twig', array_merge($params, $this->initProductCategories()));
    }

    /**
     * @Route("{slug}/products/set-validity-date/{date}", name="set_products_validity_date_action")
     * 
     */
    public function setProductsValidityDate(Company $company, $date, Request $request) {
        $validityDate = new DateTime($date);
        $products = $company->getProducts();        
        foreach ($products as $product) {
            $product->setValidityDate($validityDate);
            $this->persistenceService->persist($product);
        }
        $this->persistenceService->flush();
        return $this->redirectToRoute('products', ['slug' => $company->getSlug()]);
    }

    /**
     * @Route("{slug}/products/edit/{product_slug}", name="edit_product")
     * @ParamConverter("product", options={"mapping": {"product_slug": "slug"}})
     */
    public function editProduct(Company $company, Product $product, Request $request) {
        $form = $this->formService->createProductForm($product, $company);
        $isSaved = false;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            if ($form->get('preview')->isClicked()) {
                
            }
            $this->saveProduct($product, $request);
            $isSaved = true;
        }
        $optionsForm = $this->createProductSaleOptionsForm($product);
        $isSparePart = false;
        $category = $product->getCategory();
        return $this->render('store/admin/product.form.html.twig', array(
                    'form' => $form->createView(),
                    'optionsForm' => $optionsForm->createView(),
                    'productCategories' => $category->getSubCategories(),
                    'supplier' => $company,
                    'isSaved' => $isSaved,
                    'product' => $product,
                    'isSparePart' => $isSparePart
        ));
    }
     /**
     * @Route("{slug}/product-categories/{action}/{category_slug}", defaults={"action":"view"}, name="single_product_category")
     * @ParamConverter("category", options={"mapping": {"category_slug": "slug"}})
     * 
     */
    public function singleCategoryAction(Company $company, ProductCategory $category, Request $request, $action = null) {
        $form = $this->formService->createProductCategoryForm($category);
        if ($action == "view") {
            $products = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findCategoryProducts($category, $company);
            return $this->render('store/admin/view.product.category.html.twig', array(
                        'supplier' => $company,
                        'category' => $category,
                        'products' => $products,
            ));
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $category->setSupplier($company);
            $this->saveCategory($category);
        }
       $parameters =  array(
                    'slug' => $company->getSlug(),                  
                    'category_slug' => $category->getSlug()
        );
        return $this->redirectToRoute('product_categories', $parameters);      
    }

    /**
     * @Route("business/portal-store/products/featured-products/{slug}", name="update_featured_action")
     * 
     */
    public function updateFeaturedAction(Product $product, Request $request) {
        if ($product->getIsFeatured()) {
            $product->setIsFeatured(false);
        } else {
            $product->setIsFeatured(true);
        }
        $this->saveProduct($product, $request);
       return $this->redirectToRoute('products', ['slug' => $product->getSupplier()->getSlug()]);
    }

    /**
     * @Route("business/portal-store/products/new-arrivals/{slug}", name="update_new_arrival_action")
     * 
     */
    public function updateNewArrivalAction(Product $product, Request $request) {
        if ($product->getIsNewArrival()) {
            $product->setIsNewArrival(false);
        } else {
            $product->setIsNewArrival(true);
        }
        $this->saveProduct($product, $request);
       return $this->redirectToRoute('products', ['slug' => $product->getSupplier()->getSlug()]);
    }

    private function createProductSaleOptionsForm($product) {
        $saleOptions = new ProductSaleOptions($product);
        $form = $this->createForm(ProductSaleOptionsType::class, $saleOptions);
        return $form;
    }

    private function saveCategory($productCategory) {
        $productCategory->setUser($this->getUser());
        $this->persistenceService->saveStoreEntity($productCategory);
        $supplier = $productCategory->getSupplier();
        if ($supplier != null) {
            $supplier->addProductCategory($productCategory);
        }
        $this->persistenceService->saveEntity($supplier);
    }

    private function initProductCategories() {
        /* if ($this->topLevelCategories == null) {
          $this->topLevelCategories = $this->getDoctrine()->getRepository(Constants::PRODUCT_CATEGORY)->findTopLevelCategories();
          } */
        if (self::$equipmentSubCategories == null) {
            self::$equipmentSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(Constants::CONSTRUCTION_EQUIPMENT);
        }
        if (self::$materialsSubCategories == null) {
            self::$materialsSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(Constants::CONSTRUCTION_MATERIALS);
        }
        if (self::$suppliesSubCategories == null) {
            self::$suppliesSubCategories = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT_CATEGORY)->findProductSubCategories(Constants::SUPPLIES);
        }
        return array(
// 'topLevelCategories' => $this->topLevelCategories,
            'equipmentSubCategories' => self::$equipmentSubCategories,
            'materialsSubCategories' => self::$materialsSubCategories,
            'suppliesSubCategories' => self::$suppliesSubCategories
        );
    }

    //################################# STORE OPTIONS RELATED METHODS ###############################
    /**
     * @Route("{slug}/store/options", name="store_options")
     */
    public function storeOptions(Supplier $company, Request $request) {
        $options = $company->getStoreOptions();
        if ($options == null) {
            $this->initStoreOptions($company);
            $options = $company->getStoreOptions();
        }
        $form = $this->createOptionsForm($options);
        $form->handleRequest($request);
        $feedback = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $options = $form->getData();
            
            $bannerFile = $options->getBannerFile();
            $signatureFile = $options->getSignatureFile();
            if ($bannerFile != null) {
                $bannerFileName = $this->get('app.image_processor')->processSingleImage($this->container->getParameter('kernel.root_dir'), Constants::CONTENT_UPLOAD_DIR, $bannerFile);
                $options->setStoreBanner($bannerFileName);
            }
            if ($signatureFile != null) {
                $signatureFileName = $this->get('app.image_processor')->processSingleImage($this->container->getParameter('kernel.root_dir'), Constants::CONTENT_UPLOAD_DIR, $signatureFile);
                $options->setDigitalSignature($signatureFileName);
            }
            $company->setStoreOptions($options);
            $this->persistenceService->saveEntity($company);
            $feedback = "You have succesfully updated your store options. You can change them anytime to reflect your business needs";
        }
        return $this->render('store/admin/store.options.html.twig', array(
                    'supplier' => $company,
                    'feedback' => $feedback,
                    'form' => $form->createView()
        ));
    }

    private function initStoreOptions($company) {        
        $options = new StoreOptions();
        $company->setStoreOptions($options);
        $this->persistenceService->saveEntity($company);
    }

    private function createOptionsForm($options = null) {
        if ($options == null) {
            $options = new StoreOptions();
        }
        return $this->createForm(StoreOptionsType::class, $options);
    }
//################################# TAGS RELATED METHODS ###############################
    /**
     * @Route("{slug}/product-tags", name="product_tags")
     */
    public function tagsAction(Supplier $company, Request $request) {
        $form = $this->createTagForm();

        $success = false;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $this->saveTag($tag);
            $success = true;
            unset($form);
            $form = $this->createTagForm();
        }
        $tags = $this->getDoctrine()->getRepository(EntityConfig::TAG)->findAll();
        return $this->render('store/admin/tags.html.twig', array(
                    'supplier' => $company,
                    'success' => $success,
                    'form' => $form->createView(),
                    'tags' => $tags
        ));
    }

    /**
     * @Route("{slug}/product-tags/{action}/{tag_slug}", defaults={"action":"view"}, name="single_tag_action")
     * @ParamConverter("tag", options={"mapping": {"tag_slug": "slug"}})
     */
    public function singleTagAction(Supplier $company, Tag $tag, Request $request, $action = null) {
        $form = $this->createTagForm($tag);
        if ($action == "view") {
            $tags = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findTagProducts($tag, $company);
            return $this->render('store/admin/view.product.tag.html.twig', array(
                        'supplier' => $company,
                        'tag' => $tag,
                        'tags' => $tags,
            ));
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $this->saveTag($tag,$company);
        }
        return $this->render('store/admin/edit.product.tag.html.twig', array(
                    'form' => $form->createView(),
                    'company' => $company,
                    'tag' => $tag
        ));
    }

    private function saveTag(Tag $tag, $company) {       
        $slugifiedName = $this->slugger->slugifyUnique($tag->getName(), EntityConfig::TAG, $tag->getId());
        $tag->setSlug($slugifiedName);
        $tag->setAddedBy($this->getUser());
        $tag->setSupplier($company);
        $this->persistenceService->saveEntity($tag);
    }

    private function createTagForm($tag = null) {
        if ($tag == null) {
            $tag = new Tag();
        }
        return $this->createForm(TagType::class, $tag);
    }

//################################# ORDERS RELATED METHODS ###############################
    /**
     * @Route("{slug}/orders", name="store_orders")
     */
    public function orders(Supplier $company, Request $request) {
        $orders = $this->transactionService->getStoreOrders($company, $request);
        return $this->render('store/admin/orders.html.twig', array(
                    'supplier' => $company,
                    'orders' => $orders
        ));
    }
}
