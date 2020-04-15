<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/AppBundle/Form/MediaHouseRegistrationType.php


use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ProjectCategoryType
 *
 * @author Edmond
 */
class ProductType extends AbstractType {

    private $company;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->company = $options['vendor'];
        $builder->add('name', null, array('required' => true))
                ->add('slug', null, array('required' => false))
                ->add('companyName', null, array('required' => false))
                ->add('category', EntityType::class, array(
                    'class' => ProductCategory::class,
                    //'attr' => ['data-select' => 'true'],
                    'required' => false,
                    'placeholder' => 'Select Product Group',
                    'query_builder' => function (ProductCategoryRepository $pcr) {
                        return $pcr->findTopLevelCategoriesQry();
                    },
                ))
                /*                 * ---------- This is for the specific case of spare parts -------------
                  ->add('vehicleBrand', EntityType::class, array(
                  'class' => 'AppBundle:EntityType',
                  'attr' => ['data-select' => 'true'],
                  'required' => false,
                  'query_builder' => function (EntityTypeRepository $er) {
                  return $er->findEntityTypesQry("VehicleBrand");
                  },
                  'group_by' => function($vehicleBrand, $key, $index) {
                  // randomly assign things into 2 groups
                  return ($vehicleBrand->getParent() != null && !empty($vehicleBrand->getParent()->getSubCategories())) ? $vehicleBrand->getParent() : "Other Brands";
                  },
                  'placeholder' => 'Select Vehicle Brand'))
                  ->add('model', null, array('required' => false))* */
                /*                 * ----------  Spare Parts ------------------ */
                ->add('imageFile', FileType::class, array('required' => false))
                ->add('galleryFiles', FileType::class, array(
                    'required' => false,
                    'multiple' => true,
                    'data_class' => null
                ))
                ->add('validityDate', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    'placeholder' => 'End of price validity date',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // add a class that can be selected in JavaScript
                    'attr' => ['class' => 'form-control date']))
                ->add('saveAsDraft', SubmitType::class, array('label' => 'Save As Draft'))
                ->add('preview', SubmitType::class)
                ->add('isFeatured')
                ->add('enabled')
                ->add('publishProduct', SubmitType::class, array('label' => 'Publish Product'))
                ->add('updateProduct', SubmitType::class, array('label' => 'Update Product'))
                ->add('productData', ProductDataType::class)
                ->add('description', TextareaType::class, array('required' => false));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Product::class,
            'vendor' => null
        ));
    }

}
