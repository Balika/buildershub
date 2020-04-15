<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\Hubernize;

use App\HubernizeModel\Diary\CreateDiaryEntry;
use App\Services\AppManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of BlogController
 *
 * @author Balika Edmond
 * @Route("apps/")
 */
class SiteDiaryController extends HubernizeBaseController {

    /**
     * @Route("site-diary/add", 
     * name="hubernize_new_diary_entry",
     * )
     */
    public function addNew(Request $request) {
        $createDiaryEntry = new CreateDiaryEntry();
        $form = $this->formService->createDiaryEntryForm($createDiaryEntry);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                
            } catch (Exception $ex) {

            }
        }
        return $this->render('hubernize/diary/new.diary.entry.html.twig', [
                    'company' => $this->getCompany(),
                    'domain' => $this->getDomain(),
                    'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("site-diary/entries", 
     * name="hubernize_diary_entries",
     * )
     */
    public function diaryEntries(AppManager $appManager, Request $request) {
        return $this->render('hubernize/diary/diary.index.html.twig', [
                    'company' => $this->getCompany(),
                    'domain' => $this->getDomain()
        ]);
    }

}
