<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Company;
use App\Entity\Region;
use App\Entity\Town;
use App\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of CompanyType
 *
 * @author Edmond
 */
class CompanyType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('businessSummary', TextareaType::class, array('required' => false))
                ->add('profile', TextareaType::class, array('required' => false))
                ->add('telephone1', TextType::class, array('required' => false))
                ->add('telephone2', TextType::class, array('required' => false))
                ->add('mobile1', TextType::class, array('required' => false))
                ->add('mobile2', TextType::class, array('required' => false))
                ->add('email', EmailType::class, array('required' => true))
                ->add('url', TextType::class, array('required' => false), array('required' => false))
                ->add('imageFile', FileType::class, array('required' => false))
                ->add('isActive')
                ->add('companySize', ChoiceType::class, array(
                    'choices' => array(
                        ' Less Than 10 ' => 'Less Than 10',
                        ' 10 to 20 ' => '10 to 20',
                        ' 20 to 50 ' => '20 to 50',
                        ' 50 to 100 ' => '50 to 100',
                        ' More Than 100 ' => 'More Than 100'
                    ),
                    'expanded' => false,
                    'placeholder' => 'Select Company Size'
                ))
                ->add('address', TextareaType::class, array('required' => false))
                ->add('vision', TextareaType::class, array('required' => false))
                ->add('mission', TextareaType::class, array('required' => false))
                ->add('history', TextareaType::class, array('required' => false))
                ->add('owner', CompanyOwnerType::class, array('required' => true))
                ->add('subLocation', null, array('required' => false))
                ->add('historySubBtn', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-tiny border border-blue xround-1 pull-right')))
                ->add('summarySubBtn', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-tiny border border-blue xround-1 pull-right')))
                ->add('visionSubBtn', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-tiny border border-blue xround-1 pull-right')))
                ->add('missionSubBtn', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-tiny border border-blue xround-1 pull-right')))
                ->add('region', EntityType::class, array(
                    'class' => Region::class,
                    'query_builder' => function (RegionRepository $rr) {
                        return $rr->findAllQry();
                    },
                    'placeholder' => 'Select Region'
        ));

        $regionFormModifier = function (FormInterface $form, Region $region = null) {
            $towns = null === $region ? array() : $region->getTowns();
            $form->add('businessLocation', EntityType::class, array(
                'class' => Town::class,
                'choices' => $towns,
                'placeholder' => 'Select Business Location'
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
            'data_class' => Company::class,
        ));
    }

    public function getBlockPrefix() {
        return 'app_company';
    }

    // For Symfony 2.x
    public function getName() {
        return $this->getBlockPrefix();
    }

}
