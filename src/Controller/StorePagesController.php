<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Utils\Constants;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of StorePagesController
 *  All pages that give further information on builders hub but do not necessarily hold/display products
 * @author Balika Edmond
 */

/**
 * @Route("/store/hub/")
 */
class StorePagesController extends BaseController {    
    const HUB_PAGE_PREFIX= "store/hub/";
    
    /**
     * @Route("{page}", name="hub_page")
     */
    public function hubPage($page, Request $request) {
        $template = self::HUB_PAGE_PREFIX.$page.Constants::TPL_SUFFIX;
        return $this->render($template);
    }
}
