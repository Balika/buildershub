<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;


use App\Entity\Base\BaseModel as Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of Location
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="store_options")
 * @ORM\Entity
 */
class StoreOptions extends Model {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    /**
     * @var boolean $allowPriceRequest
     *
     * @ORM\Column(type="boolean")
     */
    protected $allowPriceRequest;
    /**
     * @var boolean $allowQuotationRequest
     *
     * @ORM\Column(type="boolean")
     */
    protected $allowQuotationRequest;

    /**
     * @var string $storeBanner
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $storeBanner;
    
    /**
     * @var string $digitalSignature
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $digitalSignature;
    
    /**
     * @var boolean $manageStock
     *
     * @ORM\Column(type="boolean")
     */
    protected $manageStock;
   
    /**
     * @var boolean $showStockLevel
     *
     * @ORM\Column(type="boolean")
     */
    protected $showStockLevel;
     /**
     * @var boolean $showSTockLevel
     *
     * @ORM\Column(type="boolean")
     */
    protected $showFeaturedProducts;
    /**
     * @var boolean $showSTockLevel
     *
     * @ORM\Column(type="boolean")
     */
    protected $showPrices;
    
     /**
     * @var boolean $showSTockLevel
     *
     * @ORM\Column(type="boolean")
     */
    protected $displayBanner;
    
     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="storeBanner", fileNameProperty="storeBanner")
     * 
     * @var File
     */
    protected $bannerFile; 
    
     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="digitalSignature", fileNameProperty="digitalSignature")
     * 
     * @var File
     */
    protected $signatureFile; 
    /**
     * @var Supplier
     * @ORM\OneToOne(targetEntity="Supplier", inversedBy="storeOptions")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     *
     */
    protected $supplier;
    
    /**
     * @var string $merchandise
     *
     * @ORM\Column(type="array")
     * 
     */
    protected $merchandise;
    
    function __construct(Company $vendor=null) {
        $this->store=$vendor;
        $this->createdAt= new \DateTime();
    }
    public function __toString(){
       
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setBannerFile(File $image = null) {
        $this->bannerFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setSignatureFile(File $image = null) {
        $this->signatureFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getBannerFile() {
        return $this->bannerFile;
    }

    public function getSignatureFile() {
        return $this->signatureFile;
    }

    public function getAllowPriceRequest() {
        return $this->allowPriceRequest;
    }

    public function getAllowQuotationRequest() {
        return $this->allowQuotationRequest;
    }

    public function getStoreBanner() {
        return $this->storeBanner;
    }

    public function getDigitalSignature() {
        return $this->digitalSignature;
    }

    public function getManageStock() {
        return $this->manageStock;
    }

    public function getShowStockLevel() {
        return $this->showStockLevel;
    }

    public function getShowFeaturedProducts() {
        return $this->showFeaturedProducts;
    }

    public function getDisplayBanner() {
        return $this->displayBanner;
    }

    
    public function setAllowPriceRequest($allowPriceRequest) {
        $this->allowPriceRequest = $allowPriceRequest;
        return $this;
    }

    public function setAllowQuotationRequest($allowQuotationRequest) {
        $this->allowQuotationRequest = $allowQuotationRequest;
        return $this;
    }

    public function setStoreBanner($storeBanner) {
        $this->storeBanner = $storeBanner;
        return $this;
    }

    public function setDigitalSignature($digitalSignature) {
        $this->digitalSignature = $digitalSignature;
        return $this;
    }

    public function setManageStock($manageStock) {
        $this->manageStock = $manageStock;
        return $this;
    }

    public function setShowStockLevel($showStockLevel) {
        $this->showStockLevel = $showStockLevel;
        return $this;
    }

    public function setShowFeaturedProducts($showFeaturedProducts) {
        $this->showFeaturedProducts = $showFeaturedProducts;
        return $this;
    }

    public function setDisplayBanner($displayBanner) {
        $this->displayBanner = $displayBanner;
        return $this;
    }

   
    public function getShowPrices() {
        return $this->showPrices;
    }

    public function setShowPrices($showPrices) {
        $this->showPrices = $showPrices;
        return $this;
    }

    public function getMerchandise() {
        return $this->merchandise;
    }

    public function setMerchandise($merchandise) {
        $this->merchandise = $merchandise;
        return $this;
    }
    public function getSupplier(): Supplier {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }


}
