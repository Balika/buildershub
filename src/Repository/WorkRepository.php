<?php

namespace App\Repository;

use App\Utils\EntityConfig;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WorkRepository
 *
 * @author Edmond
 */
class WorkRepository extends EntityRepository {

    public function findUserProjects($user) {
        return $this->createQueryBuilder('w')
                        ->where('w.user = :user')
                        ->setParameter("user", $user)
                        ->getQuery();
    }
     public function findBuilderProjects($user) {
        return $this->createQueryBuilder('w')
                        ->where('w.user = :user')
                        ->setParameter("user", $user)
                        ->getQuery()
                ->getResult();
    }

    public function findLatestProject($user) {
        return $this->createQueryBuilder('w')
                        ->where('w.user = :user')
                        ->setMaxResults(1)
                        ->setParameter("user", $user)
                        ->orderBy('w.createdAt', "DESC")
                        ->getQuery()
                        ->getOneOrNullResult();
    }

}
