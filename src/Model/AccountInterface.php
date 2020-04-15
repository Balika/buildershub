<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Entity\Company;
use App\Entity\User;

/**
 *
 * @author Balika - BTL
 */
interface AccountInterface {

    public function createUser(User $user);

    public function createBuilderAccount(User $user, $type, $profile = null, $persist = TRUE);

    /** public function createStudentAccount(User $user);

      public function createProfessionalAccount(User $user);
     */
    public function createSupplierAccount(User $user);

    public function generateRandomPassword($length = 8);

    public function generateRandomToken();

    public function activateUser(User $user);

    public function triggerUserAccountCreatedEvent(User $user, $token);

    public function doesAccountExist($username);

    public function processPasswordRequest(User $user);

    public function getGuestUserParams($guestContact, $loginForm, $registrationForm);

    //##################### Firm Related Methods ######################################

    public function createFirmAccount(User $user);

    public function saveCompany(User $user, Company $company);

    public function loadCompanyForm($type, $formService, $company = null);

    //####################### Builder Professional Details Methods ############################
    public function saveBuilderProfessionalDetails($entity);

    public function loadBuilderProfessionalData($sub, $entityId,$formService);
}
