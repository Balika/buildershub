<?php

namespace App\Form\Inventory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\RentalRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of RentalRequestType
 *
 * @author Edmond Balika
 */
class RentalRequestType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('message', TextareaType::class, array('required' => true))  
                ->add('phone', TextType::class, array('required' => true))
                ->add('email', TextType::class, array('required' => false))
                ->add('numberRequested', NumberType::class, array('required' => true));
                
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => RentalRequest::class,
            
        ));
    }

}
