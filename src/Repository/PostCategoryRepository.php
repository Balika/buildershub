<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostCategoryRepository
 *
 * @author Edmond
 */
class PostCategoryRepository extends EntityRepository {

    public function findCategoryQry($type = 'category') {
        return $this->createQueryBuilder('c')
                        ->where('c.type = :type')
                        ->setParameter('type', $type)
                        ->orderBy('c.name', 'DESC');
    }

    public function findParentCategoryQry($type = 'category', $rank = 1) {
        return $this->createQueryBuilder('c')
                        ->where('c.type = :type AND c.rank =:rank')
                        ->setParameter('type', $type)
                        ->setParameter('rank', $rank)
                        ->orderBy('c.name', 'ASC');
    }

}
