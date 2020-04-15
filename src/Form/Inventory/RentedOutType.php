<?php

namespace App\Form\Inventory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\CompanyClient;
use App\Entity\RentedOut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of RentedOutType
 *
 * @author Edmond Balika
 */
class RentedOutType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('attachmentFile', FileType::class, array('required' => FALSE))
                ->add('remarks', TextType::class, array('required' => true))
                ->add('rentalRate', TextType::class, array('required' => false))
                ->add('rentalDuration', TextType::class, array('required' => false))
                ->add('amountPaid', TextType::class, array('required' => false))
                ->add('totalAmount', TextType::class, array('required' => false))
                ->add('quantity', NumberType::class, array('required' => false))
                ->add('datePaid', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    'placeholder' => 'Select campaign end date',
                    'format' => 'yyyy-MM-dd',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control date']))
                 ->add('startDate', DateType::class, array(
                    'required' => true,
                    'widget' => 'single_text',
                    'placeholder' => 'Select campaign end date',
                    'format' => 'yyyy-MM-dd',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
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
                ->add('paymentDueDate', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    'placeholder' => 'Select campaign end date',
                    'format' => 'yyyy-MM-dd',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control date']))               
                ->add('billingCycle', ChoiceType::class, array(
                    'choices' => [
                        'Hourly' => 'Hourly',
                        "Daily" => "Daily",
                        "Weekly" => "Weekly",
                        "Monthly" => "Monthly",
                        "Yearly" => "Yearly"
                    ],
                    'required' => false,
                    'placeholder' => "Select Billing Cycle"
                ))
                ->add('isFullyPaid')
                ->add('client', EntityType::class, array(
                    'class' => CompanyClient::class,
                    //'attr' => ['data-select' => 'true'],
                    'required' => false,
                    'placeholder' => 'Select Client',
                ))
                ->add('paymentStatus', ChoiceType::class, array(
                    'choices' => [
                        'Part Payment' => 'Part Payment',
                        "Full Payment" => "Full Payment",
                        "No Payment" => "No Payment"
                    ],
                    'placeholder' => "Select Payment Status",
                    'required' => false
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => RentedOut::class,
            'company'=>null
        ));
    }

}
