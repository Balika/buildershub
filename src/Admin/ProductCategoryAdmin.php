<?php

namespace App\Admin;

use App\Entity\ProductCategory;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductCategoryAdmin
 *
 * @author Balika - BTL
 */
class ProductCategoryAdmin extends AbstractAdmin {

    protected $slugger;
    protected $user;

    protected function configureFormFields(FormMapper $formMapper) {
        // use $fileFieldOptions so we can add other options to the field
        $productCategory = $this->getSubject();
        $fileFieldOptions = ['required' => false];
        if ($productCategory && ($webPath = $productCategory->getImageFile())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath() . '/' . $webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="' . $fullPath . '" class="admin-preview" />';
        }
        $formMapper
                ->with('Category Info', ['class' => 'col-md-7'])
                ->add('name', TextType::class, array('required' => true))
                ->add('slug', TextType::class, array('required' => false))
                ->add('isStoreItem')
                ->add('imageFile', FileType::class, $fileFieldOptions)
                ->add('parent', EntityType::class, array(
                    'required' => false,
                    'class' => ProductCategory::class,
                    'placeholder' => 'Select Parent Category',
                ))
                ->add('description', TextareaType::class, array(
                    'required' => false
                ))
                ->add('level', ChoiceType::class, array(
                    'choices' => array(
                        ' 1 ' => '1',
                        ' 2 ' => '2',
                        ' 3 ' => '3',
                        ' 4 ' => '4',
                        ' 5 ' => '5'
                    ),
                    'expanded' => true,
                    'placeholder' => 'Select Category Level'
                ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('featureImage')
                ->addIdentifier('name')
                ->add('slug')
                ->add('parent.name')
                ->add('level')
                ->add('description')
                ->add('deleted');
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::PRODUCT_CATEGORY);
        $object->setSlug($slug);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
        //$object->setSupplier($user->getCompany());
        $this->manageFileUpload($object);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::PRODUCT_CATEGORY, $object->getId());
        $object->setSlug($slug);
        $this->manageFileUpload($object);
    }

    public function getSlugger() {
        return $this->slugger;
    }

    public function setSlugger(Slugger $slugger) {
        $this->slugger = $slugger;
        return $this;
    }

    private function manageFileUpload($productCategory) {
        if ($productCategory->getImageFile()) {
            //$productCategory->refreshUpdated();
        }
    }

}
