<?php

namespace App\Form;

use App\Entity\ProductData;
use App\Entity\Unit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// src/AppBundle/Form/MediaHouseRegistrationType.php



/**
 * Description of ProjectCategoryType
 *
 * @author Edmond
 */
class ProductDataType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('regularPrice',null, array('required'=>true)) 
                ->add('salePrice',null, array('required'=>false))
                ->add('unit', EntityType::class, array(
                    'class' => Unit::class,
                    'required'=>false,
                    // 'attr' => ['data-select' => 'true']
                    ))
                ->add('saleVolume', NumberType::class, array('required'=>false))
                ->add('SKU',null, array('required'=>false))
                ->add('isStockManaged',null, array('required'=>false))
                ->add('isSoldIndividually',null, array('required'=>false))
                ->add('stockQuantity',null, array('required'=>false))
                ->add('stockStatus', ChoiceType::class, array(
                    'choices' => array(                
                        ' In Stock ' => 'In Stock',
                        ' Out of Stock ' => 'Out of Stock'
                                             
                     ),                    
                    'expanded'=>false,
                    ))
                ->add('backOrders', ChoiceType::class, array(
                    'choices' => array(                
                        ' Do Not Allow ' => 'Do Not Allow',
                        ' Allow, But inform Customer ' => 'Allow, But Inform',
                        ' Allow ' => 'Allow'
                                             
                     ),                    
                    'expanded'=>false,
                    ))
                ->add('salePriceDateFrom', DateType::class)
                ->add('salePriceDateTo', DateType::class); 
                                              
    }          

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProductData::class
        ));
    }

   

}
