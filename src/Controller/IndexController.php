<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Services\AppManager;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of IndexController
 *
 * @author Balika Edmond
 */
class IndexController extends BaseController {

    /**
     * @Route("/", name="home")
     */
    public function index(AppManager $appManager) {
        $currentDomain  = $appManager->getCurrentDomain();
        if($currentDomain){
            return $this->redirectToRoute('hubernize_dashboard');
        }
        return $this->render('index.html.twig', [
                    'controller_name' => 'IndexController'
        ]);
    }
    /**
     * @Route("/test-s3-images", name="s3_test_loader")
     */
    public function s3Testloader() {
        $image = '22_product_feature_image_8k2nsbrl.jpeg';//'https://buildershub.s3-us-west-1.amazonaws.com/live/images/archibald_appiah_profile_cover_vwsfk.jpg';        
        return $this->render('s3.test.html.twig', [
            'image' => $image
        ]);
    }

    

}
