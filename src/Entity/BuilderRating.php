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
 * Description of RatingMeasure
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="builder_rating")
 * @ORM\Entity
 * 
 */
class BuilderRating extends Model{

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
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="ratings")
     * @ORM\JoinColumn(name="builder_id", referencedColumnName="id")
     */
    protected $builder;

   /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @var RatingMeasure
     * @ORM\ManyToOne(targetEntity="RatingMeasure")
     * @ORM\JoinColumn(name="measure_id", referencedColumnName="id")
     */
    protected $measure;
    
    function __construct(Person $builder, User $user, RatingMeasure $measure, $rating, $symbol) {
        $this->builder=$builder;
        $this->user=$user;
        $this->measure=$measure;
        $this->rating=$rating;
        $this->symbol=$symbol;
        $this->createdAt= new \DateTime();
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

    public function getUser() {
        return $this->user;
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

    public function setBuilder(Person $builder=null) {
        $this->builder = $builder;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function getMeasure(){
        return $this->measure;
    }

    public function setMeasure(RatingMeasure $measure=null) {
        $this->measure = $measure;
        return $this;
    }






}
