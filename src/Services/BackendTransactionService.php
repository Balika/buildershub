<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Supplier;
use App\Utils\EntityConfig;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of BackendTransactionService
 *
 * @author Balika
 */
class BackendTransactionService {

    protected $persistenceService;
    protected $paginator;

    const QUERY_SIZE = 12;

    public function __construct(PersistenceService $persistenceService, KnpPaginatorWrapper $paginator) {
        $this->persistenceService = $persistenceService;
        $this->paginator = $paginator;
    }

    public function getStoreOrders(Supplier $supplier, Request $request, $isPaginated = FALSE) {
        $results = $this->persistenceService->getRepository(EntityConfig::ORDER_ITEM)->findStoreOrders($supplier, $isPaginated);
        return $isPaginated ? $this->paginator->getPaginatedEntity($request, $results) : $results;
    }

}
