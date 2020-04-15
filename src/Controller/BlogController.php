<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\BlogPost;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of BlogController
 *
 * @author Balika Edmond
 */

/**
 * @Route("/hub")
 */
class BlogController extends BaseController {
    const NEWS = "News";
    const ARTICLE="Articles";
    const BLOG="Blog";
    const VIDEO="Video";
            

    protected $paginatorService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

    /**
     * @Route(name="posts_index")
     */
    public function index(Request $request) {
        $query = $this->getDoctrine()->getRepository(EntityConfig::BLOG_POST)->findPaginatedBlogPosts();
        $posts = $this->paginatorService->getPaginatedEntity($request, $query, 6, array('distinct' => true));
        return $this->render('blog/blog.index.html.twig', [
                    'posts' => $posts
        ]);
    }

    /**
     * @Route("/{type}/{slug}", name="single_post")
     */
    public function singlePost(BlogPost $post, $type, Request $request) {
        return $this->render('blog/single.post.html.twig', [
                    'post' => $post
        ]);
    }

}
