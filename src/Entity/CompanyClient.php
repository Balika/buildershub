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
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Description of CompanyClient
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="company_client")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * 
 */
 class CompanyClient extends Model {

    
    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    protected $name;
   
    /**
     * @var  $telephone
     *
     * @ORM\Column(type="string", name="phone", nullable=true)
     * 
     */
    protected $telephone;

    /**
     * @var  $telephone1
     *
     * @ORM\Column(type="string", name="mobile", nullable=true)
     * 
     */
    protected $mobileNumber;

   

    /**
     * @var  $email
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $email;

   
    /**
     * @var  $address
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $address;


    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $contactPersonName;

   
    //Relations with other entites
    
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $user;
    
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="contact_person_id", referencedColumnName="id")
     * 
     */
    protected $contactPerson;
    
    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * 
     */
    protected $company;

    

    function __construct() {
       
        
    }

    function __toString() {
        return $this->name;
    }

    public function getName() {
        return $this->name;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getMobileNumber() {
        return $this->mobileNumber;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getContactPersonName() {
        return $this->contactPersonName;
    }

    public function getUser() {
        return $this->user;
    }

    public function getContactPerson(){
        return $this->contactPerson;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    public function setMobileNumber($mobileNumber) {
        $this->mobileNumber = $mobileNumber;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function setContactPersonName($contactPersonName) {
        $this->contactPersonName = $contactPersonName;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setContactPerson(User $contactPerson) {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }



}
