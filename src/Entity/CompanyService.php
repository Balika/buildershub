<?php

// src/App/Entity/CompanyService.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Base\BaseModel as Model;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**

 * @author Balika Edmon Mwinbamon <balikaem@gmail.com>
 *
 * @ORM\Table(name="company_service")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 *
 */
class CompanyService extends Model {

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $summary;

    /**
     * @ORM\Column(type="text")
     */
    protected $imageCaption;

    /**
     * @ORM\Column(type="string")
     */
    protected $link;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isEnabled;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="featureImage")
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
    protected $featureImage;
    //#################### Relations with other entites #########################
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $user;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="serviceOfferings")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * 
     */
    protected $company;

    public function __construct(Company $company = null) {
        $this->createdAt = new \DateTime();
        $this->company = $company;
        $this->isEnabled = true;
    }

    public function getTitle() {
        return $this->title;
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
     * @return Person
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    public function getFeatureImage() {
        return $this->featureImage;
    }

    public function getUser() {
        return $this->user;
    }

    public function setTitle($title = null) {
        $this->title = $title;
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

    public function getFileName() {
        return 'Service_Featured_Photo_' . $this->getId();
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany(Company $company = null) {
        $this->company = $company;
        return $this;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getImageCaption() {
        return $this->imageCaption;
    }

    public function getLink() {
        return $this->link;
    }

    public function getIsEnabled() {
        return $this->isEnabled;
    }

    public function setSummary($summary = null) {
        $this->summary = $summary;
        return $this;
    }

    public function setImageCaption($imageCaption = null) {
        $this->imageCaption = $imageCaption;
        return $this;
    }

    public function setLink($link = null) {
        $this->link = $link;
        return $this;
    }

    public function setIsEnabled($isEnabled = null) {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    

}
