<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SupplierRepository
 *
 * @author Edmond
 */
class SupplierRepository extends CompanyRepository {

    public function findMerchants($region = null) {
        return $this->createQueryBuilder('c')
                        ->leftJoin('c.firmType', 'f')
                        ->leftJoin('c.owner', 'u')
                        ->where('(f.code = :code OR u.userType =:userType)' . ($region != null ? ' AND c.region = :region' : ' OR c.region =:region'))
                        ->setParameter('region', $region)
                        ->setParameter('code', 'MERCHANT')
                        ->setParameter('userType', 'CIPRON_ADMIN')
                        ->orderBy('c.name', 'ASC')
                        ->getQuery()
                        ->getResult();
    }

    public function findTownMerchants($town, $firmType ='MERCHANT') {
        return $this->createQueryBuilder('c')
                        ->leftJoin('c.firmType', 'f')
                        ->leftJoin('c.owner', 'u')
                        ->where('(f.code = :code OR u.userType =:userType) AND c.businessLocation = :town')
                        ->setParameter('town', $town)
                        ->setParameter('code', $firmType)
                        ->setParameter('userType', 'CIPRON_ADMIN')
                        ->orderBy('c.name', 'ASC')
                        ->getQuery()
                        ->getResult();
    }
    public function findPaginatedMerchants($region = null) {
        return $this->createQueryBuilder('c')
                        ->leftJoin('c.firmType', 'f')
                        ->leftJoin('c.owner', 'u')
                        ->where('(f.code = :code OR u.userType =:userType )' . ($region != null ? ' AND c.region = :region' : ' OR c.region =:region'))
                        ->setParameter('region', $region)
                        ->setParameter('code', 'MERCHANT')
                        ->setParameter('userType', 'CIPRON_ADMIN')
                        ->orderBy('c.name', 'ASC')
                        ->getQuery();
    }
    public function findPaginatedFirms($firmCode, $region=null) {
        return $this->createQueryBuilder('c')
                        ->leftJoin('c.firmType', 'f')                        
                        ->where('f.code = :code ' . ($region != null ? ' AND c.region = :region' : ' OR c.region =:region'))
                        ->setParameter('region', $region)
                        ->setParameter('code', $firmCode)                       
                        ->orderBy('c.name', 'ASC')
                        ->getQuery();
    }

   

}
