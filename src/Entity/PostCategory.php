<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of PostCategory
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="post_category")
 * @ORM\Entity(repositoryClass="App\Repository\PostCategoryRepository")
 * 
 */
class PostCategory {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    
     /**
     * @ORM\Column(type="string")
     * 
     */
    protected $type;
     /** 
     * @var string $name
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $name;
    /**
     * @var integer $count
     *
     * @ORM\Column(type="integer")
     */
    protected $count;
    /**
     * @var string $rank
     *
     * @ORM\Column(type="integer")
     */
    protected $rank;
    
    
    
    /**
     * @var string $icon
     *
     * @ORM\Column(type="string")
     */
    protected $icon;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     */
    protected $slug;
     
    /**
     * @var string $deleted
     * @ORM\Column(type="boolean")
     */
    protected $deleted;
   
    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;
    
   
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
     /**
     * @var PostCategory
     * @ORM\ManyToOne(targetEntity="PostCategory", inversedBy="subCategories")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;
     /**
     * @ORM\OneToMany(
     *      targetEntity="PostCategory",
     *      mappedBy="parent",       
     * )
     */
    protected $subCategories;
    
    
    
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
     * @return ProductCategory
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
     * Set count
     *
     * @param integer $count
     *
     * @return ProductCategory
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

   
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return ProductCategory
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
     * Set description
     *
     * @param string $description
     *
     * @return ProductCategory
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
     * Set icon
     *
     * @param string $icon
     *
     * @return ProductCategory
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set parent
     *
     * @param PostCategory $parent
     *
     * @return PostCategory
     */
    public function setParent(PostCategory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return PostCategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add subCategory
     *
     * @param PostCategory $subCategory
     *
     * @return PostCategory
     */
    public function addSubCategory(PostCategory $subCategory)
    {
        $this->subCategories[] = $subCategory;

        return $this;
    }

    /**
     * Remove subCategory
     *
     * @param PostCategory $subCategory
     */
    public function removeSubCategory(PostCategory $subCategory)
    {
        $this->subCategories->removeElement($subCategory);
    }

    /**
     * Get subCategories
     *
     * @return Collection
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    
    public function getRank() {
        return $this->rank;
    }

    public function setRank($rank) {
        $this->rank = $rank;
    }

    
    
    public function getDeleted() {
        return $this->deleted;
    }
    public function setDeleted($deleted) {
        $this->deleted = $deleted;
        return $this;
    }
   
    public function getUser() {
        return $this->user;
    }

    
    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
     public function getType() {
        return $this->type;
    }

    public function setType($type=null) {
        $this->type = $type;
        return $this;
    }
}
