<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use DateTime;
use Doctrine\ORM\Mapping as ORM;




/**
 * Description of WeeklyDeal
 * @author Edmond
 */

/**
 * @ORM\Table(name="weekly_deal")
 * @ORM\Entity(repositoryClass="App\Repository\DealsRepository")
 * 
 */
class WeeklyDeal extends Model {

    /**
     * @var  $dealPrice
     *
     * @ORM\Column(type="decimal",  nullable=true)
     * 
     */
    protected $dealPrice;

    /**
     * @var  $dicountRate
     *
     * @ORM\Column(type="decimal",  nullable=true)
     * 
     */
    protected $discountRate;

    /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * 
     */
    protected $supplier;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
     /**
     * @var RentalAd
     * @ORM\ManyToOne(targetEntity="RentalAd")
     * @ORM\JoinColumn(name="rental_ad_id", referencedColumnName="id")
     */
    protected $rentalAd;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $user;

    /**
     * @var HubBid
     * @ORM\ManyToOne(targetEntity="HubBid")
     * @ORM\JoinColumn(name="bid_id", referencedColumnName="id")
     * 
     */
    protected $bid;

    

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDiscounted;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endDate;

    function __construct() {
        $this->createdAt = new DateTime();
    }

    public function getBid() {
        return $this->bid;
    }

    

    public function getEndDate() {
        return $this->endDate;
    }

    public function setBid(HubBid $bid) {
        $this->bid = $bid;
        return $this;
    }

   
    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function getSupplier(): Supplier {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function getDealPrice() {
        return $this->dealPrice;
    }

    public function getDiscountRate() {
        return $this->discountRate;
    }

    public function setDealPrice($dealPrice = null) {
        $this->dealPrice = $dealPrice;
        return $this;
    }

    public function getIsDiscounted() {
        return $this->isDiscounted;
    }

    public function setIsDiscounted($isDiscounted = false) {
        $this->isDiscounted = $isDiscounted;
        return $this;
    }

    public function setDiscountRate($discountRate) {
        $this->discountRate = $discountRate;
        return $this;
    }
    public function getProduct() {
        return $this->product;
    }

    public function setProduct(Product $product=null) {
        $this->product = $product;
        return $this;
    }

    public function getRentalAd() {
        return $this->rentalAd;
    }

    public function setRentalAd(RentalAd $rentalAd=null) {
        $this->rentalAd = $rentalAd;
        return $this;
    }



}
