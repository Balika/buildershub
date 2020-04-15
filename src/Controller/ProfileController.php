<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Builder;
use App\Entity\BuilderRating;
use App\Entity\Person;
use App\Entity\Professional;
use App\Entity\ServiceRequest;
use App\Entity\User;
use App\Entity\Work;
use App\Form\ProfileType;
use App\Form\Type\CoverPictureType;
use App\Form\Type\LocationFilterType;
use App\Form\Type\ProfilePictureType;
use App\Services\EngageService;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Services\PortfolioService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ProfileController
 *
 * @author Balika 
 */
class ProfileController extends BaseController {

    const USER_PROFILE_PAGE_SUFFIX = 'user-profile/';

    protected $paginatorService;
    protected $portfolioService;
    protected $engageService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger, PortfolioService $portfolioService, EngageService $engageService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
        $this->portfolioService = $portfolioService;
        $this->engageService = $engageService;
    }

    /**
     * @Route("/profile/{usernameCanonical}", name="user_profile")
     */
    public function userProfile(User $user, Request $request) {
        $page = 'index';
        if ($request->query->get('page')) {
            $page = $request->query->get('page');
        }
        $userProfile = $user->getUserProfile();
        $profileForm = $this->createForm(ProfileType::class, $userProfile);

        $profileForm->submit($request->request->get($profileForm->getName()), false);
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $this->persistenceService->saveEntity($userProfile);
        }
        $sub = $request->query->get('sub');
        $pagePrams = $this->getPageParams($user, $request);
        return $this->render('user-profile/profile.page.html.twig', array_merge($this->loadCommonParams($user, $page, $sub), $pagePrams));
    }

    /**
     * @Route("user-profile/update-profile-photos", name="update_profile_photos")
     */
    public function updateHeaderPhotos(Request $request) {
        $user = $this->getUser();
        $person = $user->getPerson();
        $profilePictureForm = $this->createForm(ProfilePictureType::class, $person);
        $profilePictureForm->handleRequest($request);
        if ($profilePictureForm->isSubmitted() && $profilePictureForm->isValid()) {
            $this->persistenceService->saveEntity($user);
        }
        $coverPictureForm = $this->createForm(CoverPictureType::class, $person);
        $coverPictureForm->handleRequest($request);
        if ($coverPictureForm->isSubmitted() && $coverPictureForm->isValid()) {
            $this->persistenceService->saveEntity($person);
        }
        return $this->redirectToRoute('user_profile', ['usernameCanonical' => $user->getUsernameCanonical()]);
    }

    /**
     * @Route("user-profile/update-profile-location", name="update_profile_location")
     */
    public function updateProfileLocation(Request $request) {
        $userProfile = $this->getUser()->getUserProfile();
        $form = $this->createForm(LocationFilterType::class, $userProfile, ['userProfile' => $userProfile]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistenceService->saveEntity($userProfile);
            return $this->redirectToRoute('user_profile', ['usernameCanonical' => $this->getUser()->getUsernameCanonical()]);
        }
        return $this->render('user-profile/profile.page.html.twig', $this->loadCommonParams($this->getUser(), 'index', null));
    }

    private function isOwnProfile($requestedProfile) {
        $isOwnProfile = false;
        $loggedInUser = $this->getUser();
        if ($requestedProfile != null && $loggedInUser != null) {
            $isOwnProfile = $requestedProfile->getId() == $loggedInUser->getId() ? true : $isOwnProfile;
        }
        return $isOwnProfile;
    }

    private function getPageParams($requestedProfile, Request $request) {
        $page = 'index';
        if ($request->query->get('page')) {
            $page = $request->query->get('page');
        }
        $sub = $request->query->get('sub');
        $pagePrams = [];
        switch ($page) {
            case 'index':
                $project = $this->portfolioService->getLatestProject($requestedProfile);
                $pagePrams = ['latestProject' => $project];
                break;
            case 'works':
                $pagePrams = $this->loadWorksParams($requestedProfile, $request);
                break;
            case 'projects':
                $pagePrams = $this->loadMyProjectParams($sub, $request);
                break;
            case 'request':
                $pagePrams = $this->loadRequestParams();
                break;
            case 'ratings':
                $pagePrams = $this->loadRatingParams($requestedProfile);
                break;
            case 'association':
                // $pagePrams = $this->loadPostsParams();
                break;
            case 'following':
                //$pagePrams = $this->loadFollowingsParams();
                break;
            case 'followers':
                // $pagePrams = $this->loadFollowersParams();
                break;
            case 'timeline':
                //$pagePrams = $this->loadTimelineParams();
                break;
            case 'experience':
                $pagePrams = $this->loadExperienceParams($requestedProfile);
                break;
            case 'awards':
                //$pagePrams = $this->loadExpertiseParams($requestedProfile);
                break;
            case 'education':
                $pagePrams = $this->loadEducationParams($requestedProfile);
                break;
            default :
                break;
        }
        return $pagePrams;
    }

    private function loadCommonParams($requestedProfile, $page, $sub = null) {
        $profilePictureForm = $this->createForm(ProfilePictureType::class, $this->getUser()->getPerson());
        $template = self::USER_PROFILE_PAGE_SUFFIX . $page . Constants::TPL_SUFFIX;
        if ($sub != null) {
            $template = self::USER_PROFILE_PAGE_SUFFIX . $sub . Constants::TPL_SUFFIX;
        }
        return $commonParams = [
            'template' => $template,
            'page' => $page,
            'sub' => $sub,
            'requestedProfile' => $requestedProfile,
            'userProfile' => $requestedProfile->getUserProfile(),
            'user' => $this->getUser(),
            'profilePictureForm' => $profilePictureForm->createView(),
            'isOwnProfile' => $this->isOwnProfile($requestedProfile),
            'isBuilder'=> $this->isBuilder($requestedProfile),
            'isFollowing' => $this->engageService->isFollowing($this->getUser(), $requestedProfile),
            'currentJob' => $this->getUserCurrentJob($requestedProfile),
        ];
    }

    private function getUserCurrentJob($user) {
        return $this->getDoctrine()->getRepository(EntityConfig::EXPERIENCE)->findCurrentJob($user);
    }

