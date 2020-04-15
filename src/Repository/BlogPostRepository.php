<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlogPostRepository
 *
 * @author Edmond
 */
class BlogPostRepository extends EntityRepository {
    public function findPaginatedBlogPosts() {
        return $this->createQueryBuilder('p')  
                
                        ->getQuery();
                        
    }

}
