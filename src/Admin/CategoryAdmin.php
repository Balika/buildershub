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
 * Description of CategoryAdmin
 *
 * @author Balika - MRH
 */
class CategoryAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Category Info', ['class' => 'col-md-7'])
                    ->add('name', TextType::class, array('required'=>true)) 
                ->add('slug',TextType::class, array('required'=>false))
                ->add('isQuickAccess')
                ->add('parent', EntityType::class, array(
                    'required'=>false,
                    'class'=>Category::class,                    
                    'placeholder'=>'Select Parent Category',
                    ))
                ->add('type', ChoiceType::class, array(   
                    'choices'=>[
                        'Artisan'=> Constants::ARTISAN,
                        'Consultant'=>Constants::CONSULTANT
                    ],
                    'placeholder'=>'Category Type',
                    'required'=>true)) 
                 ->add('practitioner', TextType::class, array('required'=>true)) 
                ->add('description', TextareaType::class, array(                    
                    'required'=>false                    
                    ))                                         
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
                       ->add('type');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('name')
                ->add('practitioner')
                ->add('slug')
                ->add('type')
                 ->add('parent.name')                
                ->add('deleted');
               
    }
     public function prePersist($object) {
        parent::prePersist($object);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::CATEGORY);
        $object->setSlug($slug);       
    }
    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);
        //$user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        //$object->setUser($user);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::CATEGORY, $object->getId());
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
