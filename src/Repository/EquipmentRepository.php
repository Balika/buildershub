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
 * Description of EquipmentRepository
 *
 * @author Edmond
 */
class EquipmentRepository extends EntityRepository {
    public function findCompanyEquipment(Company $company, $isPaginated=TRUE) {
        $qry = $this->createQueryBuilder('e')
                        ->where('e.company = :company')
                        ->setParameter('company', $company)
                        ->getQuery(); 
        return $isPaginated ? $qry : $qry->getResult();                       
    }
     public function findCompanyEquipmentQry(Company $company) {
        return $this->createQueryBuilder('e')
                        ->where('e.company = :company')
                        ->setParameter('company', $company)
                        ->orderBy('e.name',"ASC");                        
    }

}
