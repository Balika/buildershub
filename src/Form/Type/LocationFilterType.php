<?php

namespace App\Form\Type;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Region;
use App\Entity\Town;
use App\Entity\UserProfile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of LocationFilterType
 *
 * @author Edmond
 */
class LocationFilterType extends AbstractType {

    private $userProfile;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->userProfile = $options['userProfile'];
        $currentCountryCode = $this->userProfile->getRegion() != null ? $this->userProfile->getRegion()->getCountryCode() : '';

        /* $builder->addEventSubscriber(new AddCityFieldSubscriber('town'))
          ->addEventSubscriber(new AddRegionFieldSubscriber('town'))
          ->addEventSubscriber(new AddCountryFieldSubscriber('town', $currentCountryCode))
          ->add('subLocation', TextType::class, array(
          'required' => false)); */

        $builder->add('countryCode', CountryType::class, array(
                    'data' => $currentCountryCode,
                    'preferred_choices' => array(
                        'NG', 'GH', 'BJ', 'LR', 'TG'
                    ),
                    'placeholder' => 'Select your country'
                ))
                ->add('region', EntityType::class, array(
                'class' => Region::class,                
                'required' => TRUE,
                'placeholder' => 'Select Region'
            ))
                ->add('subLocation', TextType::class, array(
                    'required' => false));

      /**  $countryFormModifier = function (FormInterface $form, $countryCode = null) {
            $form->add('region', EntityType::class, array(
                'class' => Region::class,
                'query_builder' => function (RegionRepository $rr) use ($countryCode) {
                    return $rr->findCountryRegionsQry($countryCode);
                },
                'required' => TRUE,
                'placeholder' => 'Select Region'
            ));
        };

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($countryFormModifier) {
            // this would be your entity, i.e. SportMeetup
            $data = $event->getData();
            $countryFormModifier($event->getForm(), $data->getCountryCode());
        });
        $builder->get('countryCode')->addEventListener(
                FormEvents::POST_SUBMIT, function (FormEvent $event) use ($countryFormModifier) {
            // It's important here to fetch $event->getForm()->getData(), as
            // $event->getData() will get you the client data (that is, the ID)
            $countryCode = $event->getForm()->getData();
            // since we've added the listener to the child, we'll have to pass on
            // the parent to the callback functions!
            $countryFormModifier($event->getForm()->getParent(), $countryCode);
        });
        //$builder->addEventSubscriber(new AddCityFieldSubscriber('town'));

*/
        $regionFormModifier = function (FormInterface $form, $region = null) {
            $towns = null === $region ? array() : $region->getTowns();
            $form->add('town', EntityType::class, array(
                'class' => Town::class,
                'choices'=>$towns,
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
            'data_class' => UserProfile::class,
            'userProfile' => null
        ));
    }

    public function getBlockPrefix() {
        return 'location_filter';
    }

    // For Symfony 2.x
    public function getName() {
        return $this->getBlockPrefix();
    }

}
