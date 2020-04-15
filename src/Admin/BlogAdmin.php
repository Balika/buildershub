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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlogAdmin
 *
 * @author Balika - BTL
 */
class BlogAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $blogPost = $this->getSubject();
        $fileFieldOptions = ['required' => false];
        if ($blogPost && ($webPath = $blogPost->getImageFile())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath() . '/' . $webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="' . $fullPath . '" class="admin-preview" />';
        }
        $formMapper
                ->with('Post Info', ['class' => 'col-md-8'])
                    ->add('title', TextType::class, array('required' => true))
                    ->add('slug', TextType::class, array('required' => false))
                    ->add('isPublished')
                    ->add('excerpt', TextareaType::class, array(
                        'required' => true
                    ))
                    ->add('isCommentable')
                    ->add('imageFile', FileType::class, $fileFieldOptions)
                    ->add('commentCount', NumberType::class, array('required' => false))
                    ->add('status', ChoiceType::class, array(
                        'choices' => [
                            'Trashed' => 'trashed',
                            'Spam' => 'spam',
                            'Published' => 'published'
                        ],
                        'placeholder' => 'Post Status',
                        'required' => true))
                    ->add('content', TextareaType::class, array(
                        'required' => false
                    ))
                ->end()
                ->with('Categories & Tags', ['class' => 'col-md-4'])
                   ->add('category', EntityType::class, array(
                        'class' => PostCategory::class,                        
                        'query_builder' => function (PostCategoryRepository $pcr) {
                            return $pcr->findParentCategoryQry();
                        },
                        'required'=>TRUE,
                        'placeholder'=>"Select Post Category"
                    ))
                    ->add('postCategories', EntityType::class, array(
                        'class' => PostCategory::class,
                        'multiple' => true,
                        'expanded' => true,
                        'query_builder' => function (PostCategoryRepository $pcr) {
                            return $pcr->findCategoryQry();
                        },
                    ))
                    ->add('postTags', EntityType::class, array(
                        'class' => PostCategory::class,
                        'multiple' => true,
                        'expanded' => true,
                        'query_builder' => function (PostCategoryRepository $pcr) {
                            return $pcr->findCategoryQry('tag');
                        },
                    ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('title')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('title')
                ->add('slug')
                //->add('excerpt')
                ->add('user.fullName')
                ->add('publishDate');
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $slug = $this->slugger->slugifyUnique($object->getTitle(), EntityConfig::BLOG_POST);
        $object->setSlug($slug);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
        $commentCount = $object->getCommentCount()> 1 ? $object->getCommentCount() : 0;       
        $object->setCommentCount($commentCount);
    }
    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
        $slug = $this->slugger->slugifyUnique($object->getTitle(), EntityConfig::POST_CATEGORY, $object->getId());
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
