<?php

namespace App\Admin;

use App\Utils\Slugger;
use App\Utils\UserRoles;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserAdmin
 *
 * @author Balika - BTL
 */
class UserAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $blogPost = $this->getSubject();
        $fileFieldOptions = ['required' => false];

        $formMapper
                ->with('User Info', ['class' => 'col-md-8'])
                ->add('firstname', TextType::class, array('required' => true))
                ->add('lastname', TextType::class, array('required' => false))
                ->add('isActive')
                ->add('enabled')
                ->add('email', EmailType::class, array('required' => true))
                ->end()
                ->with('User Roles', ['class' => 'col-md-4'])
                ->add('roles', ChoiceType::class, array(
                    'choices' => [
                        UserRoles::HUB_ADMIN_ROLE => UserRoles::HUB_ADMIN_ROLE,
                        UserRoles::HUBERNIZE_ROLE => UserRoles::HUBERNIZE_ROLE,
                        UserRoles::ARTISAN_ROLE => UserRoles::ARTISAN_ROLE,
                        UserRoles::DEFAULT_ROLE => UserRoles::DEFAULT_ROLE,
                        UserRoles::FIRM_ROLE => UserRoles::FIRM_ROLE,
                        UserRoles::PROFESSIONAL_ROLE => UserRoles::PROFESSIONAL_ROLE,
                        UserRoles::STUDENT_ROLE => UserRoles::STUDENT_ROLE,
                        UserRoles::SUPPLIER_ROLE => UserRoles::SUPPLIER_ROLE,                       
                    ],
                    'expanded' => true,
                    'multiple' => true,                    
                    'required' => true))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('firstname')
                ->add('lastname')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('firstname')
                ->add('lastname')
                //->add('excerpt')
                ->add('email')
                ->add('isActive')
                ->add('enabled')
                ->add('roles');
    }

    public function prePersist($object) {
        parent::prePersist($object);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }

    public function getSlugger() {
        return $this->slugger;
    }

    public function setSlugger(Slugger $slugger) {
        $this->slugger = $slugger;
        return $this;
    }

}
