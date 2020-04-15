<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Unit
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="unit")
 * @ORM\Entity
 */
class Unit {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @var string $singular
     * @ORM\Column(type="string", length=255, unique=true)
     *
     */
    protected $singular;

    /**
     * @var string $plural
     *
     * @ORM\Column(type="string")
     */
    protected $plural;

    /**
     * @var string $abbr
     *
     * @ORM\Column(type="string")
     */
    protected $abbr;

    

    function __construct() {
          
    }

    public function __toString() {
        return $this->abbr!=null ? $this->singular . " ($this->abbr)" : " $this->singular ";
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getSingular() {
        return $this->singular;
    }

    public function getPlural() {
        return $this->plural;
    }

    public function getAbbr() {
        return $this->abbr;
    }

    public function setSingular($singular) {
        $this->singular = $singular;
        return $this;
    }

    public function setPlural($plural) {
        $this->plural = $plural;
        return $this;
    }

    public function setAbbr($abbr) {
        $this->abbr = $abbr;
        return $this;
    }
}