//####################################################  Profile Page Form Submission ############################################
    /**
     * @Route("user-profile/send-profile-request/{usernameCanonical}", name="send_request")
     */
    public function sendRequest(User $requestedProfile, Request $request) {
        $form = $this->formService->createRequestForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $requestData = $form->getData();
            $requestType = $requestData['requestType'];
            $request = $requestData['request'];
            $serviceRequest = new ServiceRequest($requestType, $request);
            $serviceRequest->setUser($requestedProfile);
            $serviceRequest->setLead($user);
            $this->persistenceService->saveEntity($serviceRequest);
            $this->get('event.listener.service')->triggerItemAddedEvent(EntityConfig::SERVICE_REQUEST, $serviceRequest, $user, $requestedProfile);
            unset($form);
        }
        return $this->redirectToRoute('user_profile', ['usernameCanonical' => $requestedProfile->getUsernameCanonical(), 'page' => 'request', 'isSaved' => true]);
    }

    /**
     * @Route("user-profile/save-work", name="save_work")
     */
    public function saveWork(Request $request) {
        $form = $this->formService->createWorkForm();
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $work = $form->getData();
            $this->portfolioService->saveWork($work);
            $this->get('event.listener.service')->triggerItemAddedEvent(EntityConfig::WORK, $work, $user, null);
            unset($form);
            return $this->redirectToRoute('user_profile', ['usernameCanonical' => $user->getUsernameCanonical(), 'page' => 'projects', 'sub' => 'add-project', 'isSaved' => true]);
        }
        return $this->render('user-profile/profile.page.html.twig', array_merge($this->loadCommonParams($this->getUser(), 'projects', 'add-project'), [
                    'form' => $form->createView(),
                    'isSaved' => false
        ]));
    }

    /**
     * @Route("user-profile/project/add-photo/{id}", name="add_project_photo")
     */
    public function addProjectPhoto(Work $work, Request $request) {
        $photoForm = $this->formService->createPhotoForm();
        $photoForm->handleRequest($request);
        $user = $this->getUser();
        if ($photoForm->isSubmitted() && $photoForm->isValid()) {
            $entityImage = $photoForm->getData();
            $entityImage->setUser($user);
            $entityImage->setEntity(EntityConfig::WORK);
            $entityImage->setEntityId($work->getId());
            $this->persistenceService->saveEntity($entityImage);
        }
        return $this->redirectToRoute('user_profile', ['usernameCanonical' => $user->getUsernameCanonical(), 'page' => 'projects']);
    }

    /**
     * @Route("user-profile/load-projects-asyn-content", name="load_projects_asyn_content", options={"expose":true})
     */
    public function loadProjectsAsynContent(Request $request) {
        $projects = $this->portfolioService->getMyProjects($request);
        $photoForm = $this->formService->createPhotoForm();
        return $this->render('user-profile/profile.page.html.twig', array_merge($this->loadCommonParams($this->getUser(), 'projects'), [
                    'isSaved' => false,
                    'photoForm' => $photoForm->createView(),
                    'projects' => $projects
        ]));
    }

