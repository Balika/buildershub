<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ProductData
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="product_data")
 * @ORM\Entity(repositoryClass="App\Repository\ProductDataRepository")
 */
class ProductData extends Model {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     /** 
     * @var decimal $stockQuantity
     *
     * @ORM\Column(type="decimal")
      * 
     */
    protected $stockQuantity;
    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $salePriceDateFrom;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $salePriceDateTo;
    
    /**
     * @var boolean $isStockManaged
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isStockManaged;
    /**
     * @var string $backOrders
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $backOrders;
    /**
     * @var string $stockStatus
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $stockStatus;
   /**
     * @var boolean $isSoldIndividually
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isSoldIndividually;

    /**
     * @var string $SKU
     *
     * @ORM\Column(type="string", name="sku")
     */
    protected $SKU;
   
     /** 
     * @var string $unit
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $unit;
    
     /** 
     * @var integer $saleVolume
     *
     * @ORM\Column(type="integer")
     * 
     */
    protected $saleVolume;
    /**
     * @var string $regularPrice
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $regularPrice;
    
    /**
     * @var string $salePrice
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $salePrice;
  
    /**
     * @var Product
     * @ORM\OneToOne(targetEntity="Product", inversedBy="productData")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
    function __construct() {
        $this->isSoldIndividually=true;
        $this->isStockManaged=false;
        $this->createdAt= new \Datetime();
        $this->saleVolume=1;
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
     * Set stockQuantity
     *
     * @param string $stockQuantity
     *
     * @return ProductData
     */
    public function setStockQuantity($stockQuantity)
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    /**
     * Get stockQuantity
     *
     * @return string
     */
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    /**
     * Set salePriceDateFrom
     *
     * @param \DateTime $salePriceDateFrom
     *
     * @return ProductData
     */
    public function setSalePriceDateFrom($salePriceDateFrom)
    {
        $this->salePriceDateFrom = $salePriceDateFrom;

        return $this;
    }

    /**
     * Get salePriceDateFrom
     *
     * @return \DateTime
     */
    public function getSalePriceDateFrom()
    {
        return $this->salePriceDateFrom;
    }

    /**
     * Set salePriceDateTo
     *
     * @param \DateTime $salePriceDateTo
     *
     * @return ProductData
     */
    public function setSalePriceDateTo($salePriceDateTo)
    {
        $this->salePriceDateTo = $salePriceDateTo;

        return $this;
    }

    /**
     * Get salePriceDateTo
     *
     * @return \DateTime
     */
    public function getSalePriceDateTo()
    {
        return $this->salePriceDateTo;
    }

    /**
     * Set isStockManaged
     *
     * @param boolean $isStockManaged
     *
     * @return ProductData
     */
    public function setIsStockManaged($isStockManaged)
    {
        $this->isStockManaged = $isStockManaged;

        return $this;
    }

    /**
     * Get isStockManaged
     *
     * @return boolean
     */
    public function getIsStockManaged()
    {
        return $this->isStockManaged;
    }

    /**
     * Set backOrders
     *
     * @param string $backOrders
     *
     * @return ProductData
     */
    public function setBackOrders($backOrders)
    {
        $this->backOrders = $backOrders;

        return $this;
    }

    /**
     * Get backOrders
     *
     * @return string
     */
    public function getBackOrders()
    {
        return $this->backOrders;
    }

    /**
     * Set stockStatus
     *
     * @param string $stockStatus
     *
     * @return ProductData
     */
    public function setStockStatus($stockStatus)
    {
        $this->stockStatus = $stockStatus;

        return $this;
    }

    /**
     * Get stockStatus
     *
     * @return string
     */
    public function getStockStatus()
    {
        return $this->stockStatus;
    }

    /**
     * Set isSoldIndividually
     *
     * @param boolean $isSoldIndividually
     *
     * @return ProductData
     */
    public function setIsSoldIndividually($isSoldIndividually)
    {
        $this->isSoldIndividually = $isSoldIndividually;

        return $this;
    }

    /**
     * Get isSoldIndividually
     *
     * @return boolean
     */
    public function getIsSoldIndividually()
    {
        return $this->isSoldIndividually;
    }

    /**
     * Set sKU
     *
     * @param string $sKU
     *
     * @return ProductData
     */
    public function setSKU($sKU)
    {
        $this->SKU = $sKU;

        return $this;
    }

    /**
     * Get sKU
     *
     * @return string
     */
    public function getSKU()
    {
        return $this->SKU;
    }

    /**
     * Set regularPrice
     *
     * @param string $regularPrice
     *
     * @return ProductData
     */
    public function setRegularPrice($regularPrice)
    {
        $this->regularPrice = $regularPrice;

        return $this;
    }

    /**
     * Get regularPrice
     *
     * @return string
     */
    public function getRegularPrice()
    {
        return $this->regularPrice;
    }

    /**
     * Set salePrice
     *
     * @param string $salePrice
     *
     * @return ProductData
     */
    public function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    /**
     * Get salePrice
     *
     * @return string
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }

    /**
     * Set product
     *
     * @param \App\Entity\Product $product
     *
     * @return ProductData
     */
    public function setProduct(\App\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
    public function getUnit() {
        return $this->unit;
    }

    public function setUnit($unit) {
        $this->unit = $unit;
        return $this;
    }

    public function getSaleVolume() {
        return $this->saleVolume;
    }

    public function setSaleVolume($saleVolume) {
        $this->saleVolume = $saleVolume;
        return $this;
    }



}
