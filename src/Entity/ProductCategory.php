<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of Category
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="product_category")
 * @ORM\Entity(repositoryClass="App\Repository\ProductCategoryRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable 
 */
class ProductCategory {
    
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
     * @var integer $displayed
     *
     * @ORM\Column(type="integer")
     */
    protected $level;
     /**
     * @var string $displayed
     *
     * @ORM\Column(type="boolean")
     */
    protected $isStoreItem;
/**
     * @var string $image
     *
     * @ORM\Column(type="string", name="image")
     */
    protected $featureImage;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="featureImage")
     * 
     * @var File
     */
    protected $imageFile;
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
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     */
    protected $supplier;
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
     /**
     * @var ProductCategory
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="subCategories")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;
     /**
     * @ORM\OneToMany(
     *      targetEntity="ProductCategory",
     *      mappedBy="parent",       
     * )
     */
    protected $subCategories;
     /**
     * @ORM\OneToMany(
     *      targetEntity="Product",
     *      mappedBy="category",       
     * )
     */
    protected $products;
  
    
    
    function __construct() {
        $this->deleted=false;
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subCategories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set image
     *
     * @param string $image
     *
     * @return ProductCategory
     */
    public function setFeatureImage($image)
    {
        $this->featureImage = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getFeatureImage()
    {
        return $this->featureImage;
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
     * @param ProductCategory $parent
     *
     * @return ProductCategory
     */
    public function setParent(ProductCategory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\ProductCategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add subCategory
     *
     * @param ProductCategory $subCategory
     *
     * @return ProductCategory
     */
    public function addSubCategory(ProductCategory $subCategory)
    {
        $this->subCategories[] = $subCategory;

        return $this;
    }

    /**
     * Remove subCategory
     *
     * @param ProductCategory $subCategory
     */
    public function removeSubCategory(ProductCategory $subCategory)
    {
        if($this->subCategories->contains($subCategory)){
            $this->subCategories->removeElement($subCategory);
            if($subCategory->getParent()=== $this){
                $subCategory->setParent(null);
            }
        }
        return $this;
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
    
    /**
     * Add product
     *
     * @param Product $product
     *
     * @return Product
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set isStoreItem
     *
     * @param boolean $isStoreItem
     *
     * @return ProductCategory
     */
    public function setIsStoreItem($isStoreItem)
    {
        $this->isStoreItem = $isStoreItem;

        return $this;
    }
    public function getRank() {
        return $this->rank;
    }

    public function setRank($rank) {
        $this->rank = $rank;
    }

        /**
     * Get isStoreItem
     *
     * @return boolean
     */
    public function getIsStoreItem()
    {
        return $this->isStoreItem;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     *
     * @return ProductCategory
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }
    
    public function getDeleted() {
        return $this->deleted;
    }
    public function setDeleted($deleted) {
        $this->deleted = $deleted;
        return $this;
    }
    public function getLevel() {
        return $this->level;
    }

    public function getSupplier() {
        return $this->supplier;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
    public function getFileName() {
        return 'product_category_'.\App\Utils\HubUtil::generateRandomString();
    }
}
