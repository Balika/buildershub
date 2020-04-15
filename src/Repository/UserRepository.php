<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserRepository
 *
 * @author Edmond
 */
class UserRepository extends EntityRepository {

    public function searchUsers($term, $paginated = FALSE) {
        $qb = $this->createQueryBuilder('u');
        $qb
                ->where($qb->expr()->like('u.firstname', $qb->expr()->literal("%$term%")))
                ->orWhere($qb->expr()->like('u.lastname', $qb->expr()->literal("%$term%")))
                ->orWhere($qb->expr()->like('u.email', $qb->expr()->literal("%$term%")))
                ->orWhere($qb->expr()->like('u.username', $qb->expr()->literal("%$term%")))
                ->orWhere($qb->expr()->like('u.contactNo', $qb->expr()->literal("%$term%")));
               // ->andWhere('u.company IS NULL');
        $query = $qb->getQuery();
        return $paginated ? $query : $query->getResult();
    }

    public function loadUserByUsername($username) {
        $user = $this->createQueryBuilder('u')
                ->select('u')
                //->leftJoin('u.roles', 'g')
                ->where('u.username = :username OR u.email = :email')
                ->setParameter('username', $username)
                ->setParameter('email', $username)
                ->getQuery()
                ->getOneOrNullResult();

        if (null === $user) {
            $message = sprintf(
                    'There is no user identified by "%s" in our database', $username
            );
            throw new UsernameNotFoundException($message);
        }
        return $user;
    }
    public function findPaginatedUsers($company) {
        return $this
                    ->createQueryBuilder('u')
                    ->leftJoin('u.firm', 'f')
                    ->where('f = :company')
                    ->setParameter('company',$company)
                    ->orderBy('u.firstname', 'ASC')
                    ->getQuery();
    }

}
