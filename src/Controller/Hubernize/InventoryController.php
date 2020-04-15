<?php

namespace App\Controller\Hubernize;

use App\Controller\Hubernize\HubernizeBaseController;
use App\Entity\Equipment;
use App\Entity\RentalAd;
use App\Entity\RentalRequest;
use App\Entity\RentedOut;
use App\Model\AppInterface;
use App\Model\HubernizeFormInterface;
use App\Services\Hubernize\InventoryService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventoryController
 *
 * @author Balika Edmond
 * @Route("apps/")
 */
class InventoryController extends HubernizeBaseController {

    const TEMPLATE_PREFIX = 'hubernize/inventory/';
    const INVENTORY_FRAGMENT_PREFIX = self::TEMPLATE_PREFIX . 'fragments/';

    protected $inventoryService;

    public function __construct(AppInterface $appManager, HubernizeFormInterface $formService, InventoryService $inventoryService) {
        parent::__construct($appManager, $formService);
        $this->inventoryService = $inventoryService;
    }

    /**
     * @Route("equipment-inventory/list", name="hubernize_list_equipment")
     * 
     */
    public function listInventory(Request $request) {
        $company = $this->getCompany();
        $extraParams = [];
        if ($request->query->get('equip-id')) {
            $selectedEquipment = $this->inventoryService->getEquipment($request->query->get('equip-id'));
            $form = $this->formService->createRentalAdForm();
            $extraParams = ['form' => $form->createView(), 'selectedEquipment' => $selectedEquipment];
        }
        $listMode = $request->query->get('list_mode');
        $isPaginated = !($listMode == null || $listMode == 'list');
        $equipment = $this->inventoryService->getEquipmentList($company, $request, $isPaginated);
        $commonParams = [
            'company' => $company,
            'equipmentList' => $equipment,
            'listMode' => $listMode
        ];
        return $this->render('hubernize/inventory/list.equipment.html.twig', array_merge($commonParams, $extraParams));
    }

