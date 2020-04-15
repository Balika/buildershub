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
 * Description of ServiceRequest
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="service_request")
 * @ORM\Entity
 *
 */
class ServiceRequest extends Model {

    /**
     * @var string $requestType
     *
     * @ORM\Column(type="string")
     */
    protected $requestType;
   
    /**
     * @var string $request
     *
     * @ORM\Column(type="string")
     */
    protected $request;
    /**
     * @var boolean $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;
    
    
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="requests")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="lead_id", referencedColumnName="id")
     */
    protected $lead;
    

    
    /**
     * @var boolean $isViewed
     *
     * @ORM\Column(type="boolean")
     */
    protected $isViewed;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;
    
    function __construct($requestType, $request) {
        $this->isViewed=FALSE;
        $this->requestType=$requestType;
        $this->request=$request;
        $this->createdAt = new DateTime();      
    }

    function __toString() {
        $this->request;
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
    public function getRequestType() {
        return $this->requestType;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getUser() {
        return $this->user;
    }

    public function getLead() {
        return $this->lead;
    }

    public function getIsViewed() {
        return $this->isViewed;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setRequestType($requestType) {
        $this->requestType = $requestType;
        return $this;
    }

    public function setRequest($request) {
        $this->request = $request;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setLead(User $lead) {
        $this->lead = $lead;
        return $this;
    }

    public function setIsViewed($isViewed) {
        $this->isViewed = $isViewed;
        return $this;
    }

    public function setCompany(Company $company=null) {
        $this->company = $company;
        return $this;
    }

  

}
