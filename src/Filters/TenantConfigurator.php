<?php

namespace App\Filters;

use App\Entity\User;
use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeleteConfigurator
 *
 * @author Balika
 */
class TenantConfigurator {

    //put your code hereprotected $em;
    protected $tokenStorage;
    protected $reader;

    const DEMO_TENANT_DOMAIN = 'btl';

    private $persistenceService;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, Reader $reader, PersistenceService $persistenceService) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->reader = $reader;
        $this->persistenceService = $persistenceService;
    }

    public function onKernelRequest() {
        //Filter out deleted items from results set for non-admin users
        $tenant = $this->getTenant();
        if ($tenant) {            
            $filter = $this->em->getFilters()->enable('tenant_filter');
            $filter->setParameter('supplier_id', $tenant->getId());
            $filter->setAnnotationReader($this->reader);
        }
    }

    private function getTenant() {
        $tenant = $this->persistenceService->getRepository(EntityConfig::COMPANY)->findOneBy(['domain' => self::DEMO_TENANT_DOMAIN]);
        $token = $this->tokenStorage->getToken();   
        if ($tenant && $token != NULL) {
           // $token = $this->tokenStorage->getToken();            
            $user = $token->getUser();
            if ($user instanceof User && in_array('ROLE_HUB_ADMIN', $user->getRoles())) {//If user has administrator role, do not filter out deleted items
                return null;
            }
            return $tenant;
        }
       return null;
    }

}
