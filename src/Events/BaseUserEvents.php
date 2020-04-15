<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Events;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;


/**
 * Description of BaseUserEvents
 *
 * @author Balika - MRH
 */
class BaseUserEvents extends Event{
    protected $user;
    protected $token;

    public function __construct(User $user, $token) {
        
        $this->user = $user;
        $this->token = $token;
    }

    public function getUser() {
        return $this->user;
    }

    public function getToken() {
        return $this->token;
    }

}
