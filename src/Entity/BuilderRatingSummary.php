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
 * @ORM\Table(name="builder_rating_summary")
 * @ORM\Entity
 * 
 */
class BuilderRatingSummary {
    
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
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="ratingSummary")
     * @ORM\JoinColumn(name="builder_id", referencedColumnName="id")
     */
    protected $builder;

   
    /**
     * @var RatingMeasure
     * @ORM\ManyToOne(targetEntity="RatingMeasure")
     * @ORM\JoinColumn(name="measure_id", referencedColumnName="id")
     */
    protected $measure;
    
    function __construct(Person $builder, RatingMeasure $measure, $rating, $symbol) {
        $this->builder=$builder;
        $this->measure=$measure;
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

    public function getBuilder() {
        return $this->builder;
    }

    public function getMeasure() {
        return $this->measure;
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

    public function setMeasure(RatingMeasure $measure) {
        $this->measure = $measure;
        return $this;
    }


}
