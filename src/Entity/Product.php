<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Annotation\Tenant;
//use JMS\Serializer\Annotation\ExclusionPolicy;
//use JMS\Serializer\Annotation\Groups;

/**
 * Description of Category
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable 
 * @Tenant(tenantFieldName="supplier_id")
 */
class Product extends Model {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $name;

    /**
     * @var string $gallery
     *
     * @ORM\Column(type="array")
     * 
     */
    protected $gallery;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="gallery", fileNameProperty="gallery")
     * 
     * @var File
     */
    protected $galleryFiles;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    protected $validityDate;

    /**
     * @var string $tags
     *
     * @ORM\Column(type="array")
     * 
     */
    protected $tags;

    /**
     * @var string $categories
     *
     * @ORM\Column(type="array")
     * 
     */
    protected $categories;

    /**
     * @var string $realtedProducts
     *
     * @ORM\Column(type="array")
     * 
     */
    protected $relatedProducts;

    /**
     * @var string $image
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $featureImage;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="featureImage")
     * 
     * @var File
     */
    protected $imageFile;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $slug;
     /**
     * @var integer $views
     *
     * @ORM\Column(type="integer")
     * 
     */
    protected $views;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $description;

   

    /**
     * @var string $companyName
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $companyName;

    /**
     * @var boolean $isFeatured
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isFeatured;
    /**
     * @var boolean $enabled
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $enabled;
    
    /**
     * @var boolean $isNewArrival
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isNewArrival;

    /**
     * @var $productData
     *
     * @ORM\OneToOne(targetEntity="ProductData", mappedBy="product", cascade={"persist"})
     * 
     */
    protected $productData;

    /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * 
     */
    protected $supplier;
     /**
     * @var ProductCategory
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * 
     */
    protected $category;
    
    
     /**
     * @var string $model
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $model;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(
     *      targetEntity="ProductSaleOptions",
     *      mappedBy="product",    
     *      cascade={"persist"}      
     * )
     */
    protected $saleOptions;

    function __construct() {
        $this->enabled = true;
        $this->isNewArrival = false;
        $this->createdAt = new \Datetime();
        $this->galleryFiles = array();
        $this->relatedProducts = array();
        $this->saleOptions = new ArrayCollection();
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set gallery
     *
     * @param array $gallery
     *
     * @return SnapShare
     */
    public function setGallery($gallery) {
        $this->gallery = array();
        foreach ($gallery as $galleryItem) {
            $this->addGallery($galleryItem);
        }
        return $this;
    }

    public function addGallery($galleryItem) {
        if (!in_array($galleryItem, $this->gallery, true)) {
            $this->gallery[] = $galleryItem;
        }

        return $this;
    }

    /**
     * Get gallery
     *
     * @return array
     */
    public function getGallery() {
        if ($this->gallery == null)
            $this->gallery = array();
        return array_unique($this->gallery);
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     *
     * @return Product
     */
    public function setGalleryFiles(array $images = null) {
        $this->galleryFiles = $images;
        if ($images) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getGalleryFiles() {
        if ($this->galleryFiles == null) {
            $this->galleryFiles = array();
        }
        return array_unique($this->galleryFiles);
    }

    /**
     * Set tags
     *
     * @param array $tags
     *
     * @return Product
     */
    public function setTags($tags) {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Set categories
     *
     * @param array $categories
     *
     * @return Product
     */
    public function setCategories($categories) {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return array
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return ProductCategory
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Set featureImage
     *
     * @param string featureImage
     *
     * @return Product
     */
    public function setFeatureImage($featureImage) {
        $this->featureImage = $featureImage;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getFeatureImage() {
        return $this->featureImage;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Product
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

   

   

    /**
     * Set productData
     *
     * @param ProductData $productData
     *
     * @return Product
     */
    public function setProductData(ProductData $productData = null) {
        $this->productData = $productData;
        $productData->setProduct($this);
        return $this;
    }

    /**
     * Get productData
     *
     * @return ProductData
     */
    public function getProductData() {
        return $this->productData;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return Product
     */
    public function setCompanyName($companyName) {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName() {
        return $this->companyName;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    public function getIsFeatured() {
        return $this->isFeatured;
    }

    public function setIsFeatured($isFeatured) {
        $this->isFeatured = $isFeatured;
    }

    public function getValidityDate() {
        return $this->validityDate;
    }

    public function setValidityDate($validityDate) {
        $this->validityDate = $validityDate;
        return $this;
    }

    public function addRelatedProduct($product) {
       if ($this->relatedProducts == null)
            $this->relatedProducts = [];
        if (!in_array($product, $this->relatedProducts, true)) {
            $this->relatedProducts[] = $product;
        }
        
        return $this;
    }

    /**
     * Set relatedProducts
     *
     * @param array $relatedProducts
     *
     * @return Product
     */
    public function setRelatedProducts($relatedProducts) {
        foreach ($relatedProducts as $product) {
            $this->addRelatedProduct($product);
        }
        return $this;
    }

    /**
     * Get $relatedProducts
     *
     * @return array
     */
    public function getRelatedProducts() {
        if ($this->relatedProducts == null)
            $this->relatedProducts = [];
        return array_unique($this->relatedProducts);
    }

    public function getSaleOptions() {
        return $this->saleOptions;
    }

    public function setSaleOptions($saleOptions) {
        $this->saleOptions = $saleOptions;
        return $this;
    }
    public function getIsNewArrival() {
        return $this->isNewArrival;
    }

    public function setIsNewArrival($isNewArrival) {
        $this->isNewArrival = $isNewArrival;
        return $this;
    }
   
    public function getModel() {
        return $this->model;
    }

   

    public function setModel($model) {
        $this->model = $model;
        return $this;
    }
    public function getViews() {
        return $this->views;
    }

    public function setViews($views) {
        $this->views = $views;
        return $this;
    }
    public function getSupplier() {
        return $this->supplier;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setSupplier(Company $supplier) {
        $this->supplier = $supplier;
        return $this;
    }

    public function setCategory(ProductCategory $category=null) {
        $this->category = $category;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
    public function getFileName() {
        return $this->supplier->getId().'_product_feature_image_'.$this->generateRandomString();
    }

}
