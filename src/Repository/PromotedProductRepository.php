<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PromotedProductRepository
 *
 * @author Edmond
 */
class PromotedProductRepository extends EntityRepository {

    public function findAllQry() {
        return $this
                        ->createQueryBuilder('c');
                        
    }

    
    public function findPromotedProducts($supplier = null, $limit=100) {
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where($supplier != null ? 'p.supplier = :supplier' : 'p.id > 0')// p.id > 0 here is meaningless. Only added to avoid syntax  error if vendor = null                         
                        ->setParameters($supplier != null ? array('supplier' => $supplier) : array())
                        ->setMaxResults($limit)
                        ->getQuery()
                        ->getResult();
    }

}
