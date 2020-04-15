<?php
namespace App\Controller\Store;

use App\Utils\Constants;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShopperDashboardController
 *
 * @author Balika
 */
class ShopperDashboardController extends AbstractController{
    const SHOPPER_TPL_PREFIX = "store/shopper/";
    /**
     * 
     * @Route("/shopper/dashboard/{page}", name="shopper_dashboard", defaults={"page":"summary"}) 
     */
    public function shopperDashboar(Request $request, $page=null){
        $template = self::SHOPPER_TPL_PREFIX.$page.Constants::TPL_SUFFIX;
       return $this->render('store/shopper/shopper.dashboard.html.twig', ['template'=>$template, 'page'=>$page]);
    }
}
