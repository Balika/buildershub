<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Company;
use App\Entity\RentalAd;
use App\Entity\RentalRequest;
use App\Model\AccountInterface;
use App\Model\AppInterface;
use App\Model\HubernizeFormInterface;
use App\Services\FormService;
use App\Services\Hubernize\InventoryService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of RentalController
 *
 * @author Balika
 * @Route("equipment-rental")
 */
class RentalController extends AbstractController {

    const RENTAL_FRAGMENT_PREFIX = "rentals/fragments/";

    private $inventoryService;
    private $formService;
    private $accountService;

    public function __construct(HubernizeFormInterface $formService, InventoryService $inventoryService, AccountInterface $accountService) {
        $this->inventoryService = $inventoryService;
        $this->formService = $formService;
        $this->accountService = $accountService;
    }

    /**
     * 
     * @param type $request
     * @Route(name="rental_index")
     */
    public function index(Request $request) {
        return $this->render('rentals/rental.index.html.twig', [
                    'rentalAds' => $this->inventoryService->getAllRentalAds(),
                    'weeklyDeals' => $this->inventoryService->getWeeklyDeals()
        ]);
    }

    /**
     * 
     * @Route("/place-rental-request/{slug}/{request_id}", name="place_rental_request", defaults={"request_id":0})
     * @ParamConverter("rentalRequest", options={"mapping": {"request_id": "id"}})
     */
    public function placeRentalRequest(Request $request, RentalAd $rentalAd, RentalRequest $rentalRequest = null) {
        $form = $this->formService->createRentalRequestForm();
        $form->handlerequest($request);
        $isRequestedPlaced = !is_null($rentalRequest) || $request->query->get('is-request-placed');
        $template = 'rentals/place.rental.request.html.twig';
        $extraParams = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $rentalRequest = $form->getData();
            $rentalRequest->setRentalAd($rentalAd);
            $this->inventoryService->placeRentalRequest($rentalRequest);
            $isRequestedPlaced = TRUE;
            $request_id = $rentalRequest->getId();
            //TODO: FInd a way to attach the query strings to the url
            $request->query->set('is-request-placed', $isRequestedPlaced);
            $request->query->set('rental_request_id', $request_id);
        }
        if ($isRequestedPlaced) {
            $rentalRequest = $rentalRequest != null ? $rentalRequest : $this->getDoctrine()->getRepository(EntityConfig::RENTAL_REQUEST)->find($request_id);
            $extraParams = $this->accountService->getGuestUserParams($rentalRequest->getPhone(), $this->formService->createLoginForm(), $this->formService->createUserRegistrationForm());
        }

        $defaultParams = [
            'rentalAd' => $rentalAd,
            'sponsoredAds' => [],
            'user' => $this->getUser(),
            'rentalRequest' => $rentalRequest,
            'form' => $form->createView(),
            'isRequestedPlaced' => $isRequestedPlaced,
            'relatedAds' => $this->inventoryService->getAllRentalAds()
        ];
        return $this->render($template, array_merge($defaultParams, $extraParams));
    }

    /**
     * 
     * @Route("/filter/{slug}", name="rental_filter", defaults={"slug":"none"})
     */
    public function rentalFilter(Request $request, RentalAd $rentalAd = null) {
        $defaultParams = [
            'activeAd' => $rentalAd,
            'sponsoredAds' => [],
            'filteredAds' => $this->inventoryService->getAllRentalAds()
        ];
        return $this->render('rentals/rental.filter.html.twig', array_merge($defaultParams, $this->inventoryService->getRentalFilterParams($request)));
    }

    /**
     * 
     * @Route("/firm/{slug}", name="rental_firm_view")
     */
    public function firmView(Company $company, Request $request) {
        return $this->render('rentals/company.view.html.twig', [
                    'company' => $company
        ]);
    }

    /**
     * @Route("/firm-register", name="rental_firm_registration")
     */
    public function registerRentalFirm(FormService $formService, AppInterface $appManager, Request $request) {
        $redirectRoute = 'rental_firm_registration';
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && !$request->query->get('allowRedirect')) {
            return $this->redirectToRoute('security_login_form', ['redirect' => $redirectRoute]);
        }
        $form = $formService->createFirmForm();
        $form->handleRequest($request);
        $message = '';
        $existingUsername = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form->getData();
            $user = $company->getOwner();
            $userType = $request->request->get('userType');
            if (!$this->accountService->doesAccountExist($user->getEmail())) {
                try{
                    $this->accountService->createBuilderAccount($user, $userType, null, FALSE);
                    $this->accountService->saveCompany($user, $company);
                    return $this->redirectToRoute("activate_account", array('id' => $user->getId()));
                }catch (Exception $ex) {
                    $message = "An error occured " . $ex->getMessage();
                }
            } else {
                $message = 'The email or phone number you entered already exist';
                $existingUsername = $user->getEmail();
            }
        }
        $slug = $request->query->get('slug');
        $company = $this->getDoctrine()->getRepository(EntityConfig::COMPANY)->findOneBy(['slug'=>$request->query->get('slug')]);
        $isSubscribed = ($company != null && $request->query->get('is-equipment-module-subscribed') != null) ?  $appManager->isSubscribedToApp($company, $appManager->getApp('EquiPack')) : FALSE;
        if($slug){
            $company = $this->getDoctrine()->getRepository(EntityConfig::COMPANY)->findOneBy(['slug'=>$slug]);
        }
        return $this->render('rentals/advertise.equipment.html.twig', [
                    'form' => $form->createView(),
                    'message' => $message,
                    'selectedCompany'=>$company,
                    'isSubscribed'=>$isSubscribed,
                    'username' => $existingUsername
        ]);
    }
   

    /**
     * 
     * @Route("/load-towns/region/{id}", name="load_towns")
     */
    public function loadTowns($id, Request $request) {
        return $this->redirectToRoute('rental_filter', ['region_id' => $id]);
    }

    /**
     * 
     * @Route("/equipment-rental/async/most-popular", name="async_most_popular_rentals", options={"expose":"true"})
     */
    public function renderPoularRentals($template = "most.popular.rentals") {
        return $response = $this->render(self::RENTAL_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, ['popularRentals' => $this->inventoryService->getAllRentalAds()]);
        // return new JsonResponse(['response'=>$response]);
    }

}
