<?php

namespace App\Admin;

use App\Entity\Category;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RatingMeasureAdmin
 *
 * @author Balika - MRH
 */
class RatingMeasureAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Ratings Measure', ['class' => 'col-md-7'])
                ->add('name', TextType::class, array('required' => true))
                ->add('measureKey',TextType::class, array('required' => true))
                ->add('type', ChoiceType::class, array(
                    'choices' => [
                        'Artisan' => Constants::ARTISAN,
                        'Consultant' => Constants::CONSULTANT, 
                        'Both'=>"BOTH"
                    ],
                    'expanded'=>true,
                    'placeholder' => 'Builder Type',
                    'required' => true))
                ->add('description', TextareaType::class, array(
                    'required' => false
                ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
                ->add('measureKey')
                ->add('type');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('name')
                ->add('measureKey')
                ->add('type')
        ;
    }

}
