<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Award;
use App\Entity\Company;
use App\Entity\CompanyService;
use App\Model\AccountInterface;
use App\Model\AppInterface;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\CompanyTypes;
use App\Utils\Constants;
use App\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccountController
 *
 * @author Balika 
 */
class FirmAccountController extends BaseController {

    protected $accountService;
    protected $paginatorService;

    const COMPANY_TABS_PREFIX = 'account/firm/tab-content/';

    public function __construct(AccountInterface $accountService, FormService $formService, PersistenceService $persistenceService, Slugger $slugger, KnpPaginatorWrapper $paginator) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->accountService = $accountService;
        $this->paginatorService = $paginator;
    }

    /**
     * @Route("account/firms/edit/{slug}", name="edit_company")
     */
    public function editCompany(Company $company, Request $request) {
        $form = $this->formService->createCompanyForm($company);
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form->getData();
            $this->accountService->saveCompany($this->getUser(), $company);
            return $this->redirectToRoute('account_settings', ['tab' => 'firm-details']);
        }
        return $this->render('account/firm/edit.company.html.twig', [
                    'company' => $company,
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("account/firms/add", name="add_company", options={"expose"=true})
     */
    public function addCompany(Request $request) {
        $type = $request->query->get('type');
        $form = $this->accountService->loadCompanyForm($type, $this->formService);
        if ($form != null) {
            $form->submit($request->request->get($form->getName()), false);
            if ($form->isSubmitted() && $form->isValid()) {
                $company = $form->getData();
                $company->setSubType($type);
                $this->accountService->saveCompany($this->getUser(), $company);
                return $this->redirectToRoute('account_settings', ['tab' => 'firm-details']);
            }
        }
        return $this->redirectToRoute('account_settings', ['tab' => 'firm-details', 'sub'=>'add-new', 'type' => $type]);
    }

    /**
     * @Route("account/firms/load-company-form/{type}",  options={"expose"=true}, name="render_company_form")
     */
    public function renderCompanyForm($type, Request $request) {
        return $this->redirectToRoute('add_company', ['type' => $type]);
    }

    

    /**
     * @Route("account/firms/view/{slug}", name="view_company")
     */
    public function viewCompany(Company $company, Request $request, AppInterface $appManager) {
        $tab = 'company-info';
        $sub = '';
        if ($request->query->get('tab')) {
            $tab = $request->query->get('tab');
        }
        $template = self::COMPANY_TABS_PREFIX . $tab . Constants::TPL_SUFFIX;
        if ($request->query->get('sub')) {
            $sub = $request->query->get('sub');
            $template = self::COMPANY_TABS_PREFIX . $sub . Constants::TPL_SUFFIX;
        }
        $isSaved = $request->query->get('isSaved');
        $form = $this->formService->createCompanyForm($company);
        $firmServiceForm = $this->formService->createCompanyServiceForm($company);
        $form->submit($request->request->get($form->getName()), false);
        $activeAccordian = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $company = $this->accountService->saveCompany($this->getUser(), $company);
            $activeAccordian = $this->getActiveAccordian($form);
            /** if ($request->isXmlHttpRequest()) {
              $template = $this->get('twig')->loadTemplate($template);
              $activePanelContent = $template->renderBlock($activeAccordian, [
              'company' => $company,
              'form' => $form->createView()
              ]);
              return new JsonResponse(
              ['response' => $activePanelContent,
              'activeAccordion' => '#' . $activeAccordian
              ]);
              } */
        }
        $extras['activeAccordian'] = $activeAccordian;
        $extras['form'] = $form;
        $extras['firmServiceForm'] = $firmServiceForm;
        //$appManager->setRouterContext($company->getDomain());
        $commonParams = [
            'company' => $company,
            'template' => $template,
            'tab' => $tab,
            'sub' => $sub,
            'url' => $appManager->getHubernizeHome($company->getDomain()),
            'host' => $appManager->getHubernizeHost($company->getDomain()),
            'isSaved' => $isSaved]; //Used to determine feedback to give to user after saving service 


        return $this->render('account/firm/view.company.html.twig', array_merge($commonParams, $this->loadPageParams($tab, $extras, null, $appManager))
        );
    }

    private function loadPageParams($tab, $extras = [], $entity = null, $appManager = null) {
        $params = [];
        switch ($tab) {
            case 'awards-received':
                $form = $this->formService->createAwardForm($entity);
                $params = [
                    'form' => $form->createView(),
                ];
                break;
            case 'apps':
                $apps = $appManager->getApps();
                $params = [
                    'apps' => $apps
                ];
                break;
            case 'associations':
                $form = $this->formService->createAssociationForm($entity);
                $params = [
                    'form' => $form->createView(),
                ];
                break;
            default:
                $params = ['service' => null,
                    'activeAccordion' => $extras['activeAccordian'],
                    'form' => $extras['form']->createView(),
                    'serviceForm' => $extras['firmServiceForm']->createView()];
                break;
        }
        return $params;
    }

    /**
     * @Route("account/firms/awards/save/{slug}/{award_id}", name="save_company_award", defaults={"award_id":0})
     * @ParamConverter("award", options={"mapping": {"award_id": "id"}})
     */
    public function saveAward(Company $company, Request $request, Award $award = null) {
        $form = $this->formService->createAwardForm($award);
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $award = $form->getData();
            $slug = $this->slugger->slugify($award->getName());
            $award->setSlug($slug);
            $award->setUser($this->getUser());
            $company->addAward($award);
            $this->persistenceService->saveEntity($company);
            $isSaved = true;
        }
        return $this->redirectToRoute('view_company', ['tab' => 'awards-received', 'slug' => $company->getSlug(), 'isSaved' => $isSaved]);
    }

    /**
     * @Route("account/firms/associations/save/{slug}/{association_id}", name="save_company_association", defaults={"association_id":0})
     * @ParamConverter("association", options={"mapping": {"association_id": "id"}})
     */
    public function saveAssociation(Company $company, Request $request, Association $association = null) {
        $form = $this->formService->createAssociationForm($association);
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {
            $association = $form->getData();
            $association->setUser($this->getUser());
            $company->addAssociation($association);
            $this->persistenceService->saveEntity($company);
            $isSaved = true;
        }
        return $this->redirectToRoute('view_company', ['tab' => 'associations', 'slug' => $company->getSlug(), 'isSaved' => $isSaved]);
    }

    /**
     * @Route("account/firms/save-service/{slug}/{service_id}", name="save_company_service", defaults={"service_id":0})
     * @ParamConverter("service", options={"mapping": {"service_id": "id"}})
     */
    public function saveService(Company $company, Request $request, CompanyService $service = null) {
        $firmServiceForm = $this->formService->createCompanyServiceForm($company, $service);
        $isSaved = false;
        $firmServiceForm->submit($request->request->get($firmServiceForm->getName()), false);
        if ($firmServiceForm->isSubmitted() && $firmServiceForm->isValid()) {
            $service = $firmServiceForm->getData();
            $service->setUser($this->getUser());
            $this->persistenceService->saveEntity($service);
            $isSaved = true;
        }
        return $this->redirectToRoute('view_company', ['slug' => $company->getSlug(), 'isSaved' => $isSaved]);
    }

    private function getActiveAccordian($form) {
        $activeAccordian = 'none';
        $clickedBtn = $form->getClickedButton();
        switch ($clickedBtn) {
            case'historySubBtn':
                $activeAccordian = 'historyAccordian';
                break;
            case 'summarySubBtn':
                $activeAccordian = 'summaryAccordian';
                break;
            case 'visionSubBtn':
                $activeAccordian = 'visionAccordian';
                break;
            case 'missionSubBtn':
                $activeAccordian = 'missionAccordian';
                break;
            default:
                break;
        }
        return $activeAccordian;
    }

}
