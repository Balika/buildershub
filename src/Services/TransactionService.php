<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Model\AccountInterface;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Description of TransactionService
 *
 * @author Balika
 */
class TransactionService {

    private $sessionManager;
    private $tokenStorage;
    private $persistenceService;
    private $shoppingCart;
    private $accountService;
    private $isOrderPlaced = FALSE;

    const ADD_TO_CART = 'add';
    const REMOVE_FROM_CART = 'remove';
    const UPDATE_CART = 'update';
    const TAX_RATE = 17.5;
    const NUMBER_OF_WEEKS = 2;

    public function __construct(SessionInterface $session, PersistenceService $persistenceService, TokenStorageInterface $token, AccountInterface $accountService) {
        $this->persistenceService = $persistenceService;
        $this->sessionManager = $session;
        $this->tokenStorage = $token;
        $this->shoppingCart = new ArrayCollection();
        $this->accountService = $accountService;
    }

    public function addToCart(OrderItem $orderItem) {
        if ($this->shoppingCart->get($orderItem->getProduct()->getId())) {
            return FALSE; //Item is already in cart
        }
        $orderItem->setQuantity(1);
        $this->updateShoppingCart($orderItem);
        return TRUE; //Item successfully added to cart
    }

    public function updateCart(OrderItem $orderItem) {
        if ($this->shoppingCart->get($orderItem->getProduct()->getId())) {
            $this->updateShoppingCart($orderItem);
            return TRUE; // Cart item successfully updated
        }
        return FALSE; //Item is not in cart
    }

    public function placeOrder(Order $order = null) {
        if (!$order) {
            $order = $this->getCurrentOrder();
        }
       // try {
            $customer = $this->tokenStorage->getToken()->getUser();
            $customer->addOrder($order); 
            $this->persistenceService->getEntityManager()->clear();
            $this->persistenceService->saveEntity($customer);
            $this->isOrderPlaced = TRUE;
        /**} catch (Exception $ex) {
            $this->isOrderPlaced = FALSE;
        } finally {
            if ($this->isOrderPlaced) {
                $this->emptyCart();
            }
        }*/
        return $this->isOrderPlaced;
    }

    public function emptyCart() {
        $this->sessionManager->remove('shoppingCart');
        $this->sessionManager->remove('order');
        $this->shoppingCart = null;
    }

    public function removeFromCart(OrderItem $orderItem) {
        $this->updateShoppingCart($orderItem, 'remove');
    }

    private function updateShoppingCart(OrderItem $orderItem, $action = 'add') {
        if ($action == 'add') {
            $this->populateOrderItem($orderItem);
            $this->getShoppingCart()->set($orderItem->getProduct()->getId(), $orderItem);
        } else if ('remove') {
            if ($this->getShoppingCart()->get($orderItem->getProduct()->getId()))
                $this->shoppingCart->remove($orderItem->getProduct()->getId());
        }
        $this->sessionManager->set('shoppingCart', $this->shoppingCart);
    }

    public function populateOrder(Order $order) {
        $orderItems = $order->getOrderItems();
        $this->initOrderData($order, $orderItems);
        $currentDate = new DateTime();
        $order->setCreatedAt(new DateTime());
        $expiryDate = $currentDate->modify('+' . self::NUMBER_OF_WEEKS . ' weeks');
        $order->setExpiryDate($expiryDate);
        $order->setQuantity($orderItems != null ? $orderItems->count() : 0);
        $orderId = Constants::ORDER_NUMBER_PREFIX . date('d-M-y_H:i:s');
        //$quoteNumber = Constants::PRICE_QUOTATION_PREFIX . date('d-M-y_H:i:s');
        $order->setOrderId($orderId);
        $order->setQuoteNumber(Null);
        return $order;
    }

    private function initOrderData($order = null, $orderItems = null, $isViewCart = false) {
        if ($order == null) {
            $order = new Order();
        }
        if ($orderItems != null && $orderItems->count() > 0) {//Only process populate order data if shopping cart contains items
            $subTotal = $total = $taxTotal = 0;
            foreach ($orderItems as $key => $orderItem) {
                $subTtl = $orderItem->getProduct()->getProductData()->getSalePrice() != null ? ($orderItem->getProduct()->getProductData()->getSalePrice() * $orderItem->getQuantity() ) : ($orderItem->getProduct()->getProductData()->getRegularPrice() * $orderItem->getQuantity());
                $subTotal = $subTotal + $subTtl;
            }
            $taxTotal = (self::TAX_RATE / 100) * $subTotal;
            /** if ($isViewCart) {
              $total = $subTotal;
              } else {
              $total = $subTotal + $taxTotal;
              } */
            $total = $subTotal + $taxTotal;
            $order->setSubTotal($subTotal);
            $order->setTax($taxTotal);
            $order->setTotal($total);
        }

        return $order;
    }

    public function populateOrderItem(OrderItem $orderItem) {
        $product = $this->persistenceService->getRepository(EntityConfig::PRODUCT)->find($orderItem->getProduct()->getId());
        $salePrice = $product->getProductData()->getSalePrice() != null ? $product->getProductData()->getSalePrice() : $product->getProductData()->getRegularPrice();
        $subTotal = $salePrice * $orderItem->getQuantity();
        $tax = (self::TAX_RATE / 100) * $subTotal;
        $total = $subTotal + $tax;
        $orderItem->setProduct($product);
        $orderItem->setSalePrice($salePrice);
        $orderItem->setSubTotal($subTotal);
        $orderItem->setTax($tax);
        $orderItem->setTotal($total);

        return $orderItem;
    }

    public function getShoppingCart() {
        if (!$this->sessionManager->get('shoppingCart')) {
            $this->shoppingCart = new ArrayCollection();
        } else {
            $this->shoppingCart = $this->sessionManager->get('shoppingCart');
        }
        return $this->shoppingCart;
    }

    public function getCurrentOrder() {
        $order = new Order();
        if ($this->getShoppingCart()->count()) {
            foreach ($this->getShoppingCart() as $orderItem) {
                $order->addOrderItem($orderItem);
            }
            $this->populateOrder($order);
            $this->sessionManager->set('order', $order);
            return $order;
        }
        return null;
    }

    public function doesAccountExist($username) {
        return $this->accountService->doesAccountExist($username);
    }

}
