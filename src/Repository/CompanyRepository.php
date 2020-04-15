<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanyRepository
 *
 * @author Edmond
 */
class CompanyRepository extends EntityRepository {

    
    public function filterByLocationPaginated($region = null, $town = null, $subLocation = null) {
        $parameters =[];
        $qb = $this->createQueryBuilder('c');        
        if ($region != null) {
            $parameters['region'] = $region;
            $qb->where('c.region = :region');
        }
        if ($town != null) {
            $parameters['town'] = $town;
            $qb->andWhere('c.businessLocation = :town');
        }
        if ($subLocation != null) {
            $parameters['subLocation'] = $subLocation;
            $qb->andWhere('c.subLocation = :subLocation');
        }        
        return $qb->setParameters($parameters)
                        ->getQuery();
    }

}
