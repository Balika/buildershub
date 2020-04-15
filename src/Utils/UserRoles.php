<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of UserRoles
 *
 * @author Balika - MRH
 */
class UserRoles {
    const ARTISAN_ROLE="ROLE_ARTISAN";
    const DEFAULT_ROLE="ROLE_USER";
    const SUPPLIER_ROLE="ROLE_SUPPLIER";
    const STUDENT_ROLE="ROLE_STUDENT";
    const FIRM_ROLE="ROLE_FIRM";
    const HUB_ADMIN_ROLE="ROLE_HUB_ADMIN";
    const HUBERNIZE_ROLE="ROLE_HUBERNIZE";
    const PROFESSIONAL_ROLE="ROLE_PROFESSIONAL";
    const GUEST_ROLE="ROLE_GUEST";
    const ALL_ROLES=["ROLE_ARTISAN","ROLE_USER","ROLE_SUPPLIER","ROLE_STUDENT","ROLE_FIRM","ROLE_FIRM","ROLE_PROFESSIONAL","ROLE_GUEST", "ROLE_HUBERNIZE"];
}
