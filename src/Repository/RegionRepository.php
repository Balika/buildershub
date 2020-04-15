<?php
namespace App\Repository;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegionRepository
 *
 * @author Edmond
 */
class RegionRepository extends EntityRepository{
   public function findAllQry()
    {
        return $this
            ->createQueryBuilder('r')            
            ->orderBy('r.name', 'ASC')   ;            
    }
     public function findCountryRegionsQry($countryCode)
    {
        return $this
            ->createQueryBuilder('r')  
            ->where('r.countryCode = :code')
            ->setParameter('code', $countryCode)
            ->orderBy('r.name', 'ASC');            
    }
}
