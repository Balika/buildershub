<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Twig;

use App\Entity\User;
use App\Model\AppInterface;
use App\Services\EngageService;
use App\Services\PersistenceService;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Description of HubRuntime
 *
 * @author Balika
 */
class ProfileRuntime implements RuntimeExtensionInterface {

    protected $persistenceService;
    protected $appManager;
    protected $engageService;
    

    public function __construct(PersistenceService $persistenceService, AppInterface $appManager, EngageService $engageService) {
        $this->persistenceService = $persistenceService;
        $this->appManager=$appManager;
        $this->engageService=$engageService;
    }

    
    public function isLiked($entity, $user=null) {
        return $user instanceof User ? $this->engageService->isLiked($user, $entity) : FALSE;
    }

}
