<?php

namespace App\Form\Type;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Entity\Company;
use App\Entity\ProductCategory;
use App\Entity\Region;
use App\Entity\Town;
use App\Repository\ProductCategoryRepository;
use App\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of StoreLocationFilterType
 *
 * @author Edmond
 */
class StoreLocationFilterType extends AbstractType {

    protected $category;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->category = $options['category'];
        $builder->add('region', EntityType::class, array(
            'class' => Region::class,
            'required' => false,
            'query_builder' => function (RegionRepository $rr) {
                return $rr->findAllQry();
            },
            'placeholder' => 'Select Region'));
        if ($this->category != null) {
            $builder->add('category', EntityType::class, array(
                'class' => ProductCategory::class,
                'choices' => $this->category->getSubCategories(),
                'required' => false,
                'mapped' => false,
                'placeholder' => 'Select Category'));
        } else {
            $builder->add('category', EntityType::class, array(
                'class' => ProductCategory::class,
                'query_builder' => function (ProductCategoryRepository $pcr) {
                    return $pcr->findAllQry();
                },
                'required' => false,
                'mapped' => false,
                'placeholder' => 'Select Category'));
        }
        $builder->add('subLocation', TextType::class, array(
            'required' => false));
        $regionFormModifier = function (FormInterface $form, Region $region = null) {
            $towns = null === $region ? array() : $region->getTowns();
            $form->add('businessLocation', EntityType::class, array(
                'class' => Town::class,
                'choices' => $towns,
                'required' => false,
                'placeholder' => 'Select Town'
            ));
        };

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($regionFormModifier) {
            // this would be your entity, i.e. SportMeetup
            $data = $event->getData();
            $regionFormModifier($event->getForm(), $data->getRegion());
        });
        $builder->get('region')->addEventListener(
                FormEvents::POST_SUBMIT, function (FormEvent $event) use ($regionFormModifier) {
            // It's important here to fetch $event->getForm()->getData(), as
            // $event->getData() will get you the client data (that is, the ID)
            $region = $event->getForm()->getData();

            // since we've added the listener to the child, we'll have to pass on
            // the parent to the callback functions!
            $regionFormModifier($event->getForm()->getParent(), $region);
        });
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Company::class,
            'category' => null
        ));
    }

}
