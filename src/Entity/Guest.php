<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Description of Guest
 *
 * @author Balika - BTL
 *
 * @ORM\Table(name="guest")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Guest extends Person{
   function __construct() {
       $this->createdAt = new \DateTime();
   }
   public function getPersonType() {
       return self::GUEST;
   }
 public function getDefaultRole(){
       return self::GUEST_ROLE;
   }
}
