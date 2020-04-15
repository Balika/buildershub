<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InstitutionRepository
 *
 * @author Edmond
 */
class InstitutionRepository extends EntityRepository {

    public function findAllQry() {
        return $this
                        ->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
    }

    public function findQry($type) {
        return $this
                        ->createQueryBuilder('i')
                        ->where('i.type = :type')
                        ->setParameter('type', $type)
                        ->orderBy('i.name', 'ASC');
    }

    public function fetchInstitutionsNames() {
        $list=[];
         $institutions = $this
                        ->createQueryBuilder('i')
                        ->select('i.name')
                        ->distinct()
                        ->getQuery()
                        ->getResult();
        foreach($institutions as $institution){
            $list[]=$institution['name'];
        }
        return $list;
    }

}
