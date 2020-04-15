<?php

namespace App\Form;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// src/AppBundle/Form/MediaHouseRegistrationType.php


use App\Entity\Education;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Description of EducationType
 *
 * @author Edmond
 */
class EducationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('certificateAwarded', TextType::class, array('required'=>true)) 
                ->add('programmeOfStudy',TextType::class, array('required'=>false))
                ->add('yearAwarded',IntegerType::class, array('required'=>false))
                ->add('from', IntegerType::class, array(                    
                    'required'=>true))                   
                ->add('to', IntegerType::class, array(                    
                    'required'=>true                    
                    ))
                 ->add('institution', TextType::class,array('required'=>true))
                ->add('details', TextareaType::class,array('required'=>false));                             
    }          

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Education::class
        ));
    }

   
}
