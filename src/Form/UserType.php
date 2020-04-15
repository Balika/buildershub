<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/AppBundle/Form/MediaHouseRegistrationType.php


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of UserType
 *
 * @author Edmond
 */
class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('userProfile', ProfileType::class)
                ->add('person', PersonType::class) ;               
    }
    public function getParent(): string {
        return UserBaseType::class;
    }

}
