<?php

namespace App\Repository;

use App\Utils\Constants;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductCategoryRepository
 *
 * @author Edmond
 */
class ProductCategoryRepository extends EntityRepository {

    public function findAllQry() {
        return $this
                        ->createQueryBuilder('pc')
                        ->orderBy('pc.name', 'ASC');
    }

    public function findVendorTypeQry() {
        return $this
                        ->createQueryBuilder('pc')
                        ->where('pc.displayed = false');
    }

    public function findDisplayableCategoryQry() {
        return $this
                        ->createQueryBuilder('pc')
                        ->where('pc.displayed = true');
    }

    public function findTopLevelCategoriesQry($includeSecondLevel = false) {
        $qb = $this
                ->createQueryBuilder('pc')
                ->where('pc.level = :level');
        if ($includeSecondLevel) {
            $qb->orWhere('pc.level = :secondLevel');
            $qb->setParameter('secondLevel', Constants::SECOND_LEVEL_CATEGORY);
        }
        return $qb->setParameter('level', Constants::TOP_LEVEL_CATEGORY)
                        ->orderBy('pc.rank', 'ASC');
    }

    public function findMaterialsTopLevelCategories() {
        return $this
                        ->createQueryBuilder('pc')
                        ->where('pc.level = :level')
                        ->andWhere('pc.name != :equipment AND pc.name != :parts AND pc.name != :tools')
                        ->setParameter('level', Constants::TOP_LEVEL_CATEGORY)
                        ->setParameter('equipment', Constants::CONSTRUCTION_EQUIPMENT)
                        ->setParameter('parts', Constants::SPARE_PARTS)
                        ->setParameter('tools', Constants::HAND_TOOLS)
                        ->orderBy('pc.rank', 'ASC')
                        ->getQuery()
                        ->getResult();
    }

    public function findEquipmentTopLevelCategories($isQueryBuilder = FALSE) {
        $qb = $this
                ->createQueryBuilder('pc')
                ->where('pc.level = :level')
                
                ->andWhere('pc.name = :equipment OR pc.name = :parts OR pc.name = :tools')
                ->setParameter('level', Constants::TOP_LEVEL_CATEGORY)
                ->setParameter('equipment', Constants::CONSTRUCTION_EQUIPMENT)
                ->setParameter('parts', Constants::SPARE_PARTS)
                ->setParameter('tools', Constants::HAND_TOOLS)
                ->orderBy('pc.rank', 'ASC');
        return $isQueryBuilder ? $qb : $qb->getQuery()->getResult();
    }

    public function findAllEquipmentCategories($isQueryBuilder = FALSE) {
        $qb = $this
                ->createQueryBuilder('pc') 
                ->leftJoin('pc.parent', 'p')
                ->where('p.name = :equipment OR p.name = :tools')                
                ->setParameter('equipment', Constants::CONSTRUCTION_EQUIPMENT)
                ->setParameter('tools', Constants::HAND_TOOLS)
                ->orderBy('pc.name', 'ASC');
        return $isQueryBuilder ? $qb : $qb->getQuery()->getResult();
    }

    public function findTopLevelCategories() {
        return $this
                        ->createQueryBuilder('pc')
                        ->where('pc.level = :level')
                        ->setParameter('level', Constants::TOP_LEVEL_CATEGORY)
                        ->orderBy('pc.rank', 'ASC')
                        ->getQuery()
                        ->getResult();
    }

    public function findProductCategorySidebarItems($parentName) {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :parentName')
                        ->setParameter('parentName', $parentName)
                        ->getQuery()
                        ->getResult();
    }

    public function findProductCategory($name) {
        return $this->createQueryBuilder('pc')
                        ->where('pc.name = :name')
                        ->setParameter('name', $name)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    public function findProductSubCategoriesQry($parentName) {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :parentName')
                        ->setParameter('parentName', $parentName);
    }

    public function findProductSubCategories($parentName = null, $topLevelCategory = null) {
        if ($topLevelCategory == null) {
            return $this->createQueryBuilder('pc')
                            ->leftJoin('pc.parent', 'p')
                            ->where('p.name = :parentName')
                            ->setParameter('parentName', $parentName)
                            ->setMaxResults(8)
                            ->getQuery()
                            ->getResult();
        } else {
            switch ($topLevelCategory) {
                case Constants::CONSTRUCTION_EQUIPMENT_SLUG:
                    return $this->getEquipmentAndToolsSubcategories();
                case Constants::MATERIALS_AND_SUPPLIES_SLUG:
                    return $this->getMaterialsAndSuppliesSubcategories();
                case Constants::INTERIOR_EXTERIOR_DECOR_SLUG:
                    return $this->getInteriorAndExteriorDecorSubcategories();
                case Constants::DOORS_AND_FURNITURE_SLUG:
                    return $this->getDoorsAndFurnitureSubcategories();
                case Constants::SPARE_PARTS_SLUG:
                    return $this->getSparePartsSubcategories();
                case Constants::LIGHTING_AND_SECURITY_SLUG:
                    return $this->getLightingSubcategories();
                default:
                    break;
            }
            return $this->createQueryBuilder('pc');
        }
    }

    private function getInteriorAndExteriorDecorSubcategories() {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :interior OR p.name = :exterior')
                        ->setParameter('interior', Constants::INTERIOR_DECOR)
                        ->setParameter('exterior', Constants::EXTERIOR_DECOR)
                        ->setMaxResults(7)
                        ->getQuery()
                        ->getResult();
    }

    private function getMaterialsAndSuppliesSubcategories() {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :materials OR p.name = :supplies')
                        ->setParameter('materials', Constants::CONSTRUCTION_MATERIALS)
                        ->setParameter('supplies', Constants::SUPPLIES)
                        ->setMaxResults(8)
                        ->getQuery()
                        ->getResult();
    }

    private function getEquipmentAndToolsSubcategories() {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :equipment OR p.name = :tools')
                        ->setParameter('equipment', Constants::CONSTRUCTION_EQUIPMENT)
                        ->setParameter('tools', Constants::HAND_TOOLS)
                        ->setMaxResults(8)
                        ->getQuery()
                        ->getResult();
    }

    private function getDoorsAndFurnitureSubcategories() {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :doors')
                        ->setParameter('doors', Constants::DOORS_AND_FURNITURE)
                        ->setMaxResults(8)
                        ->getQuery()
                        ->getResult();
    }

    private function getSparePartsSubcategories() {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :spareParts')
                        ->setParameter('spareParts', Constants::SPARE_PARTS)
                        ->setMaxResults(8)
                        ->getQuery()
                        ->getResult();
    }

    private function getLightingSubcategories() {
        return $this->createQueryBuilder('pc')
                        ->leftJoin('pc.parent', 'p')
                        ->where('p.name = :lighting')
                        ->setParameter('lighting', Constants::LIGHTING_AND_SECURITY)
                        ->setMaxResults(8)
                        ->getQuery()
                        ->getResult();
    }

    public function findPaginatedCategories() {
        return $this
                        ->createQueryBuilder('pc')
                        ->orderBy('pc.name', 'ASC')
                        ->getQuery();
    }

}
