<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\Backend;

use App\Controller\BaseController;
use App\Entity\Campaign;
use App\Entity\Company;
use App\Entity\HubBid;
use App\Entity\OpenBid;
use App\Entity\PromotedProduct;
use App\Entity\Supplier;
use App\Entity\TopSupplier;
use App\Entity\WeeklyDeal;
use App\Form\CampaignType;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of CampaignsController
 *
 * @author Balika
 */
class CampaignsController extends BaseController {
    const CAMPAIGN_DURATION=2;
    /**
     * @Route("{slug}/campaigns-and-promos", name="store_campaigns_and_promos")
     */
    public function campaignsAndPromosAction(Supplier $supplier, Request $request) {
        $form = $this->createCampaignForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $campaign = $form->getData();
            $campaign->setUser($this->getUser());            
            $supplier->addCampaign($campaign);
            $this->persistenceService->saveEntity($campaign);
            unset($form);
            $form = $this->createCampaignForm();
        }
        return $this->render('store/admin/campaigns.and.promos.html.twig', array(
                    'supplier' => $supplier,
                    'form' => $form->createView()
        ));
    }

    private function createCampaignForm($campaign = null) {
        if ($campaign == null) {
            $campaign = new Campaign();
        }

        $form = $this->createForm(CampaignType::class, $campaign);
        return $form;
    }

    /**
     * @Route("business/portal/{slug}/store/promote-products", name="portal_store_promote_products_action")
     */
    public function promoteProductsAction(Company $company, Request $request) {
        if ($request->request->get('campaign')) {
            $campaignId = $request->request->get('campaign');
            $selectedProductsIdsStr = $request->request->get('selectedProducts');
            $selectedProductsIds = explode(',', $selectedProductsIdsStr);
            if ($campaignId > 0) {
                $campaign = $this->getDoctrine()->getRepository(EntityConfig::CAMPAIGN)->find($campaignId);
                $this->addProductsToCampaign($campaign, $selectedProductsIds);
            }
        }
        return $this->redirectToRoute('portal_store_campaigns_action', array('slug' => $company->getSlug()));
    }

    private function addProductsToCampaign(Campaign $campaign, $selectedProductsIds) {
        foreach ($selectedProductsIds as $id) {
            $product = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->find($id);
            $promotedProduct = new PromotedProduct($product, $this->getUser());
            $promotedProduct->setPromoCode($this->generatePromoCode());
            $promotedProduct->setVendor($campaign->getCompany());
            $promotedProduct->setExpiryDate($campaign->getEndDate());
            $regularPrice = $product->getProductData()->getRegularPrice();
            $discountedPrice = ($campaign->getDiscountRate() / 100) * $regularPrice;
            $promotedProduct->setDiscountedPrice($discountedPrice);
            $promotedProduct->setCampaign($campaign);
            $this->persistenceService->persist($promotedProduct);
        }
        $this->persistenceService->persist($campaign);
        $this->persistenceService->flush();
    }

    private function generatePromoCode() {
        $length = 6;
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $randomPassword = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[mt_rand(0, $max)];
        }
        return $randomPassword;
    }

    /**
     * @Route("{slug}/adverts/bid-slots", name="open_bids")
     */
    public function bidSlotsAction(Supplier $company, Request $request) {
        $premiumSlot = $this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::PREMIUM_PRODUCT]);
        $bids = $this->getDoctrine()->getRepository(EntityConfig::OPEN_BID)->findCurrentBids($premiumSlot->getEndingAt());
        $form = $this->formService->createBidForm();
        /** $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
          $this->saveBid($premiumSlot, $bid, $company, $request);
          } */
        return $this->render('store/admin/adverts/bid.slots.html.twig', array(
                    'slug' => $company->getSlug(),
                    'bids' => $bids,
                    //'selectedBid' => $bid,
                    'supplier' => $company,
                    'bidForm' => $form->createView(),
                    'premiumProductSlot' => $premiumSlot
        ));
    }

    /**
     * @Route("{slug}/adverts/bid-slots/place-bid/{slot_id}/{bid_id}", name="place_bid", defaults={"bid_id":"0"})
     * @ParamConverter("adSlot", options={"mapping": {"slot_id": "id"}})
     * @ParamConverter("bid", options={"mapping": {"bid_id": "id"}})
     */
    public function placeBidAction(Supplier $company, HubBid $adSlot, Request $request, OpenBid $bid = null) {
        $form = $this->formService->createBidForm($bid);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bid = $form->getData();
            $this->saveBid($adSlot, $bid, $company, $request);
        }
        return $this->redirectToRoute('open_bids', ['slug' => $company->getSlug()]);
    }

    private function saveBid($adSlot, $bid, $company, Request $request) {
        $productId = $request->request->get('selectedProduct');
        $product = $this->getDoctrine()->getRepository(EntityConfig::PRODUCT)->find($productId);
        $bid->setProduct($product);
        $bid->setSupplier($company);
        $bid->setUser($this->getUser());
        $bid->setBid($adSlot);
        $campaignStartDate = $adSlot->getEndingAt();
        $bid->setCreatedAt(new DateTime('now'));
        $endDate = $campaignStartDate->modify('+' . self::CAMPAIGN_DURATION . ' weeks');        
        $bid->setEndDate($endDate);
        $this->persistenceService->saveEntity($bid);
    }

    /**
     * @Route("{slug}/adverts/bid-slots/edit-bid/{bid_id}", name="edit_bid")
     * @ParamConverter("bid", options={"mapping": {"bid_id": "id"}})
     */
    public function editBidAction(Supplier $company, OpenBid $bid, Request $request) {
        $premiumSlot = $this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::PREMIUM_PRODUCT]);
        $form = $this->formService->createBidForm($bid);
        return $this->render('store/admin/adverts/premium.product.bid.form.html.twig', array(
                    'selectedBid' => $bid,
                    'supplier' => $company,
                    'bidForm' => $form->createView(),
                    'premiumProductSlot' => $premiumSlot
        ));
    }

    /**
     * @Route("{slug}/adverts/top-supplier-bid/{action}/{bid_id}", name="top_supplier_bid_form", defaults={"bid_id":"0", "action":"create"})
     * @ParamConverter("topSupplier", options={"mapping": {"bid_id": "id"}})
     */
    public function topSupplierBidForm(Supplier $company, Request $request, $action, TopSupplier $topSupplier = null) {
        $form = $this->formService->createTopSupplierForm($topSupplier);
        $topSupplierSlot = $this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::TOP_SUPPLIER]);
        $form->handlerequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($action == 'create') {
                $topSupplier = $form->getData();
                $topSupplier->setBid($topSupplierSlot);
                $topSupplier->setSupplier($company);
                $topSupplier->setStartDate($topSupplierSlot->getStartingAt());
                $topSupplier->setEndDate($topSupplierSlot->getEndingAt());
                $topSupplier->setUser($this->getUser());
            }
            $selectedCategoriesIdsStr = $request->request->get('selectedCategories');
            $selectedCategoriesIds = explode(',', $selectedCategoriesIdsStr);
            $topSupplier->setProductCategories($selectedCategoriesIds);
            $this->persistenceService->saveEntity($topSupplier);
            return $this->redirectToRoute('open_bids', ['slug' => $company->getSlug()]);
        }
        return $this->render('store/admin/adverts/top.supplier.form.html.twig', array(
                    'topSupplier' => $topSupplier,
                    'supplier' => $company,
                    'form' => $form->createView(),
                    'topSupplierSlot' => $topSupplierSlot
        ));
    }

    /**
     * @Route("top-supplier-timer/render", name="render_top_supplier_timer", options={"expose":"true"})
     */
    public function renderTopSupplierTimer() {
        $topSupplierSlot = $this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::TOP_SUPPLIER]);
        $year = $topSupplierSlot->getEndingAt()->format('Y');
        $month = $topSupplierSlot->getEndingAt()->format('m');
        $day = $topSupplierSlot->getEndingAt()->format('d');
        $dateString = $year . ', ' . $month . ', ' . $day;
        return new JsonResponse(['dateString' => $dateString]);
    }

    /**
     * @Route("{slug}/adverts/weekly-deals/save/{deal_id}", name="save_weekly_deal",  defaults={"deal_id":"0"})
     * @ParamConverter("deal", options={"mapping": {"deal_id": "id"}})
     */
    public function saveWeeklyDeal(Supplier $supplier, Request $request, WeeklyDeal $deal = null) {
        $weeklyDealSlot = $this->getDoctrine()->getRepository(EntityConfig::HUB_BID)->findOneBy(['bidCode' => Constants::WEEKLY_DEALS]);
        $dealForm = $this->formService->createWeeklyDealForm($deal,$supplier);
        $dealForm->handleRequest($request);
        if($dealForm->isSubmitted() && $dealForm->isValid()){
            $deal = $dealForm->getData();
            $deal->setEndDate($weeklyDealSlot->getEndingAt());
            $deal->setSupplier($supplier);
            $deal->setBid($weeklyDealSlot);
            $deal->setUser($this->getUser());
            $deal->setIsDiscounted($deal->getDiscountRate()!=null);
            $this->persistenceService->saveEntity($deal);
        }
         return $this->redirectToRoute('open_bids', ['slug' => $supplier->getSlug()]);
    }

    
}
