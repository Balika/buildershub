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
class RentalRequestRepository extends EntityRepository {
    public function findCompanyRentalRequests(Company $company, $isPaginated=TRUE) {
        $qry = $this->createQueryBuilder('rr')
                        ->leftJoin('rr.rentalAd', 'ra')
                        ->where('ra.company = :company')
                        ->setParameter('company', $company)
                        ->getQuery(); 
        return $isPaginated ? $qry : $qry->getResult();
                        
    }
}
