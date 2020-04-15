<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\QuotationRequest;
use App\Entity\Unit;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of QuotationRequestType
 *
 * @author Balika - MRH
 */
class QuotationRequestType extends AbstractType {

    //put your code here
    public function __construct() {
        
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        //
        //$builder->add('content', null, array('required' => false));

        $builder
                ->add('quantity', NumberType::class, array('required' => true))
                ->add('requestType', ChoiceType::class, array(
                            'choices' => [
                                'Price List Request' => 'Price List Request',
                                'Invoice/Quotation Request' => 'Invoice/Quotation Request',
                                'Product Details Reques' => 'Product Details Reques',
                            ],
                            'multiple' => false,
                            'expanded' => true,
                            'required' => true,
                        ))
                        ->add('quantity', NumberType::class, array(
                            'required' => true,
                        ))
                        ->add('contact', TextType::class, array(
                            'required' => true,
                            
                        ))
                        ->add('unit', EntityType::class, array(
                            'class' => Unit::class,
                            'query_builder' => function(EntityRepository $er) {
                                return $er->createQueryBuilder('u')
                                        ->orderBy('u.singular', 'ASC');
                            },
                            'placeholder' => 'Select Unit',                           
                            'required' => true,
                        ))
                        ->add('request', TextareaType::class, array(
                            'required' => true
                        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => QuotationRequest::class,
            
        ));
        
    }

    

}
