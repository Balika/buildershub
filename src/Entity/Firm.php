<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Description of Firm
 *
 * @author Balika - BTL
 *
 * @ORM\Table(name="firm")
 * @ORM\Entity(repositoryClass="App\Repository\FirmRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Firm extends Company{
     const  ROLE = "ROLE_FIRM";
    public function getCompanyType() {
        return $this::FIRM;
    }

}