    /**
     * @Route("equipment-inventory/list/{action}/{slug}", name="hubernize_save_equipment", defaults={"slug":"", "action":""})
     */
    public function saveEquipment(Request $request, $action, Equipment $equipment = null) {
        $action = $action == "" ? "add" : $action;
        $company = $this->getCompany();
        $form = $this->formService->createEquipmentForm($equipment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipment = $form->getData();
            $this->inventoryService->saveEquipment($equipment, $company, $action);
            return $this->redirectToRoute('hubernize_list_equipment');
        }
        $template = self::TEMPLATE_PREFIX . "$action.equipment" . Constants::TPL_SUFFIX;
        return $this->render($template, [
                    'company' => $company,
                    'equipment' => $equipment,
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("equipment-inventory/rental-ads/{action}", name="hubernize_rental_ads", defaults={"action":"list"})
     */
    public function rentalAds(Request $request, $action) {
        $company = $this->getCompany();
        $form = $this->formService->createRentalPromoForm();

        $ads = $this->inventoryService->getRunningAds($company, $request);
        return $this->render('hubernize/inventory/list.ads.html.twig', [
                    'company' => $company,
                    'rentalAds' => $ads,
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("equipment-inventory/rental-ads/placement/{action}/{equip_slug}/{ad_slug}", name="hubernize_rental_ads_placement", 
     * defaults={"equip_slug":"none", "ad_slug":"", "action":""})
     * @ParamConverter("equipment", options={"mapping": {"equip_slug":"slug"}})
     * @ParamConverter("ad", options={"mapping": {"ad_slug":"slug"}})
     */
    public function placeRentalAd(Request $request, $action, Equipment $equipment = null, RentalAd $ad = null) {
        $company = $this->getCompany();
        $isSaved = FALSE;
        $form = $this->formService->createRentalAdForm($ad, $company);
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $rentalAd = $form->getData();
            $this->inventoryService->saveRentalAd($rentalAd, $action, $equipment);
            $isSaved = TRUE;
            unset($form);
            $form = $this->formService->createRentalAdForm(null, $company);
        }
        return $this->render('hubernize/inventory/ad.placement.html.twig', [
                    'company' => $company,
                    'form' => $form->createView(),
                    'selectedAd' => $ad,
                    'isSaved' => $isSaved,
                    'selectedEquipment' => $equipment
        ]);
    }

    /**
     * @Route("equipment-inventory/rented-out/{action}", name="hubernize_rented_out", defaults={"action":"list"})
     */
    public function rentedOut(Request $request, $action) {
        $company = $this->getCompany();
        $rented = []; //$this->inventoryService->getRunningAds($company, $request);
        return $this->render('hubernize/inventory/list.rented.html.twig', [
                    'company' => $company,
                    'rentedList' => $rented
        ]);
    }

    /**
     * @Route("equipment-inventory/rental-ads/view/{slug}", name="hubernize_view_ad")
     */
    public function viewRentalAd(RentalAd $ad, Request $request) {
        $company = $this->getCompany();
        return $this->render('hubernize/inventory/view.rental.ad.html.twig', [
                    'company' => $company,
                    'ad' => $ad
        ]);
    }

    /**
     * @Route("equipment-inventory/ads-promo/{action}", name="hubernize_ads_promo", defaults={"action":"list"})
     */
    public function adsPromo(Request $request, $action) {
        $company = $this->getCompany();
        $ads = $this->inventoryService->listAdsOnPromo($company, $request);
        return $this->render('hubernize/inventory/list.promos.html.twig', [
                    'company' => $company,
                    'promos' => $ads
        ]);
    }

    /**
     * @Route("equipment-inventory/update-ad-publication-status/{id}", name="hubernize_ad_publication_status")
     */
    public function updateAdPublicationStatus(RentalAd $ad) {
        $this->inventoryService->updateAdPublicationStatus($ad);
        return $this->redirectToRoute('hubernize_rental_ads');
    }

    /**
     * @Route("equipment-inventory/equipment-movement/{action}", name="hubernize_equipment_movement", defaults={"action":"list"})
     */
    public function equipmentMovement(Request $request, $action) {
        $company = $this->getCompany();
        $ads = $this->inventoryService->getRunningAds($company, $request);
        return $this->render('hubernize/inventory/list.assignments.html.twig', [
                    'company' => $company,
                    'assignments' => $ads
        ]);
    }

    /**
     * @Route("equipment-inventory/rental-requests", name="hubernize_rental_requests")
     */
    public function rentalsRequests(Request $request) {
        $selectedRequestId = $request->query->get('selected-request-id');
        $selectedRequest = null;
        if ($selectedRequestId != null && $selectedRequestId > 0) {
            $selectedRequest = $this->getDoctrine()->getRepository(EntityConfig::RENTAL_REQUEST)->find($selectedRequestId);
        }

        $company = $this->getCompany();
        $ads = $this->inventoryService->getRentalRequests($company, $request);
        return $this->render('hubernize/inventory/list.requests.html.twig', [
                    'company' => $company,
                    'requests' => $ads,
                    'selectedRequest' => $selectedRequest
        ]);
    }

    /**
     * @Route("equipment-inventory/rental-requests/details/{id}", name="hubernize_rental_request_details")
     */
    public function requestDetails(RentalRequest $rentalRequest, Request $request) {
        return $this->redirectToRoute('hubernize_rental_requests', ['selected-request-id' => $rentalRequest->getId()]);
    }

    /**
     * @Route("equipment-inventory/list-clients", name="hubernize_rental_clients")
     */
    public function listClients(Request $request) {
        $company = $this->getCompany();
        $ads = $this->inventoryService->getRunningAds($company, $request);
        return $this->render('hubernize/inventory/list.clients.html.twig', [
                    'company' => $company,
                    'clients' => $ads
        ]);
    }

    /**
     * @Route("equipment-inventory/rental-ads/load-form/{id}/{fragment}", name="hubernize_promote_rental_ad", defaults={"fragment":"_rental.promo.form"})
     */
    public function promoteRentalAd(RentalAd $rentalAd, Request $request, $fragment = null) {
        $form = $this->formService->createRentalPromoForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rentalPromo = $form->getData();
            $rentalAd->setIsPromoted(TRUE);
            $rentalPromo->setRentalAd($rentalAd);
            $this->inventoryService->saveRentalAdPromo($rentalPromo);
            return $this->redirectToRoute('hubernize_rental_ads');
        }
        $params = ['rentalAd' => $rentalAd, 'form' => $form->createView()];
        return $this->getRentalActionResponse($params, $fragment);
    }

    /**
     * @Route("equipment-inventory/rental-ads/weekly-deal/{id}/{fragment}", name="hubernize_place_rental_weekly_deal", defaults={"fragment":"_rental.weekly.deal.form"})
     */
    public function placeWeeklyDeal(RentalAd $rentalAd, Request $request, $fragment = null) {
        $supplier = $rentalAd->getCompany();
        $form = $this->formService->createWeeklyDealForm(null, $supplier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $weeklyDeal = $form->getData();
            $rentalAd->setIsOnDeal(TRUE);
            $weeklyDeal->setRentalAd($rentalAd);
            $weeklyDeal->setSupplier($supplier);
            $this->inventoryService->saveWeeklyDeal($weeklyDeal);
            return $this->redirectToRoute('hubernize_rental_ads');
        }
        $params = ['rentalAd' => $rentalAd, 'form' => $form->createView()];
        return $this->getRentalActionResponse($params, $fragment);
    }

    private function getRentalActionResponse($params, $fragment) {
        $template = self::INVENTORY_FRAGMENT_PREFIX . $fragment . Constants::TPL_SUFFIX;
        return $this->getFragmentAsJSON($template, $params);
    }

    /**
     * @Route("equipment-inventory/rental-ads/request-actions/{id}/rented_out_id/{fragment}", name="hubernize_process_rental_request", defaults={"fragment":"_honour.rental.request", "rented_out_id":0})
     * @ParamConverter("$rentedOut", options={"mapping": {"rented_out_id": "id"}})
     */
    public function renderRentedOutForm(RentalRequest $request, RentedOut $rentedOut = null, $fragment = null) {
        $template = self::INVENTORY_FRAGMENT_PREFIX . $fragment . Constants::TPL_SUFFIX;
        $params = $this->inventoryService->initRentedOutForm($request, $this->formService,  $rentedOut);
        return $this->getFragmentAsJSON($template, $params);
    }

}
