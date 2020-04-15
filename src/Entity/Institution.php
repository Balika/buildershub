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
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of Profession
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="institution")
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionRepository")
 * @Vich\Uploadable 
 * @ORM\HasLifecycleCallbacks
 */
class Institution extends Model{
    /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string $shortName
     *
     * @ORM\Column(type="string")
     */
    protected $shortName;
    
     /**
     * @var string $slug
     *
     * @ORM\Column(type="string")
     */
    protected $slug;
    
    /**
     * @var string $type
     *
     * @ORM\Column(type="string")
     */
    protected $type;
    
     /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;
    
     /**
     * @var string $logo
     *
     * @ORM\Column(type="string")
     */
    protected $logo;
    
     /**
     * @var string $logo
     *
     * @ORM\Column(type="string")
     */
    protected $countryCode;
    
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="entity_logo", fileNameProperty="logo")
     * 
     * @var File
     */
    protected $imageFile;
    
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function __toString() {
        return $this->name;
    }

    
    public function getName() {
        return $this->name;
    }

    public function getShortName() {
        return $this->shortName;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getLogo() {
        return $this->logo;
    }

    public function getCountryCode() {
        return $this->countryCode;
    }

    public function getImageFile(){
        return $this->imageFile;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setShortName($shortName) {
        $this->shortName = $shortName;
        return $this;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
        return $this;
    }

    public function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|File $image
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
    public function getUser() {
        return $this->user;
    }
    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }
}
