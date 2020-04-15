<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Project;
use App\Model\AccountInterface;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of SearchController
 *
 * @author Balika 
 */
class ProjectController extends BaseController {

    const PAGE_PREFIX = 'projects/';

    protected $paginatorService;
    protected $accountService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger, AccountInterface $accountService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
        $this->accountService = $accountService;
    }

    /**
     * @Route("/projects/add/{id}", name="add_project", defaults={"id":0})
     */
    public function addProject(Request $request, Project $project = null) {
        $form = $this->formService->createProjectForm();
        $isSuccess = FALSE;
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $userType = $request->request->get('userType');
            $project = $form->getData();
            $project->setSlug($this->slugger->slugify($project->getTitle()));
            $project->setIsActive(TRUE);
            $project->setArtisans($request->request->get('artisanCategories'));
            $project->setProfessionals($request->request->get('professionalCategories'));
            $user = $this->getUser();
            if($user == null){
               $user = $project->getUser();
               $this->accountService->createBuilderAccount($user, $userType, null);
            }                     
            $project->setUser($user);
            $this->persistenceService->saveEntity($project);
            $isSuccess = TRUE;
        }
        $professionalCategories = $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->findBy(['type' => Constants::CONSULTANT]);
        $artisanCategories = $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->findBy(['type' => Constants::ARTISAN]);
        return $this->render(self::PAGE_PREFIX . '/add.project.html.twig', [
                    'form' => $form->createView(),
                    'professionalCategories' => $professionalCategories,
                    'project' => $project,
                    'isSuccess' => $isSuccess,
                    'user' => $this->getUser(),
                    'artisanCategories' => $artisanCategories
        ]);
    }

}
