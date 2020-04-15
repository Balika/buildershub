<?php

namespace App\Utils;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Constants
 *
 * @author Edmond
 */
class Constants {

    const TOP_LEVEL_CATEGORY=1;
    const SECOND_LEVEL_CATEGORY=2;
    
    //USER Types
    const ARTISAN = "ARTISAN";
    const FIRM_OWNER = "FIRM_OWNER";
    const PUBLIC_USER = "PUBLIC";
    const PROFESSIONAL = "PROFESSIONAL";
    const STUDENT = "STUDENT";
    const SUPPLIER = "SUPPLIER";
    const DEFAULT_PAGE_SIZE = 10;
    
    const DEFAULT_COUNTRY_PHONE_CODE="+233";
    /**
     * Firm Type codes
     */
    const MERCHANT = "MERCHANT";
    const CONTRACTOR = "CONTRACTOR";
    const CONSULTANT = "CONSULTANT";
    const ARTISANAL = "ARTISANAL";
    
    const SPARE_PARTS_DEALERS = "SPARE_PARTS";
    const ORDER_NUMBER_PREFIX = "BHUBORDER-";
    const PRICE_QUOTATION_PREFIX = "PQR-";
    const PRICE_RQUEST_PREFIX = "PLR-";
    
    //FILE NAMES
    const USER_PAGE_DASHBOARD = "dashboard";
    const USER_PAGE_CONVERSATIONS = "conversations";
    const USER_PAGE_MY_PROJECTS = "my-projects";
    const USER_PAGE_MY_QUESTIONS = "my-questions";
    const USER_PAGE_MY_SNAP_SHARE = "my-snap-share";
    const USER_PAGE_MY_POSTS = "my-posts";
    const USER_PROFILE_PAGE_SUFFIX = 'Secure/user-profile/';
    const TPL_SUFFIX = ".html.twig";
    const ARTISAN_HOME = "artisan.home";
    const PROFESSIONAL_HOME = "professional.home";
    const STUDENT_HOME = "student.home";
    const PUBLIC_USER_HOME = "public.user.home";
    
    //PRODUCT GROUP CIPRON SUPPORTS - used in main menu display
    const CONSTRUCTION_EQUIPMENT = "Construction Equipment";
    const CONSTRUCTION_MATERIALS = "Construction Materials & Accessories";
    const SUPPLIES = "Material Supplies & Products";
    const SPARE_PARTS = "Equipment Spare Parts";
    const INTERIOR_DECOR = "Interior Decor";
    const EXTERIOR_DECOR = "Exterior Decor";
    const DOORS_AND_FURNITURE = "Doors & Furniture";
    const HAND_TOOLS = 'Hand Tools & Accessories';
    const LIGHTING_AND_SECURITY = 'Lighting & Security';
    
    //PRODUCT GROUP CIPRON SUPPORTS
    const CONSTRUCTION_EQUIPMENT_SLUG = "construction-equipment";
    const MATERIALS_AND_SUPPLIES_SLUG = "building-materials-and-supplies";
    const MACHINERY_PARTS_SLUG = "machniery-and-equipment-spare-parts";
    const INTERIOR_EXTERIOR_DECOR_SLUG = "interior-and-exterior-decor";
    const DOORS_AND_FURNITURE_SLUG = "doors-and-furniture";
    const LIGHTING_AND_SECURITY_SLUG = "lighting-and-security-slug";
    const SPARE_PARTS_SLUG = "equipment-spare-parts";
    
    
    //PROJECT TYPES
    const NEW_PROJECT = "New Project";
    const MINOR_REPAIRS = "Minor Repair Works";
    const MAJOR_REHABILITATION = "Major Rehabilitation Works";
    
    //UPLOADS DIR 
    const CONTENT_UPLOAD_DIR = '/../public/uploads/content';
    const PRODUCT_UPLOAD_DIR = '/../public/uploads/products';
    const PROFILE_UPLOAD_DIR = '/../public/uploads/profile';
    const COVER_UPLOAD_DIR = '/../public/uploads/cover';
    const EQUIPMENT_UPLOAD_DIR = '/../public/uploads/equipment';
    const LOGOS_UPLOAD_DIR = '/../public/uploads/logos';
    const BACKEND_UPLOAD_DIR = '/../public/uploads/backend';
    const USER_TPL_PREFIX = "Secure/Includes/user.";
    const USER_HOME_TPL_PREFIX = "Secure/Includes/";
    
    //########## ADS SLOTS CODES ##################
    const PREMIUM_PRODUCT="PREMIUM_PRODUCT";
    const TOP_SUPPLIER="TOP_SUPPLIER";
    const SUPPLIER_INTRO="SUPPLIER_INTRO";
    const SUPPLIER_TRAIL="SUPPLIER_TRAIL";
    const SUPPLIER_WEEKLY_DEALS="SUPPLIER_WEEKLY_DEALS";
    const WEEKLY_DEALS="WEEKLY_DEALS";
    
    const TWILIO_SMS_NUMBER ="+18627019196";
    const SENDER_EMAIL_ACCOUNT="balikaem@gmail.com";
    const APP="BuildersHub";
    
    //################# IPSTACK WEB SERVICICES API ###################
    const IP_STACK_BASE_URL = "http://api.ipstack.com/";
    
    

}
