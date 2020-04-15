<?php
namespace App\Controller;
use App\Entity\Region;
use App\Model\DirectoryInterface;
use App\Utils\Constants;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of AccountController
 *
 * @author Balika 
 */
class DirectoryController extends AbstractController {

    protected $accountService;
    protected $directoryService;

    const FIRMS_PAGE_PREFIX = 'firms/';

    public function __construct(DirectoryInterface $directoryService) {
        $this->directoryService = $directoryService;
    }

    /**
     * @Route("/firms/list/{slug}", name="list_firms", defaults={"slug":"none"})
     */
    public function listFirms(Request $request, Region $region = null) {
        $page = $request->query->get('b-page') != null ? $request->query->get('b-page') : 'suppliers';
        $template = self::FIRMS_PAGE_PREFIX . $page . Constants::TPL_SUFFIX;
        $defaultParams = ['template' => $template];
        return $this->render('firms/firms.page.html.twig', array_merge($defaultParams, $this->directoryService->listFirms($request, $page, $region)));
    }

}
