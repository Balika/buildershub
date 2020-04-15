<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Invitation;
use App\Entity\User;
use App\Model\AccountInterface;
use App\Model\MessagingInterface;
use App\Services\FormService;
use App\Services\PersistenceService;
use App\Utils\ImageProcessor;
use App\Utils\Slugger;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccountController
 *
 * @author Balika 
 */
class InvitationController extends BaseController {

    const ACOOUNT_PREFIX = 'account/includes/';
    const PERSONAL_DETAILS_SUB = 'account/profile-sub/';

    protected $imageProcessor;
    protected $accountService;
    protected $messagingService;

    public function __construct(AccountInterface $accountService, FormService $formService, PersistenceService $persistenceService, ImageProcessor $imageProcessor, Slugger $slugger, MessagingInterface $messagingService) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->accountService = $accountService;
        $this->imageProcessor = $imageProcessor;
        $this->messagingService = $messagingService;
    }

    /**
     * @Route("/invitation-response/{id}", name="invitation_response")
     */
    public function invitationResponse(Invitation $invitation, Request $request) {
        $form = $this->formService->createInvitationResponseForm($invitation->getEmail());
        $route = 'invitation.response.html.twig';
        $form->handleRequest($request);
        if (($form->isSubmitted() && $form->isValid())) {
            $userData = $form->getData();
            $user = new User();
            $userType = strtoupper($request->request->get('userType'));
            $profile = $userData['profile'];
            $user->setFirstname($userData['firstname']);
            $user->setLastname($userData['lastname']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
            $this->accountService->createBuilderAccount($user, $userType, $profile);
            $ipAddress = $request->getClientIp();
            $userAgent = $request->headers->get('User-Agent');
            $invitation->setAgent($userAgent);
            $invitation->setIpAddress($ipAddress);
            $invitation->setHasResponded(TRUE);
            $this->persistenceService->saveEntity($invitation);
            return $this->redirectToRoute("activate_account", array('id' => $user->getId()));
        }
        return $this->render($route, ['form' => $form->createView()]);
    }

    /**
     * @Route("/invite-friends", name="invite_friends")
     */
    public function inviteFriends(Request $request) {
        $form = $this->formService->createInvitationForm();
        $message = "";
        $invitationsSent = FALSE;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $inputSize = 4;
                $invitationData = $form->getData();
                $user = $this->getUser();
                $email = $invitationData['email'];
                $userType = $request->request->get('userType');
                $invitation = new Invitation($user, $email, $userType);
                $this->persistenceService->persist($invitation);
                $invitation->setEmail($invitationData['email']);
                for ($i = 1; $i <= $inputSize; $i++) {
                    if ($invitationData['email' . $i] != null) {
                        $this->persistenceService->persist(new Invitation($user, $invitationData['email' . $i], $request->request->get('userType' . $i)));
                    }
                }
                $this->persistenceService->flush();
                $invitationsSent = TRUE;
                $message = "Your invitations have been successfuly sent";
            } catch (Exception $ex) {
                $message = "Error! " . $ex->getMessage();
            } finally {
                if ($invitationsSent) {
                    $this->messagingService->sendInvitationEmails($user);
                }
            }
        }
        return new JsonResponse(['message' => $message]);
    }

}
