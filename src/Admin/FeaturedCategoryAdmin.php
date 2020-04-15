<?php

namespace App\Admin;

use App\Entity\ProductCategory;
use App\Entity\Supplier;
use App\Repository\ProductCategoryRepository;
use App\Utils\EntityConfig;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FeaturedCategoryAdmin
 *
 * @author Balika - BTL
 */
class FeaturedCategoryAdmin extends AbstractAdmin {
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper                
                ->add('startDate', DateType::class, array('required' => true))
                ->add('endDate', DateType::class, array('required' => true))               
                ->add('deleted')
                ->add('isCurrent')
                ->add('supplier', EntityType::class, array(
                    'required' => false,
                     'class' => Supplier::class,
                    'placeholder' => 'Select Supplier',))
                 ->add('category', EntityType::class, array(
                    'class' => ProductCategory::class,
                    //'attr' => ['data-select' => 'true'],
                    'required' => true,
                    'placeholder' => 'Select Product Group',
                    'query_builder' => function (ProductCategoryRepository $pcr) {
                        return $pcr->findTopLevelCategoriesQry();
                    },
                ));
                             
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('category')
                ->add('startDate')
                ->add('endDate');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('category')
                ->add('startDate')
                ->add('endDate')
                ->add('supplier')
                ->add('isCurrent')
                ->add('deleted');
    }

    public function prePersist($object) {
        parent::prePersist($object);      
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $currentFeatured = $this->modelManager->findOneBy(EntityConfig::FEATURED_CATEGORY, ['isCurrent'=>TRUE]);
        if($currentFeatured){            
           $currentFeatured->setIsCurrent(FALSE);
           $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getEntityManager();
           $em->persist($currentFeatured);
        }
        $object->setIsCurrent(TRUE);
        $object->setUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);        
    }

    
}
