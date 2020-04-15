<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Builder;
use App\Entity\Professional;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Entity\Work;
use App\Form\ProfileType;
use App\Form\Type\CoverPictureType;
use App\Form\Type\LocationFilterType;
use App\Form\Type\ProfilePictureType;
use App\Services\EngageService;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Description of ProfileUtilityController
 *
 * @author Balika - BTL
 */
class ProfileUtilityController extends BaseController {

    protected $engageService;

    const PROFILE_FRAGMENT_PREFIX = "portal/fragments/";

    function __construct(EngageService $engageService, FormService $formService, PersistenceService $persistenceService, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->engageService = $engageService;
    }

    /**
      public function timelineEntryAction($entity, $entityId, $blockName) {
      $timelineEntry = $this->getDoctrine()->getRepository($entity)->find($entityId);
      $template = $this->get('twig')->loadTemplate("Secure/user-profile/includes/profile.block.content.html.twig");
      $block = $template->renderBlock($blockName, ['timelineEntry' => $timelineEntry]);
      return new Response($block);
      }

      public function workGalleryAction(Work $work) {
      $template = $this->get('twig')->loadTemplate("Secure/user-profile/includes/profile.block.content.html.twig");
      $workGallery = $this->getDoctrine()->getRepository(Constants::ENTITY_IMAGE_ENTITY)->findBy(['entityId' => $work->getId(), 'entity' => Constants::WORK_ENTITY]);
      $block = $template->renderBlock('workGalleryBlock', ['workGallery' => $workGallery, 'work' => $work]);
      return new Response($block);
      } */
    public function profileHeader(User $requestedProfile, $page, Request $request, $template = 'profile.header') {
        $requestedUserId = intval($request->query->get('uref'));
        $profileViewer = $this->getDoctrine()->getRepository(EntityConfig::USER)->find($requestedUserId);
        $userProfile = $requestedProfile->getUserProfile();
        $user = $this->getUser();
        if ($profileViewer != null && ($profileViewer->getId() != $user->getId())) {
            throw new AccessDeniedException();
        }
        if ($userProfile == null) {
            $userProfile = $this->initUserProfile($requestedProfile);
        }

        $profileForm = $this->createForm(ProfileType::class, $userProfile);
        $profilePictureForm = $this->createForm(ProfilePictureType::class, $user->getPerson());
        $coverPictureForm = $this->createForm(CoverPictureType::class, $user->getPerson());
        $locationFilterForm = $this->createForm(LocationFilterType::class, $userProfile, ['userProfile' => $userProfile]);
        $response = $this->render(self::PROFILE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'requestedProfile' => $requestedProfile,
            'userProfile' => $userProfile,
            'currentJob' => $this->getUserCurrentJob($requestedProfile),
            'user' => $user,
            'page' => $page,
            'isBuilder' => $this->isBuilder($requestedProfile),
            'isOwnProfile' => $this->isOwnProfile($requestedProfile),
            'locationFilterForm' => $locationFilterForm->createView(),
            'profileForm' => $profileForm->createView(),
            'profilePictureForm' => $profilePictureForm->createView(),
            'coverPictureForm' => $coverPictureForm->createView(),
        ]);
        return $response;
    }

    private function isOwnProfile($requestedProfile) {
        $isOwnProfile = false;
        $loggedInUser = $this->getUser();
        if ($requestedProfile != null && $loggedInUser != null) {
            $isOwnProfile = $requestedProfile->getId() == $loggedInUser->getId() ? true : $isOwnProfile;
        }
        return $isOwnProfile;
    }

    private function isBuilder($requestedProfile) {
        $person = $requestedProfile->getPerson();
        return $person instanceof Builder;
    }

    private function getUserCurrentJob($user) {
        return null; //$this->getDoctrine()->getRepository(Constants::EXPERIENCE_ENTITY)->findCurrentJob($user);
    }

    private function initUserProfile($requestedProfile) {
        $userProfile = new UserProfile($requestedProfile);
        $this->persistenceService->saveEntity($userProfile);
        return $userProfile;
    }

    public function userCurrentJobAction(User $user) {
        $template = $this->get('twig')->loadTemplate("user-profile/includes/profile.block.content.html.twig");
        $currentJobBlock = $template->renderBlock('currentJobBlock', [
            'currentJob' => $this->getUserCurrentJob($user),
        ]);
        return new Response($currentJobBlock);
    }

    public function renderProfileViews($userId) {
        $user = $this->getDoctrine()->getRepository(EntityConfig::USER)->find($userId);
        $profileViews = count($this->getDoctrine()->getRepository(EntityConfig::PAGE_VIEW)->findBy(['entity' => EntityConfig::USER, 'entityId' => $user->getId(), 'page' => 'ProfilePage']));
        return new Response(strval($profileViews));
    }

    public function renderProjectPhotos(Work $work, $block = 'projectPhotosBlock') {
        $projectPhotos = $this->getDoctrine()->getRepository(EntityConfig::ENTITY_IMAGE)->findBy(['entity' => EntityConfig::WORK, 'entityId' => $work->getId()]);
        $template = $this->get('twig')->loadTemplate("user-profile/includes/profile.block.content.html.twig");
        $photosBlock = $template->renderBlock($block, [
            'projectPhotos' => $projectPhotos,
            'project' => $work
        ]);
        return new Response($photosBlock);
    }

    public function renderEngageDashboard($template = 'engage.dashboard') {
        $posts = $this->getDoctrine()->getRepository(EntityConfig::POST)->findAll();
        $response = $this->render(self::PROFILE_FRAGMENT_PREFIX.$template.Constants::TPL_SUFFIX, [
            'posts' => $posts
        ]);
        return $response;
    }

    public function renderProductAdsDashboard() {
        $products = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->findBy(['isFeatured' => TRUE]);
        $template = $this->get('twig')->loadTemplate("user-profile/includes/profile.block.content.html.twig");
        $photosBlock = $template->renderBlock('productAdsDashboard', [
            'featuredProducts' => $products
        ]);
        return new Response($photosBlock);
    }

    public function renderUserStatus($userId) {
        $requestedProfile = $this->getDoctrine()->getRepository(EntityConfig::USER)->find($userId);
        $statusForm = $this->formService->createStatusForm();
        $statusPosts = $this->getDoctrine()->getRepository(EntityConfig::STATUS_POST)->findBy(['user' => $requestedProfile], ['createdAt' => 'DESC']);
        $template = $this->get('twig')->loadTemplate("user-profile/includes/profile.block.content.html.twig");
        $contentBlock = $template->renderBlock('userStatus', [
            'statusPosts' => $statusPosts,
            'isOwnProfile' => $this->isOwnProfile($requestedProfile),
            'requestedProfile' => $requestedProfile,
            'user' => $this->getUser(),
            'statusForm' => $statusForm->createView(),
        ]);
        return new Response($contentBlock);
    }

    public function renderPersonsOfInterest($userId) {
        $requestedProfile = $this->getDoctrine()->getRepository(EntityConfig::USER)->find($userId);
        $user = $this->getUser();
        $recommendedPersons = $this->getDoctrine()->getRepository(EntityConfig::BUILDER)->profileRecommendations($requestedProfile);
        $template = $this->get('twig')->loadTemplate("user-profile/includes/profile.block.content.html.twig");
        $contentBlock = $template->renderBlock('personsOfInterest', [
            'requestedProfile' => $requestedProfile,
            'user' => $user,
            'personsOfInterest' => $recommendedPersons
        ]);
        return new Response($contentBlock);
    }

    public function renderCommentsBlock($postId, $block = "postCommentsBlock") {
        $entity = null;
        if ($block == "postCommentsBlock") {
            $entity = $this->getDoctrine()->getRepository(EntityConfig::POST)->find($postId);
            $commentForm = $this->formService->createPostCommentForm($entity);
        } elseif ($block == "projectCommentsBlock") {
            $entity = $this->getDoctrine()->getRepository(EntityConfig::WORK)->find($postId);
            $commentForm = $this->formService->createProjectCommentForm($entity);
        }
        $template = $this->get('twig')->loadTemplate("user-profile/includes/profile.block.content.html.twig");
        $contentBlock = $template->renderBlock($block, [
            'user' => $this->getUser(),
            'post' => $entity,
            'commentForm' => $commentForm->createView(),
        ]);
        return new Response($contentBlock);
    }

}
