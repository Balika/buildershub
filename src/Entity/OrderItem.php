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
 * Description of OrderItem
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="order_item")
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 * 
 */
class OrderItem extends Model {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
      
    
    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
     /**
     * @var Order
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderItems", cascade={"persist"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;
    
    
    /**
     * @var integer $quantity
     *
     * @ORM\Column(type="integer", name="quantity_ordered")
     */
    protected $quantity;
    /**
     * @var double $subTotal
     *
     * @ORM\Column(type="decimal")
     */
    protected $subTotal;
    /**
     * @var decimal $tax
     *
     * @ORM\Column(type="decimal")
     */
    protected $tax;
    /**
     * @var decimal $total
     *
     * @ORM\Column(type="decimal")
     */
    protected $total;
    /**
     * @var string $serialNumber
     *
     * @ORM\Column(type="string")
     */
    protected $serialNumber;
    /**
     * @var string $invoiceNumber
     *
     * @ORM\Column(type="string")
     */
    protected $promoCode;
    
   /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;
    
    /**
     * @var integer $discountPercent
     *
     * @ORM\Column(type="integer")
     */
    protected $discountPercent;
     /**
     * @var integer $line
     *
     * @ORM\Column(type="integer")
     */
    protected $line;
    
    /**
     * @var string $invoiceNumber
     *
     * @ORM\Column(type="decimal")
     */
    protected $salePrice;
     
     function __construct(Product $product=null) {       
        $this->createdAt= new \Datetime();
        $this->product = $product;
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return OrderItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set subTotal
     *
     * @param string $subTotal
     *
     * @return OrderItem
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    /**
     * Get subTotal
     *
     * @return string
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * Set tax
     *
     * @param string $tax
     *
     * @return OrderItem
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return OrderItem
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set serialNumber
     *
     * @param string $serialNumber
     *
     * @return OrderItem
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Get serialNumber
     *
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Set promoCode
     *
     * @param string $promoCode
     *
     * @return OrderItem
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

    /**
     * Set discountPercent
     *
     * @param integer $discountPercent
     *
     * @return OrderItem
     */
    public function setDiscountPercent($discountPercent)
    {
        $this->discountPercent = $discountPercent;

        return $this;
    }

    /**
     * Get discountPercent
     *
     * @return integer
     */
    public function getDiscountPercent()
    {
        return $this->discountPercent;
    }

    /**
     * Set line
     *
     * @param integer $line
     *
     * @return OrderItem
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get line
     *
     * @return integer
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Set salePrice
     *
     * @param string $salePrice
     *
     * @return OrderItem
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
     * Set order
     *
     * @param Order $order
     *
     * @return OrderItem
     */
    public function setOrder(Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param Product $product
     *
     * @return OrderItem
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;        
        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status='Pending') {
        $this->status = $status;
        return $this;
    }


}
