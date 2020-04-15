<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Company;
use App\Entity\Notification;
use App\Utils\EntityConfig;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of NotificationService
 *
 * @author Balika
 */
class NotificationService {

    protected $persistenceService;
    protected $paginator;

    const QUERY_SIZE = 12;

    public function __construct(PersistenceService $persistenceService, KnpPaginatorWrapper $paginator) {
        $this->persistenceService = $persistenceService;
        $this->paginator = $paginator;
    }

    public function getCompanyTopNavNotifications(Company $company) {
        return $this->persistenceService->getRepository(EntityConfig::NOTIFICATION)->findCompanyTopNavNofications($company);
    }

    public function getCompanyNotifications(Company $company, Request $request, $isPaginated = TRUE) {
        $results = $this->persistenceService->getRepository(EntityConfig::NOTIFICATION)->findCompanyNofications($company, $isPaginated);
        return $isPaginated ? $this->paginator->getPaginatedEntity($request, $results, self::QUERY_SIZE) : $results;
    }
    public function getNotifications(Request $request, $isPaginated = TRUE) {
        $results = $this->persistenceService->getRepository(EntityConfig::NOTIFICATION)->findNofications($isPaginated);
        return $isPaginated ? $this->paginator->getPaginatedEntity($request, $results, self::QUERY_SIZE) : $results;
    }
    public function getNotificationEntity(Notification $notification=null) {
       return $notification != null ? $this->persistenceService->getRepository($notification->getEntity())->find($notification->getEntityId()) : null;
    }

}
