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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Order
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="c_order")
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 *
 */
class Order extends Model implements \App\Model\Notifiable{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     /** 
     * @var string $orderId
     *
     * @ORM\Column(type="string", name="order_number")
     */
    protected $orderId;
    
    
    /**
     * @var integer $quantiy
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity;
    /**
     * @var decimal $subTotal
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
     * @var string $invoiceNumber
     *
     * @ORM\Column(type="string")
     */
    protected $invoiceNumber;
    /**
     * @var string $invoiceNumber
     *
     * @ORM\Column(type="string")
     */
    protected $quoteNumber;
    
    /**
     * @var datetime $expiryDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $expiryDate;
    
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;
    
   /**
     * @ORM\OneToMany(
     *      targetEntity="OrderItem",
     *      mappedBy="order",
     *       cascade={"persist"}       
     * )
     */
    protected $orderItems;
    
    function __construct($orderId=null) {
        $this->orderId=$orderId;
        $this->createdAt= new \Datetime();
        $this->orderItems= new ArrayCollection();
    }
    public function __toString(){
        return $this->orderId;
    }


   


    /**
     * Set orderId
     *
     * @param string $orderId
     *
     * @return Order
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set invoiceNumber
     *
     * @param string $invoiceNumber
     *
     * @return Order
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Set quoteNumber
     *
     * @param string $quoteNumber
     *
     * @return Order
     */
    public function setQuoteNumber($quoteNumber)
    {
        $this->quoteNumber = $quoteNumber;

        return $this;
    }

    /**
     * Get quoteNumber
     *
     * @return string
     */
    public function getQuoteNumber()
    {
        return $this->quoteNumber;
    }

    /**
     * Set expiryDate
     *
     * @param DateTime $expiryDate
     *
     * @return Order
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set customer
     *
     * @param User $customer
     *
     * @return Order
     */
    public function setCustomer(User $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return User
     */
    public function getCustomer()
    {
        return $this->customer;
    }
    



    /**
     * Add orderItem
     *
     * @param OrderItem $orderItem
     *
     * @return Order
     */
    public function addOrderItem(OrderItem $orderItem)
    {
        $this->orderItems->add($orderItem);
        $orderItem->setOrder($this);
        return $this;
    }

    /**
     * Remove orderItem
     *
     * @param OrderItem $orderItem
     */
    public function removeOrderItem(OrderItem $orderItem)
    {
        $this->orderItems->removeElement($orderItem);
    }

    /**
     * Get orderItems
     *
     * @return Collection
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }
}
