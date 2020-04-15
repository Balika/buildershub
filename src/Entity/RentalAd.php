<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseModel as Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of RentalAd
 *
 * @author RentalAd
 */

/**
 * @ORM\Table(name="rental_ad")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable 
 */
class RentalAd extends Model {

    /**
     * @var string $title
     *
     * @ORM\Column(type="string", length=500)
     */
    protected $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @var decimal $rentalRate
     *
     * @ORM\Column(type="decimal")
     */
    protected $rentalRate;

    /**
     * @var string $billingCycle
     *
     * @ORM\Column(type="string")
     */
    protected $billingCycle;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var string $subLocation
     *
     * @ORM\Column(type="string")
     */
    protected $subLocation;

    /**
     * @var integer $unitsAvailable
     *
     * @ORM\Column(type="integer")
     */
    protected $unitsAvailable;

    /**
     * @var boolean $isPublished
     *
     * @ORM\Column(type="boolean")
     */
    protected $isPublished;

    /**
     * @var boolean $isOnDeal
     *
     * @ORM\Column(type="boolean")
     */
    protected $isOnDeal = FALSE;

    /**
     * @var datetime $datePublished
     *
     * @ORM\Column(name="publish_date", type="datetime")
     */
    protected $datePublished;

    /**
     * @var boolean $isPromoted
     *
     * @ORM\Column(type="boolean")
     */
    protected $isPromoted;

    /**
     * @var boolean $deleted
     *
     * @ORM\Column(type="boolean")
     */
    protected $deleted;

    /**
     * @var string $featureImage
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
    // Entity Relationship
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    /* @var Region
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;

    /* @var Town
     * @ORM\ManyToOne(targetEntity="Town")
     * @ORM\JoinColumn(name="town_id", referencedColumnName="id")
     */
    protected $town;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @var Equipment
     * @ORM\ManyToOne(targetEntity="Equipment")
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    protected $equipment;

    /**
     * @var RentalRequest
     * @ORM\OneToMany(
     *      targetEntity="RentalRequest",
     *      mappedBy="rentalAd",            
     * )
     */
    protected $requests;

    public function __construct() {
        $this->requests = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->title . '';
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
     * @return RentalAd
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getRentalRate() {
        return $this->rentalRate;
    }

    public function getBillingCycle() {
        return $this->billingCycle;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getSubLocation() {
        return $this->subLocation;
    }

    public function getUnitsAvailable() {
        return $this->unitsAvailable;
    }

    public function getIsPublished() {
        return $this->isPublished;
    }

    public function getDatePublished() {
        return $this->datePublished;
    }

    public function getIsPromoted() {
        return $this->isPromoted;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function getFeatureImage() {
        return $this->featureImage;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getRegion() {
        return $this->region;
    }

    public function getTown() {
        return $this->town;
    }

    public function getCompany(): Company {
        return $this->company;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function setRentalRate($rentalRate) {
        $this->rentalRate = $rentalRate;
        return $this;
    }

    public function setBillingCycle($billingCycle) {
        $this->billingCycle = $billingCycle;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setSubLocation($subLocation) {
        $this->subLocation = $subLocation;
        return $this;
    }

    public function setUnitsAvailable($unitsAvailable) {
        $this->unitsAvailable = $unitsAvailable;
        return $this;
    }

    public function setIsPublished($isPublished = 1) {
        $this->isPublished = $isPublished;
        return $this;
    }

    public function setDatePublished($datePublished = null) {
        $this->datePublished = $datePublished;
        return $this;
    }

    public function setIsPromoted($isPromoted = 0) {
        $this->isPromoted = $isPromoted;
        return $this;
    }

    public function setDeleted($deleted = 0) {
        $this->deleted = $deleted;
        return $this;
    }

    public function setFeatureImage($featureImage) {
        $this->featureImage = $featureImage;
        return $this;
    }

    public function setUser(User $user = null) {
        $this->user = $user;
        return $this;
    }

    public function setRegion(Region $region = null) {
        $this->region = $region;
        return $this;
    }

    public function setTown(Town $town = null) {
        $this->town = $town;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }

    public function getFileName() {
        return 'rental_ad_feature_image_' . $this->generateRandomString();
    }

    public function getEquipment() {
        return $this->equipment;
    }

    public function setEquipment(Equipment $equipment = null) {
        $this->equipment = $equipment;
        return $this;
    }

    public function getIsOnDeal() {
        return $this->isOnDeal;
    }

    public function setIsOnDeal($isOnDeal = FALSE) {
        $this->isOnDeal = $isOnDeal;
        return $this;
    }

    public function addRequest(RentalRequest $request) {
        if ($this->requests == null) {
            $this->requests = new \Doctrine\Common\Collections\ArrayCollection();
        }
        $this->requests->add($request);
        return $this;
    }

    public function getRequests() {
        return $this->requests;
    }

    public function setRequests(RentalRequest $requests) {
        foreach ($requests as $request) {
            $this->addRequest($request);
        }
        return $this;
    }

}
