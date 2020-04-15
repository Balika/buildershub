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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of Campaign
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="campaign")
 * @ORM\Entity(repositoryClass="App\Repository\CampaignRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * 
 */
class Campaign extends Model {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     
    
    /**
     * @var Supplier
     * @ORM\ManyToOne(targetEntity="Supplier", inversedBy="campaigns")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
     /**
     * @var string $name
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $name;
    
     /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $description;
    
    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $type;
    
     /**
     * @var decimal $discountRate
     *
     * @ORM\Column(type="decimal")
     * 
     */
    protected $discountRate;
    
    /**
     * @var  $startDate
     *
     * @ORM\Column(type="datetime")
     * 
     */
    protected $startDate;
    /**
     * @var  $startDate
     *
     * @ORM\Column(type="datetime")
     * 
     */
    protected $endDate;
   
     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="banner")
     * 
     * @var File
     */
    protected $imageFile;

    /**
     * @var string $featureImage
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    protected $banner;
   
    /**
     * @ORM\OneToMany(
     *      targetEntity="PromotedProduct",
     *      mappedBy="campaign",  
     *          
     * )
     */
    protected $promotedProducts;


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
     * Set name
     *
     * @param string $name
     *
     * @return Campaign
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
     * Set description
     *
     * @param string $description
     *
     * @return Campaign
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Campaign
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    

    /**
     * Set startDate
     *
     * @param DateTime $startDate
     *
     * @return Campaign
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param DateTime $endDate
     *
     * @return Campaign
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
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
     * @return User
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
     * Set banner
     *
     * @param string $banner
     *
     * @return Campaign
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set company
     *
     * @param Company $company
     *
     * @return Campaign
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

    public function getUser(): User {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

        /**
     * Set discountRate
     *
     * @param string $discountRate
     *
     * @return Campaign
     */
    public function setDiscountRate($discountRate)
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    /**
     * Get discountRate
     *
     * @return string
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->promotedProducts = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    

    /**
     * Add promotedProduct
     *
     * @param \App\Entity\PromotedProduct $promotedProduct
     *
     * @return Campaign
     */
    public function addPromotedProduct(PromotedProduct $promotedProduct)
    {
        $this->promotedProducts[] = $promotedProduct;
        $promotedProduct->setCampaign($this);

        return $this;
    }

    /**
     * Remove promotedProduct
     *
     * @param \App\Entity\PromotedProduct $promotedProduct
     */
    public function removePromotedProduct(PromotedProduct $promotedProduct)
    {
        $this->promotedProducts->removeElement($promotedProduct);
    }

    /**
     * Get promotedProducts
     *
     * @return Collection
     */
    public function getPromotedProducts()
    {
        return $this->promotedProducts;
    }
    public function getFileName() {
        return 'campaign_banner_'.$this->generateRandomString();
    }
}
