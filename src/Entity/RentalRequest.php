<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use App\Utils\HubUtil;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
/**
 * Description of RentalRequest
 *
 * @author Balika
 * @ORM\Table(name="rental_request")
 * @ORM\Entity(repositoryClass="App\Repository\RentalRequestRepository")
 */
class RentalRequest extends Model{
   /**
     * @var string $email
     *
     * @ORM\Column(type="string", length=500)
     */
    protected $email;

    /**
     * @var string $phone
     *
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @var integer $numberRequested
     *
     * @ORM\Column(type="integer")
     */
    protected $numberRequested;

    /**
     * @var string $message
     *
     * @ORM\Column(type="string")
     */
    protected $message;

    /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;

    
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
        $this->createdAt=new DateTime();
    }

    
    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getNumberRequested() {
        return $this->numberRequested;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getUser() {
        return $this->user;
    }

    public function getRentalAd() {
        return $this->rentalAd;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPhone($phone=null) {
        $this->phone = HubUtil::internationalizePhoneNumber($phone);
        return $this;
    }

    public function setNumberRequested($numberRequested) {
        $this->numberRequested = $numberRequested;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setUser(User $user=null) {
        $this->user = $user;
        return $this;
    }

    public function setRentalAd(RentalAd $rentalAd) {
        $this->rentalAd = $rentalAd;
        return $this;
    }


}
