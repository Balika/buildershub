<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Services\TransactionService;
use App\Utils\Constants;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of CartController
 *
 * @author Balika Edmond
 */
class CartController extends BaseController {

    const SUPPLIER_STORE_TEMPLATE_PREFIX = 'store/supplier/';
    const STORE_GENERIC_PREFIX = 'store/pages/';
    const PAGE_SIZE = 12;
    const ADD_TO_CART = 'add';
    const REMOVE_FROM_CART = 'remove';
    const UPDATE_CART = 'update';
    const TAX_RATE = 17.5;
    const STORE_FRAGMENT_PREFIX = 'store/fragments/';

    private $transactionService;

    public function __construct(FormService $formService, PersistenceService $persistenceService, Slugger $slugger, TransactionService $trxnService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->transactionService = $trxnService;
    }

    public function renderHeaderCart($template='header.cart') {       
        $response  = $this->render(self::STORE_FRAGMENT_PREFIX.$template.Constants::TPL_SUFFIX, [
            'shoppingCart' => $this->transactionService->getShoppingCart(),
            'order' => $this->transactionService->getCurrentOrder()
        ]);
        return $response;
       
    }

    /**
     * @Route("store/view-cart",  name="view_cart", options={"expose":"true"})
     */
    public function viewCart(Request $request) {
        $form = $this->formService->createEmptyForm();
        return $this->render("store/cart/view.cart.html.twig", [
                    'shoppingCart' => $this->transactionService->getShoppingCart(),
                    'order' => $this->transactionService->getCurrentOrder(),
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("store/checkout",  name="checkout", options={"expose":"true"})
     */
    public function checkout(Request $request) {
        $user = $this->getUser();
        $commonParams = ['user' => $user,
            'order' => $this->transactionService->getCurrentOrder(),
            'shoppingCart' => $this->transactionService->getShoppingCart()
        ];
        $allParams = [];
        if ($user == null) {
            $loginForm = $this->formService->createLoginForm();
            $registrationForm = $this->formService->createUserRegistrationForm();
            $allParams = array(
                'accountExist' => $this->transactionService->doesAccountExist(''),
                'userForm' => $registrationForm->createView(),
                'loginForm' => $loginForm->createView()
            );
        }
        return $this->render("store/cart/checkout.html.twig", array_merge($commonParams, $allParams));
    }

    /**
     * @Route("store/add-to-cart/{slug}",  name="add_to_cart", options={"expose":"true"})
     */
    public function addToCart(Product $product, Request $request) {
        $orderItem = new OrderItem($product);
        $isAdded = $this->transactionService->addToCart($orderItem);
        $request->query->set('isAdded', $isAdded);
        return $this->redirectToReferer($request);
    }

    /**
     * @Route("store/update-cart",  name="update_cart", options={"expose":"true"})
     */
    public function updateCart(Request $request) {
        $form = $this->formService->createEmptyForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($this->transactionService->getShoppingCart() as $productId => $orderItem) {
                $itemQty = $request->request->get('product_' . $productId);
                if ($orderItem->getQuantity() != intval($itemQty)) {
                    $orderItem->setQuantity($itemQty);
                    $this->transactionService->updateCart($orderItem);
                }
            }
        }
        return $this->redirectToRoute('view_cart');
    }

    /**
     * @Route("store/remove-from-cart/{slug}",  name="remove_from_cart", options={"expose":"true"})
     */
    public function removeCartItem(Product $product, Request $request) {
        $orderItem = new OrderItem($product);
        $this->transactionService->removeFromCart($orderItem);
        return $this->redirectToReferer($request);
    }

    /**
     * @Route("store/empty-cart",  name="empty_cart", options={"expose":"true"})
     */
    public function emptyCart(Request $request) {
        $this->transactionService->emptyCart();
        return $this->redirectToRoute("view_cart");
    }

    /**
     * @Route("store/place-order",  name="place_order", options={"expose":"true"})
     */
    public function placeOrder(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');             
        $this->transactionService->placeOrder();
        return $this->redirectToRoute('checkout');
    }

}
