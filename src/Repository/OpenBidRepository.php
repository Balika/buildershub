<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OpenBidRepository
 *
 * @author Edmond
 */
class OpenBidRepository extends EntityRepository{   
    public function findCurrentBids($bidsClosingDate) { 
        $todaysDate = new \DateTime();
        return $this->createQueryBuilder('ob')                
                ->where('ob.endDate >= :todaysDate')
                //->setParameter('closingDate',$bidsClosingDate)  
                ->setParameter('todaysDate',$todaysDate)  
                ->orderBy('ob.bidAmount', 'DESC')
                ->getQuery()
                ->getResult();               
    }    
}