//############################################# End Profile Form Submission #########################################################
    private function loadWorksParams($requestedProfile, $request) {
        //$form = $this->formService->createWorkForm();
        $projects = $this->portfolioService->getBuilderProjects($requestedProfile, $request);

        return [
            // 'form' => $form->createView(),
            // 'isSaved' => false,
            'projects' => $projects
        ];
    }

    private function loadProjectFormParams($work = null) {
        $form = $this->formService->createWorkForm($work);
        return [
            'form' => $form->createView(),
            'isSaved' => false
        ];
    }

    private function loadMyProjectParams($sub, $request) {
        if ($sub != null && $sub == 'add-project') {
            return $this->loadProjectFormParams();
        }
        $photoForm = $this->formService->createPhotoForm();
        return [
            'isSaved' => false,
            'photoForm' => $photoForm->createView()
        ];
    }

    private function loadRequestParams() {
        $form = $this->formService->createRequestForm();
        return [
            'form' => $form->createView(),
            'isSaved' => false
        ];
    }

    private function loadRatingParams($requestedProfile) {
        $form = $this->formService->createEmptyForm();
        $builderType = $requestedProfile->getPerson()->getPersonType() == Person::ARTISAN ? Constants::ARTISAN : Constants::CONSULTANT;
        $ratingMeasures = $this->getDoctrine()->getRepository(EntityConfig::RATING_MEASURE)->findBuilderRatingMeasures($builderType);
        return['ratingMeasures' => $ratingMeasures, 'form' => $form->createView()];
    }
    /**
     * @Route("user-profile/submit-review/{id}", name="submit_review", options={"expose":true})
     */
    public function submitReview(User $builderProfile, Request $request) {
        $builderType = $builderProfile->getPerson()->getPersonType() == Person::ARTISAN ? Constants::ARTISAN : Constants::CONSULTANT;
        $ratingMeasures = $this->getDoctrine()->getRepository(EntityConfig::RATING_MEASURE)->findBuilderRatingMeasures($builderType);
        $form = $this->formService->createEmptyForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ratingMeasures as $measure) {
                $ratingSymbol = $request->request->get($measure->getMeasureKey());
                $rating = str_split($ratingSymbol)[1];//The symbol is made of only 2 characters, a letter and number as first and second respectively
                $this->persistenceService->persist(new BuilderRating($builderProfile->getPerson(), $this->getUser(), $measure, $rating, $ratingSymbol));
            }
            $this->persistenceService->flush();
        }
        return $this->redirectToRoute('user_profile', ['usernameCanonical' => $builderProfile->getUsernameCanonical(), 'page' => 'ratings', 'isSaved' => true]);
      
    }

    private function loadTimelineParams() {
        return[];
    }

    private function loadPostsParams() {
        $postForm = $this->formService->createConversationForm();
        $snapshareForm = $this->formService->createSnapshareForm();
        return[
            'postForm' => $postForm->createView(),
            'snapshareForm' => $snapshareForm->createView()
        ];
    }

    private function loadExperienceParams(User $requestedProfile) {
        $workExperience = $this->getDoctrine()->getRepository(EntityConfig::EXPERIENCE)->findBy(['user' => $requestedProfile], ['startDate' => "DESC"]);
        return[
            'workExperience' => $workExperience
        ];
    }

    private function loadFollowersParams() {
        return [];
    }

    private function loadProjectParams() {
        return [];
    }

    private function loadExpertiseParams(User $requestedProfile) {
        $type = $requestedProfile->getUserType() == Constants::ARTISAN ? 'Artisan' : 'Consultant';
        return ['workCategories' => $this->getWorkCategories($type)];
    }

    private function loadFollowingsParams() {
        return['cipronPeople' => $this->getDoctrine()->getRepository(Constants::USER_ENTITY)->findAll()];
    }

    private function loadEducationParams($requestedProfile) {
        $educationHistory = $this->getDoctrine()->getRepository(EntityConfig::EDUCATION)->fetchEducationHistory($requestedProfile);
        return [
            "educationHistory" => $educationHistory
        ];
    }
    private function isBuilder($requestedProfile) {
        $person = $requestedProfile->getPerson();
        return $person instanceof Builder || $person instanceof Professional;
    }

}
