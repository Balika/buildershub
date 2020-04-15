<?php

namespace App\Repository;

use App\Entity\User;
use App\Utils\EntityConfig;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonRepository
 *
 * @author Edmond
 */
class PersonRepository extends EntityRepository {

    public function profileRecommendations(User $requestedProfile, User $currentUser=null, $service = 'ALL') {
        return $this->createQueryBuilder('p')
                        //->where('p INSTANCE OF ' . EntityConfig::ARTISAN . ' OR p INSTANCE OF ' . EntityConfig::PROFESSIONAL)
                        ->where('p.user != :user')
                        ->setParameter('user', $requestedProfile)
                        ->getQuery()
                        ->getResult();
    }

}
