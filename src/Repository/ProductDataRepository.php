<?php
namespace App\Repository;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductDataRepository
 *
 * @author Edmond
 */
class ProductDataRepository extends EntityRepository{
   public function findAllQry()
    {
        return $this
            ->createQueryBuilder('c')            
            ->orderBy('c.name', 'ASC');            
    }
}
