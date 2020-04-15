<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Region;
use App\Entity\UserProfile;
use App\Form\Type\PortalLocationFilterType;
use App\Services\FormService;
use App\Services\KnpPaginatorWrapper;
use App\Services\PersistenceService;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of StudentsController
 *
 * @author Balika 
 */
class StudentsController  extends BaseController{
    const STUDENTS_PAGE_PREFIX = 'students/';
    protected $paginatorService;
    public function __construct(FormService $formService, PersistenceService $persistenceService, KnpPaginatorWrapper $paginator, Slugger $slugger) {
        parent::__construct($formService, $persistenceService, $slugger);
        $this->paginatorService = $paginator;
    }

   /**
     * @Route("/students", name="students_index")
    */
    public function studentsIndex(Request $request)
    {
        
        return $this->render('students/students.page.html.twig', [
           
        ]);
    }
   

}
