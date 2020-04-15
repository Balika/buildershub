<?php

// src/App/Entity/User.php

namespace App\Entity;

use App\Entity\Base\BaseUser;
use App\Utils\HubUtil;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="c_user")
 * @author Balika Edmon Mwinbamon <balikaem@gmail.com
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"username"},
 *  message="The username chosen has already been taken"
 * )
 * 
 */
class User extends BaseUser {

    /**
     * @ORM\Column(type="string")
     *
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string")
     *
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string")
     *
     */
    protected $contactNo;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    protected $isActive;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    protected $expired;
    //###### Related Fields #######/
    /**
     * @var $person
     *
     * @ORM\OneToOne(targetEntity="Person", mappedBy="user", cascade={"persist"})
     */
    protected $person;

    /**
     * @var $company
     *
     * @ORM\OneToOne(targetEntity="Company", mappedBy="owner", cascade={"persist"})
     */
    protected $company;

    /**
     * @var $userProfile
     *
     * @ORM\OneToOne(targetEntity="UserProfile", mappedBy="user", cascade={"persist"})
     * 
     */
    protected $userProfile;

    /**
     *   @ORM\ManyToMany(targetEntity="Company")
     *   @ORM\JoinTable(name="user_company",
     *   joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")})
     * */
    protected $userCompanies;

    /**
     * @ORM\OneToMany(
     *      targetEntity="ServiceRequest",
     *      mappedBy="user",       
     * )
     */
    protected $requests;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Work",
     *      mappedBy="user",       
     * )
     */
    protected $works;

    /**
     *
     *   @ORM\ManyToMany(targetEntity="User")
     *   @ORM\JoinTable(name="follow",
     *   joinColumns={@ORM\JoinColumn(name="follower", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="following", referencedColumnName="id")})
     * */
    protected $following;

    /**
     *
     *   @ORM\ManyToMany(targetEntity="User")
     *   @ORM\JoinTable(name="follow",
     *   joinColumns={@ORM\JoinColumn(name="following", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="follower", referencedColumnName="id")})
     * */
    protected $followers;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Order",
     *      mappedBy="customer",
     *      cascade={"persist"}       
     * )
     */
    protected $orders;

    public function __construct() {
        parent::__construct();
        $this->createdAt = new \DateTime();
        $this->userCompanies = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
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

    /*
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return User
     */

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function isEqualTo(UserInterface $user) {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /*     * ################################## Transcient Properties ################################# */

    public function getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getPerson() {
        return $this->person;
    }

    /**
     * @return Person
     */
    public function setPerson(Person $person = null) {
        $this->person = $person;
        $person->setUser($this);
        return $this;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany(Company $company = null) {
        $this->company = $company;
        $company->setOwner($this);
        return $this;
    }

    public function getContactNo() {
        return $this->contactNo;
    }

    public function setContactNo($contactNo = null) {
        $this->contactNo = HubUtil::internationalizePhoneNumber($contactNo);
        return $this;
    }

    public function getUserProfile() {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfile $userProfile = null) {
        $this->userProfile = $userProfile;
        $userProfile->setUser($this);
        return $this;
    }

    /**
     * Add Company
     *
     * @param Company $company
     *
     * @return User
     */
    public function addCompany(Company $company) {
        $this->userCompanies[] = $company;

        return $this;
    }

    /**
     * Remove company
     *
     * @param Company $company
     */
    public function removeCompany(Company $company) {
        $this->userCompanies->removeElement($company);
    }

    /**
     * Get userCompanies
     *
     * @return Collection
     */
    public function getUserCompanies() {
        return $this->userCompanies;
    }

    /**
     * Add request
     *
     * @param ServiceRequest $request
     *
     * @return User
     */
    public function addRequest(ServiceRequest $request) {
        $this->requests[] = $request;

        return $this;
    }

    /**
     * Remove request
     *
     * @param ServiceRequest $request
     */
    public function removeRequest(ServiceRequest $request) {
        $this->requests->removeElement($request);
    }

    /**
     * Get requests
     *
     * @return Collection
     */
    public function getRequests() {
        return $this->requests;
    }

    public function getWorks() {
        return $this->works;
    }

    /**
     * Add work
     *
     * @param Work $work
     *
     * @return Company
     */
    public function addWork(Work $work) {
        $this->works[] = $work;

        return $this;
    }

    /**
     * Remove work
     *
     * @param Work $work
     */
    public function removeWork(Work $work) {
        $this->works->removeElement($work);
    }

    /**
     * Add follower
     *
     * @param User $follower
     *
     * @return User
     */
    public function addFollower(User $follower) {
        $this->followers[] = $follower;

        return $this;
    }

    /**
     * Remove follower
     *
     * @param User $follower
     */
    public function removeFollower(User $follower) {
        $this->followers->removeElement($follower);
    }

    /**
     * Get followers
     *
     * @return Collection
     */
    public function getFollowers() {
        return $this->followers;
    }

    /**
     * Add following
     *
     * @param User $following
     *
     * @return User
     */
    public function addFollowing(User $following) {
        $this->following[] = $following;

        return $this;
    }

    /**
     * Remove following
     *
     * @param User $following
     */
    public function removeFollowing(User $following) {
        $this->following->removeElement($following);
    }

    /**
     * Get following
     *
     * @return Collection
     */
    public function getFollowing() {
        return $this->following;
    }

     /**
     * Add order
     *
     * @param Order $order
     *
     * @return Company
     */
    public function addOrder(Order $order) {
        $this->orders[] = $order;
        $order->setCustomer($this);
        return $this;
    }

    /**
     * Remove order
     *
     * @param Order $order
     */
    public function removeOrder(Order $order) {
        $this->orders->removeElement($order);
    }
    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired() {
        return true;
    }
    public function getOrders() {
        return $this->orders;
    }

        /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired() {
        return true;
    }

}
