<?php

namespace App\Admin;

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
 * Description of HubAppAdmin
 *
 * @author Balika 
 */
class HubAppAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Add New App', ['class' => 'col-md-9'])
                ->add('label', TextType::class, array('required' => true))
                ->add('code', TextType::class, array('required' => true))
                ->add('logo', TextType::class, array('required' => false
                ))
                ->add('icon', TextType::class, array('required' => true))
                ->add('altIcon', TextType::class, array('required' => false))
                ->add('isHubernized')
                ->add('isEnabled')
                ->add('defaultUri', TextType::class, array('required' => false))
                ->add('rank', NumberType::class, array('required' => false))
                ->add('description', TextareaType::class, array(
                    'required' => false
                ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('label')
                ->add('code')
                ->add('isHubernized')
                ->add('isEnabled');
                
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('label')
                ->add('code')
                ->add('rank')
                ->add('icon')
                ->add('logo')
                ->add('isHubernized') 
                ->add('isEnabled')
                ->add('defaultUri')
                ->add('description');                
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);      
    }

    

}
