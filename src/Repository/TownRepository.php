<?php
namespace App\Repository;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TownRepository
 *
 * @author Edmond
 */
class TownRepository extends EntityRepository{
   public function findAllQry()
    {
        return $this
            ->createQueryBuilder('t')            
            ->orderBy('t.name', 'ASC')   ;            
    }
    public function findByRegionQry($regionId)
    {
        return $this
            ->createQueryBuilder('t') 
            ->leftJoin('t.region', 'r')
            ->where('r.id = :regiondId')
            ->setParameter('regiondId', $regionId)
            ->orderBy('t.name', 'ASC')   ;            
    }
    public function findCapitalTowns() {
        return $this->createQueryBuilder('t')                              
                ->where('t.isCapital = true')                                            
                ->orderBy('t.name', 'ASC')
                ->getQuery()
                ->getResult();               
    }
    public function findTownByTerm($term) {
        return $this->createQueryBuilder('t')
        ->where('t.name LIKE :name')
                ->setParameter('name', '%' . $term . '%')                
                ->getQuery()
                ->getResult();
    }
     public function findPaginatedTowns() {
        return $this
                        ->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC')
                        ->getQuery();
    }
}
