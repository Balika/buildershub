<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Hubernize;

use App\Entity\Company;
use App\Entity\Equipment;
use App\Entity\RentalAd;
use App\Entity\RentalPromo;
use App\Entity\RentalRequest;
use App\Entity\RentedOut;
use App\Entity\WeeklyDeal;
use App\Form\Inventory\EquipmentType;
use App\Form\Inventory\RentalAdType;
use App\Form\Inventory\RentalRequestType;
use App\Form\Inventory\RentedOutType;
use App\Form\RentalAdPromoType;
use App\Form\SiteDiary\DiaryEntryType;
use App\Form\WeeklyDealType;
use App\HubernizeModel\Diary\CreateDiaryEntry;
use App\Model\HubernizeFormInterface;
use App\Services\BaseFormService;

/**
 * Description of HubernizeFormService
 *
 * @author Balika
 */
class HubernizeFormService extends BaseFormService implements HubernizeFormInterface{
    
    public function createDiaryEntryForm( CreateDiaryEntry $createDiaryEntry) {
          if ($createDiaryEntry == null) {
            $createDiaryEntry =  new CreateDiaryEntry();         
        }
        $form = $this->createForm(DiaryEntryType::class, $createDiaryEntry);
        return $form;
    }  
    public function createDiaryEntryExtraForm(CreateDiaryEntry $createDiaryEntry, $entryType) {
        
    }
    public function createEquipmentForm(Equipment $equipment=null) {
        if($equipment == null){
            $equipment = new Equipment();
        }
        $form = $this->createForm(EquipmentType::class, $equipment);
        return $form;
    }

    public function createRentalAdForm(RentalAd $rentalAd=null, Company $company=null) {
        if($rentalAd == null){
            $rentalAd = new RentalAd();
        }
         $options = ['company'=>$company];
        $form = $this->createForm(RentalAdType::class, $rentalAd, $options);
        return $form;
    }

    public function createRentedOutForm(RentedOut $rentedOut=null, Company $company=null) {
        if($rentedOut == null){
            $rentedOut = new RentedOut();
        }
        $options = ['company'=>$company];
        $form = $this->createForm(RentedOutType::class, $rentedOut, $options);
        return $form;
    }

    public function createRentalPromoForm(RentalPromo $rentalPromo = null) {
        if ($rentalPromo == null) {
            $rentalPromo = new RentalPromo();
        }
        $form = $this->createForm(RentalAdPromoType::class, $rentalPromo);
        return $form;
    }
    public function createRentalRequestForm(RentalRequest $rentalRequest = null) {
        if ($rentalRequest == null) {
            $rentalRequest = new RentalRequest();
        }
        $form = $this->createForm(RentalRequestType::class, $rentalRequest);
        return $form;
    }

    public function createWeeklyDealForm(WeeklyDeal $weeklyDeal = null, $supplier = null) {
        if ($weeklyDeal == null) {
            $weeklyDeal = new WeeklyDeal();
        }
        $form = $this->createForm(WeeklyDealType::class, $weeklyDeal, ['supplier' => $supplier]);
        return $form;
    }
    
}
