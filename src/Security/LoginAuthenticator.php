<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Security;

use App\Model\AccountInterface;
use App\Services\FormService;
use App\Utils\EntityConfig;
use App\Utils\Globals;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Description of LoginAuthenticator
 *
 * @author Balika - BTL
 */
class LoginAuthenticator extends AbstractFormLoginAuthenticator {

    const LOGIN_ROUTE = 'security_login_form';
    const LOGIN_SUBMIT_URL = "security_login_check";

    private $formFactory;
    private $userAccountService;
    private $userManager;
    //private $doctrine;
    private $router;
    private $storeLogin;
    private $authChecker;
    private $isLogoutRoute = false;
    private $requiresActivation = false;
    private $user;
    private $redirect;

    const GUEST_LANDING_PAGE = 'home';
    const LOGOUT_ROUTE = 'security_logout';

    private $requestedRoute, $requestedUrl, $inpageLogin = null;

    use TargetPathTrait;

    public function __construct(Doctrine $doctrine, FormService $formService, AccountInterface $accountService, RouterInterface $router, AuthorizationCheckerInterface $authChecker) {
        $this->formFactory = $formService;
        $this->userAccountService = $accountService;
        $this->userManager = $doctrine->getRepository(EntityConfig::USER);
        $this->router = $router;
        $this->authChecker = $authChecker;
    }

    protected function getLoginUrl() {
        return $this->router->generate(self::LOGIN_ROUTE);
    }

    public function checkCredentials($credentials, UserInterface $user) {
        $password = $credentials['password'];
        $isSessionStarted = $this->userAccountService->startUserSession($user, $password);
        if (!$isSessionStarted) {
            throw new CustomUserMessageAuthenticationException(
            'The user credentials supplied are invalid!'
            );
        }
        return $isSessionStarted;
    }

    public function getCredentials(Request $request) {
        $this->requestedUrl = $request->query->get('requestedUrl');
        $this->inlineLogin = $request->query->get('inpageLogin');
        $this->redirect = $request->request->get('redirect') ? $request->request->get('redirect')  : null;//redirect is the route that the user should be redirected to after in-page login. Same as requestedUrl
        $data = array(
            'username' => $request->request->get('_username'),
            'password' => $request->request->get('_password'),
        );
        $request->getSession()->set(
                Security::LAST_USERNAME, $data['username']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider) {
        $username = $credentials['username'];
        if (substr($username, 0, 1) == '@') {
            throw new CustomUserMessageAuthenticationException(
            'Please you cannot start a username with @ '
            );
        }
        $user = $userProvider->loadUserByUsername($username); //$this->userManager->loadUserByUsername($username);
        if ($user == null) {
            throw new CustomUserMessageAuthenticationException(
            "There is no user matching $username"
            );
        }
        if ($user && (!$user->isEnabled() || !$user->getIsActive())) {
            throw new CustomUserMessageAuthenticationException(
            "You account is not yet activated! Username: $username"
            );
        }
        if (is_null(Globals::getUser())) {//Checks if current user is set as global variable
            Globals::setCurrentUser($user);
        }
        return $user;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        return parent::onAuthenticationFailure($request, $exception);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
        if ($this->inpageLogin) {
            return $this->router->generate($this->requestedUrl);
        }

        // if the user hits a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
        if (!$targetPath) {
            return new RedirectResponse($this->getDefaultSuccessRedirectUrl($token));
        }
        return new RedirectResponse($targetPath);
    }

    public function start(Request $request, AuthenticationException $authException = null) {
        return parent::start($request, $authException);
    }

    public function supportsRememberMe() {
        return parent::supportsRememberMe();
    }

    protected function getDefaultSuccessRedirectUrl(TokenInterface $token = null) {
        $user = $token->getUser();
        if ($this->authChecker->isGranted('ROLE_FIRM')) {
            //$user = $token->getUser();
        }
        return $this->processUserLogin($user);
    }

    private function processUserLogin($currentUser) {
        $route = "account_settings";
        /**if ($this->authChecker->isGranted('ROLE_SUPPLIER')) {
            $route = "store_admin_dashboard";
        }**/
        if($this->redirect !== null)$route = $this->redirect;        
        return $this->router->generate($route);
    }

    public function supports(Request $request) {
        return $request->attributes->get('_route') === self::LOGIN_ROUTE && $request->isMethod('POST');
    }
    

}
