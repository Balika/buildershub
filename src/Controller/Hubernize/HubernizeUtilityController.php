<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\Hubernize;

use App\Entity\Company;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Description of HubernizeUtilityController
 *
 * @author Balika Edmond
 */
class HubernizeUtilityController extends HubernizeBaseController {   
    public function validateHubernizeAccess() {
        $company = $this->getCompany();
        if (is_null($company)  || !$this->isCompanyStaff($company)) {
            throw new AccessDeniedException('You are not authorized to access this resource');
        }
        return new Response('');
    }

    private function isCompanyStaff(Company $company) {
        return in_array($this->getUser(), $company->getStaff()->toArray(), TRUE) || in_array($company, $this->getUser()->getUserCompanies()->toArray());
    }
}
