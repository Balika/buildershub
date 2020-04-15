<?php
namespace App\Annotation;
use Doctrine\Common\Annotations\Annotation;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tenant
 *
 * @author Balika
 * @Annotation
 * @Target("CLASS")
 */
class Tenant {
    public $tenantFieldName;
}
