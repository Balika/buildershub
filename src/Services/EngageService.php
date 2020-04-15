<?php

namespace App\Services;

use App\Entity\User;
use App\Events\ItemAddedEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EngageService implements EventSubscriberInterface {

    protected $persistenceService;
    private $templating;
    private $mailer;
    private $latestEntries;
    private $timelineEntries;

    const ENTITIES_SORTER_FUNCTION = "sortEntities";

    public static function getSubscribedEvents() {
        return array(
                //  ItemAddedEvent::NAME => 'onNewItemAdded'
        );
    }

    public function __construct(PersistenceService $persistentService) {
        $this->persistenceService = $persistentService;
        $this->latestEntries = new ArrayCollection();
    }

    public function onNewItemAdded(ItemAddedEvent $event) {
        $this->latestEntries->add(array(
            'entityType' => $event->getEnityType(),
            'entity' => $event->getEntity()
        ));
    }

    public function isLiked(User $user, $entity) {
       return in_array($user, $entity->getLikes()->toArray());        
    }

    public function like(User $user, $entity) {
        $entity->addLike($user);
        $this->persistenceService->saveEntity($entity);
    }

    public function unLike(User $user, $entity) {
        $entity->removeLike($user);
        $this->persistenceService->saveEntity($entity);
    }

    public function follow(User $follower, User $requestedProfile) {
        $follower->addFollowing($requestedProfile);
        $this->persistenceService->saveEntity($follower);
    }

    public function unfollow(User $follower, User $following) {
        $follower->removeFollowing($following);
        $this->persistenceService->saveEntity($follower);
    }

    public function isFollowing(User $follower, User $requestedProfile) {
        if (in_array($follower, $requestedProfile->getFollowers()->toArray())) {
            return true;
        }
        return false;
    }

    

}
