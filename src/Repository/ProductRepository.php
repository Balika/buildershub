<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Supplier;
use App\Utils\Constants;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductRepository
 *
 * @author Edmond
 */
class ProductRepository extends EntityRepository {

    public function findAllQry($supplier = null) {
        return $this
                        ->createQueryBuilder('p')
                        ->leftJoin('p.supplier', 's')
                        ->where('s = :supplier')
                        ->setParameter('supplier', $supplier)
                        ->orderBy('p.name', 'ASC');
    }

    public function findMerchantProductsQry(Supplier $supplier) {
        return $this
                        ->createQueryBuilder('p')
                        ->leftJoin('p.supplier', 's')
                        ->where('s.id = :supplierId')
                        ->setParameter('supplierId', $supplier->getId())
                        ->orderBy('p.name', 'ASC');
    }

    public function findCategoryProducts($category, $supplier = null) {
        $categoryId = $category->getId();
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where($qb->expr()->like('p.categories', $qb->expr()->literal("%$categoryId%")))// p.id > 0 here is meaningless. Only added to avoid syntax  error if supplier = null                 
                        ->getQuery()
                        ->getResult();
    }

    public function findTagProducts($tag, $supplier = null) {
        $tagId = $tag->getId();
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where($supplier != null ? 'p.supplier = :supplier' : 'p.id > 0')// p.id > 0 here is meaningless. Only added to avoid syntax  error if supplier = null  
                        ->andWhere($qb->expr()->like('p.tags', $qb->expr()->literal("%$tagId%")))
                        ->setParameter($supplier != null ? array('supplier' => $supplier) : [])
                        ->getQuery()
                        ->getResult();
    }

    public function findMerchantProducts($supplier) {
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where('p.supplier = :supplier')
                        ->setParameter('supplier', $supplier)
                        ->getQuery()
                        ->getResult();
    }

    public function findSupplies() {
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where('p.productGroup = :productGroup')
                        ->getQuery()
                        ->setParameter("productGroup", "Supplies")
                        ->getResult();
    }

    public function findBuildingMaterialsSupplies() {
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where('p.productGroup = :productGroup')
                        ->setParameter("productGroup", "Supplies")
                        ->getQuery()
                        ->getResult();
    }

    public function findPaginatedProducts($supplier = null, $category = null, $categories = null) {
        $qb = $this->createQueryBuilder('p');
        $literalEpx = '';
        $parameters = [];
        if ($category != null) {
            $subCategories = [];
            foreach ($category->getSubCategories() as $subCat) {
                $subCategories[] = $subCat->getId();
            }
            $literalEpx = implode(',', $subCategories);
        }
        if ($categories != null) {
            $literalEpx = $categories;
        }
        $qb->where('p.category = :category');
        $parameters['category'] = $category;
        $qb->orWhere('p.categories LIKE :categories');
        $parameters['categories'] = '%' . $literalEpx . '%';
        if ($supplier != null) {
            $qb->andWhere('p.supplier = :supplier');
            $parameters['supplier'] = $supplier;
        }
        return $qb->setParameters($parameters)
                        ->getQuery();
    }

    public function filterByLocationPaginated($category = null, $region = null, $town = null, $subLocation = null, $categories = []) {
        $literalEpx = '';
        $parameters = [];
        $qb = $this->createQueryBuilder('p')
                ->leftJoin('p.supplier', 's');
        if ($category != null) {
            $subCategroies = [];
            foreach ($category->getSubCategories() as $subCat) {
                $subCategroies[] = $subCat->getId();
            }
            $qb->where('p.category = :category');
            $parameters['category'] = $category;
            $categories = implode(',', $subCategroies);
            if ($category->getLevel() > 1) {
                $qb->orWhere('p.categories LIKE :subCat');
                $parameters['subCat'] = '%' . $category->getId() . '%';
            }
        }
        if (!empty($categories)) {
            $literalEpx = $categories;
            $qb->orWhere('p.categories  LIKE :categories');
            $parameters['categories'] = '%' . $literalEpx . '%';
        }


        if ($region != null) {
            $qb->andWhere('s.region = :region');
            $parameters['region'] = $region;
        }
        if ($town != null) {
            $qb->andWhere('s.businessLocation = :town');
            $parameters['town'] = $town;
        }
        if ($subLocation != null) {
            $qb->andWhere('s.subLocation = :subLocation');
            $parameters['subLocation'] = $subLocation;
        }
        return $qb->setParameters($parameters)
                        ->getQuery();
    }

