<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\PriceRequest;
use App\Entity\Product;
use App\Entity\QuotationRequest;
use App\Entity\RentalRequest;
use App\Entity\Supplier;
use App\Model\AccountInterface;
use App\Model\MessagingInterface;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Services\TransactionService;
use App\Utils\Constants;
use App\Utils\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of IndexController
 *
 * @author Balika Edmond
 */
class TransactionController extends BaseController {

    const NUMBER_OF_WEEKS = 2;
    const TAX_RATE = 17.5;
    const STORE_FRAGMENT_PREFIX = 'store/fragments/';

    protected $accountService;
    protected $messagingService;
    protected $transactionService;

    public function __construct(AccountInterface $accountService, FormService $formService, PersistenceService $persistenceService, Slugger $slugger, MessagingInterface $messagingService, TransactionService $transactionService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->accountService = $accountService;
        $this->messagingService = $messagingService;
        $this->transactionService = $transactionService;
    }

    /**
     * @Route("store/contact-supplier/{slug}/{product_slug}/{request_id}", name="contact_supplier", defaults={"product_slug":"no-product", "request_id":"0"})
     * @ParamConverter("product", options={"mapping": {"product_slug": "slug"}})
     * @ParamConverter("quotationRequest", options={"mapping": {"request_id": "id"}})
     */
    public function contactSupplierAction(Supplier $supplier, Request $request, Product $product = null, QuotationRequest $quotationRequest = null) {
        $form = $this->formService->createMQRForm();
        $form->handleRequest($request);
        $message = '';
        $template = 'store/contact.supplier.html.twig';
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $quotationRequest = $form->getData();
            $quotationRequest->setSupplier($supplier);
            $quotationRequest->setProduct($product);
            $quotationRequest->setUser($user);
            $this->persistenceService->saveEntity($quotationRequest);
            $message = 'Your request has been successfully sent';
            if ($user == null) {
                $params = ['supplier' => $supplier,
                    'quotationRequest' => $quotationRequest,
                    'product' => $product];
                return $this->render($template, array_merge($params, $this->accountService->getGuestUserParams($quotationRequest->getContact(), $this->formService->createLoginForm(), $this->formService->createUserRegistrationForm())));
            }
        }
        return $this->render($template, array(
                    'supplier' => $supplier,
                    'product' => $product,
                    'message' => $message,
                    'user' => $user,
                    'quotationRequest' => $quotationRequest,
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("store/user-signup/{id}/{entityClass}",  name="buyer_signup", options={"expose":"true"})
     */
    public function registerBuyer(Request $request, $id, $entityClass) {
        $entity = $this->getDoctrine()->getRepository($entityClass)->find($id);
        $registrationForm = $this->formService->createUserRegistrationForm();
        $registrationForm->handleRequest($request);
        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $newUser = $registrationForm->getData();
            $type = $request->request->get('userType');
            //$this->accountService->createUser($newUser);
            $this->accountService->createBuilderAccount($newUser, $type, null);
            if (method_exists($entity, 'setUser')) {
                $entity->setUser($newUser);
            }
            $this->persistenceService->saveEntity($entity);
            return $this->redirectToRoute("activate_account", array('id' => $newUser->getId()));
        }
        if ($entity instanceof RentalRequest) {
            return $this->redirectToRoute("rental_index");
        }
        return $this->redirectToRoute("store_index");
    }

    /**
     * @Route("store/supplier-price-list-request/{slug}",  name="pricelist_request", options={"expose":"true"})
     */
    public function supplierPricelistAction(Supplier $supplier, Request $request) {
        if ($request->request->get('selectedProducts')) {
            $selecetedProducts = $request->request->get('selectedProducts');
            $priceListRequest = new PriceRequest();
            $requestNo = Constants::PRICE_RQUEST_PREFIX . date('d-M-y_H:i:s');
            $priceListRequest->setProducts($selecetedProducts);
            $priceListRequest->setUser($this->getUser());
            $priceListRequest->setRequestNo($requestNo);
            $priceListRequest->setStatus('Pending');
            $this->persistenceService->saveEntity($priceListRequest);

            return new JsonResponse(array('message' => "Your Price List Request has been sent to $supplier"));
        }
        return $this->redirectToRoute('supplier_store_view', array('slug' => $supplier->getSlug()));
    }

    /**
     * @Route("store/supplier-quotation-request/{slug}",  name="quotation_request", options={"expose":"true"})
     */
    public function supplierQuotationRequest(Supplier $supplier, Request $request) {
        $quotationForm = $this->formService->createQuotationForm($supplier);
        $quotationForm->handleRequest($request);
        $isSaved = false;
        if ($quotationForm->isSubmitted() && $quotationForm->isValid()) {
            $order = $quotationForm->getData();
            $originalOrderItems = new ArrayCollection();
            $this->transactionService->populateOrder($order);
            // Create an ArrayCollection of the current OrderItems objects in the database
            foreach ($order->getOrderItems() as $orderItem) {
                $originalOrderItems->add($orderItem);
            }
            // remove the relationship between the orderItem and the Order
            foreach ($originalOrderItems as $orderItem) {
                $this->transactionService->populateOrderItem($orderItem);
                if (false === $order->getOrderItems()->contains($orderItem)) {
                    // remove the Order from the OrderItem
                    $orderItem->setOrder(null);
                    // if it was a many-to-one relationship, remove the relationship like this
                    // $tag->setTask(null);
                    $this->persistenceService->persist($orderItem);
                }
            }
            $this->persistenceService->persist($order);
            $this->persistenceService->flush();
            $isSaved = true;
            return new JsonResponse(array('message' => "Your Price Quotation Request has been sent to $supplier"));
        }
        return $this->redirectToRoute('supplier_store_view', array('slug' => $supplier->getSlug(), 'page' => 'quotation-request', 'isSaved' => $isSaved));
    }

    /**
     * @Route("store/mqr/submit-request", name="store_submit_mqr", options={"expose":"true"})
     */
    public function submitMQRAction(Request $request) {
        $mqrForm = $this->formService->createMQRForm();
        $mqrForm->handleRequest($request);
        if ($mqrForm->isSubmitted() && $mqrForm->isValid()) {
            $quotationRequest = $mqrForm->getData();
            $rquestType = $request->request->get('rquestType');
            //$template = $this->get('twig')->loadTemplate("Store2/includes/home.mqr.html.twig");
            $template = 'store/contact.supplier.html.twig';
            //$params['quotationRequest'] = $quotationRequest;
            //$params['isLoggedIn'] = true;
            $user = $this->getUser();
            $quotationRequest->setRequestType($rquestType);
            $quotationRequest->setUser($user);
            $this->persistenceService->saveEntity($quotationRequest);
            $message = 'Your request has been successfully sent';
            if ($user == null) {
                $registrationForm = $this->formService->createUserRegistrationForm();
                $loginForm = $this->formService->createLoginForm();
                return $this->render($template, array(
                            'supplier' => null,
                            'product' => null,
                            'message' => $message,
                            'accountExist' => $this->accountService->doesAccountExist($quotationRequest->getContact()),
                            'quotationRequest' => $quotationRequest,
                            'userForm' => $registrationForm->createView(),
                            'loginForm' => $loginForm->createView()
                ));
            }

            /* if ($user == null) {
              $loginForm = $this->formService->createLoginForm();
              $registrationForm = $this->formService->createUserRegistrationForm();
              $params['isLoggedIn'] = false;
              $params['userForm'] = $registrationForm->createView();
              $params['loginForm'] = $loginForm->createView();
              }
              $mqrFormBlock = $template->renderBlock('mqrFormBlock', $params);
              return new JsonResponse(array(
              'response' => $mqrFormBlock)); */
        }
        return $this->redirectToRoute('store_index');
    }

    public function mqrForm($template = 'mqr', $hideForm = FALSE) {
        $mqrForm = $this->formService->createMQRForm();
        return $this->render(self::STORE_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, array(
                    'mqrForm' => $mqrForm->createView(),
                    'isSaved' => false,
                    'hideForm' => $hideForm,
                    'user' => $this->getUser()));
    }

}
