<?php

namespace App\Form\Inventory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Region;
use App\Entity\RentalAd;
use App\Entity\Town;
use App\Repository\EquipmentRepository;
use App\Utils\EntityConfig;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of RentalAdType
 *
 * @author Edmond Balika
 */
class RentalAdType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $company = $options['company'];
        $builder->add('imageFile', FileType::class, array('required' => false))
                ->add('title', TextType::class, array('required' => true))
                ->add('rentalRate', TextType::class, array('required' => false))
                ->add('slug', TextType::class, array('required' => false))
                ->add('subLocation', TextType::class, array('required' => false))
                ->add('unitsAvailable', NumberType::class, array('required' => false))
                ->add('datePublished', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    'placeholder' => 'Date Published',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'gui-input']))
                ->add('billingCycle', ChoiceType::class, array(
                    'choices' => [
                        'Hourly' => 'Hourly',
                        "Daily" => "Daily",
                        "Weekly" => "Weekly",
                        "Monthly" => "Monthly",
                        "Yearly" => "Yearly"
                    ],
                    'required' => false,
                    'placeholder'=>"Select billing cycle"
                ))
                ->add('equipment', EntityType::class, array(
                    'class' => EntityConfig::EQUIPMENT,
                    //'attr' => ['data-select' => 'true'],
                    'query_builder' => function (EquipmentRepository $er) use ($company) {
                        return $er->findCompanyEquipmentQry($company);
                    },
                    'placeholder' => "Select Equipment to Rent Out",
                    'required' => false
                ))

                ->add('isPublished')
                ->add('region', EntityType::class, array(
                    'class' => Region::class,
                    //'attr' => ['data-select' => 'true'],
                    'required' => true,
                    'placeholder' => 'Select Region Equipment is Available',
                ))
                ->add('description', TextareaType::class, array('required' => true));

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
            'data_class' => RentalAd::class,
            'company'=>null
        ));
    }

}
