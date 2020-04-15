<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseModel as Model;

/**
 * Description of RentalPromo
 *
 * @author Balika
 * @ORM\Table(name="rental_promo")
 * @ORM\Entity(repositoryClass="App\Repository\RentalPromoRepository")
 */
class RentalPromo extends Model {

    /**
     * @var decimal $promoAmount
     *
     * @ORM\Column(type="decimal")
     */
    protected $promoAmount;

    /**
     * @var datetime $promoStartDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $promoStartDate;

    /**
     * @var datetime $promoEndDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $promoEndDate;

   
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var RentalAd
     * @ORM\ManyToOne(targetEntity="RentalAd")
     * @ORM\JoinColumn(name="rental_id", referencedColumnName="id")
     */
    protected $rentalAd;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function getPromoAmount(){
        return $this->promoAmount;
    }

    public function getPromoStartDate(){
        return $this->promoStartDate;
    }

    public function getPromoEndDate() {
        return $this->promoEndDate;
    }

    public function getUser() {
        return $this->user;
    }

    public function getRentalAd() {
        return $this->rentalAd;
    }

    public function setPromoAmount($promoAmount) {
        $this->promoAmount = $promoAmount;
        return $this;
    }

    public function setPromoStartDate($promoStartDate) {
        $this->promoStartDate = $promoStartDate;
        return $this;
    }

    public function setPromoEndDate($promoEndDate) {
        $this->promoEndDate = $promoEndDate;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setRentalAd(RentalAd $rentalAd) {
        $this->rentalAd = $rentalAd;
        return $this;
    }



}
