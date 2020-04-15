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
use App\Annotation\Tenant;


/**
 * Description of PromotedProduct
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="promoted_product")
 * @ORM\Entity(repositoryClass="App\Repository\PromotedProductRepository")
 * @Tenant(tenantFieldName="supplier_id")
 */
class PromotedProduct extends Model {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     
    
    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
     /**
     * @var string $promotedCode
     *
     * @ORM\Column(type="string" )
     * 
     */
    protected $promoCode;
    
     /**
     * @var string $discountedPrice
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $discountedPrice;
     /**
     * @var $campaign
     *
     * @ORM\ManyToOne(targetEntity="Campaign", inversedBy="promotedProducts")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id")
     * 
     */
    protected $campaign;
    /**
     * @var  $expectedEndDate
     *
     * @ORM\Column(type="datetime")
     * 
     */
    protected $expiryDate;
   
     /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier", inversedBy="promotedProducts")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     */
    protected $supplier;
   
    public function __construct(Product $product =null, User $addedBy=null) {
        $this->product = $product;
        $this->user = $addedBy;
        $this->createdAt = new \DateTime();
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
     * Set discountedPrice
     *
     * @param string $discountedPrice
     *
     * @return PromotedProduct
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;

        return $this;
    }

    /**
     * Get discountedPrice
     *
     * @return string
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     * Set expiryDate
     *
     * @param \DateTime $expiryDate
     *
     * @return PromotedProduct
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return \DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set product
     *
     * @param \App\Entity\Product $product
     *
     * @return PromotedProduct
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \App\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    

    /**
     * Set campaign
     *
     * @param \App\Entity\Campaign $campaign
     *
     * @return PromotedProduct
     */
    public function setCampaign(\App\Entity\Campaign $campaign = null)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return \AppBundle\Entity\Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

   
    /**
     * Set promoCode
     *
     * @param string $promoCode
     *
     * @return PromotedProduct
     */
    public function setPromoCode($promoCode)
    {
        $this->promoCode = $promoCode;

        return $this;
    }

    /**
     * Get promoCode
     *
     * @return string
     */
    public function getPromoCode()
    {
        return $this->promoCode;
    }
    public function getUser(): User {
        return $this->user;
    }

    public function getSupplier(): Supplier {
        return $this->supplier;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }


}
