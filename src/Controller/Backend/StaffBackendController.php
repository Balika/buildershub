<?php

namespace App\Controller\Backend;

use App\Controller\BaseController;
use App\Entity\Company;
use App\Entity\User;
use App\Model\AccountInterface;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/store/admin/")
 */
class StaffBackendController extends BaseController {

    protected $productCategories;
    protected $nonStoreCategories;
    private static $equipmentSubCategories;
    private static $materialsSubCategories;
    private static $suppliesSubCategories;
    protected $storeAdminService;
    protected $accountService;
    protected $paginatorService ;

    public function __construct(FormService $formService, PersistenceService $persistenceService, Slugger $slugger, AccountInterface $accountService, KnpPaginatorWrapper $paginator) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->accountService = $accountService;
        $this->paginatorService = $paginator;
    }

    /**
     * @Route("{slug}/staff/list", name="list_staff")
     */
    public function listStaff(Company $company, Request $request) {
        $listMode = $request->query->get('list_mode');
        if ($listMode == null || $listMode == 'list') {
            $staff = $company->getStaff();   //$this->getDoctrine()->getRepository(EntityConfig::USER)->findBy(['firm' => $company]);
        } else {
            $staffQry = $this->getDoctrine()->getRepository(EntityConfig::USER)->findPaginatedUsers($company);
            $staff = $this->paginatorService->getPaginatedEntity($request, $staffQry, 20);
        }

        return $this->render('store/admin/staff/staff.list.html.twig', array(
                    'staffList' => $staff,
                    'supplier' => $company,
                    'listMode' => $listMode
        ));
    }

    /**
     * @Route("{slug}/staff/add-staff", name="add_staff")
     */
    public function addStaff(Company $company, Request $request) {
        $form = $this->formService->createUserRegistrationForm();
        $searchForm = $this->formService->createSearchForm();
        $form->handleRequest($request);
        $isSaved = false;
        $route = 'store/admin/staff/add.staff.html.twig';
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $form->getData();                
                $company->addStaff($user);
                $user->setPassword($this->accountService->generateRandomPassword(6));
                $this->accountService->createBuilderAccount($user, null, null);
                $this->persistenceService->flush();
                $isSaved = TRUE;
            } catch (Exception $ex) {
                
            } finally {
                if ($isSaved) {
                    $this->accountService->triggerUserAccountCreatedEvent($user, $user->getConfirmationToken());
                }
            }
        }
        $commonParams = array(
            'supplier' => $company,
            'isSaved' => $isSaved,
            'form' => $form->createView(),
            'searchForm' => $searchForm->createView()
        );
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchTerm = $searchForm->getData()['searchTerm'];
            $users = $this->getDoctrine()->getRepository(EntityConfig::USER)->searchUsers($searchTerm);
            $params = [
                'users' => $users,
                'searchTerm' => $searchTerm
            ];
            return $this->render($route, array_merge($params, $commonParams));
        }
        return $this->render($route, $commonParams);
    }

    /**
     * @Route("{slug}/staff/{user_id}/assign-to-store", name="assign_user_to_store")
     * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
     */
    public function assignToStore(Company $company, User $user, Request $request) {
        $company->addStaff($user);
        $this->persistenceService->saveEntity($company);
        return $this->redirectToRoute('list_staff', ['slug' => $company->getSlug()]);
    }

}
