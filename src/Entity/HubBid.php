<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

//use JMS\Serializer\Annotation\ExclusionPolicy;
//use JMS\Serializer\Annotation\Groups;

/**
 * Description of HubBid
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="hub_bid")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable 
 */
class HubBid {

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
     * @ORM\Column(type="string")
     * 
     */
    protected $name;

    /**
     * @var string $bidCode
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $bidCode;

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

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $description;

    /**
     * @var boolean $isFeatured
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isEnabled;

    /**
     * @var boolean $isOpen
     *
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isOpen;

    /**
     * @var integer $bidDuration in weeks
     *
     * @ORM\Column(type="integer")
     * 
     */
    protected $bidDuration;

    /**
     * @var decimal $flatFee in GHc
     *
     * @ORM\Column(type="decimal", nullable=true)
     * 
     */
    protected $flatFee;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startingAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endingAt;

    function __construct() {
        $this->isEnabled = true;
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
     * @return Product
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
     * Set gallery
     *
     * @param array $gallery
     *
     * @return CipronBid
     */
    public function setGallery($gallery) {
        $this->gallery = array();
        foreach ($gallery as $galleryItem) {
            $this->addGallery($galleryItem);
        }
        return $this;
    }

    public function addGallery($galleryItem) {
        if (!in_array($galleryItem, $this->gallery, true)) {
            $this->gallery[] = $galleryItem;
        }

        return $this;
    }

    /**
     * Get gallery
     *
     * @return array
     */
    public function getGallery() {
        if ($this->gallery == null)
            $this->gallery = array();
        return array_unique($this->gallery);
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
     * @return CipronBid
     */
    public function setGalleryFiles(array $images = null) {

        $this->galleryFiles = $images;

        if ($images) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->isEnabled = true;
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

    /**
     * Set featureImage
     *
     * @param string featureImage
     *
     * @return CipronBid
     */
    public function setFeatureImage($featureImage) {
        $this->featureImage = $featureImage;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getFeatureImage() {
        return $this->featureImage;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CipronBid
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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     *
     * @return CipronBid
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->isEnabled = true;
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    public function getIsEnabled() {
        return $this->isEnabled;
    }

    public function getBidDuration() {
        return $this->bidDuration;
    }

    public function setIsEnabled($isEnabled) {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    public function setBidDuration($bidDuration) {
        $this->bidDuration = $bidDuration;
        return $this;
    }

    public function getFlatFee() {
        return $this->flatFee;
    }

    public function setFlatFee($flatFee) {
        $this->flatFee = $flatFee;
        return $this;
    }

    public function getIsOpen() {
        return $this->isOpen;
    }

    public function getStartingAt() {
        return $this->startingAt;
    }

    public function getEndingAt() {
        return $this->endingAt;
    }

    public function setIsOpen($isOpen) {
        $this->isOpen = $isOpen;
        return $this;
    }

    public function setStartingAt($startingAt) {
        $this->startingAt = $startingAt;
        return $this;
    }

    public function setEndingAt($endingAt) {
        $this->endingAt = $endingAt;
        return $this;
    }

    public function getBidCode() {
        return $this->bidCode;
    }

    public function setBidCode($bidCode) {
        $this->bidCode = $bidCode;
        return $this;
    }

    public function getFileName() {
        return 'HubBid_Photo_' . $this->getId();
    }

}
