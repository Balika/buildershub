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
 * Description of RentalAdRepository
 *
 * @author Edmond
 */
class RentalPromoRepository extends EntityRepository {
    public function findAdsOnPromo(Company $company, $isPaginated=TRUE) {
        $today = new \DateTime('now');
        $qry = $this->createQueryBuilder('rp')
                        ->leftJoin('rp.rentalAd', 'ra')
                        ->where('ra.company = :company')
                        ->andWhere('rp.promoEndDate >= :today')
                        ->setParameter('company', $company)
                        ->setParameter('today', $today)
                        ->getQuery(); 
        return $isPaginated ? $qry : $qry->getResult();
                        
    }
}
