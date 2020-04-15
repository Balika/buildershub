<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Description of BaseFormService
 *
 * @author Balika
 */
class BaseFormService {

    protected $accountService;
    protected $formFactory;

    public function __construct(FormFactoryInterface $formFactory, AccountService $accountService) {
        $this->formFactory = $formFactory;
        $this->accountService = $accountService;
    }

    protected function createForm($type, $data = null, array $options = array()) {
        return $this->formFactory->create($type, $data, $options);
    }

    /**
     * Creates and returns a form builder instance.
     *
     * @param mixed $data    The initial data for the form
     * @param array $options Options for the form
     *
     * @return FormBuilder
     */
    protected function createFormBuilder($data = null, array $options = array()) {
        return $this->formFactory->createBuilder(FormType::class, $data, $options);
    }

    //##################################### End User Registration Related Forms ####################   
    //######################## Start Security Related Forms #######################
    public function createLoginForm() {
        $defaultData = array('message' => 'Enter passwords');
        $form = $this->createFormBuilder($defaultData)
                ->add('email', EmailType::class, array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'mwinbamon@gmail.com'),
                    'required' => true,
                ))
                ->add('password', PasswordType::class, array(
                    'invalid_message' => 'The password is incorrect',
                    'attr' => array('class' => 'form-control'),
                    'required' => true,
                ))
                ->setMethod('POST')
                ->getForm();
        return $form;
    }

    public function createForgottenPasswordForm() {
        $defaultData = array('message' => 'Enter email address');
        $form = $this->createFormBuilder($defaultData)
                ->add('email', EmailType::class, array('required' => true
                ))
                ->setMethod('POST')
                ->getForm();
        return $form;
    }

    public function createResetPasswordForm() {
        $defaultData = array('message' => 'Enter passwords');
        $form = $this->createFormBuilder($defaultData)
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                ))
                ->add('oldPassword', PasswordType::class, array(
                    'invalid_message' => 'The password is incorrect',
                    'required' => true,
                ))
                ->setMethod('POST')
                ->getForm();
        return $form;
    }

    public function createUserRegistrationForm(User $user = null, $contact = null) {
        if ($user == null) {
            $user = new User();
        }
        if ($contact != null) {
            if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                $user->setEmail($contact);
            } else {
                $user->setContactNo($contact);
            }
        }
        return $this->createForm(RegistrationType::class, $user);
    }

}
