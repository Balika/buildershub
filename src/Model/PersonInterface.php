<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 *
 * @author Balika - MRH
 */
interface PersonInterface {
   /**
     * Return the attribute PersonType
     */
    public function getPersonType();
    public function getDefaultRole();
}
