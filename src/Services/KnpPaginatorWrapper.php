<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of KnpPaginatorWrapper
 *
 * @author Balika - BTL
 */
class KnpPaginatorWrapper implements PaginatorAwareInterface {

    private $paginator;
    const DEFAULT_PAGE_INDEX = 1;
    const PAGE_SIZE = 10;

    public function __construct() {
        
    }

    public function setPaginator(Paginator $paginator) {
        $this->paginator = $paginator;
    }

    public function getPaginatedEntity(Request $request, $query, $pageSize = 10, $options=[]) {
        return $this->paginator->paginate($query, $request->query->getInt('page', self::DEFAULT_PAGE_INDEX), $pageSize, $options);
    }

}
