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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of OpenBid
 * @author Edmond
 */

/**
 * @ORM\Table(name="open_bid")
 * @ORM\Entity(repositoryClass="App\Repository\OpenBidRepository")
 * @Vich\Uploadable 
 * @ORM\HasLifecycleCallbacks
 */
class OpenBid extends Model {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

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
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * 
     */
    protected $product;

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
    protected $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var string $image
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $banner;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="banner")
     * 
     * @var File
     */
    protected $imageFile;

    function __construct() {
        $this->createdAt = new \DateTime();
    }

    function __toString() {
        return $this->id . '';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getBidAmount() {
        return $this->bidAmount;
    }

    public function getBid() {
        return $this->bid;
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

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setProduct(Product $product) {
        $this->product = $product;
        return $this;
    }

    public function getSupplier(): Supplier {
        return $this->supplier;
    }


    public function setSupplier(Supplier $supplier = null) {
        $this->supplier = $supplier;
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

    public function getUser(): User {
        return $this->user;
    }

    public function getBanner() {
        return $this->banner;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setBanner($banner = null) {
        $this->banner = $banner;
        return $this;
    }

    public function getFileName() {
        return 'OpenBid_Photo_' . $this->getId();
    }

}
