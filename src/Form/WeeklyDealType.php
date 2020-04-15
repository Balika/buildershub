<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\Product;
use App\Entity\WeeklyDeal;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of WeeklyDealType
 *
 * @author Balika - BTL
 */
class WeeklyDealType extends AbstractType {

    private $supplier;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->supplier = $options['supplier'];
        $builder->add('dealPrice', NumberType::class, ['required' => false])
                ->add('isDiscounted', NumberType::class, ['required' => false])
                ->add('product', EntityType::class, ['required' => true,
                    'class' => Product::class,
                    //'attr' => ['data-select' => 'true'],
                    'query_builder' => function (ProductRepository $pr) {
                        return $pr->findAllQry($this->supplier);
                    },
                    'placeholder' => 'Select Product for Deal'])
                ->add('discountRate', NumberType::class, ['required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => WeeklyDeal::class,
            'supplier' => null
        ]);
    }

}
