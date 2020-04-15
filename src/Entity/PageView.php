<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of PageView
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="page_view")
 * @ORM\Entity
 */
class PageView {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @var integer $entityId
     * @ORM\Column(type="integer")
     *
     */
    protected $entityId;

    /**
     * @var string $entity
     *
     * @ORM\Column(type="string")
     */
    protected $entity;

   
    /**
     * @var string $page
     *
     * @ORM\Column(type="string")
     */
    protected $page;
    
     /**
     * @var string $ipAddress
     *
     * @ORM\Column(type="string")
     */
    protected $ipAddress;
     /**
     * @var string $agent
     *
     * @ORM\Column(type="string")
     */
    protected $agent;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="viewed_by", referencedColumnName="id")
     */
    protected $viewedBy;

    

    /**
     * @var datetime $dateViewed
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateViewed;
    
    function __construct($entity, $entityId, User $viewedBy=null, $agent = null, $page = null, $ipAddress = null) {
        $this->entity=$entity;
        $this->entityId=$entityId;
        $this->viewedBy = $viewedBy;
        $this->agent=$agent;
        $this->page=$page;
        $this->ipAddress=$ipAddress;
        $this->dateViewed= new \DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function getEntityId() {
        return $this->entityId;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getPage() {
        return $this->page;
    }

    public function getIpAddress() {
        return $this->ipAddress;
    }

    public function getAgent() {
        return $this->agent;
    }

    public function getViewedBy() {
        return $this->viewedBy;
    }

    public function getDateViewed() {
        return $this->dateViewed;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setEntityId($entityId) {
        $this->entityId = $entityId;
        return $this;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
        return $this;
    }

    public function setPage($page) {
        $this->page = $page;
        return $this;
    }

    public function setIpAddress($ipAddress) {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function setAgent($agent) {
        $this->agent = $agent;
        return $this;
    }

    public function setViewedBy(User $viewdBy) {
        $this->viewedBy = $viewdBy;
        return $this;
    }

    public function setDateViewed($dateViewed=null) {
        $this->dateViewed = $dateViewed;
        return $this;
    }
}
