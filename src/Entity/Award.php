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
 * Description of Award
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="award")
 * @ORM\Entity
 * @Vich\Uploadable 
 * @ORM\HasLifecycleCallbacks
 */
class Award extends Model {

    /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var  $awardingOrganisation
     *
     * @ORM\Column(type="string")
     */
    protected $awardingOrganisation;

    /**
     * @var  $placeOfAward
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $placeOfAward;
    /**
     * @var  $awardDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $awardDate;

     /**
     * @var array $gallery
     *
     * @ORM\Column(type="array")
     */
    protected $gallery;

   
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $slug;

    /**
     * @var string $featureImage
     *
     * @ORM\Column(type="string", name="picture")
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="gallery", fileNameProperty="gallery")
     * 
     * @var File
     */
    protected $galleryFiles;
    
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="awards")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;
    

    function __construct() {
        $this->createdAt = new DateTime();
        
    }

    function __toString() {
        return $this->name;
    }

    /**
     * Set featureImage
     *
     * @param string $featureImage
     *
     * @return SnapShare
     */
    public function setFeatureImage($featureImage) {
        $this->featureImage = $featureImage;

        return $this;
    }

    /**
     * Get featureImage
     *
     * @return string
     */
    public function getFeatureImage() {
        return $this->featureImage;
    }

    /**
     * Set gallery
     *
     * @param array $gallery
     *
     * @return SnapShare
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

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Award
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set awardingOrganisation
     *
     * @param string $awardingOrganisation
     *
     * @return Award
     */
    public function setAwardingOrganisation($awardingOrganisation)
    {
        $this->awardingOrganisation = $awardingOrganisation;

        return $this;
    }

    /**
     * Get awardingOrganisation
     *
     * @return string
     */
    public function getAwardingOrganisation()
    {
        return $this->awardingOrganisation;
    }

    /**
     * Set placeOfAward
     *
     * @param string $placeOfAward
     *
     * @return Award
     */
    public function setPlaceOfAward($placeOfAward)
    {
        $this->placeOfAward = $placeOfAward;

        return $this;
    }

    /**
     * Get placeOfAward
     *
     * @return string
     */
    public function getPlaceOfAward()
    {
        return $this->placeOfAward;
    }

    /**
     * Set awardDate
     *
     * @param \DateTime $awardDate
     *
     * @return Award
     */
    public function setAwardDate($awardDate)
    {
        $this->awardDate = $awardDate;

        return $this;
    }

    /**
     * Get awardDate
     *
     * @return \DateTime
     */
    public function getAwardDate()
    {
        return $this->awardDate;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Award
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Award
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set company
     *
     * @param Company $company
     *
     * @return Award
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }
    public function getFileName() {
        return $this->user->getId().'_Award_Photo_'.$this->getId();
    }
}
