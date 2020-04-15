<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Region;
use App\Entity\Town;
use App\Entity\UserProfile;
use App\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ProfileType
 *
 * @author Edmond
 */
class ProfileType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('profile', TextareaType::class, array('required' => false))
                ->add('help', TextareaType::class, array('required' => false))
                ->add('interests', TextareaType::class, array('required' => false))
                ->add('drive', TextareaType::class, array('required' => false))
                ->add('address', TextareaType::class, array('required' => false))               
                ->add('subLocation', null, array('required' => false))
                /** ->add('category', EntityType::class, array(
                  'class' => "AppBundle:Category",
                  'query_builder' => function (CategoryRepository $cr) {
                  return $cr->findAllParentCategoriesQry();
                  },
                  'attr' => ['data-select' => 'true'],
                  'placeholder' => 'Select Work Category'
                  )) */
                ->add('region', EntityType::class, array(
                    'class' => Region::class,
                    'query_builder' => function (RegionRepository $rr) {
                        return $rr->findAllQry();
                    },
                    'placeholder' => 'Select Region'
        ));

        /* $formModifier = function (FormInterface $form, Category $category = null) {
          $services = null === $category ? array() : $category->getSubCategories();
          $form->add('services', EntityType::class, array(
          'class' => "AppBundle:Category",
          'placeholder' => 'Select Service Offered',
          'required' => false,
          'multiple' => true,
          'choices' => $services,
          ));
          };

          $builder->addEventListener(
          FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
          // this would be your entity, i.e. SportMeetup
          $data = $event->getData();
          $formModifier($event->getForm(), $data->getCategory());
          });

          $builder->get('category')->addEventListener(
          FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
          // It's important here to fetch $event->getForm()->getData(), as
          // $event->getData() will get you the client data (that is, the ID)
          $category = $event->getForm()->getData();
          // since we've added the listener to the child, we'll have to pass on
          // the parent to the callback functions!
          $formModifier($event->getForm()->getParent(), $category);
          }
          ); */

        $regionFormModifier = function (FormInterface $form, Region $region = null) {
            $towns = null === $region ? array() : $region->getTowns();
            $form->add('town', EntityType::class, array(
                'class' => Town::class,                
                'choices' => $towns,
                'placeholder' => 'Select Your Location'
            ));
        };

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($regionFormModifier) {
            // this would be your entity, i.e. SportMeetup
            $data = $event->getData();
            $regionFormModifier($event->getForm(), $data->getRegion());
        });
        $builder->get('region')->addEventListener(
                FormEvents::POST_SUBMIT, function (FormEvent $event) use ($regionFormModifier) {
            // It's important here to fetch $event->getForm()->getData(), as
            // $event->getData() will get you the client data (that is, the ID)
            $region = $event->getForm()->getData();

            // since we've added the listener to the child, we'll have to pass on
            // the parent to the callback functions!
            $regionFormModifier($event->getForm()->getParent(), $region);
        }
        );
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => UserProfile::class
        ));
    }

   
}
