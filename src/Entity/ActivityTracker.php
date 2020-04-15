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
 * Description of EntityImage
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="activity_tracker")
 * @ORM\Entity
 * 
 */
class ActivityTracker extends Model{

    /**
     * @var string $entity
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $entity;
   

   /**
     * @var integer $entityId
     *
     * @ORM\Column(type="integer")
     */
    protected $entityId;
   
    /**
     * @var boolean $isReacted
     *
     * @ORM\Column(type="boolean")
     */
    protected $isReacted;
    
    
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="actor_id", referencedColumnName="id")
     */
    protected $actor;
    
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="recipient_id", referencedColumnName="id")
     */
    protected $recipient;
    
   

    /**
     * @var array $reactions
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $reactions;

   
   

   
    function __construct($entity, $entityId, User $actor, User $recipient=null) {
        $this->createdAt = new DateTime();  
        $this->entity=$entity;
        $this->entityId=$entityId;
        $this->actor=$actor;       
        $this->recipient =$recipient ;
        $this->isReacted=false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getEntityId() {
        return $this->entityId;
    }

    public function getIsReacted() {
        return $this->isReacted;
    }

    public function getActor() {
        return $this->actor;
    }

    public function getRecipient() {
        return $this->recipient;
    }

    public function getReactions() {
        return $this->reactions;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
        return $this;
    }

    public function setEntityId($entityId) {
        $this->entityId = $entityId;
        return $this;
    }

    public function setIsReacted($isReacted) {
        $this->isReacted = $isReacted;
        return $this;
    }

    public function setActor(User $actor) {
        $this->actor = $actor;
        return $this;
    }

    public function setRecipient(User $recipient) {
        $this->recipient = $recipient;
        return $this;
    }

    public function setReactions($reactions) {
        $this->reactions = $reactions;
        return $this;
    }


}
