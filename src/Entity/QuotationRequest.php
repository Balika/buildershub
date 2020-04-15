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
 * Description of QuotationRequest
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="quotation_request")
 * @ORM\Entity
 * 
 */
class QuotationRequest extends Model implements \App\Model\Notifiable{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     
   
    
   /**
     * @var Unit
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
    */
    protected $unit;
    
    /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $requestType;
    /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $request;
    
   /**
     * @var string $quantity
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity;
    
    /**
     * @var string $contact
     *
     * @ORM\Column(type="string")
     */
    protected $contact;
    
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    protected $supplier;
    
   
    
    function __construct() {      
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

 

    public function getUnit() {
        return $this->unit;
    }

    public function getRequestType() {
        return $this->requestType;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getProduct() {
        return $this->product;
    }

    public function getSupplier() {
        return $this->supplier;
    }

    public function setUnit(Unit $unit) {
        $this->unit = $unit;
        return $this;
    }

    public function setRequestType($requestType) {
        $this->requestType = $requestType;
        return $this;
    }

    public function setRequest($request) {
        $this->request = $request;
        return $this;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function setProduct(Product $product=null) {
        $this->product = $product;
        return $this;
    }

    public function setSupplier(Supplier $vendor=null) {
        $this->supplier = $vendor;
        return $this;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setContact($contact) {
        $this->contact = $contact;
        return $this;
    }

            /**
     * Set user
     *
     * @param User $user
     *
     * @return PriceRequest
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
