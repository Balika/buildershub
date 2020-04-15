<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Post;
use App\Model\FirmProfileInterface;
use App\Services\EngageService;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Services\PortfolioService;
use App\Utils\Constants;
use App\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of FirmProfileController
 *
 * @author Balika 
 */
class FirmProfileController extends BaseController {

    const FIRM_PROFILE_PAGE_SUFFIX = 'firms/profile/';

    protected $paginatorService;
    protected $portfolioService;
    protected $engageService;
    protected $profileService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger, PortfolioService $portfolioService, EngageService $engageService, FirmProfileInterface $profileService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
        $this->portfolioService = $portfolioService;
        $this->engageService = $engageService;
        $this->profileService = $profileService;
    }

    /**
     * @Route("/firm/profile/{slug}", name="firm_profile")
     */
    public function loadProfile(Company $firm, Request $request) {
        $page = 'index';
        if ($request->query->get('page')) {
            $page = $request->query->get('page');
        }
        $sub = $request->query->get('sub');
        $pagePrams = $this->getPageParams($firm, $request);
        return $this->render('firms/profile/profile.base.html.twig', array_merge($this->loadCommonParams($firm, $page, $sub), $pagePrams));
    }

    private function getPageParams($firm, Request $request) {
        $page = 'index';
        if ($request->query->get('page')) {
            $page = $request->query->get('page');
        }
        $sub = $request->query->get('sub');
        $pagePrams = [];
        switch ($page) {
            case 'index':
                //$project = $this->portfolioService->getLatestProject($requestedProfile);
                //$pagePrams = ['latestProject' => $project];
                break;
            case 'our-clients':
                //$pagePrams = $this->loadWorksParams($requestedProfile, $request);
                break;
            case 'history':
                //$pagePrams = $this->loadMyProjectParams($sub, $request);
                break;
            case 'works':
                $form = $this->formService->createWorkForm();
                $pagePrams = ['form' => $form->createView()];
                break;
            case 'posts':
                $statusForm = $this->formService->createStatusForm();
                $pagePrams = ['statusForm' => $statusForm->createView()];
                break;
            case 'awards':
                //$pagePrams = $this->loadExpertiseParams($requestedProfile);
                break;
            case 'education':
                //$pagePrams = $this->loadEducationParams($requestedProfile);
                break;
            default :
                break;
        }
        return $pagePrams;
    }

    private function loadCommonParams($firm, $page, $sub = null) {
        //$profilePictureForm = $this->createForm(ProfilePictureType::class, $this->getUser()->getPerson());
        $template = self::FIRM_PROFILE_PAGE_SUFFIX . $page . Constants::TPL_SUFFIX;
        if ($sub != null) {
            $template = self::FIRM_PROFILE_PAGE_SUFFIX . $sub . Constants::TPL_SUFFIX;
        }
        return $commonParams = [
            'template' => $template,
            'page' => $page,
            'sub' => $sub,
            'firm' => $firm
        ];
    }

    /**
     * @Route("/firm/profile-post/{slug}/{post_slug}", name="submit_post", defaults={"post_slug":""})
     * @ParamConverter("post", options={"mapping": {"post_slug": "slug"}})
     */
    public function submitPost(Company $firm, Request $request, Post $post = null) {
        $statusForm = $this->formService->createStatusForm($post);
        $statusForm->handleRequest($request);
        if ($statusForm->isSubmitted()) {
            $post = $statusForm->getData();
            $post->setSlug($this->slugger->slugify($post->getTitle()));
            $post->setCompany($firm);
            $post->setUser($this->getUser());
            $this->persistenceService->saveEntity($post);
        }
        $page = 'posts';
        return $this->redirectToRoute('firm_profile', ['slug' => $firm->getSlug(), 'page' => $page]);
    }

    /**
     * @Route("/firm/save-work/{slug}", name="save_firm_work")
     */
    public function saveWork(Request $request, Company $company = null) {
        $form = $this->formService->createWorkForm();        
        $user = $this->getUser();
        $page = 'works';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $work = $form->getData();
            $this->portfolioService->saveWork($work, $company);
            $this->get('event.listener.service')->triggerItemAddedEvent(EntityConfig::WORK, $work, $user, null);
            unset($form);            
            return $this->redirectToRoute('firm_profile', ['slug' =>$company->getSlug(), 'page' => $page]);
        }
        $sub ="project-entry";
        return $this->redirectToRoute('firm_profile', ['slug' =>$company->getSlug(), 'page' => $page, 'sub'=>$sub]);
        
    }

}
