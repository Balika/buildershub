<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity\Base;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
/**
 * Description of BaseHubMenu
 *
 * @author Balika
 */
class BaseHubMenu {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @var string $label
     *
     * @ORM\Column(type="string")
     */
    protected $label;
    
    /**
     * @var integer $rank
     *
     * @ORM\Column(type="integer")
     */
    protected $rank;
    
    /**
     * @var boolean $isEnabled
     *
     * @ORM\Column(type="boolean")
     */
    protected $isEnabled;

    /**
     * @var string $code
     *
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * @var string $icon
     *
     * @ORM\Column(type="string")
     */
    protected $icon;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    public function __toString(){
        return $this->label.'';
    }
    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getCode() {
        return $this->code;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getUser() {
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setUser(User $user=null) {
        $this->user = $user;
        return $this;
    }

    public function getRank() {
        return $this->rank;
    }

    public function setRank($rank) {
        $this->rank = $rank;
        return $this;
    }

    public function getIsEnabled() {
        return $this->isEnabled;
    }

    public function setIsEnabled($isEnabled) {
        $this->isEnabled = $isEnabled;
        return $this;
    }




}
