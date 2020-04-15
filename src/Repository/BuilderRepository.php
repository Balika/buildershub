<?php

namespace App\Repository;

use App\Entity\User;

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
class BuilderRepository extends PersonRepository {

    public function findBuilders() {
        return $this->createQueryBuilder('b')                       
                        ->getQuery()
                        ->getResult();
    }

    public function findBuildersPaginated($service, $category = null, $region = null, $town = null, $subLocation = null) {
        /*         * $count = $this->createQueryBuilder('p')
          ->select('count(p)')
          ->getQuery()
          ->getSingleScalarResult();
          //$paginator =new Paginator(); */

        $qb = $this->createQueryBuilder('p');
                
                $qb->leftJoin('p.user', 'u')
                ->leftJoin('u.userProfile', 'up')
                ->where($qb->expr()->like('p.services', $qb->expr()->literal("%$service%")));

        $parameters = [];
        if ($region != null) {
            $qb->andWhere('up.region = :region');
            $parameters['region'] = $region;
        }
        if ($category != null) {
            $qb->andWhere('p.profession = :profession');
            $parameters['profession'] = $category;
        }
        if ($town != null) {
            $qb->andWhere('up.town = :town');
            $parameters['town'] = $town;
        }
        if ($subLocation != null) {
            $qb->andWhere('up.subLocation = :subLocation');
            $parameters['subLocation'] = $subLocation;
        }
        return $query = $qb->setParameters($parameters)
                ->getQuery();
        //->setHint('knp_paginator.count', $count);
        //return $paginator->paginate($query, 1, 10, array('distinct' => false));
    }
    public function profileRecommendations(User $requestedProfile, User $currentUser=null, $service = 'ALL') {
        return $this->createQueryBuilder('p')                        
                        ->where('p.user != :user')
                        ->setParameter('user', $requestedProfile)
                        ->getQuery()
                        ->getResult();
    }

}
