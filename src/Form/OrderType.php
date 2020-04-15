<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\Order;
use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of OrderType
 *
 * @author Balika - MRH
 */
class OrderType extends AbstractType {

    //put your code here



    public function __construct() {
        
    }

    protected $supplier;

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
        //     $builder->add('content', null, array('required' => false));
        $this->supplier = $options['supplier'];
        $builder
                ->add('orderItems', CollectionType::class, array(
                    'entry_type' => PriceQuotationType::class,
                    'entry_options' => array(
                        'supplier' => $this->supplier
                    ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'prototype' => true,
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Order::class,
            'supplier' => null
        ));
        $resolver->setRequired('supplier'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('supplier', Supplier::class); // Validates the type(s) of option(s) passed.
    }

   

}
