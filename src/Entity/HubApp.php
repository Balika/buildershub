<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseHubMenu;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of HubApp
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="hub_app")
 * @ORM\Entity
 */
class HubApp extends BaseHubMenu{    
     /**
     * @var string $logo
     *
     * @ORM\Column(type="string")
     */
    protected $logo;
    
    /**
     * @var string $altIcon
     *
     * @ORM\Column(type="string")
     */
    protected $altIcon;
    
    /**
     * @var boolean $isHubenized
     *
     * @ORM\Column(type="boolean")
     */
    protected $isHubernized;
    
    /**
     * @var string $defaultUri
     *
     * @ORM\Column(type="string")
     */
    protected $defaultUri;
    
    
    
    
    public function getIsHubernized() {
        return $this->isHubernized;
    }

    public function setIsHubernized($isHubernized) {
        $this->isHubernized = $isHubernized;       
        return $this;
    }
    public function getLogo() {
        return $this->logo;
    }

    public function setLogo($logo=null) {
        $this->logo = $logo;
        return $this;
    }
    public function getAltIcon() {
        return $this->altIcon;
    }

    public function setAltIcon($altIcon=null) {
        $this->altIcon = $altIcon;
        return $this;
    }
    public function getDefaultUri() {
        return $this->defaultUri;
    }

    public function setDefaultUri($defaultUri=null) {
        $this->defaultUri = $defaultUri;
        return $this;
    }




}
