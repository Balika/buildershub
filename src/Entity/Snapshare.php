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
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of SnapShare
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="snapshare")
 * @ORM\Entity(repositoryClass="App\Repository\SnapshareRepository")
 * @Vich\Uploadable 
 * @ORM\HasLifecycleCallbacks
 */
class Snapshare extends Post {

    /**
     * @var string $latitude
     *
     * @ORM\Column(type="string")
     */
    protected $latitude;

    /**
     * @var string $longitude
     *
     * @ORM\Column(type="string")
     */
    protected $longitude;

    /**
     * @var string $gallery
     *
     * @ORM\Column(type="string")
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

    function __construct() {
        $this->createdAt = new DateTime();
        $this->galleryFiles = array();
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Set gallery
     *
     * @param array $gallery
     *
     * @return Snapshare
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return User
     */
    public function setGalleryFiles(array $images = null) {

        $this->galleryFiles = $images;

        if ($images) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    public function getGalleryFiles() {
        return $this->galleryFiles;
    }

    public function getPostType() {
        return self::SNAPSHARE;
    }

}
