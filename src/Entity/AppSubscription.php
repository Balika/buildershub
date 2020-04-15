<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of AppSubscription
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="app_subscription")
 * @ORM\Entity
 */
class AppSubscription extends Model {

    /**
     * @var string $subscriptionType
     *
     * @ORM\Column(type="string")
     */
    protected $subscriptionType;

    /**
     * @var HubApp
     * @ORM\ManyToOne(targetEntity="HubApp")
     * @ORM\JoinColumn(name="app_id", referencedColumnName="id")
     */
    protected $app;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    public function __construct(HubApp $app, Company $company, User $user, $subscriptionType='SingleModule') {
        $this->subscriptionType = $subscriptionType;
        $this->app = $app;
        $this->company = $company;
        $this->user = $user;
        $this->createdAt = new \DateTime();
    }

    
    public function getSubscriptionType() {
        return $this->subscriptionType;
    }

    public function getApp() {
        return $this->app;
    }

    public function getCompany(){
        return $this->company;
    }

    public function getUser() {
        return $this->user;
    }

    public function setSubscriptionType($subscriptionType) {
        $this->subscriptionType = $subscriptionType;
        return $this;
    }

    public function setApp(HubApp $app) {
        $this->app = $app;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }



}