    public function findProducts($supplier = null, $category = null, $categories = null) {
        $qb = $this->createQueryBuilder('p');
        $literalEpx = '';
        $parameters = [];
        if ($category != null) {
            $qb->where('p.category = :category');
            $parameters['category'] = $category;
            $subCategroies = [];
            foreach ($category->getSubCategories() as $subCat) {
                $subCategroies[] = $subCat->getId();
            }
            $literalEpx = implode(',', $subCategroies);
            $qb->orWhere($qb->expr()->like('p.categories', $qb->expr()->literal("%$literalEpx%")));
        }
        if ($categories != null) {
            $literalEpx = $categories;
            $qb->andWhere($qb->expr()->like('p.categories', $qb->expr()->literal("%$literalEpx%")));
        }
        if ($supplier != null) {
            $qb->andWhere('p.supplier = :supplier');
            $parameters['supplier'] = $supplier;
        }
        return $qb      ->setParameters($parameters)
                        ->getQuery()
                        ->getResult();
    }

    public function productsFilterPaginated($supplier, $category = null, $brand = null, $minPrice = null, $maxPrice = null) {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productData', 'pd');
        $literalEpx = '';
        $parameters = null;
        $qb->where('p.supplier = :supplier');
        $parameters['supplier'] = $supplier;
        if ($category != null) {
            $qb->andWhere('p.category = :category');
            $parameters['category'] = $category;
            $subCategroies = [];
            foreach ($category->getSubCategories() as $subCat) {
                $subCategroies[] = $subCat->getId();
            }

            $literalEpx = implode(',', $subCategroies);
            if ($category->getLevel() > 1) {
                $qb->orWhere('p.categories LIKE :subCat'); // p.id > 0 here is meaningless. Only added to avoid syntax  error if supplier = null   
                $parameters['subCat'] = '%' . $literalEpx . '%';
            }
        }

        if ($brand != null) {
            $parameters['brand'] = $brand;
            $qb->andWhere('p.name != :brand');
        }
        if ($minPrice != null) {
            $parameters['minPrice'] = $minPrice;
            $qb->andWhere('pd.salePrice >= :minPrice');
        }
        if ($maxPrice != null) {
            $parameters['maxPrice'] = $maxPrice;
            $qb->andWhere('pd.salePrice <= :maxPrice');
        }
        if (!is_array($parameters))
            $parameters = [];

        return $qb->setParameters($parameters)
                        ->getQuery();
    }

    public function findRelatedProducts(Product $product, $supplier = null, $category = null, $categories = null) {
        $qb = $this->createQueryBuilder('p');
        $literalEpx = '';

        if ($category != null) {
            $literalEpx = $category->getId();
        } else if ($categories != null) {
            $literalEpx = $categories;
        } else {
            $literalEpx = $product->getCategories();
        }
        $parameters = array('product' => $product);
        return $qb
                        ->where('p != :product')// p.id > 0 here is meaningless. Only added to avoid syntax  error if supplier = null  
                        ->andWhere(($category != null || $categories != null) ? $qb->expr()->like('p.categories', $qb->expr()->literal("%$literalEpx%")) : 'p.id > 0 ')
                        ->setParameters($parameters)
                        ->getQuery()
                        ->getResult();
    }

    public function findFeaturedProducts($supplier = null, $limit = 100) {
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where($supplier != null ? 'p.supplier = :supplier' : 'p.id > 0')// p.id > 0 here is meaningless. Only added to avoid syntax  error if supplier = null  
                        ->andWhere('p.isFeatured=TRUE')
                        ->setParameters($supplier != null ? array('supplier' => $supplier) : array())
                        ->setMaxResults($limit)
                        ->getQuery()
                        ->getResult();
    }

    /**
     * 
     * @param type $supplier
     * @param type $limit
     * @return array of Product objects
     * @Description  This picks up a list of products marked as new arrivals either by supplier or for all suppliers
     */
    public function findNewProducts($supplier = null, $limit = 100) {
        $qb = $this->createQueryBuilder('p');
        return $qb
                        ->where($supplier != null ? 'p.supplier = :supplier' : 'p.id > 0')// p.id > 0 here is meaningless. Only added to avoid syntax  error if supplier = null  
                        ->andWhere('p.isNewArrival=TRUE')
                        ->setParameters($supplier != null ? array('supplier' => $supplier) : array())
                        ->setMaxResults($limit)
                        ->getQuery()
                        ->getResult();
    }

