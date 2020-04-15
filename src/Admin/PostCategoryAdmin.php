<?php

namespace App\Admin;

use App\Entity\PostCategory;
use App\Repository\PostCategoryRepository;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostCategoryAdmin
 *
 * @author Balika - BTL
 */
class PostCategoryAdmin extends AbstractAdmin {

    protected $slugger;
    protected $user;

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper                
                ->add('name', TextType::class, array('required' => true))
                ->add('slug', TextType::class, array('required' => false))
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Category' => 'category',
                        'Tag' => 'tag',
                    )
                ))
                ->add('deleted')
                ->add('rank', NumberType::class, array('required' => false))
                ->add('parent', EntityType::class, array(
                    'required' => false,
                    'class' => PostCategory::class,
                    'placeholder' => 'Select Parent Category',
                ))
                ->add('description', TextareaType::class, array(
                    'required' => false
                ));                
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('name')
                ->add('type')
                ->add('slug')
                ->add('parent.name')
                ->add('rank')
                ->add('deleted');
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::POST_CATEGORY);
        $object->setSlug($slug);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::POST_CATEGORY, $object->getId());
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
