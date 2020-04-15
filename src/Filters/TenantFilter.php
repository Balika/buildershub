<?php
namespace App\Filters;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TenantFilter
 *
 * @author Balika
 */
class TenantFilter extends SQLFilter {
    protected $reader;
    const TENANT_FIELD_NAME = 'supplier_id';
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias) {
        if (empty($this->reader)) {
            return '';
        }

        // The Doctrine filter is called for any query on any entity
        // Check if the current entity is "deleted" (marked with an annotation)
        $tenant= $this->reader->getClassAnnotation(
                $targetEntity->getReflectionClass(), 'App\\Annotation\\Tenant'
        );

        if (!$tenant) {
            return '';
        }
        $fieldName = $tenant->tenantFieldName;

        try {
            // Don't worry, getParameter automatically quotes parameters
            $idField = $this->getParameter(self::TENANT_FIELD_NAME);
        } catch (InvalidArgumentException $e) {
            // No school id has been defined
            return '';
        }

        if (empty($fieldName) || empty($idField)) {
            return '';
        }
        $query = sprintf('%s.%s != %s', $targetTableAlias, $fieldName, $idField);
        return $query;
    }

    public function setAnnotationReader(Reader $reader) {
        $this->reader = $reader;
    }
}
