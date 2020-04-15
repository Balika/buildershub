<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of Category
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="category")
 *@ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @var string $name
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     */
    protected $name;

    /**
     * @var string $icon
     *
     * @ORM\Column(type="string")
     */
    protected $icon;

    /**
     * @var string $image
     *
     * @ORM\Column(type="string")
     */
    protected $image;

    /**
     * @var string $type
     *
     * @ORM\Column(type="string")
     */
    protected $type;
    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subCategories")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Category",
     *      mappedBy="parent",       
     * )
     */
    protected $subCategories;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $practitioner;

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $slug;
    
    /**
     * @var boolean $isQuickAccess
     *
     * @ORM\Column(type="boolean")
     */
    protected $isQuickAccess;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;
    
     /**
     * @var string $deleted
     * @ORM\Column(type="boolean")
     */
    protected $deleted;

    function __construct() {
          $this->deleted=false;
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
     * @return Category
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
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set practitioner
     *
     * @param string $practitioner
     *
     * @return Category
     */
    public function setPractitioner($practitioner) {
        $this->practitioner = $practitioner;

        return $this;
    }

    /**
     * Get practitioner
     *
     * @return string
     */
    public function getPractitioner() {
        return $this->practitioner;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Category
     */
    public function setIcon($icon) {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon() {
        return $this->icon;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Category
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Town
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

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set parent
     *
     * @param \App\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\App\Entity\Category $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \App\Entity\Category
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add subCategory
     *
     * @param \App\Entity\Category $subCategory
     *
     * @return Category
     */
    public function addSubCategory(\App\Entity\Category $subCategory) {
        $this->subCategories[] = $subCategory;

        return $this;
    }

    /**
     * Remove subCategory
     *
     * @param \App\Entity\Category $subCategory
     */
    public function removeSubCategory(\App\Entity\Category $subCategory) {
        $this->subCategories->removeElement($subCategory);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubCategories() {
        return $this->subCategories;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getIsQuickAccess() {
        return $this->isQuickAccess;
    }

    public function setIsQuickAccess($isQuickAccess) {
        $this->isQuickAccess = $isQuickAccess;
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
