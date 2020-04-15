<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use App\Utils\Constants;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Notification
 * @author Edmond
 */

/**
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 * 
 */
class Notification extends Model {

    /**
     * @var string $entity
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $entity;

    /**
     * @var string $emailedTo
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $emailedTo;
    
    /**
     * @var boolean $isViewed
     *
     * @ORM\Column(type="boolean")
     */
    protected $isViewed=FALSE;

    /**
     * @var string $subject
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $subject;

    /**
     * @var string $body
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $body;

    /**
     * @var string $smsTo
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $smsTo;

    /**
     * @var integer $entityId
     *
     * @ORM\Column(type="integer")
     */
    protected $entityId;
    
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $sentTo;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;
    function __construct() {
        $this->createdAt = new DateTime();
    }
    public function getEntity() {
        return $this->entity;
    }
    public function getEntityId() {
        return $this->entityId;
    }
    
    public function getEmailedTo() {
        return $this->emailedTo;
    }
    public function getSubject() {
        return $this->subject;
    }
    public function getBody() {
        return $this->body;
    }
    public function getSmsTo() {
        return $this->smsTo;
    }
    public function getSentTo() {
        return $this->sentTo;
    }
    public function getCompany(){
        return $this->company;
    }
    public function setEmailedTo($emailedTo=null) {
        $this->emailedTo = $emailedTo;
        return $this;
    }
    public function setSubject($subject=null) {
        $this->subject = $subject;
        return $this;
    }
    public function setBody($body=null) {
        $this->body = $body;
        return $this;
    }

    public function setSmsTo($smsTo=null) {
        $this->smsTo = preg_replace('/^0/', Constants::DEFAULT_COUNTRY_PHONE_CODE,$smsTo);
        return $this;
    }
    public function setSentTo(User $sentTo=null) {
        $this->sentTo = $sentTo;
        return $this;
    }
    public function setCompany(Company $company=null) {
        $this->company = $company;
        return $this;
    }
    public function setEntity($entity) {
        $this->entity = $entity;
        return $this;
    }

    public function setEntityId($entityId) {
        $this->entityId = $entityId;
        return $this;
    }

    public function getIsViewed() {
        return $this->isViewed;
    }

    public function setIsViewed($isViewed=FALSE) {
        $this->isViewed = $isViewed;
        return $this;
    }


}
