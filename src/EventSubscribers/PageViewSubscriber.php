<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\EventSubscribers;

use App\Entity\PageView;
use App\Entity\Product;
use App\Entity\Property;
use App\Events\ItemViewedEvent;
use App\Services\PersistenceService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of PageViewSubscriber
 *
 * @author Balika - MRH
 */
class PageViewSubscriber implements EventSubscriberInterface {

    protected $persistenceService;

    public function __construct(PersistenceService $persistenceService) {
        $this->persistenceService = $persistenceService;
    }

    public static function getSubscribedEvents() {
        return array(
            ItemViewedEvent::NAME => 'onNewItemViewed'
        );
    }

    public function onNewItemViewed(ItemViewedEvent $event) {
        $event->stopPropagation();
        $entity = $event->getEntity();
        $pageView = new PageView($event->getEnityType(), $entity->getId(), $event->getViewedBy(), $event->getAgent(), $event->getPage(), $event->getIpAddress());
        if ($entity instanceof Product || $entity instanceof Property) {          
            $totalViews = $entity->getViews();
            $totalViews++;
            $entity->setViews($totalViews);
            $this->persistenceService->saveEntities([$entity, $pageView]);
        } else {
            $this->persistenceService->saveEntity($pageView);
        }
    }

}
