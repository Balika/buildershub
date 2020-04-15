<?php

namespace App\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Utils\EntityConfig;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ProductCategoryType
 *
 * @author Edmond
 */
class ProductCategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', TextType::class, array('required' => true))
                ->add('slug', TextType::class, array('required' => false))
                //->add('displayed', null, array('required' => false))
                ->add('imageFile', FileType::class, array('required' => false))
                ->add('isStoreItem', null, array('required' => false))
                ->add('parent', EntityType::class, array(
                    'class' => EntityConfig::PRODUCT_CATEGORY,
                    //'attr' => ['data-select' => 'true'],
                    'query_builder' => function (ProductCategoryRepository $pcr) {
                        return $pcr->findTopLevelCategoriesQry(true);
                    },
                    'placeholder' => "Select Product Category",
                    'required' => false
                ))
                ->add('description', TextareaType::class, array('required' => false));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => ProductCategory::class,
        ));
    }

   
}
