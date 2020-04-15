<?php
namespace App\Repository;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExperienceRepository
 *
 * @author Edmond
 */
class ExperienceRepository extends EntityRepository{
   public function findCurrentJob($user) {
        return $this->createQueryBuilder('e')                
                ->leftJoin('e.user', 'u')                
                ->where('u = :user AND e.isPresent = TRUE')                             
                ->setParameter('user', $user)                
                ->getQuery()
                ->getOneOrNullResult();             
    }
}
