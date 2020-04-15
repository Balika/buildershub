<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Supplier;
use App\Utils\EntityConfig;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderItemRepository
 *
 * @author Edmond
 */
class OrderItemRepository extends EntityRepository {

    public function findAllQry() {
        return $this
                        ->createQueryBuilder('oi')
                        ->orderBy('oi.serialNumber', 'ASC');
    }

    public function findStoreOrders(Supplier $supplier, $pagination = TRUE) {
        $qb = $this->createQueryBuilder('oi')
                ->leftJoin('oi.product', 'p')
                ->leftJoin('p.supplier', 's')
                ->select('o')
                ->from(EntityConfig::ORDER, 'o')
                ->where('s = :supplier AND oi MEMBER OF o.orderItems')
                ->setParameter('supplier', $supplier);
        $query = $qb->getQuery();
        return $pagination ? $query : $query->getResult();
    }

    public function findStoreOrderItems(Supplier $supplier, Order $order) {
        return $this->createQueryBuilder('oi')
                        ->leftJoin('oi.product', 'p')
                        ->leftJoin('p.supplier', 's')
                        ->where('s= :supplier')
                        ->andWhere('oi IN (:orderItems)')
                        ->setParameter('supplier', $supplier)
                        ->setParameter('orderItems', $order->getOrderItems())
                        ->getQuery()
                        ->getResult();
    }

}
