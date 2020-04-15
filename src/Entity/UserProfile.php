<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Description of UserProfile
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="user_profile")
 * @ORM\Entity
 */
class UserProfile {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @var string $profile
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $profile;
    
    /**
     * @var string $countryCode
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $countryCode;

    /**
     * @var string $help
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $help;

    /**
     * @var string $drive
     *
     * @ORM\Column(type="string")
     */
    protected $drive;

    /**
     * @var string $address
     *
     * @ORM\Column(type="string")
     */
    protected $address;

    /**
     * @var string $subLocation
     *
     * @ORM\Column(type="string")
     */
    protected $subLocation;

    /**
     * @var string $help
     *
     * @ORM\Column(type="string")
     */
    protected $interests;

    /**
     * @var string $latitude
     *
     * @ORM\Column(type="string")
     */
    protected $latitude;

    /**
     * @var string $latitude
     * @ORM\Column(type="string")
     */
    protected $longitude;

    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Region",fetch="EAGER")
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
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="userProfile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    protected $user;

   

    public function __construct(User $user=null) {
        $this->user = $user;
    }

    /**
     * Get id
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set profile
     *
     * @param string $profile
     *
     * @return UserProfile
     */
    public function setProfile($profile) {
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
     * Set experience
     *
     * @param string $help
     *
     * @return UserProfile
     */
    public function setHelp($help) {
        $this->help = $help;

        return $this;
    }

    /**
     * Get help
     *
     * @return string
     */
    public function getHelp() {
        return $this->help;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return UserProfile
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return UserProfile
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude() {
        return $this->longitude;
    }

   
    /**
     * Set town
     *
     * @param \App\Entity\Town $town
     *
     * @return UserProfile
     */
    public function setTown(\App\Entity\Town $town = null) {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return \App\Entity\Town
     */
    public function getTown() {
        return $this->town;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return UserProfile
     */
    public function setUser(\App\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    

    /**
     * Set region
     *
     * @param \App\Entity\Region $region
     *
     * @return UserProfile
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
     * Set interests
     *
     * @param string $interests
     *
     * @return UserProfile
     */
    public function setInterests($interests) {
        $this->interests = $interests;

        return $this;
    }

    /**
     * Get interests
     *
     * @return string
     */
    public function getInterests() {
        return $this->interests;
    }

    /**
     * Set drive
     *
     * @param string $drive
     *
     * @return UserProfile
     */
    public function setDrive($drive) {
        $this->drive = $drive;

        return $this;
    }

    /**
     * Get drive
     *
     * @return string
     */
    public function getDrive() {
        return $this->drive;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return UserProfile
     */
    public function setAddress($address) {
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
     * Set subLocation
     *
     * @param string $subLocation
     *
     * @return UserProfile
     */
    public function setSubLocation($subLocation) {
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

    
    public function getCountryCode() {
        return $this->countryCode;
    }

    public function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;
        return $this;
    }
}
