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
 * Description of Project
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @Vich\Uploadable 
 */
class Project extends Model {

    /**
     * @var string $title
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     */
    protected $title;
   

    /**
     * @var  $expectedStartDate
     *
     * @ORM\Column(type="datetime")
     * 
     */
    protected $expectedStartDate;

    /**
     * @var  $expectedEndDate
     *
     * @ORM\Column(type="datetime")
     * 
     */
    protected $expectedEndDate;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $summary;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $slug;

    /**
     * @var string $requestDetails
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $requestDetails;

    /**
     * @var boolean $isActive
     *
     * @ORM\Column(type="boolean")
     */
    protected $isActive;
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $user;
    /**
     * @var string $projectType
     * @ORM\Column(name="project_type")
     *
     */
    protected $projectType;

    /**
     * @var string $budget
     * @ORM\Column(name="budget")
     *
     */
    protected $budget;
    /**
     * @var array $gallery
     *
     * @ORM\Column(type="array")
     */
    protected $gallery;

    /**
     * @var array $artisans
     *
     * @ORM\Column(type="array")
     */
    protected $artisans;
    /**
     * @var array $professionals
     *
     * @ORM\Column(type="array")
     */
    protected $professionals;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploadedPhoto", fileNameProperty="featureImage")
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
     * @var string $featureImage
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    protected $featureImage;

   
    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Region", fetch="EAGER")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * 
     */
    protected $region;
    /**
     * @var Town
     * @ORM\ManyToOne(targetEntity="Town", fetch="EAGER")
     * @ORM\JoinColumn(name="town_id", referencedColumnName="id")
     * 
     */
    protected $town;
    /**
     * @var string $subLocation
     *
     * @ORM\Column(type="string")
     *
     */
    protected $subLocation;

   

    function __construct() {
        $this->createdAt = new DateTime();
       // $this->likes = new ArrayCollection();
        $this->galleryFiles = array();
        $this->artisans = array();
        $this->professionals = array();
        
    }

    function __toString() {
        return $this->title . " ";
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set expectedStartDate
     *
     * @param DateTime $expectedStartDate
     *
     * @return Project
     */
    public function setExpectedStartDate($expectedStartDate) {
        $this->expectedStartDate = $expectedStartDate;

        return $this;
    }

    /**
     * Get expectedStartDate
     *
     * @return DateTime
     */
    public function getExpectedStartDate() {
        return $this->expectedStartDate;
    }

    /**
     * Set expectedEndDate
     *
     * @param DateTime $expectedEndDate
     *
     * @return Project
     */
    public function setExpectedEndDate($expectedEndDate) {
        $this->expectedEndDate = $expectedEndDate;

        return $this;
    }

    /**
     * Get expectedEndDate
     *
     * @return DateTime
     */
    public function getExpectedEndDate() {
        return $this->expectedEndDate;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Project
     */
    public function setSummary($summary) {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary() {
        return $this->summary;
    }

    public function getRequestDetails() {
        return $this->requestDetails;
    }

    public function setRequestDetails($requestDetails=null) {
        $this->requestDetails = $requestDetails;
        return $this;
    }

        /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Project
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Project
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
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


    public function getArtisans() {
        return $this->artisans;
    }

    public function getProfessionals() {
        return $this->professionals;
    }

    public function setArtisans($artisans) {
        $arrayInput = $this->getArrayFromString($artisans);
        $this->artisans = $arrayInput;
        return $this;
    }

    public function setProfessionals($professionals) {
         $arrayInput = $this->getArrayFromString($professionals);
        $this->professionals = $arrayInput;
        return $this;
    }

    public function getBudget() {
        return $this->budget;
    }

    public function setBudget($budget=null) {
        $this->budget = $budget;
        return $this;
    }
    private function getArrayFromString($inputString){        
       return  strlen($inputString) > 0 ? explode(',', $inputString) : [];
    }
        

    /**
     * Set projectType
     *
     * @param  $projectType
     *
     * @return Project
     */
    public function setProjectType($projectType = null)
    {
        $this->projectType = $projectType;

        return $this;
    }

    /**
     * Get projectType
     *
     * @return $projectType
     */
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * Set subLocation
     *
     * @param string $subLocation
     *
     * @return Project
     */
    public function setSubLocation($subLocation)
    {
        $this->subLocation = $subLocation;

        return $this;
    }

    /**
     * Get subLocation
     *
     * @return string
     */
    public function getSubLocation()
    {
        return $this->subLocation;
    }

    /**
     * Set town
     *
     * @param \App\Entity\Town $town
     *
     * @return Project
     */
    public function setTown(\App\Entity\Town $town = null)
    {
        $this->town = $town;
        return $this;
    }

    /**
     * Get town
     *
     * @return \App\Entity\Town
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set region
     *
     * @param \App\Entity\Region $region
     *
     * @return Project
     */
    public function setRegion(\App\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \App\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }
     public function getFileName() {
        return 'project_featured_photo_' . \App\Utils\HubUtil::generateRandomString();
    }
}
