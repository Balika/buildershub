<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Town
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="town")
 * @ORM\Entity
 */
class Town {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *  
     */
    protected $id;
     /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255, unique=true)
      * 
     */
    protected $name;
    
    /**
     * @var string $isCapital
     *
     * @ORM\Column(type="boolean")
     */
    protected $isCapital;
    /**
     * @var string $isCapital
     *
     * @ORM\Column(type="boolean")
     */
    protected $isSparePartsHub;
    
    /**
     * @var string $isCity
     *
     * @ORM\Column(type="boolean")
     */
    protected $isCity;
    
    /**
     * @var string $deleted
     * @ORM\Column(type="boolean")
     */
    protected $deleted;
    
   
    
     /**
     * @var string $slug
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     */
    protected $slug;

    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="towns", fetch="EAGER")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * 
     */
    protected $region;
    
   
   
    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;
    
    /**
     * @var Town
     * @ORM\ManyToOne(targetEntity="Town", inversedBy="subLocations")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;
     /**
     * @ORM\OneToMany(
     *      targetEntity="Town",
     *      mappedBy="parent",       
     * )
     */
    protected $subLocations;
    
    function __construct() {
         $this->deleted=false;
    }
    public function __toString(){
        return $this->name.'';
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Town
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set region
     *
     * @param \App\Entity\Region $region
     *
     * @return Town
     */
    public function setRegion(\App\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    

    /**
     * Set isCapital
     *
     * @param boolean $isCapital
     *
     * @return Town
     */
    public function setIsCapital($isCapital)
    {
        $this->isCapital = $isCapital;

        return $this;
    }

    /**
     * Get isCapital
     *
     * @return boolean
     */
    public function getIsCapital()
    {
        return $this->isCapital;
    }

    /**
     * Set parent
     *
     * @param \App\Entity\Town $parent
     *
     * @return Town
     */
    public function setParent(\App\Entity\Town $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \App\Entity\Town
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add subLocation
     *
     * @param \App\Entity\Town $subLocation
     *
     * @return Town
     */
    public function addSubLocation(\App\Entity\Town $subLocation)
    {
        $this->subLocations[] = $subLocation;
        return $this;
    }

    public function getIsSparePartsHub() {
        return $this->isSparePartsHub;
    }

    public function setIsSparePartsHub($isSparePartsHub=FALSE) {
        $this->isSparePartsHub = $isSparePartsHub;
        return $this;
    }

        /**
     * Remove subLocation
     *
     * @param \App\Entity\Town $subLocation
     */
    public function removeSubLocation(\App\Entity\Town $subLocation)
    {
        $this->subLocations->removeElement($subLocation);
    }

    /**
     * Get subLocations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubLocations()
    {
        return $this->subLocations;
    }
    
    public function getIsCity() {
        return $this->isCity;
    }

    public function setIsCity($isCity) {
        $this->isCity = $isCity;
        return $this;
    }
   
    public function getDeleted() {
        return $this->deleted;
    }

    public function setDeleted($deleted) {
        $this->deleted = $deleted;
        return $this;
    }



}
