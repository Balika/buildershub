<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/App/Form/StoreOptionsType.php


use App\Entity\ProductCategory;
use App\Entity\StoreOptions;
use App\Repository\ProductCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of StoreOptionsType
 *
 * @author Edmond
 */
class StoreOptionsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('bannerFile', FileType::class, array('required' => false))
                ->add('signatureFile', FileType::class, array('required' => false))
                ->add('allowPriceRequest')
                ->add('allowQuotationRequest')
                ->add('manageStock')
                ->add('showStockLevel')
                ->add('showFeaturedProducts')
                ->add('showPrices')
                ->add('displayBanner')
                ->add('merchandise', EntityType::class, array(
                    'class' => ProductCategory::class,
                    //'attr' => ['data-select' => 'true'],
                    'required' => false,
                    'placeholder' => 'Select Product Group',
                    'query_builder' => function (ProductCategoryRepository $pcr) {
                        return $pcr->findTopLevelCategoriesQry();
                    },
                    'expanded' => false,
                    'multiple' => true
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => StoreOptions::class,
        ));
    }

}
