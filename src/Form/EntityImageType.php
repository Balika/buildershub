<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\EntityImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of EnityImageType
 *
 * @author Edmond
 */
class EntityImageType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('imageFile', FileType::class, array('required' => true))
                ->add('caption', TextareaType::class, array('required' => true))
                ->add('photos', FileType::class, array('required' => false, 'multiple'=>true, 'mapped'=>false));       
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => EntityImage::class
        ));
    }

   
}
