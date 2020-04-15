<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SpecialtyRepository
 *
 * @author Edmond
 */
class SpecialtyRepository extends EntityRepository {
    public function specialtyNames($type) {
        $list=[];
        $specialties = $this->createQueryBuilder('s')
                        ->select('s.name')
                        ->where('s.type = :type')
                        ->setParameter('type', $type)
                        ->distinct()
                        ->getQuery()
                        ->getResult();
        foreach($specialties as $specialty){
            $list[]=$specialty['name'];
        }
        return $list;
    }

}
