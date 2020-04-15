<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseModel as Model;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;

/**
 * Description of Group
 *
 * @author Equipment
 */

/**
 * @ORM\Table(name="equipment")
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable 
 */
class Equipment extends Model {

    /**
     * @var string $membershipTitle
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @var string $assetLabel
     *
     * @ORM\Column(type="string")
     */
    protected $assetLabel;

    /**
     * @var string $brand
     *
     * @ORM\Column(type="string")
     */
    protected $brand;

    /**
     * @var string $color
     *
     * @ORM\Column(type="string")
     */
    protected $color;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var string $outputUnit
     *
     * @ORM\Column(type="string")
     */
    protected $outputUnit;

    /**
     * @var string $chasisNumber
     *
     * @ORM\Column(type="string")
     */
    protected $chasisNumber;

    /**
     * @var string $registrationNumber
     *
     * @ORM\Column(type="string")
     */
    protected $registrationNumber;

    /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @var boolean $isActive
     *
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * @var boolean $deleted
     *
     * @ORM\Column(type="boolean")
     */
    protected $deleted;

    /**
     * @var decimal $output
     *
     * @ORM\Column(type="decimal")
     */
    protected $output;

    /**
     * @var decimal $noOfAxles
     *
     * @ORM\Column(type="decimal")
     */
    protected $noOfAxles;

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

    /**
     * @var string $gallery
     *
     * @ORM\Column(type="array")
     * 
     */
    protected $gallery;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="gallery", fileNameProperty="gallery")
     * 
     * @var File
     */
    protected $galleryFiles;
    // Entity Relationship
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    /* @var ProductCategory
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="equipment")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    public function __toString() {
        return $this->name . '';
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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     *
     * @return Equipment
     */
    public function setGalleryFiles(array $images = null) {
        $this->galleryFiles = $images;
        if ($images) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getGalleryFiles() {
        if ($this->galleryFiles == null) {
            $this->galleryFiles = array();
        }
        return array_unique($this->galleryFiles);
    }

    public function getName() {
        return $this->name;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getAssetLabel() {
        return $this->assetLabel;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getColor() {
        return $this->color;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getOutputUnit() {
        return $this->outputUnit;
    }

    public function getChasisNumber() {
        return $this->chasisNumber;
    }

    public function getRegistrationNumber() {
        return $this->registrationNumber;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function getOutput() {
        return $this->output;
    }

    public function getNoOfAxles() {
        return $this->noOfAxles;
    }

    public function getFeatureImage() {
        return $this->featureImage;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function setAssetLabel($assetLabel) {
        $this->assetLabel = $assetLabel;
        return $this;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
        return $this;
    }

    public function setColor($color) {
        $this->color = $color;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setOutputUnit($outputUnit) {
        $this->outputUnit = $outputUnit;
        return $this;
    }

    public function setChasisNumber($chasisNumber) {
        $this->chasisNumber = $chasisNumber;
        return $this;
    }

    public function setRegistrationNumber($registrationNumber) {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setIsActive($isActive = TRUE) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setDeleted($deleted = FALSE) {
        $this->deleted = $deleted;
        return $this;
    }

    public function setOutput($output) {
        $this->output = $output;
        return $this;
    }

    public function setNoOfAxles($noOfAxles) {
        $this->noOfAxles = $noOfAxles;
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

    public function setCategory($category) {
        $this->category = $category;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }

    public function getFileName() {
        return 'equipment_feature_image_' . $this->generateRandomString();
    }

    public function getGallery() {
        return $this->gallery;
    }

    public function setGallery($gallery = []) {
        $this->gallery = $gallery;
        return $this;
    }

    public function addFile($file) {
        if ($this->gallery == null) {
            $this->gallery = array();
        }
        $this->gallery[] = $file;
        return array_unique($this->gallery);
    }

}
