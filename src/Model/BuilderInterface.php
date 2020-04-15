<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 *
 * @author Balika - BTL
 */
interface BuilderInterface {
     /**
     * Gets the groups granted to the user.
     *
     * @return \Traversable
     */
    public function getBuilderTypes();
    
    /**
     * Indicates whether the builder belongs to the specified builderGroup or not.
     *
     * @param string $type Name of the group
     *
     * @return bool
     */
    public function hasBuilderType($type);
}
