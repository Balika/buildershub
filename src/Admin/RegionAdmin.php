<?php
namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of RegionAdmin
 *
 * @author Balika - MRH
 */
class RegionAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Region Info', ['class' => 'col-md-7'])
                ->add('name', TextType::class, array('required' => true))
                ->add('shortName', TextType::class, array('required' => true))
                ->add('slug', TextType::class, array('required' => false))
                ->add('countryCode', CountryType::class, array(
                    'required' => true,
                    'data' => 'GH',
                    'preferred_choices' => array(
                        'NG', 'GH', 'BJ', 'LR', 'TG'
                    ),
                    'placeholder' => 'Select Country'
                ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
                ->add('countryCode');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('name')
                ->add('shortName')
                ->add('slug')
                ->add('countryCode');
    }

}
