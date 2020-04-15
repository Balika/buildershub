<?php
namespace App\Events;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SchoolRegisteredEvent
 *
 * @author Edmond
 */
class ItemAddedEvent extends Event{
    const NAME = 'item.added.event';
   
    protected $enityType;
    protected $entity;
    protected $actor;
    protected $recipient;

    public function __construct($entityType, $entity, User $actor=null, User $recipient=null)
    {      
        $this->enityType = $entityType;
        $this->entity = $entity;
        $this->actor = $actor;
        $this->recipient= $recipient;
    }  
    function getEnityType() {
        return $this->enityType;
    }

    function getEntity() {
        return $this->entity;
    }
    public function getActor() {
        return $this->actor;
    }

    public function getRecipient() {
        return $this->recipient;
    }
}
