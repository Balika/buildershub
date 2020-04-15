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
 * Description of ItemViewedEvent
 *
 * @author Edmond
 */
class ItemViewedEvent extends Event {

    const NAME = 'item.viewed.event';

    protected $enityType;
    protected $entity;
    protected $viewedBy;
    protected $agent;
    protected $page;
    protected $ipAddress;

    public function __construct($entityType, $entity, User $viewedBy=null, $agent = null, $page = null, $ipAddress = null) {
        $this->enityType = $entityType;
        $this->entity = $entity;
        $this->viewedBy = $viewedBy;
        $this->agent = $agent;
        $this->page = $page;
        $this->ipAddress = $ipAddress;
    }
    
    /**
     * This is fully qualified class name of the entity type being viewed. e.g. AppBundle:Product 
     * @return string
     * 
     */
    function getEnityType() {
        return $this->enityType;
    }

    /**
     * An instance of the entity being persisted. Will be used to retrieve the Id used to create an instance of the page view
     * @return Object
     */
    function getEntity() {
        return $this->entity;
    }

    public function getViewedBy() {
        return $this->viewedBy;
    }

    public function getAgent() {
        return $this->agent;
    }

    public function getPage() {
        return $this->page;
    }

    public function getIpAddress() {
        return $this->ipAddress;
    }



}
