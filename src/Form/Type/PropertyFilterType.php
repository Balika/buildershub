<?php

namespace App\Form\Type;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Property;
use App\Entity\Region;
use App\Entity\Town;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PropertyFilterType
 *
 * @author Edmond
 */
class PropertyFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('region', EntityType::class, array(
                    'class' => Region::class,
                    'required' => TRUE,
                    'placeholder' => 'Select Region'
                ))
                ->add('neighbourhood', ChoiceType::class, array(
                    'choices' => array(
                        'Gated Community' => 'Gated Community',
                        'Level 5 Residential Area' => 'Level 5 Residential Area'
                    ),
                    'required' => false,
                     'placeholder' => 'Select Preferred Neighbourhood'
                ))
                ->add('buildingType', ChoiceType::class, array(
                    'choices' => array(
                        'Apartment' => 'Apartment',
                        'Villa' => 'Villa',
                        'Commercial Property' => 'Commercial Property'
                    ),
                    'required' => false,
                     'placeholder' => 'Select Propety Type'
                ))
                 ->add('bedrooms', ChoiceType::class, array(
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '8',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10'
                    ),
                    'required' => false,
                      'placeholder' => 'Number of Bedrooms'
                ))
                ->add('bathrooms', ChoiceType::class, array(
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '8',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10'
                    ),
                    'required' => false,
                     'placeholder' => 'Number of Bathrooms'
                ))
                ->add('parkingLots', ChoiceType::class, array(
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '8',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10'
                    ),
                    'required' => false,
                    'placeholder' => 'Number of Parking Spaces'
                ))
                ->add('subLocation', TextType::class, array(
                    'required' => false))
                ->add('area', TextType::class, array(
                    'required' => false))
                 ->add('minPrice', NumberType::class, array(
                    'required' => false))
                 ->add('maxPrice', NumberType::class, array(
                    'required' => false));


        $regionFormModifier = function (FormInterface $form, $region = null) {
            $towns = null === $region ? array() : $region->getTowns();
            $form->add('town', EntityType::class, array(
                'class' => Town::class,
                'choices' => $towns,
                'required' => false,
                'placeholder' => 'Select Town'
            ));
        };

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($regionFormModifier) {
            // this would be your entity, i.e. SportMeetup
            $data = $event->getData();
            $regionFormModifier($event->getForm(), $data->getRegion());
        });

        //$builder->addEventSubscriber(new AddCityFieldSubscriber('town'));
        $builder->get('region')
                ->addEventListener(
                        FormEvents::POST_SUBMIT, function (FormEvent $event) use ($regionFormModifier) {
                    $region = $event->getForm()->getData();
                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                    $regionFormModifier($event->getForm()->getParent(), $region);
                });
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Property::class,
        ));
    }

}
