<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EducationRepository
 *
 * @author Edmond
 */
class EducationRepository extends EntityRepository {

    public function searchInstitutions($term) {
        $qb = $this->createQueryBuilder('i');
        return
                        $qb->where($qb->expr()->like('i.institution', $qb->expr()->literal("%$term%")))
                        ->getQuery()
                        ->getResult();
    }

    public function fetchEducationEntries() {
        $list = [];
        $institutions = $this
                ->createQueryBuilder('e')
                ->select('e.certificateAwarded, e.programmeOfStudy')
                ->distinct()
                ->getQuery()
                ->getResult();
        foreach ($institutions as $institution) {
            $list['diploma'][] = $institution['certificateAwarded'];
            $list['programme'][] = $institution['programmeOfStudy'];
        }
        return $list;
    }

    public function fetchEducationHistory(User $user) {
        return $this
                        ->createQueryBuilder('e')
                        ->where("e.user = :user")
                        ->setParameter('user', $user)
                        ->orderBy("e.to", "DESC")
                        ->getQuery()
                        ->getResult();
    }

}
