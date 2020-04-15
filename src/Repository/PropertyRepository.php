<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\Supplier;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PropertyRepository
 *
 * @author Edmond
 */
class PropertyRepository extends EntityRepository {

    public function findAllQry($supplier = null) {
        return $this
                        ->createQueryBuilder('p')
                        ->leftJoin('p.company', 's')
                        ->where('s = :company')
                        ->setParameter('company', $supplier)
                        ->orderBy('p.name', 'ASC');
    }

    public function findMerchantPropertiesQry(Supplier $supplier) {
        return $this
                        ->createQueryBuilder('p')
                        ->leftJoin('p.company', 's')
                        ->where('s.id = :supplierId')
                        ->setParameter('supplierId', $supplier->getId())
                        ->orderBy('p.name', 'ASC');
    }
}
