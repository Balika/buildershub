<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\Post;
use App\Entity\PostCategory;
use App\Repository\PostCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PostType
 *
 * @author Balika - MRH
 */
class PostType  extends AbstractType{
     /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('content', null, ['required' => false]);
        $builder
                ->add('title', TextareaType::class, array('required' => true))
                    ->add('slug', TextType::class, array('required' => false))
                    ->add('isPublished')
                    ->add('excerpt', TextareaType::class, array(
                        'required' => true
                    ))
                    ->add('isCommentable')
                    ->add('imageFile', FileType::class )
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
                    ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Post::class
        ]);
    }
}
