<?php

namespace App\Form;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// src/AppBundle/Form/MediaHouseRegistrationType.php


use App\Entity\ProductSaleOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Description of ProductSaleOptionsType
 *
 * @author Edmond
 */
class ProductSaleOptionsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('price',null, array('required'=>false))
                ->add('unit',null, array('required'=>false))
                ->add('saleVolume', null, array('required'=>false))
                ->add('brand',null, array('required'=>false))
                ->add('dimension',null, array('required'=>false));                                             
    }          

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProductSaleOptions::class
        ));
    }
}
