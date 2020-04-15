<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of BuilderRatingSummary
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="builder_overall_rating")
 * @ORM\Entity
 * 
 */
class BuilderOverallRating{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    
     /**
     * @var string $symbol
     *
     * @ORM\Column(type="string")
     */
    protected $symbol;
    
     /**
     * @var integer $rating
     *
     * @ORM\Column(type="integer")
     */
    protected $rating;

    /**
     * @var Person
     * @ORM\OneToOne(targetEntity="Person", inversedBy="overallRating")
     * @ORM\JoinColumn(name="builder_id", referencedColumnName="id")
     */
    protected $builder;
    
    function __construct(Person $builder,  $rating, $symbol) {
        $this->builder=$builder;      
        $this->rating=$rating;
        $this->symbol=$symbol;
    }
    public function getId() {
        return $this->id;
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getBuilder(){
        return $this->builder;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setSymbol($symbol) {
        $this->symbol = $symbol;
        return $this;
    }

    public function setRating($rating) {
        $this->rating = $rating;
        return $this;
    }

    public function setBuilder(Person $builder) {
        $this->builder = $builder;
        return $this;
    }


}
