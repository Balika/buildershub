<?php
namespace App\Controller\Backend;

use App\Controller\BaseController;
use App\Entity\Company;
use App\Entity\Supplier;
use App\Entity\User;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of StoreBackendUtilityController
 *
 * @author Balika - BTL
 */
class StoreBackendUtilityController extends BaseController {

    protected $engageService;

    function __construct(FormService $formService, PersistenceService $persistenceService, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
    }

    public function validateSupplierAccess(Company $company) {
        
        if (!($company instanceof Supplier && $this->isCompanyStaff($company))) {
            throw new AccessDeniedException('Only Companies registed as suppliers can access this page');
        }
        return new Response('');
    }

     private function isCompanyStaff(Company $company) {
        return in_array($this->getUser(), $company->getStaff()->toArray(), TRUE);
    }
    public function renderAdSlots($block, $adSlot, $supplier = null) {
        $template = $this->get('twig')->loadTemplate("store/admin/adverts/includes/ads.content.block.html.twig");
        $adBlock = $template->renderBlock($block, array_merge($this->loadCommonSlotParams($supplier), $this->loadSlotParams($adSlot,$supplier)));
        return new Response($adBlock);
    }

    private function loadCommonSlotParams($supplier = null) {
        return ['user' => $this->getUser(),
            'supplier' => $supplier
        ];
    }

    private function loadSlotParams($adSlot, $supplier=null) {
        $params = [];
        switch ($adSlot) {
            case Constants::PREMIUM_PRODUCT:
                $params = [
                ];
                break;
            case Constants::TOP_SUPPLIER:
                $params = [
                    'topSuppliers' => $this->getDoctrine()->getRepository(EntityConfig::TOP_SUPPLIERS)->findTopSuppliers(),
                    'topSupplierSlot' => $this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::TOP_SUPPLIER])
                ];
                break;
            case Constants::SUPPLIER_WEEKLY_DEALS:
                $dealForm = $this->formService->createWeeklyDealForm(null,$supplier);
                $params = [
                    'dealForm'=>$dealForm->createView(),
                    'weeklyDealSlot'=>$this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::WEEKLY_DEALS]),
                    'weeklyDeals'=>$this->getDoctrine()->getRepository(EntityConfig::WEEKLY_DEAL)->findWeeklyDeals($supplier),
                ];
                break;
            case Constants::SUPPLIER_INTRO ||  Constants::SUPPLIER_TRAIL:
                $params = [
                ];
                break;           
            default:
                break;
        }
        return $params;
    }

}