    public function searchProductsPaginated($searchTerm, $category, $region = null, $town = null, $brand = null) {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.supplier', 'v');
        $qb->leftJoin('p.category', 'c');
        $qb->leftJoin('v.region', 'r');
        $qb->leftJoin('v.businessLocation', 't');
        $qb->where($qb->expr()->like('p.name', $qb->expr()->literal("%$searchTerm%")))
                ->orWhere($qb->expr()->like('p.description', $qb->expr()->literal("%$searchTerm%")))
                ->orWhere($qb->expr()->like('p.slug', $qb->expr()->literal("%$searchTerm%")));
        $params = [];
        if ($category != null) {
            $qb->andWhere('c = :category');
            $params['category'] = $category;
            $subCategories = [];
            foreach ($category->getSubCategories() as $subCat) {
                $subCategories[] = $subCat->getId();
            }
            $literalEpx = implode(',', $subCategories);
            $qb->orWhere('p.categories LIKE :subCat');
            $params['subCat'] = '%' . $literalEpx . '%';
        }
        if ($region != null && $region != 'all-regions') {
            $qb->andWhere('r = :region');
            $params['region'] = $region;
        }
        if ($town != null && $town != 'all-towns') {
            $qb->andWhere('t = :town');
            $params['town'] = $town;
        }
        if ($brand != null && $brand != 'all-brands') {
            $qb->andWhere('p.model = :brand');
            $params['brand'] = $brand;
        }
        return $qb->setParameters($params)
                        ->getQuery();
    }

    public function findMostViewedProducts($supplier = null, $limit = 24) {
        $qb = $this->createQueryBuilder('p');
        $params = [];
        $qb->where('p.views > 0');
        if ($supplier != null) {
            $qb->andWhere('p.supplier = :supplier');
            $params['supplier'] = $supplier;
            $qb->setParameters($params);
        }
        return $qb
                        ->setMaxResults($limit)
                        ->orderBy('p.views', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

    public function findMostViewedProductsPaginated($category = null, $region = null, $town = null) {
        $qb = $this->createQueryBuilder('p')
                ->leftJoin('p.supplier', 'v')
                ->leftJoin('v.region', 'r')
                ->leftJoin('v.businessLocation', 't')
                ->where('p.views > 0');
        $params = [];
        if ($category != null) {
            $qb->andWhere('p.category = :category');
            $params['category'] = $category;
        }
        if ($region != null && $region != 'all-regions') {
            $qb->andWhere('r = :region');
            $params['region'] = $region;
        }
        if ($town != null && $town != 'all-towns') {
            $qb->andWhere('t = :town');
            $params['town'] = $town;
        }
        return $qb->setParameters($params)
                        ->orderBy('p.views', 'DESC')
                        ->getQuery();
    }

    public function findParentCategoryProducts($category) {//This is for the broad product category supported on Cipron
        switch ($category) {
            case Constants::EQUIPMENT_AND_TOOLS_SLUG:
                return $this->getEquipmentAndToolsProducts();
            case Constants::MATERIALS_AND_SUPPLIES_SLUG:
                return $this->getMaterialsAndSuppliesProducts();
            case Constants::INTERIOR_EXTERIOR_DECOR_SLUG:
                return $this->getInteriorAndExteriorDecorProducts();
            case Constants::DOORS_AND_FURNITURE_SLUG:
                return $this->getDoorsAndFurnitureProducts();
            default:
                break;
        }
        return $this->createQueryBuilder('p')->getQuery();
    }

    private function getEquipmentAndToolsProducts() {
        return $this->createQueryBuilder('p')
                        ->where('p.productGroup = :productGroup')
                        ->setParameter("productGroup", Constants::CONSTRUCTION_EQUIPMENT)
                        ->getQuery();
    }

    private function getMaterialsAndSuppliesProducts() {
        return $this->createQueryBuilder('p')
                        ->where('p.productGroup = :productGroup1 OR p.productGroup = :productGroup2')
                        ->setParameter("productGroup1", Constants::CONSTRUCTION_MATERIALS)
                        ->setParameter("productGroup2", Constants::SUPPLIES)
                        ->getQuery();
    }

    private function getInteriorAndExteriorDecorProducts() {
        return $this->createQueryBuilder('p')
                        ->where('p.productGroup = :productGroup1 OR p.productGroup = :productGroup2')
                        ->setParameter("productGroup1", Constants::INTERIOR_DECOR)
                        ->setParameter("productGroup2", Constants::EXTERIOR_DECOR)
                        ->getQuery();
    }

    private function getDoorsAndFurnitureProducts() {
        return $this->createQueryBuilder('p')
                        ->where('p.productGroup = :productGroup1')
                        ->setParameter("productGroup1", Constants::DOORS_AND_FURNITURE)
                        ->getQuery();
    }

}
