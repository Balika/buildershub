<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

use App\Services\PersistenceService;

/**
 * Description of HubUtil
 *
 * @author Balika
 */
class HubUtil {

    private $persistenceService;
    protected static $regions;
    protected static $towns;
    protected static $sparePartsCities;

    public function __construct(PersistenceService $persistenceService) {
        $this->persistenceService = $persistenceService;
    }

    public static function generateRandomString($length = 8) {
        $characters = "abcdefghijklmnopqrstuvwxyz0123456789";
        $randomPassword = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[mt_rand(0, $max)];
        }
        return $randomPassword;
    }

    public function getRegions() {
        if (self::$regions == null || count(self::$regions) < 1) {
            self::$regions = $this->persistenceService->getRepository(EntityConfig::REGION)->findAll();
        }
        return self::$regions;
    }

    public function getRegion($id) {
        return is_numeric($id) ? $this->persistenceService->getRepository(EntityConfig::REGION)->find($id) :
                $this->persistenceService->getRepository(EntityConfig::REGION)->findOneBy(['slug' => $id]);
    }

    public function getCategory($id) {
        return is_numeric($id) ? $this->persistenceService->getRepository(EntityConfig::PRODUCT_CATEGORY)->find($id) :
                $this->persistenceService->getRepository(EntityConfig::PRODUCT_CATEGORY)->findOneBy(['slug' => $id]);
    }

    public function getTowns($region) {
        if (self::$towns == null || count(self::$towns) < 1) {
            self::$towns = $this->persistenceService->getRepository(EntityConfig::TOWN)->findBy(['region' => $region]);
        }
        return self::$towns;
    }

    public function getTown($id) {
        return is_numeric($id) ? $this->persistenceService->getRepository(EntityConfig::TOWN)->find($id) :
                $this->persistenceService->getRepository(EntityConfig::TOWN)->findOneBy(['slug' => $id]);
    }

    public function getAllEquipmentCategories() {
        return $this->persistenceService->getRepository(EntityConfig::PRODUCT_CATEGORY)->findAllEquipmentCategories();
    }

    public function getSparePartsCities() {
        if (self::$sparePartsCities == null || count(self::$sparePartsCities) < 1) {
            self::$sparePartsCities = $this->persistenceService->getRepository(EntityConfig::TOWN)->findBy(['isSparePartsHub' => TRUE]);
        }
        return self::$sparePartsCities;
    }

    public static function internationalizePhoneNumber($contactNo, $countryCode = null) {
        return preg_replace('/^0/', $countryCode != null ? $countryCode : Constants::DEFAULT_COUNTRY_PHONE_CODE, $contactNo);
    }

    public static function getNameAbbr($name) {
        foreach (preg_split('#[^a-z]+#i', $name, -1, PREG_SPLIT_NO_EMPTY) as $word) {
            $result .= $word[0];
        }
        return $result;
    }

}
