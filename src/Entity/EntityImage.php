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
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of EntityImage
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="entity_image")
 * @ORM\Entity
 * @Vich\Uploadable 
 */
class EntityImage extends Model {

    /**
     * @var string $entity
     *
     * @ORM\Column(type="string", length=55)
     */
    protected $entity;

    /**
     * @var integer $entityId
     *
     * @ORM\Column(type="integer")
     */
    protected $entityId;

    /**
     * @var string $caption
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $caption;

    /**
     * @var boolean $isFeatured
     *
     * @ORM\Column(type="boolean")
     */
    protected $isFeatured;
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="image")
     * 
     * @var File
     */
    protected $imageFile;

    /**
     * @var string $image
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $image;

    function __construct($entity = null, $entityId = null, $user = null, $image = null, $caption = null) {
        $this->createdAt = new DateTime();
        $this->isFeatured = false;
        $this->entity = $entity;
        $this->entityId = $entityId;
        $this->user = $user;
        $this->image = $image;
        $this->caption = $caption;
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
     * Set $user
     *
     * @param User $user
     *
     * @return Project
     */
    public function setUser(User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\File $image
     *
     * @return User
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

    public function getEntity() {
        return $this->entity;
    }

    public function getEntityId() {
        return $this->entityId;
    }

    public function getCaption() {
        return $this->caption;
    }

    public function getIsFeatured() {
        return $this->isFeatured;
    }

    public function getImage() {
        return $this->image;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
        return $this;
    }

    public function setEntityId($entityId) {
        $this->entityId = $entityId;
        return $this;
    }

    public function setCaption($caption) {
        $this->caption = $caption;
        return $this;
    }

    public function setIsFeatured($isFeatured) {
        $this->isFeatured = $isFeatured;
        return $this;
    }

    public function setImage($image) {
        $this->image = $image;
        return $this;
    }
    public function getFileName() {
        return 'entity_image_' . \App\Utils\HubUtil::generateRandomString();
    }

}
