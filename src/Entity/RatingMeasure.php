<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of RatingMeasure
 *
 * @author Edmond
 */

/**
 * @ORM\Entity(repositoryClass="App\Repository\RatingMeasureRepository")
 * @ORM\Table(name="rating_measure") 
 */
class RatingMeasure {

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
     */
    protected $name;



    /**
     * @var string $type
     *
     * @ORM\Column(type="string")
     */
    protected $type;
    /**
     * @var string $measureKey
     *
     * @ORM\Column(type="string")
     */
    protected $measureKey;

   /**
     * @var string $type
     *
     * @ORM\Column(type="string")
     */
    protected $description;

    function __construct() {
        
    }

    public function __toString() {
        return $this->name.'';
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RatingMeasure
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }
    public function getName() {
        return $this->name;
    }

    
    public function getType() {
        return $this->type;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    public function getMeasureKey() {
        return $this->measureKey;
    }

    public function setMeasureKey($measureKey=null) {
        $this->measureKey = $measureKey;
        return $this;
    }




}
