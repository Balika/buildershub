<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PriceQuotationType
 *
 * @author Balika - MRH
 */
class PriceQuotationType extends AbstractType {

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
                ->add('product', EntityType::class, array(
                    'class' => Product::class,
                    'query_builder' => function (ProductRepository $pr) use ($options) {
                        return $pr->findMerchantProductsQry($options['supplier']);
                    },
                    'attr' => ['data-select' => 'true'],
                    'placeholder' => 'Select Product'
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => OrderItem::class,
            'supplier' => null
        ));
        $resolver->setRequired('supplier'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('supplier', Supplier::class); // Validates the type(s) of option(s) passed.
    }

    

}
