<?php

namespace App\Admin;

use App\Utils\Constants;
use App\Utils\Slugger;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
class BuilderAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $blogPost = $this->getSubject();
        $fileFieldOptions = ['required' => false];

        $formMapper
                ->with('Builder Info', ['class' => 'col-md-8'])
                ->add('user.firstname', TextType::class, array('required' => true, 'attr'=> ['readonly'=>true]))
                ->add('user.lastname', TextType::class, array('required' => false, 'attr'=> ['readonly'=>true]))
                
                ->add('user.email', EmailType::class, array('required' => true, 'attr'=> ['readonly'=>true]))
                ->end()
                ->with('Builder Services', ['class' => 'col-md-4'])
                ->add('services', ChoiceType::class, array(
                    'choices' => [
                        'Artisanal Services' => Constants::ARTISAN,
                        'Professional Services' => Constants::PROFESSIONAL,
                        'Student' => Constants::STUDENT
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'required' => true))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('user.firstname')
                ->add('user.lastname')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('user.firstname')
                ->add('user.lastname')
                //->add('excerpt')
                ->add('user.email')
                ->add('services');
                
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
