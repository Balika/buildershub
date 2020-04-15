<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Region;
use App\Entity\Town;
use App\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjectType
 *
 * @author Edmond
 */
class ProjectType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title')
                ->add('subLocation')
                ->add('summary', TextareaType::class)
                ->add('projectType', ChoiceType::class, array(
                    'choices' => [
                        'New Project' => 'New Project',
                        'Major Rehabilitation Works' => 'Major Rehabilitation Works',
                        'Minor Repairs' => 'Minor Repairs'
                    ],
                    'placeholder' => 'Select Project Type',
                    'required' => true
                ))
                ->add('requestDetails', TextareaType::class, array(
                    'required' => true
                ))
                ->add('budget', TextType::class, array(
                    'required' => false
                ))
                ->add('isActive')
                ->add('user', UserBaseType::class)
                ->add('expectedStartDate', DateType::class, array(
                    'widget' => 'single_text',
                    'placeholder' => 'End date ',
                    'html5' => false,
                    'required' => false
                   
                ))
                ->add('expectedEndDate', DateType::class, array(
                    'widget' => 'single_text',
                    'placeholder' => 'End date ',
                    'html5' => false,
                    'required' => false))
                ->add('imageFile', FileType::class, array('required' => false))
                ->add('galleryFiles', FileType::class, array(
                    'required' => false,
                    'multiple' => true,
                    'data_class' => null
                ))
                ->add('region', EntityType::class, array(
                    'class' => Region::class,
                    'query_builder' => function (RegionRepository $rr) {
                        return $rr->findAllQry();
                    },
                    'placeholder' => 'Select Region'
        ));

        $regionFormModifier = function (FormInterface $form, Region $region = null) {
            $towns = null === $region ? array() : $region->getTowns();
            $form->add('town', EntityType::class, array(
                'class' => Town::class,
                'choices' => $towns,
                'attr' => ['data-select' => 'true'],
                'placeholder' => 'Select Project Location'
            ));
        };

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($regionFormModifier) {
            // this would be your entity, i.e. SportMeetup
            $data = $event->getData();
            $regionFormModifier($event->getForm(), $data!=null ? $data->getRegion() : null);
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
            'data_class' => Project::class
        ));
    }

}
