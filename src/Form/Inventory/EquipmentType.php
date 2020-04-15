<?php

namespace App\Form\Inventory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Equipment;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of EquipmentType
 *
 * @author Edmond Balika
 */
class EquipmentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('imageFile', FileType::class, array('required' => false))
                ->add('name', TextType::class, array('required' => true))
                ->add('assetLabel', TextType::class, array('required' => false))
                ->add('slug', TextType::class, array('required' => false))
                ->add('output', TextType::class, array('required' => false))
                ->add('outputUnit', TextType::class, array('required' => false))
                ->add('brand', TextType::class, array('required' => false))
                ->add('color', TextType::class, array('required' => false))
                ->add('registrationNumber', TextType::class, array('required' => false))
                ->add('chasisNumber', TextType::class, array('required' => false))
                ->add('noOfAxles', TextType::class, array('required' => false))
                ->add('status', ChoiceType::class, array(
                    'choices' => [
                        'Broken Down' => 'Broken Down',
                        "In Good Condition" => "In Good Condition",
                        "Under Repairs" => "Under Repairs",
                        "N/A" => "N/A"
                    ],
                    'required' => false,
                    'placeholder'=>'Select Equipment Status'
                ))
                ->add('isActive')
                ->add('category', EntityType::class, array(
                    'class' => ProductCategory::class,
                    //'attr' => ['data-select' => 'true'],
                    'required' => false,
                    'placeholder' => 'Select Equipment Category',
                    'query_builder' => function (ProductCategoryRepository $pcr) {
                        return $pcr->findAllEquipmentCategories(TRUE);
                    },
                ))
                ->add('description', TextareaType::class, array('required' => true))
                ->add('galleryFiles', FileType::class, array('required' => false, 'multiple' => true, 'data_class' => null));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Equipment::class
        ));
    }

}
