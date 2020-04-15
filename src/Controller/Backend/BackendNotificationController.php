<?php

namespace App\Controller\Backend;

use App\Entity\Notification;
use App\Entity\Supplier;
use App\Services\NotificationService;
use App\Utils\EntityConfig;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/store/admin/")
 */
class BackendNotificationController extends AbstractController {

    const CAMPAIGN_DURATION = 2;

    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function renderTopNavNotifications($companyId, $block = 'topNavNotificationBlock') {
        $company = $this->getDoctrine()->getRepository(EntityConfig::COMPANY)->find($companyId);
        if (!$company) {
            throw new Exception(printf('Company with id %s not found in our database', $companyId));
        }
        $notifications = $this->notificationService->getCompanyTopNavNotifications($company);
        $template = $this->get('twig')->loadTemplate("store/admin/shared/backend.content.block.html.twig");
        $renderBlock = $template->renderBlock($block, ['notifications' => $notifications, 'supplier' => $company]);
        return new Response($renderBlock);
    }

    /**
     * @Route("{slug}/notifications/{notification_id}", name="store_notifications", defaults={"notification_id":"0"})
     * @ParamConverter("notification",options={"mapping": {"notification_id": "id"}})
     */
    public function notifications(Supplier $supplier, Request $request, Notification $notification = null) {
        $entity = $this->notificationService->getNotificationEntity($notification);
        $notifications = $this->notificationService->getCompanyNotifications($supplier, $request);
        return $this->render('store/admin/notifications.html.twig', [
                    'notifications' => $notifications,
                    'selectedNotification' => $notification,
                    'entity' => $entity,
                    'supplier' => $supplier
        ]);
    }

}
