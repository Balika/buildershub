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
 * Description of AppMenuItem
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="app_menu_item")
 * @ORM\Entity
 */
class AppMenuItem extends BaseHubMenu{
    /**
     * @var string $label
     *
     * @ORM\Column(type="string")
     */
    protected $route;

    /**
     * @var HubApp
     * @ORM\ManyToOne(targetEntity="HubApp")
     * @ORM\JoinColumn(name="app_id", referencedColumnName="id")
     */
    protected $app;
    
    

    public function getRoute() {
        return $this->route;
    }

    public function getApp() {
        return $this->app;
    }

    public function setRoute($route) {
        $this->route = $route;
        return $this;
    }

    public function setApp(HubApp $app) {
        $this->app = $app;
        return $this;
    }



}
