<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\EventSubscribers;

use App\Entity\ActivityTracker;
use App\Events\ItemAddedEvent;
use App\Services\PersistenceService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of ActivityTrackerSubscriber
 *
 * @author Balika - MRH
 */
class ActivityTrackerSubscriber implements EventSubscriberInterface {
    
    protected $persistenceService;
    public function __construct(PersistenceService $persistenceService) {
        $this->persistenceService = $persistenceService;
    }

    public static function getSubscribedEvents() {
        return array(
            ItemAddedEvent::NAME => 'onNewItemAdded'
        );
    }
    public function onNewItemAdded(ItemAddedEvent $event) {
        $event->stopPropagation();
        $activityTracker = new ActivityTracker($event->getEnityType(), $event->getEntity()->getId(), $event->getActor(),$event->getRecipient());
        $this->persistenceService->saveEntity($activityTracker);
    }
}
