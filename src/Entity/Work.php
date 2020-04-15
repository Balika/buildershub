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
 * Description of Work
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="works")
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 * @Vich\Uploadable 
 */
class Work extends Model {

    /**
     * @var string $title
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $title;
   

    /**
     * @var  $expectedStartDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @var  $expectedEndDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $completionDate;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $summary;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $slug;
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $client;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var boolean $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="works")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isCommentable;

    /**
     * @ORM\Column(type="integer")
     */
    protected $commentCount;
    
    /**
     * @var array $gallery
     *
     * @ORM\Column(type="array")
     */
    protected $gallery;

   
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
     * @var string $featureImage
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $featureImage;
    
    /**
     * @var decimal $valuOfWorks
     *
     * @ORM\Column(type="decimal", nullable=true)
     */
    protected $valueOfWorks;

   
    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;
    
    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;
    /**
     * @var Town
     * @ORM\ManyToOne(targetEntity="Town")
     * @ORM\JoinColumn(name="town_id", referencedColumnName="id")
     */
    protected $town;
    /**
     * @var string $subLocation
     *
     * @ORM\Column(type="string")
     */
    protected $subLocation;
    
    /**
     * @ORM\OneToMany(
     *      targetEntity="ProjectComment",
     *      mappedBy="project", 
     *      cascade={"persist"}       
     * )
     * 
     */
    protected $comments;
    
    /**
     *
     *   @ORM\ManyToMany(targetEntity="User")
     *   @ORM\JoinTable(name="project_like",
     *   joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     * */
    protected $likes;

   
    function __construct() {
        $this->createdAt = new DateTime();
        $this->isCommentable=TRUE;
        $this->commentCount=0;
       
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
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
     * @return \AppBundle\Entity\Town
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

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Work
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set completionDate
     *
     * @param \DateTime $completionDate
     *
     * @return Work
     */
    public function setCompletionDate($completionDate)
    {
        $this->completionDate = $completionDate;

        return $this;
    }

    /**
     * Get completionDate
     *
     * @return \DateTime
     */
    public function getCompletionDate()
    {
        return $this->completionDate;
    }

    /**
     * Set client
     *
     * @param string $client
     *
     * @return Work
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Work
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set company
     *
     * @param \App\Entity\Company $company
     *
     * @return Work
     */
    public function setCompany(\App\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \App\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
     /**
     * Add like
     *
     * @param User $like
     *
     * @return Work
     */
    public function addLike(User $like)
    {
        $this->likes[] = $like;

        return $this;
    }

    /**
     * Remove like
     *
     * @param User $like
     */
    public function removeLike(User $like)
    {
        $this->likes->removeElement($like);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikes()
    {
        return $this->likes;
    }
    /**
     * Add comment
     *
     * @param ProjectComment $comment
     *
     * @return Post
     */
    public function addComment(ProjectComment $comment)
    {
        $this->comments[] = $comment;
        $comment->setProject($this);
        return $this;
    }

    /**
     * Remove comment
     *
     * @param ProjectComment $comment
     */
    public function removeComment(ProjectComment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
    public function getIsCommentable() {
        return $this->isCommentable;
    }

    public function getCommentCount() {
        return $this->commentCount;
    }

    public function setIsCommentable($isCommentable) {
        $this->isCommentable = $isCommentable;
        return $this;
    }

    public function setCommentCount($commentCount) {
        $this->commentCount = $commentCount;
        return $this;
    }

    public function getFileName() {
        return 'Work_Featured_Photo_'.$this->getId();
    }
    public function getValueOfWorks() {
        return $this->valueOfWorks;
    }

    public function setValueOfWorks($valuOfWorks=null) {
        $this->valueOfWorks = $valuOfWorks;
        return $this;
    }


}
