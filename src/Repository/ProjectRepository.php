<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjectRepository
 *
 * @author Edmond
 */
class ProjectRepository extends EntityRepository {

    public function findProjectsByTownAndCategory($townId, $categoryId) {
        return $this->createQueryBuilder('p')                      
                        ->leftJoin('p.user', 'u')                      
                        ->leftJoin('p.town', 't')
                        ->where('t.id = :town')                       
                        ->setParameter('town', $townId)
                        ->orderBy('p.createdAt', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findProjectsByTown($townId) {
        return $this->createQueryBuilder('p')
                        ->leftJoin('p.user', 'u')
                        ->leftJoin('u.userProfile', 'up')
                        ->leftJoin('up.town', 't')
                        ->where('t.id = :town')
                        ->setParameter('town', $townId)
                        ->orderBy('p.createdAt', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findProjectsByCategory($categoryId) {
        return $this->createQueryBuilder('p')
                        ->leftJoin('p.category', 'c')
                        ->where('c.id = :category')
                        ->setParameter('category', $categoryId)
                        ->orderBy('p.createdAt', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findProjectsByRegion($regionId) {
        return $this->createQueryBuilder('p')
                        ->leftJoin('p.user', 'u')
                        ->leftJoin('u.userProfile', 'up')
                        ->leftJoin('up.region', 'r')
                        ->where('r.id = :regionId')
                        ->setParameter('regionId', $regionId)
                        ->orderBy('p.createdAt', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findLatestProjects($limit = 10) {
        return $this->createQueryBuilder('p')
                        ->orderBy('p.createdAt', 'DESC')
                        ->getQuery()
                        ->setMaxResults($limit)
                        ->getResult();
    }

    public function findFeaturedProjects() {
        return $this->createQueryBuilder('p')
                        ->where('p.isActive = true')
                        ->orderBy('p.createdAt', 'DESC')
                        ->getQuery();
    }

    public function findProjectsByType($typeLabel, $typeLabel2 = null) {
        return $this->createQueryBuilder('p')
                        ->leftJoin('p.projectType', 'pt')
                        ->where('pt.name = :typeName OR pt.name =:typeName2')
                        ->setParameter('typeName', $typeLabel)
                        ->setParameter('typeName2', $typeLabel2)
                        ->orderBy('p.createdAt', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findProjectTypesDistribution() {
        $projectDistribution[] = array('label' => 'New Project', 'value' => $this->getProjectTypeCount('New Project'));
        $projectDistribution[] = array('label' => 'Major Rehabilitation Works', 'value' => $this->getProjectTypeCount('Major Rehabilitation Works'));
        $projectDistribution[] = array('label' => 'Minor Repair Works', 'value' => $this->getProjectTypeCount('Minor Repair Works'));
        return $projectDistribution;
    }

    private function getProjectTypeCount($typeName) {
        return $this
                        ->createQueryBuilder('p')
                        ->select('COUNT(p.id)')
                        ->leftJoin('p.projectType', 'pt')
                        ->where('pt.name = :typeName')
                        ->setParameter('typeName', $typeName)
                        ->distinct()
                        ->getQuery()
                        ->getResult()[0][1];
    }

    public function findPaginatedProject($category = null, $region = null, $town = null) {
        $parameters = [];
        $qb = $this->createQueryBuilder('p');
        if ($region != null) {
            $parameters['region'] = $region;
            $qb->andWhere('p.region = :region');
        }
        if ($town != null) {
            $parameters['town'] = $town;
            $qb->andWhere('p.town = :town');
        }
        if ($category != null) {
            $parameters['category'] = $category;
            $qb->andWhere('p.category = :category');
        }
        return $qb->setParameters($parameters)
                        ->getQuery();
    }

}
