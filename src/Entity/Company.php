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
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Description of Company
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="company_type", type="string")
 * @ORM\DiscriminatorMap({"supplier" = "Supplier", "firm" = "Firm", "advertiser"="Advertiser"})
 * 
 */
abstract class Company extends Model implements \App\Model\CompanyInterface {

    const SUPPLIER = 'supplier';
    const FIRM = 'firm';
    const ADVERTISER = 'advertiser';

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    protected $name;

    /**
     * @var string $domain
     *
     * @ORM\Column(type="string", length=25)
     * 
     */
    protected $domain;

    /**
     * @var  $businessSummary
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $businessSummary;

    /**
     * @var  $profile
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $profile;

    /**
     * @var  $telephone1
     *
     * @ORM\Column(type="string", name="telephone_1", nullable=true)
     * 
     */
    protected $telephone1;

    /**
     * @var  $telephone1
     *
     * @ORM\Column(type="string", name="telephone_2", nullable=true)
     * 
     */
    protected $telephone2;

    /**
     * @var  $mobile1
     *
     * @ORM\Column(type="string", name="mobile_1")
     * 
     */
    protected $mobile1;

    /**
     * @var  $mobile2
     *
     * @ORM\Column(type="string", name="mobile_2", nullable=true)
     * 
     */
    protected $mobile2;

