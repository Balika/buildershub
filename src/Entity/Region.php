<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the e
 * @ORM\Table(name="region")
 * @ORM\Entity
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Region
 *
 * @author Edmond
 */

/**
 * 
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region {
    
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
     * @var string $shortName
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $shortName;
   
    /**
     * @var string $slug
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $slug;
    
    /**
     * @var string $countryCode
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $countryCode;
    
    /**
     * @ORM\OneToMany(
     *      targetEntity="Town",
     *      mappedBy="region", 
     *      cascade={"persist"}        
     * )
     */
    protected $towns;
    
    function __construct() {
       
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
     * Set shortName
     *
     * @param string $shortName
     *
     * @return Region
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Region
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
     * Add town
     *
     * @param \App\Entity\Town $town
     *
     * @return Region
     */
    public function addTown(\App\Entity\Town $town)
    {
        $this->towns[] = $town;
        $town->setRegion($this);
        return $this;
    }

    /**
     * Remove town
     *
     * @param \App\Entity\Town $town
     */
    public function removeTown(\App\Entity\Town $town)
    {
        $this->towns->removeElement($town);
    }

    /**
     * Get towns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTowns()
    {
        return $this->towns;
    }
    public function getCountryCode() {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;
        return $this;
    }
}
