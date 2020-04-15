<?php

namespace App\Controller\Backend;

use App\Controller\BaseController;
use App\Entity\Company;
use App\Entity\Property;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/store/admin/")
 * 
 */
class PropertyStoreBackendController extends BaseController {

    protected $productCategories;
    protected $nonStoreCategories;
    private static $equipmentSubCategories;
    private static $materialsSubCategories;
    private static $suppliesSubCategories;
    protected $storeAdminService;

    protected $paginatorService ;

    public function __construct(FormService $formService, PersistenceService $persistenceService, Slugger $slugger, KnpPaginatorWrapper $paginator) {
        parent::__construct($formService, $persistenceService, $slugger);
       $this->paginatorService = $paginator;
    }

    /**
     * @Route("{slug}/properties", name="properties")
     */
    public function properties(Company $company, Request $request) {
         $listMode = $request->query->get('list_mode');
        if ($listMode == null || $listMode == 'list') {
            $properties = $this->getDoctrine()->getRepository(EntityConfig::PROPERTY)->findBy(array('company' => $company));
        } else {
            $propertyQry = $this->getDoctrine()->getRepository(EntityConfig::PROPERTY)->findMerchantPropertiesQry($company);
            $properties = $this->paginatorService->getPaginatedEntity($request, $propertyQry, 20);
        }
        
        return $this->render('store/admin/property/properties.html.twig', array(
                    'properties' => $properties,
                    'supplier' => $company,
                    'listMode'=>$listMode
        ));
    }

    /**
     * @Route("{slug}/add-property", name="add_property")
     */
    public function addProperty(Company $company, Request $request) {
        $property = new Property();
        $form = $this->formService->createPropertyForm($property);
        $form->handleRequest($request);
        $isSaved = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $property = $form->getData();
            $property->setCompany($company);
            $listingType = $form->get('listingTypeHolder')->getData();
            $property->setUser($this->getUser());
            if ($form->get('publishProperty')->isClicked()) {
                $property->setEnabled(true);
            } else if ($form->get('preview')->isClicked()) {
                $property->setEnabled(false);
            } else if ($form->get('saveAsDraft')->isClicked()) {
                $property->setEnabled(false);
            }
            $property->setListingType($listingType);
            $slug = $this->slugger->slugifyUnique($property->getName(), EntityConfig::PROPERTY);
            $property->setSlug($slug);
            $this->persistenceService->saveEntity($property);
            $isSaved = true;
            return $this->redirectToRoute("edit_property", array('slug' => $company->getSlug(), 'property_slug' => $property->getSlug(), 'isSaved' => $isSaved));
        }
        return $this->render('store/admin/property/property.form.html.twig', array(
                    'form' => $form->createView(),
                    'isSaved' => $isSaved,
                    'property' => $property,
                    'supplier' => $company
        ));
    }

    /**
     * @Route("{slug}/property/edit/{property_slug}", name="edit_property")
     * @ParamConverter("property", options={"mapping": {"property_slug": "slug"}})
     */
    public function editProperty(Company $company, Property $property, Request $request) {
        $form = $this->formService->createPropertyForm($property);

        $isSaved = $request->query->get('isSaved');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('preview')->isClicked()) {
                
            }
            $slug = $this->slugger->slugifyUnique($property->getName(), EntityConfig::PROPERTY, $property->getId());
            $property->setSlug($slug);
            $this->persistenceService->saveEntity($property);
            $isSaved = true;
        }
        return $this->render('store/admin/property/property.form.html.twig', array(
                    'form' => $form->createView(),
                    'isSaved' => $isSaved,
                    'property' => $property,
                    'supplier' => $company
        ));
    }

}
