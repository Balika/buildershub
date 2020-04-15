<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DealsRepository
 *
 * @author Edmond
 */
class DealsRepository extends EntityRepository {

    public function findWeeklyDeals($supplier = null) {
        return $this->createQueryBuilder('d')
                        ->leftJoin('d.product', 'p')
                        ->where('p is not NULL AND d.endDate >= :todaysDate AND d.supplier = :supplier')
                        ->setParameter('todaysDate', new \DateTime('now'))
                        ->setParameter('supplier', $supplier)
                        ->getQuery()
                        ->getResult();
    }

    public function findRentalWeeklyDeals() {
        $today = new \DateTime();
        return $this->createQueryBuilder('d')
                        ->leftJoin('d.rentalAd', 'ad')
                        ->where('ad is not NULL AND d.endDate >= :endDate')
                        ->setParameter("endDate", $today)
                        ->orderBy('d.endDate', "ASC")
                        ->getQuery()
                        ->getResult();
    }

    public function findSupplierRentalWeeklyDeals($supplier) {
        $today = new \DateTime();
        return $this->createQueryBuilder('d')
                        ->leftJoin('d.rentalAd', 'ad')
                        ->leftJoin('d.supplier', 's')
                        ->where('ad is not NULL AND d.endDate >= :endDate AND s = :supplier')
                        ->setParameter("endDate", $today)
                        ->setParameter("supplier", $supplier)
                        ->orderBy('d.endDate', "ASC")
                        ->getQuery()
                        ->getResult();
    }

}
