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
 * Description of Invitation
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="invite")
 * @ORM\Entity
 */
class Invitation extends Model {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @var boolean $hasResponded
     * @ORM\Column(type="boolean")
     *
     */
    protected $hasResponded;
    
    /**
     * @var boolean $isSent
     * @ORM\Column(type="boolean")
     *
     */
    protected $isSent;

    /**
     * @var string $email
     *
     * @ORM\Column(type="string")
     */
    protected $email;

   
    /**
     * @var string $userType
     *
     * @ORM\Column(type="string")
     */
    protected $userType;
    
     /**
     * @var string $ipAddress
     *
     * @ORM\Column(type="string")
     */
    protected $ipAddress;
     /**
     * @var string $agent
     *
     * @ORM\Column(type="string")
     */
    protected $agent;
    
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="invited_by", referencedColumnName="id")
     */
    protected $invitedBy;

    /**
     * @var datetime $responseDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $responseDate;
    
    function __construct(User $user, $email, $userType =null) {  
        $this->invitedBy=$user;
        $this->email=$email;
        $this->userType=$userType;
        $this->createdAt= new \DateTime();
        $this->hasResponded=FALSE;
        $this->isSent=FALSE;
    }

    public function getId() {
        return $this->id;
    }

    public function getHasResponded() {
        return $this->hasResponded;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUserType() {
        return $this->userType;
    }

    public function getIpAddress() {
        return $this->ipAddress;
    }

    public function getAgent() {
        return $this->agent;
    }

    public function getInvitedBy(){
        return $this->invitedBy;
    }

    public function getResponseDate() {
        return $this->responseDate;
    }

    public function setHasResponded($hasResponded=null) {
        $this->hasResponded = $hasResponded;
        return $this;
    }

    public function setEmail($email=null) {
        $this->email = $email;
        return $this;
    }

    public function setUserType($userType=null) {
        $this->userType = $userType;
        return $this;
    }

    public function setIpAddress($ipAddress=null) {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function setAgent($agent=null) {
        $this->agent = $agent;
        return $this;
    }

    public function setInvitedBy(User $invitedBy=null) {
        $this->invitedBy = $invitedBy;
        return $this;
    }

    public function setResponseDate($responseDate = null) {
        $this->responseDate = $responseDate;
        return $this;
    }
    public function getIsSent() {
        return $this->isSent;
    }

    public function setIsSent($isSent=FALSE) {
        $this->isSent = $isSent;
        return $this;
    }
}
