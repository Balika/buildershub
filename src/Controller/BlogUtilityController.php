<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of StoreBlogController
 *
 * @author Balika Edmond
 */
class BlogUtilityController extends BaseController {

    protected $paginatorService;

    const NEWS = "News";
    const ARTICLE = "Articles";
    const BLOG = "Blog";
    const VIDEO = "Video";
    const BLOG_FRAGMENT_PREFIX = 'blog/fragments/';

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

    public function renderPosts($template = 'latest.posts') {
        $latestPosts = $this->getDoctrine()->getRepository(EntityConfig::BLOG_POST)->findAll();
        $response = $this->render(self::BLOG_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'latestPosts' => $latestPosts
        ]);
        $response->setSharedMaxAge(600);
        return  $response;
    }
}
