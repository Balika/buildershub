<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TopVendorRepository
 *
 * @author Edmond
 */
class TopSupplierRepository extends EntityRepository {

    public function findTopSuppliers() {
        return $this->createQueryBuilder('t')
                        ->where('t.endDate >= :todaysDate')
                        ->setParameter('todaysDate', new \DateTime('now'))
                        ->orderBy('t.bidAmount', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findCategoryTopVendors($categories = [], $region = null, $town = null) {
        $qb = $this->createQueryBuilder('t')
                ->leftJoin('t.supplier', 's')
                ->where('t.endDate >= :todaysDate');
        $parameters['todaysDate'] = new \DateTime('now');
        if ($categories != null) {
            $literalEpx = implode(',',$categories);
            $qb->andWhere('t.productCategories LIKE :productCategories');
            $parameters['productCategories'] = '%' . $literalEpx . '%';
        }
        if ($region != null) {
            $parameters['region'] = $region;
            $qb->andWhere('s.region = :region');
        }
        if ($town != null) {
            $parameters['town'] = $town;
            $qb->andWhere('s.businessLocation = :town');
        }
        return $qb->setParameters($parameters)
                        ->orderBy('t.bidAmount', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findLocationTopVendors($region = null, $town = null) {
        $qb = $this->createQueryBuilder('t');
        $qb->leftJoin('t.supplier', 's')
                ->where('t.endDate >= :todaysDate');
        $parameters['todaysDate'] = new \DateTime('now');
        if ($region != null) {
            $parameters['region'] = $region;
            $qb->andWhere('s.region = :region');
        }
        if ($town != null) {
            $parameters['town'] = $town;
            $qb->andWhere('s.businessLocation = :town');
        }
        return $qb->setParameters($parameters)
                        ->orderBy('t.bidAmount', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

}
