<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Builder;
use App\Entity\Person;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
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
 * Description of AccountUtilityController
 *
 * @author Balika - BTL
 */
class AccountUtilityController extends BaseController {

    protected $engageService;
    protected static $regions;
    protected static $materialsCategories;
    protected static $equipmentCategories;
    protected static $artisanCategories;
    protected static $professionalCategories;
    protected static $topLevelCategories;
    protected $paginatorService;

    const ACCOUNTS_FRAGMENT_PREFIX = 'account/fragments/';

    function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

    public function renderBuilderServicesFragment($template = '_builder.services') {
        $user = $this->getUser();
        $form = $this->formService->createProfileForm($user);
        $specialtyForm = $this->formService->createSpecialtyForm();
        $builderType = $user->getPerson()->getPersonType() == Person::ARTISAN ? Constants::ARTISAN : Constants::CONSULTANT;
        $params = [
            'user' => $user,
            'profileForm' => $form->createView(),
            'specialtyForm' => $specialtyForm->createView(),
            'specialties' => $this->getDoctrine()->getRepository(EntityConfig::SPECIALTY)->findBy(['type' => $builderType]),
            'professionalCategories' => $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->findBy(['type' => Constants::CONSULTANT]),
            'artisanalCategories' => $this->getDoctrine()->getRepository(EntityConfig::CATEGORY)->findBy(['type' => Constants::ARTISAN])
        ];

        $response = $this->render(self::ACCOUNTS_FRAGMENT_PREFIX . $template . Constants::TPL_SUFFIX, $params);
        $response->setSharedMaxAge(600);
        return $response;
    }

    /**
     * @Route("/preload/fetch-institutions", name="fetch_institutions", options={"expose":TRUE})
     */
    public function fetchInstitutions(Request $request) {
        $institutions = $this->getDoctrine()->getRepository(EntityConfig::INSTITUTION)->fetchInstitutionsNames();
        $education = $this->getDoctrine()->getRepository(EntityConfig::EDUCATION)->fetchEducationEntries();
        // $type = $this->getUser()->getPerson() instanceof Artisan ? Constants::ARTISAN : Constants::PROFESSIONAL;
        // $specialties = $this->getDoctrine()->getRepository(EntityConfig::SPECIALTY)->specialtyNames([$type]);
        return new JsonResponse(array(
            'institutions' => $institutions,
            'diplomas' => $education['diploma'],
            'programmes' => $education['programme']
        ));
    }

    public function includeInvitationForm() {
        $template = $this->get('twig')->loadTemplate("account/includes/account.content.block.html.twig");
        $form = $this->formService->createInvitationForm();
        $blockContent = $template->renderBlock('inviteFriends', [
            'invitationForm' => $form->createView(),
        ]);
        return new Response($blockContent);
    }

}
