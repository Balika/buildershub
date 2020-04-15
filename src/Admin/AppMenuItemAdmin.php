<?php

namespace App\Admin;

use App\Entity\HubApp;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppMenuItemAdmin
 *
 * @author Balika 
 */
class AppMenuItemAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('App Menu Items', ['class' => 'col-md-9'])
                ->add('label', TextType::class, array('required' => true))
                ->add('route', TextType::class, array('required' => true))
                ->add('code', TextType::class, array('required' => true))
                ->add('icon', TextType::class, array('required' => false))
                ->add('app', EntityType::class, array(
                    'required' => false,
                    'class' => HubApp::class,
                    'placeholder' => 'Select App',
                ))
                ->add('isEnabled')
                ->add('rank', TextType::class, array('required' => false))
                ->add('description', TextareaType::class, array(
                    'required' => false
                ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('label')
                ->add('code')
                ->add('rank')
                ->add('isEnabled')
                ->add('app');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('label')
                ->add('route')
                ->add('code')
                ->add('icon')
                ->add('app')
                ->add('rank')
                ->add('isEnabled')
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
