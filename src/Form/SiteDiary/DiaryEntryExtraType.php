<?php

namespace App\Form\SiteDiary;

use App\HubernizeModel\Diary\CreateDiaryEntry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiaryEntryExtraType
 *
 * @author Balika
 */
class DiaryEntryExtraType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('projectName', TextType::class, [
                    'constraints' => new Length(['min' => 3]),
                ])
                ->add('entryName', ChoiceType::class, [
                    'choices' => [
                        'Labour' => 'LBR',
                        'Plant' => 'PLNT',
                        'Equipment' => 'EQPT',
                        'Materials' => 'MTRL',
                        'Other Expenses' => 'OTHR',
                    ],
                    'required' => true
                ])
                ->add('location', TextareaType::class, array('required' => false))
                ->add('latLong', TextType::class, array('required' => false))
                ->add('activity', TextareaType::class, array('required' => true))
                ->add('shiftName', TextType::class, array('required' => false))
                ->add('shiftStart', TimeType::class, array('required' => false))
                ->add('shiftEnd', TimeType::class, array('required' => false))
                ->add('safeguards', TextareaType::class, array('required' => true))
                ->add('rainfall', TextareaType::class, array('required' => true))
                ->add('weather', TextareaType::class, array('required' => true))
                ->add('siteConditions', TextareaType::class, array('required' => true))
                ->add('photo', FileType::class, array('required' => true))
                ->add('video', FileType::class, array('required' => true))
                ->add('gallery', FileType::class, array('required' => true));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => CreateDiaryEntry::class,
        ));
    }

}
