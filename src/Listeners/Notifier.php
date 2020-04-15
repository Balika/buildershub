<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Listeners;

use App\Entity\Company;
use App\Entity\Notification;
use App\Entity\Order;
use App\Entity\QuotationRequest;
use App\Entity\User;
use App\Model\MessagingInterface;
use App\Model\Notifiable;
use App\Services\MultipleFilesUploaderService;
use App\Utils\EntityConfig;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Exception;

/**
 * Description of Notifier
 *
 * @author Balika
 */
class Notifier {

    private $em;
    private $messagingService;
    private $galleryUploader;
    private $isNotificationSaved = false;

    public function __construct(MessagingInterface $messagingService, MultipleFilesUploaderService $galleryUploader) {
        $this->messagingService = $messagingService;
        $this->galleryUploader = $galleryUploader;
    }

    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $this->em = $args->getEntityManager();
        if (method_exists($entity, 'getGalleryFiles')) {
            $this->galleryUploader->uploadFiles($entity);
        }
        if (!$entity instanceof Notifiable)
            return;
        $this->notifyRelatedUsers($entity);
    }
    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $this->em = $args->getEntityManager();
        if (method_exists($entity, 'getGalleryFiles')) {
            $this->galleryUploader->uploadFiles($entity);
        }
        
    }

    private function notifyRelatedUsers($entity) {
        if ($entity instanceof Order) {
            $this->addOrderNotification($entity);
        } elseif ($entity instanceof QuotationRequest) {
            $this->addQuotationRequestNotification($entity);
        }
    }

    public function addQuotationRequestNotification(QuotationRequest $request) {
        $user = $request->getUser();
        $emailedTo = $smsTo = null;
        $subject = $request->getRequestType() != null ? $request->getRequestType() : "New Quotation Request";
        $body = "Your request on BuildersHub has been received. You will soon be contacted.";
        if ($user == null) {
            $emailedTo = $smsTo = $request->getContact();
        }
        $this->addNotification($subject, $body, EntityConfig::QUOTATION_REQUEST, $request->getId(), $user, $request->getSupplier(), $emailedTo, $smsTo);
    }

    public function addOrderNotification(Order $order) {
        $user = $order->getCustomer();
        $subject = "New Order Placed";
        $body = "Your order on BuildersHub with id=" . $order->getOrderId() . ' has been placed. You will soon be contacted.';
        $this->addNotification($subject, $body, EntityConfig::ORDER, $order->getId(), $user, $user);
    }

    public function addNotification($subject, $body, $entity, $entityId, User $user = null, Company $company = null, $emailedTo = null, $smsTo = null) {
        $notification = new Notification();
        $notification->setSubject($subject);
        $notification->setBody($body);
        $notification->setSentTo($user);
        if (!isset($smsTo)) {
            $smsTo = $user->getContactNo() != null ? $user->getContactNo() : $user->getPerson()->getContactNo() != null ? $user->getPerson()->getContactNo() : null;
        }
        if (!isset($emailedTo)) {
            $emailedTo = $user->getEmail();
        }
        $notification->setSmsTo($smsTo);
        $notification->setEmailedTo($emailedTo);
        $notification->setEntity($entity);
        $notification->setEntityId($entityId);
        $notification->setCompany($company);
        try {
            $manager = $this->em;
            $manager->persist($notification);
            $manager->flush();
            $this->isNotificationSaved = true;
        } catch (Exception $ex) {
            
        } finally {
            if ($this->isNotificationSaved) {
                $this->messagingService->sendNotification($notification);
            }
        }
    }

}
