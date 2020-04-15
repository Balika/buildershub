<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TagRepository
 *
 * @author Edmond
 */
class TagRepository extends EntityRepository {

    public function findAllQry() {
        return $this
                        ->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
    }

    
    
}
