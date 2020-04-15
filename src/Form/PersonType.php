<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ArtisanType
 *
 * @author Balika - BTL
 */
class PersonType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('content', null, ['required' => false]);
        $builder
                ->add('gender', ChoiceType::class, array(
                    'choices' => array(
                        ' Male ' => 'Male',
                        ' Female ' => 'Female'
                    ),
                    'expanded' => true
                ))
                ->add('title', ChoiceType::class, array(
                    'choices' => array(
                        ' Mr. ' => 'Mr.',
                        ' Mrs. ' => 'Mrs',
                        ' Ms. ' => 'Ms',
                        ' Dr. ' => 'Dr.',
                        ' Prof. ' => 'Prof.',
                        ' Rev. ' => 'Rev.',
                    ),
                    'expanded' => true
                ))
                ->add('contactNo')
                ->add('address', TextareaType::class, ['required' => FALSE])
                ->add('alternateEmail', EmailType::class, ['required' => FALSE])
                ->add('dateOfBirth', DateType::class, array(
                    'widget' => 'single_text',
                    'placeholder' => array(
                        'year' => 'Year', 'month' => 'Month', 'day' => 'Day'
                    ),
                    // this is actually the default format for single_text                
                    'required' => false,
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Person::class
        ]);
    }

}
