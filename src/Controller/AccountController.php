<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Award;
use App\Entity\Builder;
use App\Entity\User;
use App\Model\AccountInterface;
use App\Model\MessagingInterface;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\ImageProcessor;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccountController
 *
 * @author Balika 
 */
class AccountController extends BaseController {

    const ACOOUNT_PREFIX = 'account/includes/';
    const PERSONAL_DETAILS_SUB = 'account/profile-sub/';
    const FIRM_DETAILS_SUB = 'account/firms-sub/';
    const BUILDERSHUB = "BuildersHub Code: ";

    protected $imageProcessor;
    protected $accountService;
    protected $messagingService;

    public function __construct(AccountInterface $accountService, FormService $formService, PersistenceService $persistenceService, ImageProcessor $imageProcessor, Slugger $slugger, MessagingInterface $messagingService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->accountService = $accountService;
        $this->imageProcessor = $imageProcessor;
        $this->messagingService = $messagingService;
    }

    /**
     * @Route("/account/settings/{entityId}", name="account_settings", defaults={"entityId":"0"})
     */
    public function accountSettings(Request $request, $entityId = 0) {
        $tab = $request->query->get('tab');
        $sub = $request->query->get('sub');
        if ($tab == null) {
            $tab = "personal-details";
            if ($sub == null) {
                $sub = 'dashboard';
            }
        }

        $route = 'account/account.settings.html.twig';
        $pageParams = $this->loadSettingsPageParams($tab);
        switch ($tab) {
            case 'firm-details':
                $type = $request->query->get('type'); //Company type selected during new company registration
                if ($sub == null || $sub == 'dashboard') {//in case $sub is already set 
                    $sub = 'manage-firms';
                }
                $pageParams = $this->loadFirmsSubPageParams($sub, $request);
                if ($pageParams['isSaved']) {//Redirects to manage firms is a persistence events has occurred
                    $sub = 'manage-firms';
                }
                $template = self::FIRM_DETAILS_SUB . $sub . Constants::TPL_SUFFIX;
                break;
            case 'personal-details':
                $template = self::PERSONAL_DETAILS_SUB . $sub . Constants::TPL_SUFFIX;
                $pageParams = $this->loadPersonalSubPageParams($sub);
                break;
            default:
                $template = self::PERSONAL_DETAILS_SUB . 'dashboard' . Constants::TPL_SUFFIX;
                break;
        }
        $user = $this->getUser();
        $userForm = $this->formService->createUserForm($user);
        $userForm->submit($request->request->get($userForm->getName()), false);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $this->persistenceService->saveEntity($user);
        }
        $pageParams['userForm'] = $userForm->createView();