    /**
     * @var  $subType
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $subType;

    /**
     * @var  $email
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $email;

    /**
     * @var  $url
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $url;

    /**
     * @var  $url
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $vision;

    /**
     * @var  $url
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $mission;

    /**
     * @var  $url
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $history;

    /**
     * @var  $address
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $address;

    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Region", cascade={"persist"})
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $slug;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $companySize;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $subLocation;

    /**
     * @var boolean $isActive
     *
     * @ORM\Column(type="boolean")
     */
    protected $isActive;
    //Relations with other entites
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="company", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $owner;
    //Relations with other entites
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="contact_person", referencedColumnName="id")
     * 
     */
    protected $contactPerson;

    /**
     *   @ORM\ManyToMany(targetEntity="User")
     *   @ORM\JoinTable(name="user_company",
     *   joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     * */
    protected $staff;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Equipment",
     *      mappedBy="company",  
     *      cascade={"persist"}               
     * )
     */
    protected $equipment;

    /**
     * @ORM\OneToMany(
     *      targetEntity="CompanyService",
     *      mappedBy="company", 
     *      cascade={"persist"}          
     * )
     */
    protected $serviceOfferings;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Award",
     *      mappedBy="company",   
     *      cascade={"persist"}    
     * )
     */
    protected $awards;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Association",
     *      mappedBy="company",   
     *      cascade={"persist"}    
     * )
     */
    protected $associations;

    /**
     * @ORM\OneToMany(
     *      targetEntity="StatusPost",
     *      mappedBy="company",   
     *      cascade={"persist"}    
     * )
     */
    protected $posts;

    /**
     * @var Town
     * @ORM\ManyToOne(targetEntity="Town", cascade={"persist"})
     * @ORM\JoinColumn(name="business_location", referencedColumnName="id")
     */
    protected $businessLocation;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="logo")
     * 
     * @var File
     */
    protected $logoFile;

    /**
     * @var string $logo
     *
     * @ORM\Column(type="string")
     */
    protected $logo;

    /**
     * @var string $coverPicture
     *
     * @ORM\Column(type="string")
     */
    protected $coverPicture;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo_2", fileNameProperty="coverPicture")
     * 
     * @var File
     */
    protected $imageFile;

    function __construct() {
        $this->createdAt = new DateTime();
        $this->isActive = FALSE;
        $this->staff = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function __toString() {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name = null) {
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
     * Set businessSummary
     *
     * @param string $businessSummary
     *
     * @return Company
     */
    public function setBusinessSummary($businessSummary = null) {
        $this->businessSummary = $businessSummary;

        return $this;
    }

    /**
     * Get businessSummary
     *
     * @return string
     */
    public function getBusinessSummary() {
        return $this->businessSummary;
    }

    /**
     * Set profile
     *
     * @param string $profile
     *
     * @return Company
     */
    public function setProfile($profile = null) {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return string
     */
    public function getProfile() {
        return $this->profile;
    }

    /**
     * Set telephone1
     *
     * @param string $telephone1
     *
     * @return Company
     */
    public function setTelephone1($telephone1 = null) {
        $this->telephone1 = $telephone1;

        return $this;
    }

    /**
     * Get telephone1
     *
     * @return string
     */
    public function getTelephone1() {
        return $this->telephone1;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     *
     * @return Company
     */
    public function setTelephone2($telephone2 = null) {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * Get telephone2
     *
     * @return string
     */
    public function getTelephone2() {
        return $this->telephone2;
    }

    /**
     * Set mobile1
     *
     * @param string $mobile1
     *
     * @return Company
     */
    public function setMobile1($mobile1 = null) {
        $this->mobile1 = $mobile1;

        return $this;
    }

    /**
     * Get mobile1
     *
     * @return string
     */
    public function getMobile1() {
        return $this->mobile1;
    }

    /**
     * Set mobile2
     *
     * @param string $mobile2
     *
     * @return Company
     */
    public function setMobile2($mobile2 = null) {
        $this->mobile2 = $mobile2;

        return $this;
    }

    /**
     * Get mobile2
     *
     * @return string
     */
    public function getMobile2() {
        return $this->mobile2;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Company
     */
    public function setEmail($email = null) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Company
     */
    public function setUrl($url = null) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Company
     */
    public function setAddress($address = null) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Company
     */
    public function setSlug($slug = null) {
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
     * Set companySize
     *
     * @param string $companySize
     *
     * @return Company
     */
    public function setCompanySize($companySize = null) {
        $this->companySize = $companySize;

        return $this;
    }

    /**
     * Get companySize
     *
     * @return string
     */
    public function getCompanySize() {
        return $this->companySize;
    }

    /**
     * Set subLocation
     *
     * @param string $subLocation
     *
     * @return Company
     */
    public function setSubLocation($subLocation = null) {
        $this->subLocation = $subLocation;

        return $this;
    }

    /**
     * Get subLocation
     *
     * @return string
     */
    public function getSubLocation() {
        return $this->subLocation;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Company
     */
    public function setIsActive($isActive = FALSE) {
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
     * Set owner
     *
     * @param \Appe\Entity\User $owner
     *
     * @return Company
     */
    public function setOwner(\App\Entity\User $owner = null) {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get owner
     *
     * @return \App\Entity\User
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * Set businessLocation
     *
     * @param \App\Entity\Town $businessLocation
     *
     * @return Company
     */
    public function setBusinessLocation(\App\Entity\Town $businessLocation = null) {
        $this->businessLocation = $businessLocation;

        return $this;
    }

    /**
     * Get businessLocation
     *
     * @return \App\Entity\Town
     */
    public function getBusinessLocation() {
        return $this->businessLocation;
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
    public function setLogoFile(File $image = null) {
        $this->logoFile = $image;

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
    public function getLogoFile() {
        return $this->logoFile;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Company
     */
    public function setLogo($logo) {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo() {
        return $this->logo;
    }

    /**
     * Set region
     *
     * @param \App\Entity\Region $region
     *
     * @return Company
     */
    public function setRegion(\App\Entity\Region $region = null) {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \App\Entity\Region
     */
    public function getRegion() {
        return $this->region;
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

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    public function getSubType() {
        return $this->subType;
    }

    public function setSubType($subType = null) {
        $this->subType = $subType;
        return $this;
    }

    public function getCoverPicture() {
        return $this->coverPicture;
    }

    public function setCoverPicture($coverPicture = null) {
        $this->coverPicture = $coverPicture;
        return $this;
    }

    public function getContactPerson() {
        return $this->contactPerson;
    }

    public function setContactPerson(User $contactPerson = null) {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    public function getFileName() {
        return 'company_logo_' . \App\Utils\HubUtil::generateRandomString();
    }

    public function getCover() {
        return 'company_cover_picture_' . \App\Utils\HubUtil::generateRandomString();
    }

    /**
     * Add product
     *
     * @param \App\Entity\User $staff
     *
     * @return Supplier
     */
    public function addStaff(User $staff) {
        $this->staff[] = $staff;

        return $this;
    }

    /**
     * Remove staff
     *
     * @param \App\Entity\User $staff
     */
    public function removeStaff(User $staff) {
        $this->staff->removeElement($staff);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStaff() {
        return $this->staff;
    }

    /**
     * Add $service
     *
     * @param \App\Entity\CompanyService serviceOfferings
     *
     * @return CompanyService
     */
    public function addServiceOffering(CompanyService $service) {
        $this->serviceOfferings[] = $service;

        return $this;
    }

    /**
     * Remove CompanyService
     *
     * @param \App\Entity\CompanyService CompanyService
     */
    public function removeServiceOffering(CompanyService $service) {
        $this->serviceOfferings->removeElement($service);
    }

    /**
     * Get serviceOfferings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiceOfferings() {
        return $this->serviceOfferings;
    }

    /**
     * Add $award
     *
     * @param \App\Entity\Award award
     *
     * @return Award
     */
    public function addAward(Award $award) {
        $this->awards[] = $award;
        $award->setCompany($this);
        return $this;
    }

    /**
     * Remove Award
     *
     * @param \App\Entity\Award $award
     */
    public function removeAward(Award $award) {
        $this->awards->removeElement($award);
    }

    /**
     * Get awards
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAwards() {
        return $this->awards;
    }

    /**
     * Add $post
     *
     * @param \App\Entity\Post post
     *
     * @return Post
     */
    public function addPost(Post $post) {
        $this->posts[] = $post;
        $post->setCompany($this);
        return $this;
    }

    /**
     * Remove Post
     *
     * @param \App\Entity\Post $post
     */
    public function removePost(Post $post) {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts() {
        return $this->posts;
    }

    /**
     * Add $association
     *
     * @param \App\Entity\Association association
     *
     * @return Company
     */
    public function addAssociation(Association $association) {
        $this->associations[] = $association;
        $association->setCompany($this);
        return $this;
    }

    /**
     * Remove Association
     *
     * @param \App\Entity\Association $association
     */
    public function removeAssociation(Association $association) {
        $this->associations->removeElement($association);
    }

    /**
     * Get associations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssociations() {
        return $this->associations;
    }

    /**
     * Add $equipment
     *
     * @param \App\Entity\Equipment equipment
     *
     * @return Company
     */
    public function addEquipment(Equipment $equipment) {
        if(!$this->equipment->contains($equipment)){
            $this->equipment->add($equipment);
            $equipment->setCompany($this);
        }       
        return $this;
    }

    /**
     * Remove Equipment
     *
     * @param \App\Entity\Equipment $equipment
     */
    public function removeEquipment(Equipment $equipment) {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get  equipment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipment() {
        return $this->equipment;
    }

    public function getVision() {
        return $this->vision;
    }

    public function getMission() {
        return $this->mission;
    }

    public function getHistory() {
        return $this->history;
    }

    public function setVision($vision = null) {
        $this->vision = $vision;
        return $this;
    }

    public function setMission($mission = null) {
        $this->mission = $mission;
        return $this;
    }

    public function setHistory($history = null) {
        $this->history = $history;
        return $this;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function setDomain($domain = null) {
        $this->domain = \App\Utils\HubUtil::getNameAbbr($this->getName());
        return $this;
    }

}
