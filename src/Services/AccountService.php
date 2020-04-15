<?php

namespace App\Services;

use App\Entity\Advertiser;
use App\Entity\Award;
use App\Entity\Builder;
use App\Entity\Company;
use App\Entity\Experience;
use App\Entity\Firm;
use App\Entity\Guest;
use App\Entity\Supplier;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Events\ForgottenPasswordEvent;
use App\Events\ItemAddedEvent;
use App\Events\UserAccountCreatedEvent;
use App\Model\AccountInterface;
use App\Model\UserInterface;
use App\Utils\CompanyTypes;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use App\Utils\UserConfig;
use DateTime;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class AccountService implements EventSubscriberInterface, AccountInterface {

    protected $persistenceService;
    protected $tokenStorage;
    protected $slugger;
    private $encoder;
    private $mailer;
    private $session;
    private $router;
    protected $eventDispatcher;

/// const ENTITIES_SORTER_FUNCTION = "sortEntities";

    public static function getSubscribedEvents() {
        return array();
    }

    public function __construct(PersistenceService $persistenceService, TokenStorageInterface $token, SessionInterface $session, EncoderFactoryInterface $encoder, RouterInterface $router, Slugger $slugger, EventDispatcherInterface $eventDispatcher) {
        $this->persistenceService = $persistenceService;
        $this->session = $session;
        $this->tokenStorage = $token;
        $this->encoder = $encoder;
        $this->slugger = $slugger;
        $this->router = $router;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function onNewItemAdded(ItemAddedEvent $event) {
// $entityType = $event->getEnityType();
        $entity = $event->getEntity();
        if ($entity instanceof UserInterface) {
            $userProfile = new UserProfile($entity);
        }
    }

//######################## Start Builder Account Setup ###################
    public function createBuilderAccount(User $user, $type, $profile = null, $persist = TRUE) {
        $isUserSaved = FALSE;
        try {
            $this->initUser($user, $profile);
            $this->initBuilder($user, $type);
            if ($persist) {//User is saved immediately into the database without waiting on other process to complete
                $this->persistenceService->saveEntity($user);
                $isUserSaved = TRUE;
            } else {// Executed when builder creation is part of a bigger transaction, e.g. new user registering a company
                $this->persistenceService->persist($user);
            }
            //$this->triggerUserAccountCreatedEvent($user, $user->getConfirmationToken());
        } catch (Exception $ex) {
            
        } finally {
            
        }
    }

    private function initUser(User $user, $profile = null) {
        $this->validateUsername($user);
        $user->addRole('ROLE_USER');
        $username = strtolower($user->getFirstname() . '.' . str_replace(' ', '', $user->getLastname()));
        $user->setUsernameCanonical($username);
        $user->setEmailCanonical($user->getEmail());
        $encoder = $this->encoder->getEncoder($user);
        $salt = null;
        $encoded = $encoder->encodePassword($user->getPassword(), $salt);
        $user->setPassword($encoded)
                ->setIsActive(false) //This should be set to true when the user clicks on the activation link sent to his email
                ->setUsername($user->getEmail())
                ->setEnabled(FALSE)
                ->setLocked(FALSE)
                ->setExpired(FALSE)
                ->setCredentialsExpired(FALSE)
                ->setExpiresAt(null);
        $userProfile = new UserProfile();
        $userProfile->setProfile($profile);
        $user->setUserProfile($userProfile);
    }

    private function initFirm($companyName) {
        $firm = new Firm();
        $slug = $this->slugger->slugifyUnique($companyName, EntityConfig::FIRM);
        $firm->setSlug($slug);
        $firm->setName($companyName);
        return $firm;
    }

    private function initBuilder(User $user, $type) {
        $username = $user->getUsername();
        $builder = new Builder();
        switch ($type) {
            case UserConfig::ARTISAN:
                $builder->addService(Constants::ARTISAN);
                $user->addRole('ROLE_ARTISAN');
                break;
            case UserConfig::PROFESSIONAL:
                $builder->addService(Constants::PROFESSIONAL);
                $user->addRole('ROLE_PROFESSIONAL');
                break;
            case UserConfig::STUDENT:
                $builder->addService(Constants::STUDENT);
                $user->addRole('ROLE_STUDENT');
                break;
            default:
                $builder = new Guest();
                $user->addRole('ROLE_PUBLIC');
                break;
        }
        $builder->setCreatedAt(new DateTime('now'));
        if (self::isValidPhoneNumber($username) && $builder != null) {
            $builder->setContactNo($username);
        }
        $builder->setContactNo($user->getContactNo());
        $user->setPerson($builder);
        return $builder;
    }

//######################## End  Artisan Account Setup ###################

    public function createFirmAccount(User $user) {
        
    }

    public function activateUser(User $user) {
        try {
            $user->setIsActive(TRUE) //This should be set to true when the user clicks on the activation link sent to his email               
                    ->setEnabled(TRUE)
                    ->setConfirmationToken(NULL);
            $this->persistenceService->saveEntity($user);
            return true;
        } catch (\Exception $ex) {
            
        }
        return false;
    }

    public function createUser(User $newUser) {
        $this->initUser($newUser);
    }

    public function logUserIn($username, $password) {
        $user = $this->userManager->findUserByUsernameOrEmail($username);
        $errorMessage = '';
        $userType = '';
        $isSuccessfulLogin = false;
        if ($user) {
            $userType = $user->getUserType();
            $isSuccessfulLogin = $this->startUserSession($user, $password);
            if (!$isSuccessfulLogin) {
                $errorMessage = 'You have supplied an invalid password for username: ' . $username;
            } else {
                $errorMessage = "Your login was successful $isSuccessfulLogin";
            }
        } else {
            $errorMessage = 'There is no user with username: ' . $username . ' in our database';
        }
        return array('user' => $user, 'userType' => $userType, 'message' => $errorMessage, 'isSuccessful' => $isSuccessfulLogin);
    }

    public function startUserSession(User $user, $credentials = null) {
        $isSesssionStarted = false;
        try {
            if ($credentials !== null) {
                $isValidCredentials = $this->validateUser($user, $credentials);
                if ($isValidCredentials) {
// $this->setToken($user, $credentials);
                    $isSesssionStarted = true;
                }
            } else {
// $this->setToken($user, $credentials); //TODO: This line does not make sense. Cross-check logic
            }
        } catch (InvalidArgumentException $ex) {
            
        }
        return $isSesssionStarted;
    }

    private function setToken($user, $credentials) {
        $token = new UsernamePasswordToken($user, $credentials, 'secured_area', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->session->set('_security_secured_area', serialize($token));
    }

    public function validateUser(User $user, $password) {
        $isCredentialsValid = false;
        $encoder = $this->encoder->getEncoder($user);
        $salt = $user->getSalt();
        if ($encoder->isPasswordValid($user->getPassword(), $password, $salt)) {
            $isCredentialsValid = true;
        }
        return $isCredentialsValid;
    }

    public function createNewUserAccount(User $user, $selectedRoles, $isSupplier = false, $companyName = null) {
//$randomPassword = $this->generateRandomPassword();
        $token = $this->generateRandomToken();
        $encoder = $this->encoder->getEncoder($user);
        $salt = null;
        $encoded = $encoder->encodePassword($user->getPassword(), $salt);
        $user->setPassword($encoded);
        //$username = strtolower($user->getFirstname() . '.' . str_replace(' ', '', $user->getLastname()));
        $user->setIsActive(false); //This should be set to true when the user clicks on the activation link sent to his email
        $user->setUsername($user->getEmail());
        $user->setActivationToken($token);
        $user->setRoles($selectedRoles);
        if ($isSupplier) {
            $supplier = $this->createSupplierAccount($companyName);
            $supplier->setOwner($user);
            $this->persistenceService->saveEntity($supplier);
        } else {
            $this->persistenceService->saveEntity($user);
        }

        $this->triggerUserAccountCreatedEvent($user, $token);
    }

    public function createSupplierAccount($companyName) {
        $supplier = new Supplier();
        $supplier->setName($companyName);
        $supplier->setSlug($this->slugger->slugifyUnique($companyName, Constants::SUPPLIER));
        $supplier->setIsActive(true);
        return $supplier;
    }

    public function processRolesAndSave($user, $rolesIds) {
        if ($user->getType() == 'STAFF' && strlen($rolesIds) > 0) {
            $roleIDs = explode(',', $rolesIds);
            foreach ($roleIDs as $key => $id) {
                $role = $this->persistenceService->getRepository(Constants::ROLE)->find($id);
                if (!in_array($role, $user->getRoles())) {
                    $user->addRole($role);
                }
            }
        }
        $this->persistenceService->saveEntity($user);
    }

    public function changeUserPassword($user, $password) {
        $encoder = $this->encoder->getEncoder($user);
        $salt = null;
        $encoded = $encoder->encodePassword($password, $salt);
        $user->setPassword($encoded);
        $user->setPasswordResetToken(null);
        $this->persistenceService->saveEntity($user);
    }

    public function getEncodedPassword($user, $password) {
        $encoder = $this->encoder->getEncoder($user);
        $salt = null;
        $encoded = $encoder->encodePassword($password, $salt);
        return $encoded;
    }

    public function generateRandomToken() {
        $length = 50;
        $token = bin2hex(random_bytes($length));
        return$token;
    }

    public function triggerUserAccountCreatedEvent(User $user, $token) {
        $event = new UserAccountCreatedEvent($user, $token);
        $this->eventDispatcher->dispatch($event);
    }

    public function generateRandomPassword($length = 8) {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $randomPassword = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[mt_rand(0, $max)];
        }
        return $randomPassword;
    }

    /**
     * <p>Checks to see if <i>$number</i> is a valid phone number or not.</p><br />
     * @param string $number <p>The value to check whether it is a valid phone number or not.</p><br />
     * @return boolean <i>true</i> if <i>$number</i> is a valid phone number otherwise it returns <i>false</i>.
     */
    public static function isValidPhoneNumber($number) {
        return preg_match("/^\+?[0-9]{8,15}$/", $number) > 0 ? true : false;
    }

    private function validateUsername(User $user) {
        $username = $user->getUsername();
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $token = $this->generateRandomToken();
            $user->setEmail($username);
            $user->setEmailCanonical($username);
            $user->setConfirmationToken($token);
        } else if (self::isValidPhoneNumber($username)) {
            $token = $this->generateRandomPassword(6);
            $user->setContactNo($username);
            $user->setConfirmationToken($token);
        }
        $user->setUsername($username);
    }

    public function doesAccountExist($username) {
        $user = $this->persistenceService->getRepository(EntityConfig::USER)->findOneBy(['username' => $username]);
        return $user != null;
    }

    public function processPasswordRequest(User $user) {
        $token = $this->generateRandomToken();
        $user->setPasswordResetToken($token);
        $this->persistenceService->saveEntity($user);
        $this->triggerPasswordResetEvent($user, $token);
    }

    public function triggerPasswordResetEvent($user, $token) {
        $event = new ForgottenPasswordEvent($user, $token);
        $this->eventDispatcher->dispatch($event);
    }

    public function getGuestUserParams($guestContact, $loginForm, $registrationForm) {
        $user = $this->getUser();
        return array(
            'accountExist' => $this->doesAccountExist($guestContact),
            'userForm' => $registrationForm->createView(),
            'loginForm' => $loginForm->createView()
        );
    }

    public function getUser() {
        return $this->tokenStorage->getToken()->getUser();
    }

    //############################### Start Professional Data Related Methods ######################
    public function saveBuilderProfessionalDetails($entity) {
        if ($entity instanceof Award) {
            $slug = $this->slugger->slugify($entity->getName());
            $entity->setSlug($slug);
        }
        if ($entity instanceof Experience) {
            $currentJob = $this->persistenceService->getRepository(EntityConfig::EXPERIENCE)->findOneBy(['isPresent' => TRUE]);
            if ($currentJob && $currentJob != $entity) {//If an existing entity is being edited
                $currentJob->setIsPresent(FALSE);
                $entity->setIsPresent(TRUE);
            }
            return $this->persistenceService->saveEntities([$entity, $currentJob]);
        }
        return $this->persistenceService->saveEntity($entity);
    }

    public function loadBuilderProfessionalData($sub, $entityId, $formService) {
        switch ($sub) {
            case 'education':
                $education = $entityId > 0 ? $this->persistenceService->getRepository(EntityConfig::EDUCATION)->find($entityId) : null;
                $form = $formService->createEducationForm($education);
                $educationEntries = $this->persistenceService->getRepository(EntityConfig::EDUCATION)->findBy(['user' => $this->getUser()]);
                return ['form' => $form->createView(), 'educationEntries' => $educationEntries];
            case 'awards':
                $award = $entityId > 0 ? $this->persistenceService->getRepository(EntityConfig::AWARD)->find($entityId) : null;
                $form = $formService->createAwardForm($award);
                $awardEntries = $this->persistenceService->getRepository(EntityConfig::AWARD)->findBy(['user' => $this->getUser()]);
                return ['form' => $form->createView(), 'awardEntries' => $awardEntries];
            case 'association':
                $association = $entityId > 0 ? $this->persistenceService->getRepository(EntityConfig::ASSOCIATION)->find($entityId) : null;
                $form = $formService->createAssociationForm($association);
                $associationEntries = $this->persistenceService->getRepository(EntityConfig::ASSOCIATION)->findBy(['user' => $this->getUser()]);
                return ['form' => $form->createView(), 'associationEntries' => $associationEntries];

            case 'experience':
                $experience = $entityId > 0 ? $this->persistenceService->getRepository(EntityConfig::EXPERIENCE)->find($entityId) : null;
                $form = $formService->createExperienceForm($experience);
                $experienceEntries = $this->persistenceService->getRepository(EntityConfig::EXPERIENCE)->findBy(['user' => $this->getUser()], ['startDate'=>'DESC']);
                return ['form' => $form->createView(), 'experienceEntries' => $experienceEntries];
            case 'service-offerings':
                break;
            default:
                return [];
        }
    }

    //############################### End Professional Data Related Methods ########################
    //############################### Start Company Setup Related Methods ########################
    public function saveCompany(User $user, Company $company, $type = null) {
        if ($company->getId() >= 1) {//if company already exist, save changes
            //$this->persistenceService->persist($user);
            $this->persistenceService->saveEntity($company);
            return $company;
        }

        if ($company instanceof Supplier) {
            $user->addRole(Supplier::ROLE);
        } elseif ($company instanceof Firm) {
            $user->addRole(Firm::ROLE);
        } elseif ($company instanceof Advertiser) {
            $user->addRole(Advertiser::ROLE);
        }
        // $this->initCompanyPerson($user);
        $user->setCompany($company);
        $user->addCompany($company);
        $this->persistenceService->persist($user);
        $company->setSlug($this->slugger->slugifyUnique($company->getName(), EntityConfig::COMPANY));
        $company->setIsActive(FALSE);
        $this->persistenceService->saveEntity($company);
        return $company;
    }

    private function initCompanyPerson(User $user) {
        $person = new Guest();
        $person->setContactNo($user->getContactNo());
        $person->setUser($user);
        $this->persistenceService->persist($person);
    }

    public function loadCompanyForm($type, $formService, $company = null) {
        switch ($type) {
            case CompanyTypes::SUPPLIER ||
            CompanyTypes::ARTISANAL:
                $form = $formService->createSupplierForm($company);
                break;
            case CompanyTypes::ADVERTISING:
                $form = $formService->createAdvertiserForm($company);
                break;
            case CompanyTypes::CONSTRUCTION_AND_CONSULTING ||
            CompanyTypes::CONSTRUCTION ||
            CompanyTypes::CONSULTING:
                $form = $formService->createFirmForm($company);
                break;
            default :
                $form = null;
                break;
        }
        return $form;
    }

//############################# End  Company Setup Related Methods #############################
}
