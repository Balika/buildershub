<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use Doctrine\ORM\Mapping as ORM;
//use JMS\Serializer\Annotation\Groups;
/**
 * Description of ProductData
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="product_sale_options")
 * @ORM\Entity
 */
class ProductSaleOptions extends Model {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     /** 
     * @var decimal $saleVolume
     *
     * @ORM\Column(type="decimal")
      *
     */
    protected $saleVolume;
   
    
    /**
     * @var string $unit
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $unit;
    /** 
     * @var string $dimension
     *
     * @ORM\Column(type="string")
      * 
     */
    protected $dimension;
   

    /**
     * @var string $brand
     *
     * @ORM\Column(type="string")
     */
    protected $brand;
   
     
    /**
     * @var string $price
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $price;
    
    
    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="saleOptions")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
    function __construct(Product $product=null) {  
        $this->product = $product;
        $this->createdAt= new \Datetime();  
        
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

    public function getSaleVolume() {
        return $this->saleVolume;
    }

    public function getUnit() {
        return $this->unit;
    }

    public function getDimension() {
        return $this->dimension;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setSaleVolume($saleVolume) {
        $this->saleVolume = $saleVolume;
        return $this;
    }

    public function setUnit($unit) {
        $this->unit = $unit;
        return $this;
    }

    public function setDimension($dimension) {
        $this->dimension = $dimension;
        return $this;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
        return $this;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function setProduct(Product $product) {
        $this->product = $product;
        return $this;
    }


}
