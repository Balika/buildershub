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
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

//use JMS\Serializer\Annotation\ExclusionPolicy;
//use JMS\Serializer\Annotation\Groups;

/**
 * Description of FeaturedCategory
 *
 * @author FeaturedCategory
 */

/**
 * @ORM\Table(name="featured_category")
 * @ORM\Entity
 *
 * 
 */
class FeaturedCategory extends Model{

    /**
     * @var boolean $isCurrent
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isCurrent;


    /**
     * @var boolean $deleted
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endDate;
    
    
    //Entity Associations 
    /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * 
     */
    protected $supplier;
     /**
     * @var ProductCategory
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * 
     */
    protected $category;
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    function __construct() {
        $this->isCurrent = TRUE;
        $this->deleted=FALSE;
        $this->createdAt= new \DateTime();       
    }
    public function __toString() {
        return $this->id.'';
    }

        public function getIsCurrent() {
        return $this->isCurrent;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getSupplier() {
        return $this->supplier;
    }

    public function getCategory(){
        return $this->category;
    }

    public function getUser() {
        return $this->user;
    }

    public function setIsCurrent($isCurrent=TRUE) {
        $this->isCurrent = $isCurrent;
        return $this;
    }

    public function setDeleted($deleted=FALSE) {
        $this->deleted = $deleted;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function setSupplier(Supplier $supplier=null) {
        $this->supplier = $supplier;
        return $this;
    }

    public function setCategory(ProductCategory $category=null) {
        $this->category = $category;
        return $this;
    }

    public function setUser(User $user=null) {
        $this->user = $user;
        return $this;
    }



}
