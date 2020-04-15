<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Feedback;
use App\Services\EventListenerService;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileUtilityController
 *
 * @author Balika - BTL
 */
class UserInteractionController extends BaseController {

    protected $engageService;

    const SHARED_FRAGMENT_PREFIX = 'shared/fragments/';

    function __construct(FormService $formService, PersistenceService $persistenceService, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
    }

    /**
     * @Route("page-view/update/{entityType}/{entityId}/{page}", name="update_page_view", options={"expose":"true"})
     * 
     * */
    public function itemViewedAction($entityType, $entityId, $page, Request $request, EventListenerService $eventListener) {
        $entity = $this->getDoctrine()->getRepository($entityType)->find($entityId);
        $IpAddress = $request->getClientIp();
        $userAgent = $request->headers->get('User-Agent');
        $eventListener->triggerItemViewedEvent($entityType, $entity, $this->getUser(), $userAgent, $page, $IpAddress);
        return new Response();
    }

    public function feedbackForm($template = 'feedback') {
        $feedbackForm = $this->formService->createFeedbackForm($this->getUser());
        return $this->render(self::SHARED_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, array('feedbackForm' => $feedbackForm->createView(), 'isSaved' => false));       
    }

    /**
     * @Route("feedback", name="feedback")
     * */
    public function sendFeedbackAction(Request $request) {
        $form = $this->formService->createFeedbackForm($this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedbackData = $form->getData();
            $email = $feedbackData['email'];
            $message = $feedbackData['message'];
            $spamTrap = $feedbackData['email_address'];
            if ($spamTrap != '') {
                //Do nothing, just return a success message to fool bots
            } else {
                $feedback = new Feedback($email, $message);
                $this->persistenceService->saveEntity($feedback);
            }
            $template = $this->get('twig')->loadTemplate("shared/portal.content.block.html.twig");
            $feedbackBlock = $template->renderBlock('feedbackBlock', array('feedbackForm' => $form->createView(), 'isSaved' => true));
        }
        return new JsonResponse(['response' => $feedbackBlock]);
    }

}
