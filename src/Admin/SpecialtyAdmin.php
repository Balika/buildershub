<?php
namespace App\Admin;

use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of SpecialtyAdmin
 *
 * @author Balika - MRH
 */
class SpecialtyAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Builders Specialties', ['class' => 'col-md-7'])
                    ->add('name', TextType::class, array('required'=>true)) 
                ->add('slug',TextType::class, array('required'=>false))               
                ->add('type', ChoiceType::class, array(   
                    'choices'=>[
                        'Artisan'=> Constants::ARTISAN,
                        'Consultant'=>Constants::CONSULTANT
                    ],
                    'placeholder'=>'Applies To',
                    'required'=>true)) 
                                                       
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
                       ->add('type');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('name')               
                ->add('slug')
                ->add('type')                                
                ->add('user.fullName');
               
    }
     public function prePersist($object) {
        parent::prePersist($object);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::SPECIALTY);
        $object->setSlug($slug);       
    }
    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::SPECIALTY, $object->getId());
        $object->setSlug($slug);
    }


    public function getSlugger() {
        return $this->slugger;
    }

    public function setSlugger(Slugger $slugger) {
        $this->slugger = $slugger;
        return $this;
    }


}
