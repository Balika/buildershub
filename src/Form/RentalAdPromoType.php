<?php

namespace App\Form;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// src/AppBundle/Form/MediaHouseRegistrationType.php


use App\Entity\RentalPromo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Description of ProductSaleOptionsType
 *
 * @author Edmond
 */
class RentalAdPromoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('promoAmount',null, array('required'=>false))                
                ->add('promoStartDate', DateType::class, array(
                    'required' => true,
                    'widget' => 'single_text',
                    'placeholder' => 'Select campaign end date',
                    'format' => 'yyyy-MM-dd',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control date']))
                ->add('promoEndDate', DateType::class, array(
                    'required' => true,
                    'widget' => 'single_text',
                    'placeholder' => 'Select campaign end date',
                    'format' => 'yyyy-MM-dd',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control date']));                                                     
    }          

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RentalPromo::class
        ));
    }
}
