<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Tag
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * 
 */
class Tag {

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
     * @var string $count
     *
     * @ORM\Column(type="integer")
     */
    protected $count;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    protected $supplier;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $addedBy;

    function __construct() {
        
    }

    public function __toString() {
        return $this->name;
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
     * @return ProductCategory
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
     * @return Tag
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

    public function getSupplier(): Supplier {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }

     /**
     * Set addedBy
     *
     * @param User $addedBy
     *
     * @return Tag
     */
    public function setAddedBy(User $addedBy = null) {
        $this->addedBy = $addedBy;

        return $this;
    }

    /**
     * Get addedBy
     *
     * @return User
     */
    public function getAddedBy() {
        return $this->addedBy;
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return Tag
     */
    public function setCount($count) {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount() {
        return $this->count;
    }

}
