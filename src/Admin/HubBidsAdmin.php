<?php

namespace App\Admin;

use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryAdmin
 *
 * @author Balika - MRH
 */
class HubBidsAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Category Info', ['class' => 'col-md-9'])
                ->add('name', TextType::class, array('required' => true))
                ->add('bidCode', TextType::class, array('required' => false))
                ->add('flatFee', TextType::class, array('required' => false
                ))
                ->add('bidDuration', NumberType::class, array('required' => true))
                ->add('isOpen')
                ->add('isEnabled')
                ->add('startingAt')
                ->add('endingAt')
                ->add('description', TextareaType::class, array(
                    'required' => false
                ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
                ->add('bidCode')
                ->add('isEnabled')
                ->add('isOpen');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('name')
                ->add('bidCode')
                ->add('bidDuration')
                ->add('flatFee')
                ->add('isOpen')
                ->add('isEnabled')
                ->add('startingAt')
                ->add('endingAt');
    }

    public function prePersist($object) {
        parent::prePersist($object);
        
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);      
    }

    public function getSlugger() {
        //return $this->slugger;
    }

    public function setSlugger(Slugger $slugger) {       
        return $this;
    }

}
