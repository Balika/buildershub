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
 * Description of Group
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="association")
 * @ORM\Entity
 */
class Association extends Model {
    /**
     * @var string $membershipTitle
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $membershipTitle;

    /**
     * @var string $membershipId
     *
     * @ORM\Column(type="string")
     */
    protected $membershipId;

    /**
     * @var datetime $dateJoined
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateJoined;
    
    /**
     * @var boolean $isVerified
     *
     * @ORM\Column(type="boolean")
     */
    protected $isVerified;
    
    
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    
     /* @var Institution
     * @ORM\ManyToOne(targetEntity="Institution")
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="id")
     */
    protected $institution;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="associations")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

     function __construct() {
        $this->createdAt = new \DateTime();
        $this->isVerified=FALSE;
    }

    public function __toString() {
        return $this->memberhipTitle;
    }

    public function getMembershipTitle() {
        return $this->membershipTitle;
    }

    public function getMembershipId() {
        return $this->membershipId;
    }

    public function getDateJoined(){
        return $this->dateJoined;
    }

    public function getIsVerified() {
        return $this->isVerified;
    }

    public function getUser(){
        return $this->user;
    }

    public function getInstitution() {
        return $this->institution;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setMembershipTitle($membershipTitle) {
        $this->membershipTitle = $membershipTitle;
        return $this;
    }

    public function setMembershipId($membershipId) {
        $this->membershipId = $membershipId;
        return $this;
    }

    public function setDateJoined($dateJoined) {
        $this->dateJoined = $dateJoined;
        return $this;
    }

    public function setIsVerified($isVerified) {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setInstitution($institution=null) {
        $this->institution = $institution;
        return $this;
    }

    public function setCompany(Company $company=null) {
        $this->company = $company;
        return $this;
    }


}
