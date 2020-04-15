<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderRepository
 *
 * @author Edmond
 */
class OrderRepository extends EntityRepository {

    public function findAllQry() {
        return $this
                        ->createQueryBuilder('o')
                        ->orderBy('o.createdAt', 'DESC');
    }

   public function findOrders(Supplier $supplier) {
       return $this->createQueryBuilder('o')            
            ->orderBy('o.createdAt', 'DESC')            
            ->getQuery()
            ->getResult();
    }
}
