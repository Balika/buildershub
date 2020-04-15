<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Company;
use App\Entity\User;
use App\Entity\Work;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Description of PortfolioService
 *
 * @author Balika - BTL
 */
class PortfolioService {

    protected $persistenceService;
    protected $tokenStorage;
    protected $slugger;
    protected $paginator;
    protected $currentUser;
    
    public function __construct(PersistenceService $persistenceService, TokenStorageInterface $token, Slugger $slugger, KnpPaginatorWrapper $paginator) {
        $this->persistenceService = $persistenceService;
        $this->tokenStorage = $token;
        $this->currentUser= $token->getToken()->getUser();
        $this->slugger = $slugger;
        $this->paginator = $paginator;
    }
    public function getMyProjects(Request $request, $pageSize=10) {
         $query = $this->persistenceService->getRepository(EntityConfig::WORK)->findUserProjects($this->currentUser);
         return $this->paginator->getPaginatedEntity($request, $query, $pageSize);
    }
    public function getLatestProject(User $user) {
        return $this->persistenceService->getRepository(EntityConfig::WORK)->findLatestProject($user);         
    }
     public function getBuilderProjects(User $user, Request $request, $pageSize=10){
         return $this->persistenceService->getRepository(EntityConfig::WORK)->findBuilderProjects($user);
        // return $this->paginator->getPaginatedEntity($request, $query, $pageSize);
     }
     public function saveWork(Work $work, Company $company=null) {
         $work->setUser($this->currentUser);
            $slug = $this->slugger->slugifyUnique($work->getTitle(), EntityConfig::WORK);
            $work->setSlug($slug);
            $work->setCompany($company);
            $this->persistenceService->saveEntity($work);
     }
    
}
