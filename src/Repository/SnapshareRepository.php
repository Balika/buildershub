<?php
namespace App\Repository;

use AppBundle\Entity\Snapshare;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SnapShareRepository
 *
 * @author Edmond
 */
class SnapshareRepository extends EntityRepository{
   public function findAllQry()
    {
        return $this
            ->createQueryBuilder('s')            
            ->orderBy('s.title', 'ASC')   ;            
    }
    public function findOtherTrendingSnapshares(Snapshare $selectedSnapshare){
        return $this->createQueryBuilder('s')                
                ->where('s != :snapshare')
                ->setParameter('snapshare', $selectedSnapshare)                              
                ->orderBy('s.createdAt', 'DESC')
                ->getQuery()
                ->getResult();   
    }
}
