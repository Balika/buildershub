<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Entity\Company;
use App\Entity\Equipment;
use App\Entity\RentalAd;
use App\Entity\RentalPromo;
use App\Entity\RentalRequest;
use App\Entity\RentedOut;
use App\Entity\User;
use App\Entity\WeeklyDeal;
use App\HubernizeModel\Diary\CreateDiaryEntry;

/**
 *
 * @author Balika
 */
interface HubernizeFormInterface {

//###################### Site Diary Related Forms #######################
    public function createDiaryEntryForm(CreateDiaryEntry $createDiaryEntry);

    public function createDiaryEntryExtraForm(CreateDiaryEntry $createDiaryEntry, $entryType);

//###################### Inventory Related Forms #######################
    public function createEquipmentForm(Equipment $equipment = null);

    public function createRentalAdForm(RentalAd $rentalAd = null, Company $company = null);

    public function createRentedOutForm(RentedOut $rentedOut = null, Company $company = null);

    public function createRentalPromoForm(RentalPromo $rentalPromo = null);

    public function createWeeklyDealForm(WeeklyDeal $weeklyDeal = null, $supplier = null);
    public function createRentalRequestForm(RentalRequest $rentalRequest = null);
    public function createUserRegistrationForm(User $user = null, $contact = null);
    public function createLoginForm();
}