        $commonParams = [
            'template' => $template,
            'tab' => $tab != null ? $tab : 'personal-details',
            'sub' => $sub,
            'user' => $user,
            'entityId' => $entityId
        ];
        return $this->render($route, array_merge($commonParams, $pageParams));
    }

    private function loadSettingsPageParams($tab) {
        switch ($tab) {
            case 'firm-details':
                return [];
            case 'personal-details':
                $this->loadUserDashboard();
            default:
                return $this->loadUserDashboard();
        }
    }

    private function loadPersonalSubPageParams($sub, $entityId = 0) {
        if ($sub == 'security') {
            return $this->loadUserSecurityDetails();
        } else {
            return $this->accountService->loadBuilderProfessionalData($sub, $entityId, $this->formService);
        }
    }

    /**
     * @Route("/account", name="account_redirect")
     */
    public function accountRedirect(Request $request, $entityId = 0) {
        return $this->redirectToRoute('account_settings');
    }
    private function loadUserSecurityDetails() {
        $passwordChangeForm = $this->formService->createResetPasswordForm();
        $form = $this->formService->createProfileForm($this->getUser());
        $userForm = $this->formService->createUserForm($this->getUser());
        return [
            'profileForm' => $form->createView(),
            'userForm' => $userForm->createView(),
            'passwordForm' => $passwordChangeForm->createView()
        ];
    }

    private function loadFirmsSubPageParams($sub, $request, $entityId = 0) {
        $isSaved = FALSE;
        switch ($sub) {
            case 'add-new':
                $type = $request->query->get('type');
                $form = $this->accountService->loadCompanyForm($type, $this->formService);
                if ($form != null) {
                    $form->submit($request->request->get($form->getName()), false);
                    if ($form->isSubmitted() && $form->isValid()) {
                        $company = $form->getData();
                        $company->setSubType($type);
                        $this->accountService->saveCompany($this->getUser(), $company);
                        $isSaved = TRUE;
                    }
                }
                return ['form' => $form != null ? $form->createView() : null,
                    'type' => $type,
                    'isSaved' => $isSaved
                ];
            case 'manage-firms':
                return ['isSaved' => $isSaved];
                break;
        }
    }

    private function loadUserDashboard() {
        
    }

    /**
     * @Route("/account/update-profile", name="update_user_profile")
     */
    public function updateUserProfile(Request $request) {
        $user = $this->getUser();
        $form = $this->formService->createProfileForm($user);
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $user->getPerson();
            $selectedSpecialtiesIds = explode(',', $request->request->get('selectedSpecialties'));
            $selectedServiceCategories = explode(',', $request->request->get('selectedServiceCategories'));
            $person->setServices($selectedServiceCategories);
            $workCategoryId = $request->request->get('workCategory');
            if ($workCategoryId > 0 && ($person instanceof Builder )) {
                $profession = $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->find($workCategoryId);
                $person->setProfession($profession);
            }
            foreach ($selectedSpecialtiesIds as $id) {
                $specialty = $this->getDoctrine()->getRepository(EntityConfig::SPECIALTY)->find($id);
                if ($specialty) {
                    $person->addSpecialty($specialty);
                    $this->persistenceService->persist($specialty);
                }
            }
            $userProfile = $form->getData();
            $this->persistenceService->saveEntity($userProfile);
        }
        return $this->redirectToRoute('account_settings', ['sub' => 'service-offerings']);
    }

    /**
     * @Route("/account/add-specialty", name="add_specialty")
     */
    public function addSpecialty(Request $request) {
        $user = $this->getUser();
        $form = $this->formService->createSpecialtyForm();
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $specialty = $form->getData();
            $specialty->setUser($user);
            $person = $user->getPerson();
            $type = $this->getUser()->getPerson() instanceof Builder ? Constants::ARTISAN : Constants::CONSULTANT;
            $specialty->setType($type);
            $specialty->setSlug($this->slugger->slugify($specialty->getName(), EntityConfig::SPECIALTY));
            $person->addSpecialty($specialty);
            $this->persistenceService->saveEntity($specialty);
        }
        return $this->redirectToRoute('account_settings', ['sub' => 'service-offerings']);
    }

    //############################ Save Personal Details Entries###########################
    /**
     * @Route("/account/save-personal-data/{entityId}", name="save_personal_data", defaults={"entityId":"0"})
     */
    public function savePersonalData(Request $request, $entityId = 0) {
        $tab = $request->query->get('tab');
        $sub = $request->query->get('sub');
        $route = 'account/account.settings.html.twig';
        $template = self::PERSONAL_DETAILS_SUB . $sub . Constants::TPL_SUFFIX;
        $user = $this->getUser();
        $form = $this->getProfessionalDataForm($sub, $entityId);
        $form->handleRequest($request); //submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $professionalData = $form->getData();
            $professionalData->setUser($user);
            $this->accountService->saveBuilderProfessionalDetails($professionalData);
            unset($form);
            $form = $this->getProfessionalDataForm($sub);
            $entityId = 0;
        }
        $commonParams = [
            'template' => $template,
            'tab' => $tab != null ? $tab : 'personal-details',
            'sub' => $sub,
            'user' => $user,
            'entityId' => $entityId
        ];
        return $this->render($route, array_merge($commonParams, $this->loadPersonalSubPageParams($sub, $entityId)));
    }

    private function getProfessionalDataForm($sub, $entityId = 0) {
        $form = null;
        switch ($sub) {
            case 'education':
                $entity = $entityId > 0 ? $this->getDoctrine()->getRepository(EntityConfig::EDUCATION)->find($entityId) : null;
                $form = $this->formService->createEducationForm($entity);
                break;
            case 'awards':
                $entity = $entityId > 0 ? $this->getDoctrine()->getRepository(EntityConfig::AWARD)->find($entityId) : null;
                $form = $this->formService->createAwardForm($entity);
                break;
            case 'association':
                $entity = $entityId > 0 ? $this->getDoctrine()->getRepository(EntityConfig::ASSOCIATION)->find($entityId) : null;
                $form = $this->formService->createAssociationForm($entity);
                break;
            case 'experience':
                $entity = $entityId > 0 ? $this->getDoctrine()->getRepository(EntityConfig::EXPERIENCE)->find($entityId) : null;
                $form = $this->formService->createExperienceForm($entity);
                break;
            default:
                break;
        }
        return $form;
    }

    /**
     * @Route("/account/update-user-details", name="update_user_details")
     */
    public function updateUserDetails(Request $request) {
        $user = $this->getUser();
        $userForm = $this->formService->createUserForm($user);
        $userForm->submit($request->request->get($userForm->getName()), false);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $this->persistenceService->saveEntity($user);
        }
        return $this->redirectToRoute('account_settings', ['tab' => 'personal-details',
                    'sub' => 'security']);
    }

    /**
     * @Route("/account/dashboard", name="account_dashboard")
     */
    public function accountDashboard(Request $request) {
        return $this->render('account/account.dashboard.html.twig', [
                    'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/signup", name="signup", options={"expose":TRUE})
     */
    public function signup(Request $request) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('account_dashboard');
        }
        $type = 'NA';
        if ($request->query->get('type')) {
            $type = $request->query->get('type');
        }
        return $this->render('signup.html.twig', $this->pickFormType($type));
    }

    private function pickFormType($type) {
        $params = [];
        $builderForm = $this->formService->createBuilderRegistrationForm()->createView();
        switch ($type) {

            case 'artisan':
                $params = [
                    'formTitle' => 'Artisan Registration',
                    'form' => $builderForm,
                    'target' => "Masons, carpenters, plumbers, tilers, steel benders, welders, electricians etc"
                ];
                break;
            case 'professional':
                $params = [
                    'formTitle' => 'Professional Registration',
                    'form' => $builderForm,
                    'target' => "Engineers (civil, material, electrical, chemical etc), architects, quantity surveors, land surveyors, planners etc "
                ];
                break;
            case 'student':
                $params = [
                    'formTitle' => 'Student Registration',
                    'form' => $builderForm,
                    'target' => "Students pursuing courses related to infrastructure developments at all levels "
                ];
                break;
            default:
                $params = [
                    'formTitle' => 'BuildersHub User Registration',
                    'form' => $builderForm,
                    'target' => "Please select a user type above to register"
                ];
                break;
        }
        return array_merge(['type' => $type], $params);
    }

    /**
     * @Route("/register/{type}", name="register_user")
     */
    public function registerUser($type, Request $request) {
        $form = $this->formService->createBuilderRegistrationForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $companyName = $form->get('companyName')->getData();
            $this->accountService->createBuilderAccount($user, $type, $companyName);
            $this->persistenceService->flush();
            return $this->redirectToRoute("activate_account", array('id' => $user->getId()));
        }
        return $this->redirectToRoute('signup',['type'=>$type]);
    }

    /**
     * @Route("/contact", name="contact_us")
     */
    public function contactUs(Request $request) {
        return $this->render('contact.us.html.twig', [
                    'form' => null
        ]);
    }

    /**
     * @Route("company/registration", name="register_store")
     */
    public function registerStore(Request $request) {
        $form = $this->formService->createSupplierForm();
        $type = 'supplier';
        $user = $this->getUser();
        $route = 'store/register.store.html.twig';
        if ($request->query->get('type') == 'property') {
            $route = 'store/estates/enlist.property.html.twig';
        } elseif ($request->query->get('type') == 'firm') {
            $type = $request->query->get('type');
            $route = 'account/firm/register.firm.html.twig';
            $form = $this->formService->createFirmForm();
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form->getData();
            $user = $company->getOwner();
            $userType = $request->request->get('userType');
            $this->accountService->createBuilderAccount($user, $userType, null);
            $this->accountService->saveCompany($user, $company);
            return $this->redirectToRoute("activate_account", array('id' => $user->getId()));
        }
        return $this->render($route, array(
                    'form' => $form->createView(),
                    'type'=>$type,
                    'user' => $user,
        ));
    }

    /**
     * @Route("/activate-account/user/{id}", name="activate_account")
     */
    public function activateAccount(User $user, Request $request) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('account_dashboard');
        }
        $mode = $request->query->get('mode');
        $isSMSSent = $request->query->get('isSMSSent');
        $form = $this->formService->createAccountActivationForm($user, $mode);
        $isActivated = $user->getIsActive();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $smsCode = $formData['code'];
            if ($form->get('sendSMS')->isClicked()) {
                $phone = $formData['phone'];
                return $this->redirectToRoute("generate_sms_code", ['id' => $user->getId(), 'phone' => $phone]);
            }
            return $this->activateAccountAndLogin($user, $smsCode);
        }
        $token = $request->query->get('token');
        if (strpos($token, 'token') !== false) {
            $token = explode('?token', $token)[0]; //Take the first part of the splitted token, this should be equal to the reset token set on user
        }
        if ($token == $user->getConfirmationToken()) {
            return $this->activateAccountAndLogin($user, $token);
        }
        return $this->render('account/activate.account.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user,
                    'isSMSSent' => $isSMSSent == null ? FALSE : $isSMSSent,
                    'isActivated' => $isActivated,
                    'mode' => $mode
        ));
    }

    private function activateAccountAndLogin(User $user, $token) {
        if ($token == $user->getConfirmationToken()) {
            $this->accountService->activateUser($user);
            return $this->redirectToRoute("security_login_form", array('id' => $user->getId()));
        }
    }

    /**
     * @Route("/generate-sms-code/user/{id}", name="generate_sms_code")
     */
    public function generateSMSCode(User $user, Request $request) {
        $smsToken = $this->accountService->generateRandomPassword(6);
        $user->setConfirmationToken($smsToken);
        if ($user->getContactNo() == null) {
            $phone = $request->query->get('phone');
            $user->setContactNo($phone);
        }
        $this->persistenceService->saveEntity($user);
        $this->messagingService->sendSMS($user->getContactNo(), self::BUILDERSHUB . $smsToken);
        return $this->redirectToRoute('activate_account', ['mode' => 'sms', 'id' => $user->getId(), 'isSMSSent' => TRUE]);
    }

    /**
     * @Route("/send-activation-link/user/{id}", name="send_activation_link")
     */
    public function sendActivationLink(User $user, Request $request) {
        $activationToken = $this->accountService->generateRandomToken();
        $user->setConfirmationToken($activationToken);
        $this->persistenceService->saveEntity($user);
        $this->messagingService->sendAccountActivationMessage($user);
        return $this->redirectToRoute('activate_account', ['mode' => 'email', 'id' => $user->getId()]);
    }

}
