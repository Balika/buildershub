<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of ProductData
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="estate")
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable 
 */
class Property extends Model {

    /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $name;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", nullable=TRUE)
     * 
     */
    protected $realtorName;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $description;

    /**
     * @var decimal $minPrice
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $minPrice;

    /**
     * @var decimal $minPrice
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $maxPrice;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $bathrooms;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $parkingLots;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $availableUnits;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $advanceDuration;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $renewalCycle;

    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $views;

    /**
     * @var boolean $isAvailable
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isAvailable;

    /**
     * @var boolean $isFeatured
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isFeatured;

    /**
     * @var boolean $isAgent
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isAgent;

    /**
     * @var string $neighbourhood
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $neighbourhood;

    /**
     * @var string $currency
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $currency;

    /**
     * @var string $listingType
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $listingType;

    /**
     * @var string $buildingType
     *
     * @ORM\Column(type="string")
     */
    protected $buildingType;

    /**
     * @var string $unit
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $unit;

    /**
     * @var integer $area
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $area;

    /**
     * @var string $regularPrice
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $regularPrice;

    /**
     * @var string $salePrice
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $salePrice;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="featureImage")
     * 
     * @var File
     */
    protected $imageFile;

    /**
     * @var string $unit
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $featureImage;

    /**
     * @var boolean $isFeatured
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $enabled;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $slug;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;

    /**
     * @var Town
     * @ORM\ManyToOne(targetEntity="Town")
     * @ORM\JoinColumn(name="town_id", referencedColumnName="id")
     */
    protected $town;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $subLocation;

    function __construct() {
        $this->isAgent = false;
        $this->isFeatured = false;
        $this->enabled = true;
        $this->createdAt = new \Datetime();
        $this->isAvailable = true;
        $this->views = 0;
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
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    public function getImageFile() {
        return $this->imageFile;
    }

    public function getName() {
        return $this->name;
    }

    public function getRealtorName() {
        return $this->realtorName;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getMinPrice() {
        return $this->minPrice;
    }

    public function getMaxPrice() {
        return $this->maxPrice;
    }

    public function getBedrooms() {
        return $this->bedrooms;
    }

    public function getBathrooms() {
        return $this->bathrooms;
    }

    public function getParkingLots() {
        return $this->parkingLots;
    }

    public function getAvailableUnits() {
        return $this->availableUnits;
    }

    public function getAdvanceDuration() {
        return $this->advanceDuration;
    }

    public function getRenewalCycle() {
        return $this->renewalCycle;
    }

    public function getIsAvailable() {
        return $this->isAvailable;
    }

    public function getIsAgent() {
        return $this->isAgent;
    }

    public function getNeighbourhood() {
        return $this->neighbourhood;
    }

    public function getListingType() {
        return $this->listingType;
    }

    public function getBuildingType() {
        return $this->buildingType;
    }

    public function getUnit() {
        return $this->unit;
    }

    public function getArea() {
        return $this->area;
    }

    public function getRegularPrice() {
        return $this->regularPrice;
    }

    public function getSalePrice() {
        return $this->salePrice;
    }

    public function getFeatureImage() {
        return $this->featureImage;
    }

    public function getUser() {
        return $this->user;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setRealtorName($realtorName) {
        $this->realtorName = $realtorName;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setMinPrice($minPrice) {
        $this->minPrice = $minPrice;
        return $this;
    }

    public function setMaxPrice($maxPrice) {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    public function setBedrooms($bedrooms) {
        $this->bedrooms = $bedrooms;
        return $this;
    }

    public function setBathrooms($bathrooms) {
        $this->bathrooms = $bathrooms;
        return $this;
    }

    public function setParkingLots($parkingLots) {
        $this->parkingLots = $parkingLots;
        return $this;
    }

    public function setAvailableUnits($availableUnits) {
        $this->availableUnits = $availableUnits;
        return $this;
    }

    public function setAdvanceDuration($advanceDuration) {
        $this->advanceDuration = $advanceDuration;
        return $this;
    }

    public function setRenewalCycle($renewalCycle) {
        $this->renewalCycle = $renewalCycle;
        return $this;
    }

    public function setIsAvailable($isAvailable) {
        $this->isAvailable = $isAvailable;
        return $this;
    }

    public function setIsAgent($isAgent) {
        $this->isAgent = $isAgent;
        return $this;
    }

    public function setNeighbourhood($neighbourhood) {
        $this->neighbourhood = $neighbourhood;
        return $this;
    }

    public function setListingType($listingType) {
        $this->listingType = $listingType;
        return $this;
    }

    public function setBuildingType($buildingType) {
        $this->buildingType = $buildingType;
        return $this;
    }

    public function setUnit($unit) {
        $this->unit = $unit;
        return $this;
    }

    public function setArea($area) {
        $this->area = $area;
        return $this;
    }

    public function setRegularPrice($regularPrice) {
        $this->regularPrice = $regularPrice;
        return $this;
    }

    public function setSalePrice($salePrice) {
        $this->salePrice = $salePrice;
        return $this;
    }

    public function setFeatureImage($featureImage) {
        $this->featureImage = $featureImage;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getRegion() {
        return $this->region;
    }

    public function getTown() {
        return $this->town;
    }

    public function getSubLocation() {
        return $this->subLocation;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function setRegion(Region $region) {
        $this->region = $region;
        return $this;
    }

    public function setTown(Town $town = null) {
        $this->town = $town;
        return $this;
    }

    public function setSubLocation($subLocation) {
        $this->subLocation = $subLocation;
        return $this;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function setCurrency($currency = 'GH¢') {
        $this->currency = $currency;
        return $this;
    }

    public function getIsFeatured() {
        return $this->isFeatured;
    }

    public function setIsFeatured($isFeatured) {
        $this->isFeatured = $isFeatured;
        return $this;
    }

    public function getEnabled() {
        return $this->enabled;
    }

    public function setEnabled($enabled) {
        $this->enabled = $enabled;
        return $this;
    }

    public function getViews() {
        return $this->views;
    }

    public function setViews($views) {
        $this->views = $views;
        return $this;
    }

    public function getFileName() {
        return 'property_featured_Photo_' . \App\Utils\HubUtil::generateRandomString();
    }

}
