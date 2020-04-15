<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/AppBundle/Form/MediaHouseRegistrationType.php


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of RegistrationType
 *
 * @author Edmond
 */
class RegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstname',TextType::class, array('required' => true))
                ->add('lastname',TextType::class, array('required' => true))                
                ->add('username', TextType::class, array('required' => true))
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                ))
                ->add('email', null, array('required' => FALSE))
                ->add('contactNo', null, array('required' => FALSE))
                ->add('agreeTerms', CheckboxType::class, array('mapped' => FALSE, 'required' => TRUE))
                ->add('companyName', null, array('required' => true, 'mapped' => FALSE));
                
    }

     /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }


    public function getBlockPrefix() {
        return 'app_user_registration';
    }
}
