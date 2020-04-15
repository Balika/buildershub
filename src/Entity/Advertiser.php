<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Description of Supplier
 *
 * @author Balika - BTL
 *
 * @ORM\Table(name="advertiser")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Advertiser extends Company{
    const  ROLE = "ROLE_ADVERTISER";
    public function getCompanyType() {
        return $this::ADVERTISER;
    }
}
