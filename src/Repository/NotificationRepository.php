<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationRepository
 *
 * @author Edmond
 */
class NotificationRepository extends EntityRepository {

    public function findCompanyTopNavNofications(Company $company) {
        return $this->createQueryBuilder('n')
                        ->leftJoin('n.company', 'c')
                        ->where('n.isViewed = :isViewed ')
                        ->andWhere('c = :company')
                        ->orWhere('c IS NULL')
                        ->setParameter('isViewed', FALSE)
                        ->setParameter('company', $company)
                        ->orderBy('n.createdAt', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findCompanyNofications(Company $company, $isPaginated = TRUE) {
        $qb = $this->createQueryBuilder('n')
                ->leftJoin('n.company', 'c')
                ->where('c = :company')
                ->orWhere('c IS NULL')
                ->setParameter('company', $company)
                ->orderBy('n.createdAt', 'DESC')
                ->getQuery();
        return $isPaginated ? $qb : $qb->getResult();
    }

    public function findNofications($filter = 'all', $isPaginated = TRUE) {
        $isViewed = $filter == 'viewed' ? TRUE : FALSE;
        $qb = $this->createQueryBuilder('n');
        if ($filter !== 'all') {
            $qb->where('n.isViewed = :isViewed')
                    ->setParameter('isViewed', $isViewed);
        }
        $qb->orderBy('n.createdAt', 'DESC')->getQuery();
        return $isPaginated ? $qb : $qb->getResult();
    }

}
