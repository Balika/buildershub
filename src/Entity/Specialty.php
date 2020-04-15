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
 * Description of Specialty
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="specialty")
 * @ORM\Entity(repositoryClass="App\Repository\SpecialtyRepository")
 * 
 */
class Specialty extends Model {

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
     * @var string $name
     *
     * @ORM\Column(type="string")
     */
    protected $slug;

    

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    function __construct() {
         $this->createdAt = new \Datetime();
    }

    public function __toString() {
        return $this->name.'';
    }

    
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Specialty
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Specialty
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    public function getType() {
        return $this->type;
    }

    public function getUser() {
        return $this->user;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
}
