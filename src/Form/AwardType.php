<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Award;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of AwardType
 *
 * @author Edmond
 */
class AwardType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('placeOfAward')
                ->add('awardingOrganisation')
                ->add('awardDate', DateType::class, array(
                    'widget' => 'single_text',
                    'placeholder' => 'End date ',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    'required' => false,                    
                        // add a class that can be selected in JavaScript
                ))
                ->add('imageFile', FileType::class, array('required' => false))
                ->add('galleryFiles', FileType::class, array(
                    'required' => false,
                    'multiple' => true,
                    'data_class' => null
                ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Award::class,
        ));
    }

}
