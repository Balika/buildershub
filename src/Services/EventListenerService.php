<?php

namespace App\Services;

use App\Entity\User;
use App\Events\ItemAddedEvent;
use App\Events\ItemViewedEvent;
use App\EventSubscribers\ActivityTrackerSubscriber;
use App\EventSubscribers\PageViewSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventListenerService  {
    protected $eventDispatcher;
    private $persistenceService;
   
    public function __construct(EventDispatcherInterface $eventDispatcher, PersistenceService $persistenceService) {
        $this->eventDispatcher = $eventDispatcher;               
        $this->persistenceService = $persistenceService;      
    }
    public function triggerItemAddedEvent($entityType, $entity, User $actor =null, User $recipient=null ) {
        $event = new ItemAddedEvent($entityType, $entity, $actor, $recipient);   
        $this->eventDispatcher->addSubscriber(new ActivityTrackerSubscriber($this->persistenceService));
        $this->eventDispatcher->dispatch(ItemAddedEvent::NAME, $event);       
    }
     public function triggerItemViewedEvent($entityType, $entity, User $viewedBy=null,$agent=null,$page=null,$ipAddress=null ) {
        $event = new ItemViewedEvent($entityType, $entity, $viewedBy, $agent, $page, $ipAddress);
        $this->eventDispatcher->addSubscriber(new PageViewSubscriber($this->persistenceService));
        $this->eventDispatcher->dispatch(ItemViewedEvent::NAME, $event);       
    }
}
