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
 * Description of Education
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="certs_obtained")
 * @ORM\Entity(repositoryClass="App\Repository\EducationRepository")
 */
class Education extends Model {
      /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $certificateAwarded
     *
     * @ORM\Column(type="string", name="name")
     */
    protected $certificateAwarded;
    
    /**
     * @var string $programmeOfStudy
     *
     * @ORM\Column(type="string")
     */
    protected $programmeOfStudy;
     /**
     * @var string $details
     *
     * @ORM\Column(type="string")
     */
    protected $details;

    /**
     * @var  $yearAwarded
     *
     * @ORM\Column(type="integer")
     */
    protected $yearAwarded;
    
     /**
     * @var  $from
     *
     * @ORM\Column(type="integer", name="start_study")
     */
    protected $from;

    /**
     * @var  $to
     *
     * @ORM\Column(type="integer", name="end_study")
     */
    protected $to;

    
    
    //Relations with other entites
    /**
     * @ORM\Column(type="string")
     */
    protected $institution;
    
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="educationHistory")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    function __construct(User $user=null) {
        $this->createdAt = new DateTime();             
        $this->user=$user;
    }

    public function getId() {
        return $this->id;
    }

    public function getCertificateAwarded() {
        return $this->certificateAwarded;
    }

    public function getProgrammeOfStudy() {
        return $this->programmeOfStudy;
    }

    public function getYearAwarded() {
        return $this->yearAwarded;
    }

    public function getFrom() {
        return $this->from;
    }

    public function getTo() {
        return $this->to;
    }

    public function getInstitution() {
        return $this->institution;
    }

    public function getUser() {
        return $this->user;
    }

    public function setCertificateAwarded($certificateAwarded) {
        $this->certificateAwarded = $certificateAwarded;
    }

    public function setProgrammeOfStudy($programmeOfStudy) {
        $this->programmeOfStudy = $programmeOfStudy;
    }

    public function setYearAwarded($yearAwarded) {
        $this->yearAwarded = $yearAwarded;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function setTo($to) {
        $this->to = $to;
    }

    public function setInstitution($institution) {
        $this->institution = $institution;
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;
        return $this;
    }


}
