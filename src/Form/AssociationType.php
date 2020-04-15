<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Association;
use App\Entity\Institution;
use App\Repository\InstitutionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of AssociationType
 *
 * @author Edmond
 */
class AssociationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('membershipTitle')
                ->add('membershipId')                
                ->add('dateJoined', DateType::class, array(
                    'widget' => 'single_text',
                    'placeholder' => 'End date ',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    'required' => false,
                    'attr' => ['class' => 'form-control']
                        // add a class that can be selected in JavaScript
                ))
                ->add('institution', EntityType::class, array(
                    'required' => true,
                    'class' => Institution::class,
                    'query_builder' => function (InstitutionRepository $ir) {
                        return $ir->findQry('professional');
                    },                    
                    'placeholder' => 'Select Association/Body'
                ))  ;
      
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Association::class,
        ));
    }

}
