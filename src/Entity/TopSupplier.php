<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

//use JMS\Serializer\Annotation\Groups;

/**
 * Description of RentalAdverts
 * @author Edmond
 */

/**
 * @ORM\Table(name="top_supplier")
 * @ORM\Entity(repositoryClass="App\Repository\TopSupplierRepository")
 * @Vich\Uploadable 
 * @ORM\HasLifecycleCallbacks
 */
class TopSupplier extends Model {

    /**
     * @var  $bidAmount
     *
     * @ORM\Column(type="decimal",  nullable=true)
     * 
     */
    protected $bidAmount;

    /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * 
     */
    protected $supplier;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $user;

    /**
     * @var HubBid
     * @ORM\ManyToOne(targetEntity="HubBid")
     * @ORM\JoinColumn(name="bid_id", referencedColumnName="id")
     * 
     */
    protected $bid;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endDate;

    /**
     * @ORM\Column(type="array")
     */
    protected $productCategories;

    /**
     * @var string $image
     *
     * @ORM\Column(type="string")
     * 
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

    function __construct() {
        $this->createdAt = new DateTime();
    }

    public function getBidAmount() {
        return $this->bidAmount;
    }

    public function getBid() {
        return $this->bid;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setBidAmount($bidAmount) {
        $this->bidAmount = $bidAmount;
        return $this;
    }

    public function setBid(HubBid $bid) {
        $this->bid = $bid;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
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
     * @return Product
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

    public function getFeatureImage() {
        return $this->featureImage;
    }

    public function setFeatureImage($featureImage) {
        $this->featureImage = $featureImage;
        return $this;
    }

    public function getSupplier(): Supplier {
        return $this->supplier;
    }

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }

    public function addProductCategory($productCategory) {
        if ($this->productCategories == null)
            $this->productCategories = [];
        if (!in_array($productCategory, $this->productCategories, true)) {
            $this->productCategories[] = $productCategory;
        }
        return $this;
    }

    /**
     * Set productCategories
     *
     * @param array $productCategories
     *
     * @return TopSupplier
     */
    public function setProductCategories($productCategories) {
        foreach ($productCategories as $productCategory) {
            $this->addProductCategory($productCategory);
        }
        return $this;
    }

    /**
     * Get $productCategories
     *
     * @return array
     */
    public function getProductCategories() {
        if ($this->productCategories == null)
            $this->productCategories = [];
        return array_unique($this->productCategories);
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function getFileName() {
        return 'Top_Supplier_Photo_' . $this->getId();
    }

}
