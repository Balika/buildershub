<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of CampaignType
 *
 * @author Edmond
 */
class CampaignType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', TextType::class, array('required' => true))
                ->add('description', TextareaType::class, array('required' => false))
                ->add('type', TextType::class, array('required' => false))
                ->add('startDate', DateType::class, array(
                    'required' => true,
                    'widget' => 'single_text',
                    'placeholder' => 'Select campaign start date',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    'format' => 'yyyy-MM-dd',
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control date']))
                ->add('endDate', DateType::class, array(
                    'required' => true,
                    'widget' => 'single_text',
                    'placeholder' => 'Select campaign end date',
                    'format' => 'yyyy-MM-dd',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control date']))
                ->add('imageFile', FileType::class, array('required' => false))
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        ' Discount Campaign ' => 'Discount Campaign',
                    ),
                    'placeholder' => 'Select Campaign Type',
                    'expanded' => false))
                ->add('discountRate', null, array('required' => true));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Campaign::class
        ));
    }

   

}
