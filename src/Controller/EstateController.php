<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Property;
use App\Utils\EntityConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of StoreBlogController
 *
 * @author Balika Edmond
 */

/**
 * @Route("/estates/")
 */
class EstateController extends BaseController {

    /**
     * @Route("index",name="estates_index")
     */
    public function indexEstates(Request $request) {
        $forRent = $forSale = $featured = [];
        $properties = $this->getDoctrine()->getRepository(EntityConfig::PROPERTY)->findBy(['enabled' => TRUE]);
        foreach ($properties as $property) {
            if ($property->getListingType() == "For Sale") {
                $forSale[] = $property;
            } else if ($property->getListingType() == "For Rent") {
                $forRent[] = $property;
            }
            if ($property->getIsFeatured()) {
                $featured[] = $property;
            }
        }
        return $this->render('store/estates/estates.index.html.twig', [
                    'featuredProperties' => $featured,
                    'listings' => $properties,
                    'forRent' => $forRent,
                    'forSale' => $forSale,
                    'featured' => $featured,
        ]);
    }

    /**
     * @Route("list",name="list_estates")
     */
    public function listProperties(Request $request) {

        $page = $request->query->get('page');
        $form = $this->formService->createPropertyFilterForm();
        //$properties = $this->getDoctrine()->getRepository(EntityConfig::PROPERTY)->findBy(['isFeatured' => FALSE]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchData = $form->getData();
        }
        return $this->render('store/estates/list.estates.html.twig', [
                    'page' => $page,
        ]);
    }

    /**
     * @Route("show/{slug}",name="property_details")
     */
    public function propertyDetails(Property $property, Request $request) {
        $relatedProperties = $this->getDoctrine()->getRepository(EntityConfig::PROPERTY)->findRelatedProperties($property);
        return $this->render('store/estates/property.details.html.twig', [
                    'property' => $property,
                    'relatedProperties' => $relatedProperties
        ]);
    }

}
