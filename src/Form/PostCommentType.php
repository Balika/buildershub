<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\PostComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PostCommentType
 *
 * @author Balika - MRH
 */
class PostCommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
                 
                                                         
    }       
     public function getParent(): string {
        return CommentType::class;
    }

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PostComment::class,
        ));
    }

    
}
