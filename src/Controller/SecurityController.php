<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\User;
use App\Model\AccountInterface;
use App\Model\AppInterface;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Controller used to manage the application security.
 * See https://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends AbstractController {

    protected $persistenceService;
    protected $formService;
    protected $accountService;

    function __construct(FormService $formService, PersistenceService $persistenceService, AccountInterface $accountService) {
        $this->persistenceService = $persistenceService;
        $this->formService = $formService;
        $this->accountService = $accountService;
    }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction() {
        throw new Exception('This should never be reached!');
    }

    /**
     * This is the route the user can use to logout.
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in config/packages/security.yaml
     * @Route("/logout", name="security_logout")
     */
    public function logout() {
        throw new Exception('This should never be reached!');
    }

    /**
     * @Route("/login", name="security_login_form")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils, AppInterface $appManager, Request $request) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $domain = $appManager->getCurrentDomain();
            if ($domain && $domain != 'www') {
                return $this->redirectToRoute('hubernize_dashboard');
            }
            return $this->redirectToRoute('account_settings', ['usernameCanonical' => $this->getUser()->getUsernameCanonical(), 'domain' => $domain]);
        }
        $form = $this->formService->createLoginForm();
        $error = $authenticationUtils->getLastAuthenticationError();

        $user = $request->query->get('id') != null && $request->query->get('id') > 0 ? $this->persistenceService->getRepository(EntityConfig::USER)->find($request->query->get('id')) : null;
        $lastUsername = $authenticationUtils->getLastUsername() != NULL ? $authenticationUtils->getLastUsername() : null !== $request->query->get('username') ? $request->query->get('username') : null;
        if (!$lastUsername && $user) {
            $lastUsername = $user->getUsername();
        }
        $redirectRoute = $request->query->get('redirect') ? $request->query->get('redirect') : null;
        return $this->render('login.html.twig', [
                    'form' => $form->createView(),
                    'error' => $error,
                    'redirect' => $redirectRoute,
                    'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/in-page/login", name="security_inpage_login")
     */
    public function inPageLogin(AuthenticationUtils $authenticationUtils) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return;
        }
        $form = $this->formService->createLoginForm();
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('login.html.twig', [
                    'form' => $form->createView(),
                    'error' => $error,
                    'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/forgotten-password", name="forgotten_password")
     *
     */
    public function forgottenPassword(Request $request) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('account_dashboard');
        }
        $feedback = array();
        $form = $this->formService->createForgottenPasswordForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = $formData['email'];
            $user = $this->getDoctrine()->getRepository(EntityConfig::USER)->findOneBy(array('email' => $email));
            if ($user) {
                $this->accountService->processPasswordRequest($user);
                $feedback = array('token' => $user->getPasswordResetToken(), 'message' => 'A password reset link as been sent to your email address (' . $email . '). Click on the link to reset your password');
            } else {
                $feedback = array('error' => 'No account matching your email (' . $email . ') was found in our database');
            }
        }
        $data = array('form' => $form->createView());
        $response = array_merge($data, $feedback);
        return $this->render('security/forgotten.password.html.twig', $response);
    }

    /**
     * @Route("/user-account-activation/{id}", name="user_account_activation")
     *
     */
    public function userAccountActivation(User $user, Request $request) {
        $token = $request->query->get('token');
        if (strpos($token, 'token') !== false) {
            $token = explode('?token', $token)[0]; //Take the first part of the splitted token, this should be equal to the reset token set on user
        }
        if ($token == $user->getConfirmationToken()) {
            $user->setIsActive(true);
            $user->setConfirmationToken(null);
            $this->persistenceService->saveEntity($user);
            $feedback = array('success' => 'Your account has been successfully activated. Thank you for choosing ZibbleSMP');
        } else {
            $feedback = array('user' => $user, 'error' => 'The token supplied is invalid. Or this reset link has already been used. Please contact your school admin or Edustore Token: ' . $token);
        }
        return $this->render('security/user.account.activation.html.twig', $feedback);
    }

    /**
     * @Route("/reset-password/{id}", name="reset_password")
     */
    public function resetPassword(User $user, Request $request) {
        $feedback = array();
        $form = $this->formService->createResetPasswordForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $password = $formData['password'];
            $token = $request->query->get('token');
            /**
             * For some weird reason anytime the reset password link is clicked via email, token is append twice to the url
             * This logic is to remove the second appendage, otherwise token will always be invalid
             */
            if (strpos($token, 'token') !== false) {
                $token = explode('?token', $token)[0]; //Take the first part of the splitted token, this should be equal to the reset token set on user
            }
            if ($token == $user->getPasswordResetToken()) {
                $this->accountService->changeUserPassword($user, $password);
                $feedback = array('message' => 'Your password was successfully reset. Thanks for using BuildersHub');
            } else {
                $feedback = array('error' => 'The token supplied is invalid. Or this reset link has already been used. Please contact BuildersHub Support: +23324 673 8954');
            }
        }
        $data = array('form' => $form->createView());
        $response = array_merge($data, $feedback);
        return $this->render('security/reset.password.html.twig', $response);
    }

    /**
     * @Route("change-password", name="change_password")
     */
    public function changePasswordAction(Request $request) {
        $user = $this->getUser();
        $passwordForm = $this->formService->createResetPasswordForm();
        $passwordForm->handleRequest($request);
        $error = 'The new password entered and its confirmation do not match';
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $formData = $passwordForm->getData();
            $oldPlainPassword = $formData['oldPassword'];
            $plainPassword = $formData['password'];
            if ($this->accountService->validateUser($user, $oldPlainPassword)) {
                $this->accountService->changeUserPassword($user, $plainPassword);
                $this->redirectToRoute('security_logout');
                //return $this->redirectToRoute('security_login_form');
            } else {
                $error = 'Your current password is incorrect. Please enter the correct password to reset your password.';
            }
        }
        return $this->redirectToRoute('account_settings', ['tab' => 'personal-details', 'sub' => 'security', 'error' => $error]);
    }

    private function checkLoginStatus() {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('account_dashboard');
        }
    }

}
