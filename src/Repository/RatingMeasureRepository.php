<?php

namespace App\Repository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArtisanRepository
 *
 * @author Edmond
 */
class RatingMeasureRepository extends PersonRepository {
    public function findBuilderRatingMeasures($builderType) {
        return $this->createQueryBuilder('r')                        
                        ->where("r.type = :builderType")
                        ->orWhere('r.type = :both')
                        ->setParameter('builderType', $builderType)
                        ->setParameter('both', "BOTH")
                        ->getQuery()
                        ->getResult();
    }

}
