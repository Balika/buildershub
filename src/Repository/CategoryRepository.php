<?php

namespace App\Repository;

use App\Utils\Constants;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryRepository
 *
 * @author Edmond
 */
class CategoryRepository extends EntityRepository {

    public function findAllQry() {
        return $this
                        ->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
    }

    public function findByTypeQry($type) {
        return $this
                        ->createQueryBuilder('c')
                        ->where('c.type = :type')
                        ->setParameter('type', $type)
                        ->orderBy('c.name', 'ASC');
    }

    public function findByType($type) {
        return $this
                        ->createQueryBuilder('c')
                        ->where('c.type = :type AND c.parent IS NULL')
                        ->setParameter('type', $type)
                        ->orderBy('c.name', 'ASC')
                        ->getQuery()
                        ->getResult();
    }

}
