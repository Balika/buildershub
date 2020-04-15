<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\ProjectComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ProjectCommentType
 *
 * @author Balika - MRH
 */
class ProjectCommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
                 
                                                         
    }       
     public function getParent(): string {
        return CommentType::class;
    }

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProjectComment::class,
        ));
    }

    
}
