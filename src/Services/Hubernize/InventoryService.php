<?php

namespace App\Services\Hubernize;

use App\Entity\Company;
use App\Entity\Equipment;
use App\Entity\RentalAd;
use App\Entity\RentalPromo;
use App\Entity\RentalRequest;
use App\Entity\RentedOut;
use App\Entity\WeeklyDeal;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\HubUtil;
use App\Utils\Slugger;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventoryService
 *
 * @author Balika
 */
class InventoryService {

    /**
     * 
     * @var PersistenceService $persistenceService
     */
    protected $persistenceService;
    protected $paginator;
    protected $tokenStorage;
    protected $slugger;
    private $utilService;

    public function __construct(PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, TokenStorageInterface $token, Slugger $slugger, HubUtil $utilService) {
        $this->persistenceService = $persistenceService;
        $this->paginator = $paginator;
        $this->tokenStorage = $token;
        $this->slugger = $slugger;
        $this->utilService = $utilService;
    }

    public function getEquipmentList(Company $company, Request $request, $isPaginated = TRUE) {
        $result = $this->persistenceService->getRepository(EntityConfig::EQUIPMENT)->findCompanyEquipment($company, $isPaginated);
        return $isPaginated ? $this->paginator->getPaginatedEntity($request, $result) : $result;
    }

    public function getEquipment($equipmentId) {
        return $this->persistenceService->getRepository(EntityConfig::EQUIPMENT)->find($equipmentId);
    }

    public function getRunningAds(Company $company, Request $request) {
        return $this->persistenceService->getRepository(EntityConfig::RENTAL_AD)->findBy(['company' => $company]);
    }

    public function getRentalRequests(Company $company, Request $request) {
        $requestQry = $this->persistenceService->getRepository(EntityConfig::RENTAL_REQUEST)->findCompanyRentalRequests($company, TRUE);
        return $this->paginator->getPaginatedEntity($request, $requestQry, 5);
    }

    public function saveEquipment(Equipment $equipment, Company $company, $action) {
        $equipment->setSlug($this->slugger->slugifyUnique($equipment->getName(), EntityConfig::EQUIPMENT));
        if ($action == 'add') {
            $equipment->setUser($this->getUser());
            $equipment->setDeleted(FALSE);
            $company->addEquipment($equipment);
            return $this->persistenceService->saveEntity($company);
        }
        return $this->persistenceService->saveEntity($equipment);
    }

    public function saveRentalAd(RentalAd $rentalAd, $action, Equipment $equipment = null) {
        $rentalAd->setSlug($this->slugger->slugifyUnique($rentalAd->getTitle(), EntityConfig::RENTAL_AD));
        if ($action == 'add') {
            if ($rentalAd->getEquipment() == null) {
                $rentalAd->setEquipment($equipment);
                $rentalAd->setCompany($equipment->getCompany());
            } else {
                $rentalAd->setCompany($rentalAd->getEquipment()->getCompany());
            }
            $rentalAd->setUser($this->getUser());
            $rentalAd->setDeleted(FALSE);
            $rentalAd->setIsPromoted(FALSE);
            if ($rentalAd->getIsPublished() && $rentalAd->getDatePublished() == null) {
                $rentalAd->setDatePublished(new DateTime());
            }
        }
        $this->persistenceService->saveEntity($rentalAd);
    }

    public function hasEquipment(Company $company) {
        return count($this->persistenceService->getRepository(EntityConfig::EQUIPMENT)->findBy(['company' => $company])) > 0;
    }

    public function getAllRentalAds() {
        return $this->persistenceService->getRepository(EntityConfig::RENTAL_AD)->findAll();
    }

    public function updateAdPublicationStatus(RentalAd $ad) {
        if ($ad->getIsPublished()) {
            $ad->setIsPublished(FALSE);
        } else {
            $ad->setIsPublished(TRUE);
        }
        return $this->persistenceService->saveEntity($ad);
    }

    public function getRentalFilterParams(Request $request) {
        $selectedRegion = $selectedTown = $selectedCategory = null;
        $towns = [];
        if ($request->query->get('region_id')) {
            $region = $this->utilService->getRegion($request->query->get('region_id'));
            $selectedRegion = $region;
            $towns = $this->utilService->getTowns($region);
        }
        if ($request->query->get('town_id')) {
            $selectedTown = $this->utilService->getTown($request->query->get('town_id'));
        }
        if ($request->query->get('category_id')) {
            $selectedCategory = $this->utilService->getCategory($request->query->get('category_id'));
        }
        return [
            "selectedRegion" => $selectedRegion,
            "selectedTown" => $selectedTown,
            "selectedCategory" => $selectedCategory,
            "townList" => $towns
        ];
    }

    //############################## Ads Promotions ##########################################
    public function saveRentalAdPromo(RentalPromo $rentalPromo) {
        $rentalPromo->setUser($this->getUser());
        $this->persistenceService->saveEntity($rentalPromo);
    }

    public function listAdsOnPromo(Company $company, Request $request) {
        return $this->persistenceService->getRepository(EntityConfig::RENTAL_PROMO)->findAdsOnPromo($company, FALSE);
    }

    public function saveWeeklyDeal(WeeklyDeal $weeklyDeal) {
        $weeklyDealSlot = $this->persistenceService->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::WEEKLY_DEALS]);
        $weeklyDeal->setUser($this->getUser());
        $weeklyDeal->setEndDate($weeklyDealSlot->getEndingAt());
        $weeklyDeal->setBid($weeklyDealSlot);
        $weeklyDeal->setIsDiscounted($weeklyDeal->getDiscountRate() != null);
        $this->persistenceService->saveEntity($weeklyDeal);
    }

    public function placeRentalRequest($rentalRequest) {
        $user = $this->getUser();
        if ($user instanceof $user) {
            $rentalRequest->setPhone($user->getContactNo());
            $rentalRequest->setUser($user);
        }
        $rentalRequest->setStatus('Requested');
        $this->persistenceService->saveEntity($rentalRequest);
    }

    public function getWeeklyDeals() {
        //$weeklyDealSlot = $this->persistenceService->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::WEEKLY_DEALS]);
        $deals = $this->persistenceService->getRepository(EntityConfig::WEEKLY_DEAL)->findRentalWeeklyDeals();
        return $deals;
    }

    public function initRentedOutForm(RentalRequest $request, $formService, RentedOut $rentedOut=null ) {
        if ($rentedOut == null) {
            $rentedOut = new RentedOut();
            $rentalAd = $request->getRentalAd();
            $rentedOut->setBillingCycle($rentalAd->getBillingCycle());
            $rentedOut->setCompany($rentalAd->getCompany());
            $rentedOut->setQuantity($request->getNumberRequested());
            $rentedOut->setEquipment($rentalAd->getEquipment());
            $rentedOut->setRentalRate($rentalAd->getRentalRate());
            $rentedOut->setCreatedAt(new \DateTime());
        }
        $form = $formService->createRentedOutForm($rentedOut);
        return $params = [
            'request' => $request,
            'form' => $form->createView(),
            'rentedOut' => $rentedOut
        ];
    }

    private function getUser() {
        return $this->tokenStorage->getToken()->getUser();
    }

}
