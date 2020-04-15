<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Work;
use App\Services\EngageService;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Services\PortfolioService;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of IndexController
 *
 * @author Balika Edmond
 */
class EngageController extends BaseController {

    protected $engageService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger, PortfolioService $portfolioService, EngageService $engageService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
        $this->portfolioService = $portfolioService;
        $this->engageService = $engageService;
    }

    /**
     * @Route("/engage", name="engage_index")
     */
    public function index(Request $request) {
        return $this->render('engage/engage.index.html.twig', [
                    'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/engage/snapshare", name="snapshare_index")
     */
    public function snapshareIndex(Request $request) {
        return $this->render('engage/snapshare/snapshare.index.html.twig', [
                    'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("engage/save-status-post/{id}", name="save_status_post")
     */
    public function saveStatusPost(User $requestedProfile, Request $request) {
        $statusForm = $this->formService->createStatusForm();
        $statusForm->handleRequest($request);
        $user = $this->getUser();
        if ($statusForm->isSubmitted() && $statusForm->isValid()) {
            $status = $statusForm->getData();
            $status->setUser($user);
            if ($user->getId() != $requestedProfile->getId()) {
                $status->setTarget($requestedProfile);
            }
            $slug = $this->slugger->slugify($status->getTitle());
            $status->setSlug($slug);
            $this->persistenceService->saveEntity($status);
        }
        return $this->redirectToRoute('user_profile', ['usernameCanonical' => $user->getUsernameCanonical()]);
    }

    /**
     * @Route("engage/process-post-comment/{id}", name="save_post_comment")
     */
    public function savePostComment(Request $request, Post $post) {
        $commentForm = $this->formService->createPostCommentForm($post);
        $commentForm->handleRequest($request);
        $user = $this->getUser();
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->addComment($commentForm, $post);
        }
        return $this->redirectToRoute('user_profile', ['usernameCanonical' => $user->getUsernameCanonical()]);
    }

    /**
     * @Route("engage/process-project-comment/{id}", name="save_project_comment")
     */
    public function saveProjectComment(Request $request, Work $project) {
        $commentForm = $this->formService->createProjectCommentForm($project);
        $commentForm->handleRequest($request);
        $user = $this->getUser();
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->addComment($commentForm, $project);
        }
        return $this->redirectToRoute('user_profile', ['usernameCanonical' => $user->getUsernameCanonical()]);
    }

    private function addComment($commentForm, $entity) {
        $user = $this->getUser();
        $comment = $commentForm->getData();
        $comment->setUser($user);
        $entity->addComment($comment);
        if ($comment->getId() <= 0) {
            $commentsCount = $entity->getCommentCount() + 1;
            $entity->setCommentCount($commentsCount);
        }
        $this->persistenceService->saveEntity($entity);
    }

    /**
     * @Route("engage/{usernameCanonical}/follow", name="follow_user")
     */
    public function followUser(User $requestedProfile, Request $request) {
        $this->engageService->follow($this->getUser(), $requestedProfile);
        if ($request->isXmlHttpRequest()) {
            // return $this->updateFollowStats($requestedProfile);
        }
        return $this->redirectToRoute('user_profile', array('usernameCanonical' => $requestedProfile->getUsernameCanonical()));
    }

    /**
     * @Route("engage/{usernameCanonical}/unfollow", name="unfollow_user")
     */
    public function unfollowUser(User $following, Request $request) {
        $this->engageService->unfollow($this->getUser(), $following);
        if ($request->isXmlHttpRequest()) {
            // return $this->updateFollowStats($following);
        }
        return $this->redirectToRoute('user_profile', array('usernameCanonical' => $following->getUsernameCanonical()));
    }

     public function isLiked($entity) {
        $isLiked = $this->engageService->isLiked($this->getUser(), $entity);
        return  new Response($isLiked);//Response params need to be string hence the single quotes
    }
    /**
     * @Route("engage/like-post/{usernameCanonical}/{entityId}/{entityClass}", name="like_post")
     * 
     */
    public function likePost(User $requestedProfile, $entityId, $entityClass, Request $request) {
        $entity = $this->getDoctrine()->getRepository($entityClass)->find($entityId);
        $this->engageService->like($this->getUser(), $entity);
        return $this->redirectToRoute("user_profile", ['usernameCanonical'=>$requestedProfile->getUsernameCanonical()]);
    }

    /**
     * @Route("engage/remove-like/{usernameCanonical}/{entityId}/{entityClass}", name="unlike_post")
     * 
     */
    public function unlikePost(User $requestedProfile, $entityId, $entityClass,  Request $request) {
        $entity = $this->getDoctrine()->getRepository($entityClass)->find($entityId);
        $this->engageService->unLike($this->getUser(), $entity);
        return $this->redirectToRoute("user_profile", ['usernameCanonical'=>$requestedProfile->getUsernameCanonical()]);
    }
    
}
