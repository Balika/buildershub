<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Twig;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Supplier;
use App\Model\AppInterface;
use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Description of HubRuntime
 *
 * @author Balika
 */
class HubRuntime implements RuntimeExtensionInterface {

    protected $persistenceService;
    protected $appManager;

    public function __construct(PersistenceService $persistenceService, AppInterface $appManager) {
        $this->persistenceService = $persistenceService;
        $this->appManager=$appManager;
    }

    /**
     * 
     * @param Order order
     * @param Supplier supplier 
     * @return OrderItem
     * @description This function returns orderItems belonging to a particular store
     */
    public function getOrderItems(Supplier $supplier, Order $order, $isPaginated=FALSE) {
        return $this->persistenceService->getRepository(EntityConfig::ORDER_ITEM)->findStoreOrderItems($supplier, $order, $isPaginated);
    }
    public function hubernizeHost($domain) {
        return $this->appManager->getHubernizeHost($domain);
    }
    public function isSubscribedToApp($company, $appCode='EquiPack') {
        $app = $this->appManager->getApp($appCode);
        return $this->appManager->isSubscribedToApp($company, $app);
    }

}
