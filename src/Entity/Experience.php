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

/**
 * Description of Experience
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="experience")
 * @ORM\Entity(repositoryClass="App\Repository\ExperienceRepository")
 */
class Experience extends Model{
     /**
     * @var string $placeOfWork
     *
     * @ORM\Column(type="string")
     */
    protected $placeOfWork;
    /**
     * @var string $jobTitle
     *
     * @ORM\Column(type="string")
     */
    protected $jobTitle;

   
    /**
     * @var  $startDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $startDate;
    
     /**
     * @var  $endDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $endDate;
    
    /**
     * @var string $jobDescription
     *
     * @ORM\Column(type="string")
     */
    protected $jobDescription;
    
    /**
     * @var boolean $isPresent
     *
     * @ORM\Column(type="boolean")
     */
    protected $isPresent;
    
 
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="jobHistory")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
     
    
    
    function __construct() {        
        $this->createdAt= new DateTime();
        $this->isPresent = FALSE;        
    }
    



    /**
     * Set placeOfWork
     *
     * @param string $placeOfWork
     *
     * @return Experience
     */
    public function setPlaceOfWork($placeOfWork)
    {
        $this->placeOfWork = $placeOfWork;

        return $this;
    }

    /**
     * Get placeOfWork
     *
     * @return string
     */
    public function getPlaceOfWork()
    {
        return $this->placeOfWork;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Experience
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
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Experience
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set jobDescription
     *
     * @param string $jobDescription
     *
     * @return Experience
     */
    public function setJobDescription($jobDescription)
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    /**
     * Get jobDescription
     *
     * @return string
     */
    public function getJobDescription()
    {
        return $this->jobDescription;
    }

    /**
     * Set isPresent
     *
     * @param boolean $isPresent
     *
     * @return Experience
     */
    public function setIsPresent($isPresent)
    {
        $this->isPresent = $isPresent;

        return $this;
    }

    /**
     * Get isPresent
     *
     * @return boolean
     */
    public function getIsPresent()
    {
        return $this->isPresent;
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
     * @return Experience
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set jobTitle
     *
     * @param string $jobTitle
     *
     * @return Experience
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }
}
