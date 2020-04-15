<?php

// src/App/Entity/Person.php

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use App\Model\PersonInterface;
use App\Utils\Constants;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**

 * @author Balika Edmon Mwinbamon <balikaem@gmail.com>
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="person_type", type="string")
 * @ORM\DiscriminatorMap({"guest" = "Guest", "builder" = "Builder"})
 */
abstract class Person extends Model implements PersonInterface {

    const ARTISAN    = 'artisan';
    const PROFESSIONAL = 'professional';
    const GUEST = 'guest';
    const STUDENT = 'student';
    const ARTISAN_ROLE    = 'ROLE_ARTISAN';
    const PROFESSIONAL_ROLE = 'ROLE_PROFESSIONAL';
    const GUEST_ROLE = 'ROLE_GUEST';
    const STUDENT_ROLE = 'ROLE_STUDENT';
    const BUILDER = 'builder';
    const BUILDER_ROLE = 'ROLE_BUILDER';
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(
     * choices= {"Male","Female"},
     * message= "Select Gender")
     */
    protected $gender;

    /**
     * @ORM\Column(type="text")
     */
    protected $address;
    
   

    /**
     * @ORM\Column(type="string")
     */
    protected $contactNo;

    /**
     * @ORM\Column(type="string")
     */
    protected $alternateEmail;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    protected $dateOfBirth;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="profilePicture")
     * 
     * @var File
     */
    protected $profileFile;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo_2", fileNameProperty="coverPicture")
     * 
     * @var File
     */
    protected $coverFile;

    /**
     * @var string $profilePicture
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    protected $profilePicture;

    /**
     * @var string $coverPicture
     *
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $coverPicture;
    //#################### Relations with other entites #########################
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="person")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $user;
    
   

    public function getTitle() {
        return $this->title;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getContactNo() {
        return $this->contactNo;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    public function setTitle($title = null) {
        $this->title = $title;
        return $this;
    }

    public function setGender($gender = null) {
        $this->gender = $gender;
        return $this;
    }

    public function setAddress($address = null) {
        $this->address = $address;
        return $this;
    }

    public function setContactNo($contactNo = null) {
        $this->contactNo =  preg_replace('/^0/', Constants::DEFAULT_COUNTRY_PHONE_CODE,$contactNo);
        return $this;
    }

    public function setDateOfBirth($dateOfBirth = null) {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getAlternateEmail() {
        return $this->alternateEmail;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setAlternateEmail($alternateEmail) {
        $this->alternateEmail = $alternateEmail;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
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
    public function setProfileFile(File $image = null) {
        $this->profileFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getProfileFile() {
        return $this->profileFile;
    }

    /**
     * Set profilePicture
     *
     * @param string $profilePicture
     *
     * @return User
     */
    public function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return string
     */
    public function getProfilePicture() {
        return $this->profilePicture;
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
    public function setCoverFile(File $image = null) {
        $this->coverFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    public function getCoverFile() {
        return $this->coverFile;
    }
     public function getCoverPicture() {
        return $this->coverPicture;
    }

    public function setCoverPicture($coverPicture=null) {
        $this->coverPicture = $coverPicture;
        return $this;
    }

    

    /**
     * Get userCompanies
     *
     * @return Collection
     */
    public function getBuilderSpecialties() {
        return $this->builderSpecialties;
    }
    

    public function getFileName() {
        return strtolower($this->user->getFirstname()).'_'.strtolower($this->user->getLastname()).'_profile_picture_'.$this->generateRandomString(5);
    }
    public function getCover() {
        return strtolower($this->user->getFirstname()).'_'.strtolower($this->user->getLastname()).'_profile_cover_'.$this->generateRandomString(5);
    }
}
