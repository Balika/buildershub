<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\Town;
use App\Entity\Work;
use App\Repository\RegionRepository;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
 * Description of WorkType
 *
 * @author Edmond
 */
class WorkType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title')
                ->add('subLocation')
                ->add('summary', TextareaType::class)
                ->add('valueOfWorks', null, array(
                    'required' => false))
                 ->add('client')
                ->add('description', TextareaType::class)
                ->add('status', ChoiceType::class, array(
                    'choices' => array(
                        'On-Going' => 'On-Going',
                        'Completed' => 'Completed',
                        'Suspended' => 'Suspended'
                    ),
                    'placeholder' => 'Select Work Status'
                ))
                ->add('startDate', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,                    
                   ))
                ->add('completionDate', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text',                   
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    ))
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
                'placeholder' => 'Select Work Location'
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
            'data_class' => Work::class,
        ));
    }


}
