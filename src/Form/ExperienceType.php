<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ExperienceType
 *
 * @author Edmond
 */
class ExperienceType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('jobTitle')
                ->add('placeOfWork')
                ->add('jobDescription', TextareaType::class)
                ->add('startDate', DateType::class, array(
                    'widget' => 'single_text',
                    'placeholder' => 'Start date ',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    'required'=>false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control']
                ))
                ->add('endDate', DateType::class, array(
                    'widget' => 'single_text',
                    'placeholder' => 'End date ',                   
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    'required'=>false,
                    
                    ))
                ->add('isPresent');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Experience::class,
        ));
    }

}
