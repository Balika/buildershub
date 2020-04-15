<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Services\FormService;
use App\Services\Hubernize\InventoryService;
use App\Utils\Constants;
use App\Utils\HubUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of RentalUtilityController
 *
 * @author Balika
 */
class RentalUtilityController extends AbstractController {

    private $inventoryService;
    private $formService;

    
    // const RENTAL_CONTENT_BLOCK_TPL = "rentals/shared/rental.content.block.html.twig";
    const RENTAL_FRAGMENT_PREFIX = "rentals/fragments/";
    
    public function __construct(FormService $formService, InventoryService $inventoryService) {
        $this->inventoryService = $inventoryService;
        $this->formService = $formService;
    }

    public function renderHeaderFragment(HubUtil $util, Request $request, $template = "top.header.nav") {
        $response = $this->render(self::RENTAL_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [
            'user' => $this->getUser(),
            'categories' => $util->getAllEquipmentCategories(),
            'sparePartsCities' => $util->getSparePartsCities()
        ]);
        $response->setSharedMaxAge(86400);
        return $response;
    }

    public function renderContentFragment(HubUtil $util, $template = "content", $regionId = null) {
        $commonParams = ['user' => $this->getUser(),
            'categories' => $util->getAllEquipmentCategories(),
        ];
        $response = $this->render(self::RENTAL_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, array_merge($commonParams, $this->getBlockParams($template, $regionId, $util)));
        $response->setSharedMaxAge(86400);
        return $response;
    }

    private function getBlockParams($template, $regionId, HubUtil $util) {
        $params = [];
        switch ($template) {
            case "pick.location":
                $params['regions'] = $util->getRegions();
                $params['selectedRegion'] = null;
                $params['townList'] = [];
                if (!is_null($regionId)) {
                    $selectedRegion = $util->getRegion($regionId);
                    $towns = $util->getTowns($selectedRegion);
                    $params['townList'] = $towns;
                    $params['selectedRegion'] = $selectedRegion;
                }
                break;
            default:
                break;
        }
        return $params;
    }

    private function isRentalFilter(Request $request) {
        return $this->getCurrentRoute($request) == 'rental_filter';
    }

    public function weeklyDeals($template = 'weekly.deals') {
        $weeklyDeals = $this->inventoryService->getWeeklyDeals();
        $response = $this->render(self::RENTAL_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, [           
            'weeklyDeals' => $weeklyDeals
        ]);
        $response->setSharedMaxAge(60);
        return $response;
    }

}
