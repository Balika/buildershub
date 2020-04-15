<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Description of Supplier
 *
 * @author Balika - BTL
 *
 * @ORM\Table(name="supplier")
 * @ORM\Entity(repositoryClass="App\Repository\SupplierRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Supplier extends Company{
    const  ROLE = "ROLE_SUPPLIER";

    /**
     * @ORM\OneToMany(
     *      targetEntity="Product",
     *      mappedBy="supplier",       
     * )
     */
    protected $products;
    
     /**
     * @ORM\OneToMany(
     *      targetEntity="PromotedProduct",
     *      mappedBy="supplier",            
     * )
     */
    protected $promotedProducts;

    /**
     * @var $storeOptions
     *
     * @ORM\OneToOne(targetEntity="StoreOptions", mappedBy="supplier", cascade={"persist"})
     * 
     */
    protected $storeOptions;
    
     /**
     * @ORM\OneToMany(
     *      targetEntity="Campaign",
     *      mappedBy="company",      
     *      cascade={"persist"}
     * )
     */
    protected $campaigns;


    
    public function getCompanyType() {
        return $this::SUPPLIER;
    }
     /**
     * Add product
     *
     * @param \App\Entity\Product $product
     *
     * @return Supplier
     */
    public function addProduct(Product $product) {
        $this->products[] = $product;

        return $this;
    }
    
    /**
     * Remove product
     *
     * @param \App\Entity\Product $product
     */
    public function removeProduct(Product $product) {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts() {
        return $this->products;
    }
    /**
     *
     *   @ORM\ManyToMany(targetEntity="ProductCategory")
     *   @ORM\JoinTable(name="supplier_product_category",
     *   joinColumns={@ORM\JoinColumn(name="supplier_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="product_category_id", referencedColumnName="id")})
     * */
    protected $productCategories;
    
    /**
     * Add productCategory
     *
     * @param \App\Entity\ProductCategory $productCategory
     *
     * @return Company
     */
    public function addProductCategory(ProductCategory $productCategory) {
        $this->productCategories[] = $productCategory;
        return $this;
    }

    /**
     * Remove productCategory
     *
     * @param \App\Entity\ProductCategory $productCategory
     */
    public function removeProductCategory(ProductCategory $productCategory) {
        $this->productCategories->removeElement($productCategory);
    }

    /**
     * Get productCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductCategories() {
        return $this->productCategories;
    }
    /**
     * Add campaign
     *
     * @param Campaign $campaign
     *
     * @return Company
     */
    public function addCampaign(Campaign $campaign) {
        $this->campaigns[] = $campaign;
        $campaign->setCompany($this);
        return $this;
    }

    /**
     * Remove campaign
     *
     * @param Campaign $campaign
     */
    public function removeCampaign(Campaign $campaign) {
        $this->campaigns->removeElement($campaign);
    }

    /**
     * Get campaigns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCampaigns() {
        return $this->campaigns;
    }
    
    public function getStoreOptions() {
        return $this->storeOptions;
    }

    public function setStoreOptions(StoreOptions $storeOptions) {
        $this->storeOptions = $storeOptions;
        $storeOptions->setSupplier($this);
        return $this;
    }
    
    /**
     * Add promotedProduct
     *
     * @param  $promotedProduct
     *
     * @return Company
     */
    public function addPromotedProduct(PromotedProduct $promotedProduct) {
        $this->promotedProducts[] = $promotedProduct;
        return $this;
    }

    /**
     * Remove promotedProduct
     * @param  $promotedProduct
    */
    public function removePromotedProduct(PromotedProduct $promotedProduct) {
        $this->promotedProducts->removeElement($promotedProduct);
    }

    /**
     * Get promotedProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromotedProducts() {
        return $this->promotedProducts;
    }
}
