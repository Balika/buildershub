-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2020 at 04:20 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `builders_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_tracker`
--

CREATE TABLE `activity_tracker` (
  `id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `entity` varchar(255) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `is_reacted` tinyint(1) NOT NULL DEFAULT '0',
  `reactions` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_tracker`
--

INSERT INTO `activity_tracker` (`id`, `actor_id`, `recipient_id`, `entity`, `entity_id`, `is_reacted`, `reactions`, `created_at`, `updated_at`) VALUES
(11, 376, 376, 'App:ServiceRequest', 5, 0, 'N;', '2018-06-18 11:20:14', '2018-06-18 09:20:15'),
(12, 376, NULL, 'App:Work', 12, 0, 'N;', '2018-06-20 12:31:52', '2018-06-20 10:31:52'),
(13, 376, NULL, 'App:Work', 13, 0, 'N;', '2018-08-10 18:08:15', '2018-08-10 16:08:16'),
(14, 376, 390, 'App:ServiceRequest', 6, 0, 'N;', '2018-12-10 17:13:07', '2018-12-10 16:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `advertiser`
--

CREATE TABLE `advertiser` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_menu_item`
--

CREATE TABLE `app_menu_item` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `route` varchar(55) NOT NULL,
  `label` varchar(55) NOT NULL,
  `app_id` int(11) NOT NULL,
  `code` varchar(55) NOT NULL,
  `icon` varchar(55) DEFAULT NULL,
  `description` text,
  `rank` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_menu_item`
--

INSERT INTO `app_menu_item` (`id`, `user_id`, `route`, `label`, `app_id`, `code`, `icon`, `description`, `rank`, `is_enabled`) VALUES
(1, 376, 'hubernize_new_diary_entry', 'Add New Item', 1, 'New_Diary_Entry', NULL, NULL, 2, 1),
(2, 376, 'hubernize_diary_entries', 'Diary Entries', 1, 'Diary_Entries', NULL, NULL, 1, 1),
(3, 376, 'hubernize_list_projects', 'List Projects', 3, 'List_Projects', NULL, NULL, 1, 1),
(4, 376, 'hubernize_list_equipment', 'List Equipment & Plants', 2, 'List_Equipment', NULL, NULL, 2, 1),
(5, 376, 'hubernize_view_suppliers', 'View Suppliers', 4, 'View_Suppliers', NULL, NULL, 1, 1),
(6, 376, 'list_staff', 'Staff List', 9, 'Staff_List', NULL, NULL, 1, 1),
(7, 376, 'add_staff', 'Add Staff', 9, 'Add_Staff', NULL, NULL, 2, 1),
(8, 376, 'products', 'Products', 10, 'Products', NULL, NULL, 1, 1),
(9, 376, 'add_product', 'Add Product', 10, 'Add_Product', NULL, NULL, 2, 1),
(10, 376, 'product_categories', 'Product Categories', 10, 'Categories', NULL, NULL, 3, 1),
(11, 376, 'product_tags', 'Tags', 10, 'Tags', NULL, NULL, 4, 1),
(12, 376, 'store_campaigns_and_promos', 'Campaigns & Promos', 10, 'Campaigns', NULL, NULL, 5, 1),
(13, 376, 'open_bids', 'Bid Slots', 10, 'Bid_Slots', NULL, NULL, 6, 1),
(14, 376, 'store_orders', 'Orders', 10, 'Orders', NULL, NULL, 7, 1),
(15, 376, 'properties', 'Properties', 11, 'Properties', NULL, NULL, 1, 1),
(16, 376, 'add_property', 'Add Property', 11, 'Add_Property', NULL, NULL, 2, 1),
(17, 376, 'hubernize_rental_ads', 'Advertise for Rent', 2, 'Rental_Ads', NULL, 'List equipment that are on advertisement fro rent', 2, 1),
(18, 376, 'hubernize_ads_promo', 'Promote Ads', 2, 'Rentals_Ads_Promo', NULL, 'Promote equipment that are advertise for rental to give them more visibility', 3, 1),
(19, 376, 'hubernize_rental_requests', 'Manage Rental Requests', 2, 'Rental_Requests', NULL, 'List incoming equipment rental requests', 4, 1),
(20, 376, 'hubernize_rented_out', 'Track Equipt on Rent', 2, 'Rented_Out', NULL, NULL, 5, 1),
(21, 376, 'hubernize_equipment_movement', 'Manage Equipt Movement', 2, 'Equipt_Movement', NULL, NULL, 6, 1),
(22, 376, 'hubernize_rental_clients', 'Manage Clients', 2, 'Rental_Clients', NULL, NULL, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_subscription`
--

CREATE TABLE `app_subscription` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subscription_type` varchar(55) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_subscription`
--

INSERT INTO `app_subscription` (`id`, `company_id`, `app_id`, `user_id`, `subscription_type`, `created_at`, `updated_at`) VALUES
(1, 22, 2, 376, 'SingleModule', '2019-12-16 23:22:54', '2019-12-16 22:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

CREATE TABLE `association` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `institution_id` int(11) NOT NULL,
  `membership_id` varchar(55) DEFAULT NULL,
  `membership_title` varchar(55) DEFAULT NULL,
  `date_joined` datetime DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`id`, `company_id`, `user_id`, `institution_id`, `membership_id`, `membership_title`, `date_joined`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, NULL, 376, 1, '08332', 'MGhIE', '2015-06-15 00:00:00', 0, '2018-08-22 15:50:33', '2018-08-22 13:54:42'),
(2, 22, 376, 1, '123445', 'Member', '2018-06-12 00:00:00', 0, '2019-01-06 20:00:58', '2019-01-06 19:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE `award` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `gallery` text,
  `award_date` datetime NOT NULL,
  `awarding_organisation` varchar(255) NOT NULL,
  `place_of_award` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `award`
--

INSERT INTO `award` (`id`, `company_id`, `user_id`, `name`, `slug`, `picture`, `gallery`, `award_date`, `awarding_organisation`, `place_of_award`, `created_at`, `updated_at`) VALUES
(5, NULL, 376, 'Best AutoCAD 3D Designer of the Year', 'best-autocad-3d-designer-of-the-year', NULL, 'N;', '2017-07-20 00:00:00', 'Ghana Institution of Engineering', 'Golden Tulip Hotel', '2018-08-21 21:12:08', '2018-08-21 19:12:08'),
(7, 22, 376, 'Best Supplier of the Year -2017', 'best-supplier-of-the-year-2017', NULL, 'N;', '2017-06-06 00:00:00', 'Ghana Association Building Materials Suppliers', 'Trade Fair Center', '2019-01-06 19:34:02', '2019-01-06 18:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_post`
--

INSERT INTO `blog_post` (`id`, `category_id`) VALUES
(1, NULL),
(2, NULL),
(6, 79);

-- --------------------------------------------------------

--
-- Table structure for table `builder`
--

CREATE TABLE `builder` (
  `id` int(11) NOT NULL,
  `profession_id` int(11) DEFAULT NULL,
  `services` longtext,
  `client_type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `builder`
--

INSERT INTO `builder` (`id`, `profession_id`, `services`, `client_type`, `created_at`, `updated_at`) VALUES
(2, 6, 'a:3:{i:0;s:7:\"ARTISAN\";i:1;s:12:\"PROFESSIONAL\";i:2;s:0:\"\";}', NULL, '0000-00-00 00:00:00', '2018-06-10 16:42:11'),
(10, NULL, NULL, NULL, '0000-00-00 00:00:00', '2018-10-13 14:19:36'),
(14, NULL, NULL, NULL, '0000-00-00 00:00:00', '2018-11-03 20:47:24'),
(20, NULL, NULL, NULL, '0000-00-00 00:00:00', '2019-05-17 12:25:11'),
(22, NULL, NULL, NULL, '0000-00-00 00:00:00', '2019-05-17 14:39:12'),
(24, NULL, NULL, NULL, '0000-00-00 00:00:00', '2019-05-17 14:47:09'),
(26, NULL, NULL, NULL, '0000-00-00 00:00:00', '2019-05-17 14:57:15'),
(28, NULL, NULL, NULL, '0000-00-00 00:00:00', '2019-05-17 15:14:01'),
(36, NULL, NULL, NULL, '0000-00-00 00:00:00', '2019-12-12 15:42:15'),
(37, NULL, NULL, NULL, '0000-00-00 00:00:00', '2019-12-12 17:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `builder_overall_rating`
--

CREATE TABLE `builder_overall_rating` (
  `id` int(11) NOT NULL,
  `builder_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `symbol` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `builder_rating`
--

CREATE TABLE `builder_rating` (
  `id` int(11) NOT NULL,
  `builder_id` int(11) NOT NULL,
  `measure_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `symbol` varchar(2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `builder_rating`
--

INSERT INTO `builder_rating` (`id`, `builder_id`, `measure_id`, `rating`, `symbol`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'r1', 376, '2018-10-02 17:49:26', '2018-10-02 15:52:07'),
(2, 2, 2, 3, 'r3', 376, '2018-10-02 17:49:26', '2018-10-02 15:52:07'),
(3, 2, 3, 2, 'r2', 376, '2018-10-02 17:49:26', '2018-10-02 15:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `builder_rating_summary`
--

CREATE TABLE `builder_rating_summary` (
  `id` int(11) NOT NULL,
  `builder_id` int(11) NOT NULL,
  `measure_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `symbol` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `builder_specialty`
--

CREATE TABLE `builder_specialty` (
  `builder_id` int(11) NOT NULL,
  `specialty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `builder_specialty`
--

INSERT INTO `builder_specialty` (`builder_id`, `specialty_id`) VALUES
(2, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(55) DEFAULT NULL,
  `description` text,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `banner` text,
  `discount_rate` double(10,3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`id`, `company_id`, `user_id`, `name`, `type`, `description`, `start_date`, `end_date`, `banner`, `discount_rate`, `created_at`, `updated_at`) VALUES
(1, 22, 376, 'Christmas Bonanza Discounted Sales', 'Discount Campaign', 'This is to reward our loyal customers during the Christmas period', NULL, NULL, 'e8cc86f50bd097fae322d76f860ff789.jpeg', 20.000, NULL, '2018-06-24 14:00:53'),
(2, 22, 376, 'Buy One Get One Free', 'Discount Campaign', 'Double value promotion to reward our loyal customers', '1923-03-22 00:00:00', '1923-04-28 00:00:00', '7ab83da866281fa750c2749d9961c137.png', 20.000, NULL, '2018-06-24 14:00:58'),
(3, 22, 376, 'Yen Twi Ko', 'Discount Campaign', 'Double value promotion to reward our loyal customers', '1923-04-21 00:00:00', '1923-05-26 00:00:00', '4f179f90c153f130b1f49a1ab56fb4a4.png', 20.000, NULL, '2018-06-24 14:01:02'),
(4, 22, 376, 'Builder Pack Campaign', 'Discount Campaign', '15% on every GHc100 spent', '2019-03-06 00:00:00', '2019-04-30 00:00:00', NULL, 15.000, NULL, '2019-03-06 07:46:20'),
(5, 22, 376, 'Extra Tools', 'Discount Campaign', 'Get extra tools when you buy our heavy equipments', '2019-02-27 00:00:00', '2019-04-24 00:00:00', 'campaign_banner_.jpg', 20.000, '2019-03-06 07:53:05', '2019-03-06 07:53:14'),
(6, 22, 376, 'Yen Dea Promo', 'Discount Campaign', 'This is to promote locally manufactured tools', '2019-03-07 00:00:00', '2019-04-19 00:00:00', 'campaign_banner_eomuo5f6.jpg', 30.000, '2019-03-06 08:01:30', '2019-03-06 08:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `practitioner` varchar(55) DEFAULT NULL,
  `icon` varchar(55) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text,
  `type` varchar(55) DEFAULT 'Artisan',
  `is_quick_access` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `practitioner`, `icon`, `image`, `parent_id`, `description`, `type`, `is_quick_access`, `deleted`) VALUES
(1, 'Plumbing Works', 'plumbing-works', 'Plumber', 'fa-wheelchair', 'plumber.jpeg', NULL, NULL, 'ARTISAN', 0, 0),
(2, 'Masonry Works', 'masonry-works', 'Mason', 'fa-cube', 'mason.jpg', NULL, NULL, 'ARTISAN', 0, 0),
(3, 'Painter', 'painting', 'Painter', 'fa-paint-brush', 'painter.jpg', NULL, NULL, 'ARTISAN', 0, 0),
(4, 'Tiler', 'tiling', 'Tiler', ' fa-square', NULL, NULL, NULL, 'ARTISAN', 1, 0),
(5, 'Steel Bender', 'steel-bender', 'Steel Bender', ' fa-wrench', NULL, NULL, NULL, 'ARTISAN', 1, 0),
(6, 'Carpentry Works', 'carpentry-works', 'Carpenter', ' fa-legal ', 'carpenter_toolbox.png', NULL, NULL, 'ARTISAN', 0, 0),
(7, 'Carpenter', 'carpenter', 'Electrician', 'fa-plug', NULL, NULL, NULL, 'ARTISAN', 1, 0),
(8, 'Water Plumbing', 'water-plumbing', 'Plumber', NULL, NULL, 1, 'Installation, removal, repair and maintenance of hot and cold water pipes and fittings', 'ARTISAN', 0, 0),
(9, 'Sanitary Plumbing', 'sanitary-plumbing', 'Plumber', NULL, NULL, 1, 'Installation, removal, renewal, repair and maintenance of pipes, including ventilation of those pipes and fittings to receive and convey sewage', 'ARTISAN', 0, 0),
(10, 'Drainage', 'drainage', 'Plumber', NULL, NULL, 1, 'Installation, removal, repair and maintenance of stormwater and waste pipes and fittings', 'ARTISAN', 0, 0),
(11, 'Mechanical Services', 'mechanical-services', 'Plumber', NULL, NULL, 1, 'Work on heating, cooling or ventilation of buildings which may include installation, removal, repair and maintenance of pipes, valves, regulators, tanks, evaporative cooling, ventilation and air conditioning systems', 'ARTISAN', 0, 0),
(12, 'Roofing', 'roofing', 'Plumber', NULL, NULL, 1, 'Installation, renewal, repair and maintenance of roof coverings and roof water systems such as gutters, rainwater piping and downpipes', 'ARTISAN', 0, 0),
(13, 'Gas Services', 'gas-services', 'Plumber', NULL, NULL, 1, 'Installation, disconnection, repair and maintenance of pipes, fittings, appliances and associated ventilation equipment involving gases such as fuel, liquefied petroleum, manufactured and natural gases.', 'ARTISAN', 0, 0),
(14, 'Block Moulders', 'block-moulders', 'Mason', NULL, NULL, 2, NULL, 'ARTISAN', 1, 0),
(15, 'Building Construction', 'building-construction', 'Mason', NULL, NULL, 2, NULL, 'ARTISAN', 0, 0),
(16, 'Welder', 'welding', 'Welder', NULL, NULL, NULL, NULL, 'ARTISAN', 1, 0),
(17, 'Project Management', 'project-manager', 'Project Manager', NULL, NULL, NULL, 'To take control of our project', 'CONSULTANT', 0, 0),
(18, 'Brick Laying / Stone Masonry', 'brick-layer-stone-mason', 'Brick Layer / Stone Mason', NULL, NULL, 2, NULL, 'ARTISAN', 0, 0),
(19, 'Civil Engineering', 'civil-engineering', 'Civil Engineer', NULL, NULL, 23, NULL, 'CONSULTANT', 0, 0),
(20, 'Structural Design', 'structural-design', 'Structural Engineer', NULL, NULL, 19, NULL, 'CONSULTANT', 0, 0),
(21, 'Highway Design', 'highway-design', 'Highway Engineer', NULL, NULL, 19, NULL, 'CONSULTANT', 0, 0),
(23, 'Engineering Works', 'engineering-works', 'Engineer', NULL, NULL, NULL, NULL, 'CONSULTANT', 0, 0),
(24, 'Architectural Designs', 'architectural-designs', 'Architect', NULL, NULL, NULL, NULL, 'CONSULTANT', 0, 0),
(25, 'Quantity Surveying', 'quantity-surveying', 'Quantity Surveyor', NULL, NULL, NULL, NULL, 'CONSULTANT', 0, 0),
(26, 'Planning', 'planning', 'Planner', NULL, NULL, NULL, NULL, 'CONSULTANT', 0, 0),
(27, 'Cost Estimation', 'cost-estimation', 'Cost Estimator', NULL, NULL, NULL, NULL, 'CONSULTANT', 0, 0),
(28, 'Land Surveyors', 'land-surveyors', 'Land Surveyor', NULL, NULL, NULL, NULL, 'CONSULTANT', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `certs_obtained`
--

CREATE TABLE `certs_obtained` (
  `id` int(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `programme_of_study` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `details` text,
  `user_id` int(11) NOT NULL,
  `year_awarded` int(4) DEFAULT NULL,
  `start_study` int(4) NOT NULL,
  `end_study` int(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `certs_obtained`
--

INSERT INTO `certs_obtained` (`id`, `name`, `programme_of_study`, `institution`, `details`, `user_id`, `year_awarded`, `start_study`, `end_study`, `created_at`, `updated_at`) VALUES
(11, 'BSc. Civil Engineering', 'Civil Engineering', 'Kwame Nkrumah University of Science & Technology', 'Structural Engineering, Highway & Transportation engineering, Water Resources Engineering', 376, 2006, 2002, 2006, '2018-08-21 07:33:08', '2018-08-21 05:33:11'),
(12, 'Certificate in Software Development & Entrepreneurship', 'Software Development', 'Meltwater Entrepreneurial School of Technology (MEST)', 'Java & PHP Programming Languages,  MySQL and Postgres Database Management, Business plan writing', 376, 2010, 2008, 2010, '2018-08-21 14:47:50', '2018-08-21 12:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `domain` varchar(25) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `contact_person` int(11) DEFAULT NULL,
  `name` varchar(55) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `business_summary` text,
  `profile` text,
  `telephone_1` varchar(55) DEFAULT NULL,
  `mobile_1` varchar(55) DEFAULT NULL,
  `telephone_2` varchar(55) DEFAULT NULL,
  `mobile_2` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `url` varchar(55) DEFAULT NULL,
  `company_type` varchar(55) NOT NULL,
  `sub_type` varchar(225) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` varchar(55) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `business_location` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `sub_location` varchar(55) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `cover_picture` varchar(25) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `company_size` varchar(55) DEFAULT NULL,
  `vision` text,
  `mission` text,
  `history` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `domain`, `user_id`, `contact_person`, `name`, `slug`, `business_summary`, `profile`, `telephone_1`, `mobile_1`, `telephone_2`, `mobile_2`, `email`, `url`, `company_type`, `sub_type`, `created_at`, `updated_at`, `address`, `region_id`, `business_location`, `district_id`, `sub_location`, `logo`, `cover_picture`, `is_active`, `company_size`, `vision`, `mission`, `history`) VALUES
(21, 'ars', 376, NULL, 'Azaa Roofing Services', 'azaa-roofing-services', 'Design and installation of roofing systems', 'We design and install modern roofing systems using the latest in construction technology', '0302457899', '0246738954', NULL, NULL, 'info@ars.com', NULL, 'firm', NULL, '2018-06-10 18:42:11', '2018-06-10 16:42:11', NULL, 1, 8, NULL, 'Okpoi-Gonno', NULL, NULL, 1, '20 to 50', NULL, NULL, NULL),
(22, 'btl', 376, 376, 'Baseline Trading Ltd', 'baseline-trading-ltd', 'We are suppliers of building and construction materials for all categories of construction works. We design, project management, contract packaging, feasibility studies and more.', NULL, '030245786', '0246738954', NULL, NULL, 'balikaem@gmail.com', NULL, 'supplier', 'Supplier', '2018-06-24 11:14:45', '2019-12-17 18:51:58', 'P.O. Box 121', 1, 8, NULL, 'Okpoi-Gonno', NULL, NULL, 1, '20 to 50', 'To become the most customer-focused consulting firm in the delivery of engineering and architectural services in Africa and beyond', 'We exist to leverage the best in engineering innovation to give our clients the best solutions to their problems. Work with us', 'We started very small as a one man company in 2011 but crew steadily to a 200 permanent staff. We have branches all over Ghana and planning move to 2 other African countries in the nest 2 years'),
(24, 'dbm', 379, NULL, 'Dan-Chelle Building Materials', 'dan-chelle-building-materials', 'We sell building materials, hand tools and plumbing and sanitary accessories', NULL, NULL, '0546401593', NULL, NULL, NULL, NULL, 'supplier', NULL, '2018-07-25 17:35:48', '2018-07-25 17:35:48', NULL, 4, 3, NULL, 'Gumani', NULL, '5b5898d4d19e6336897913.pn', 1, '20 to 50', NULL, NULL, NULL),
(25, 'brel', 380, NULL, 'Baseline Real Estate Ltd', 'baseline-real-estate-ltd', 'We deal in real estates, apartment for rent and more', NULL, NULL, '0546401593', NULL, NULL, NULL, NULL, 'supplier', NULL, '2018-07-29 20:35:59', '2018-07-29 18:35:59', NULL, 2, 2, NULL, 'Suame', NULL, NULL, 1, '20 to 50', NULL, NULL, NULL),
(26, 'apw', 385, NULL, 'Atlas Plumbing Works', 'atlas-plumbing-works', 'We sell carpentry products', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'supplier', NULL, '2018-10-13 16:02:29', '2018-10-13 14:02:29', NULL, 1, 8, NULL, 'Shell Sign Board', NULL, NULL, 0, '10 to 20', NULL, NULL, NULL),
(31, 'spe', 399, NULL, 'SARPOK Plumbing Enterprise', 'sarpok-plumbing-enterprise', 'We supplier plumbing materials', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'supplier', NULL, '2019-05-17 17:14:00', '2019-05-17 17:14:01', NULL, 1, 4, NULL, 'Oyarifa, Richop Plaza', NULL, NULL, 0, 'Less Than 10', NULL, NULL, NULL),
(32, 'nde', 407, NULL, 'N-Dimension Engineering Ltd', 'n-dimension-engineering-ltd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'firm', NULL, '2019-11-27 14:47:35', '2019-11-27 14:47:35', NULL, 1, 7, NULL, 'Police Lane', NULL, NULL, 0, '10 to 20', NULL, NULL, NULL),
(35, NULL, 407, NULL, 'Mawuena Construction Ent.', 'mawuena-construction-ent', 'Into building and road construction', NULL, '059221134', '0245444445', NULL, NULL, 'info@mawuena.com', NULL, 'supplier', 'Supplier', '2019-12-23 17:23:06', '2019-12-23 17:28:52', NULL, 2, 2, NULL, 'Ahodwo', NULL, NULL, 0, '10 to 20', NULL, NULL, NULL),
(36, NULL, 407, NULL, 'AngSuma Ltd', 'angsuma-ltd', NULL, 'All types of engineering construction', '0302393993', '0245566744', NULL, NULL, 'info@angsuma.com', NULL, 'supplier', 'Construction', '2019-12-23 17:45:15', '2019-12-23 17:45:16', NULL, 1, 6, NULL, NULL, NULL, NULL, 0, '10 to 20', NULL, NULL, NULL),
(37, NULL, 407, NULL, 'Phanuel Construction', 'phanuel-construction', 'All things construction', NULL, '0302456566', '0203883883', NULL, NULL, 'info@phanuel.com', NULL, 'supplier', 'Consulting', '2019-12-23 18:06:10', '2019-12-23 18:06:10', NULL, 1, 4, NULL, NULL, NULL, NULL, 0, '20 to 50', NULL, NULL, NULL),
(38, NULL, 407, NULL, 'Martina Ventures', 'martina-ventures', NULL, NULL, NULL, NULL, NULL, NULL, 'info@martina.com', NULL, 'supplier', 'Construction and Consulting', '2019-12-23 18:28:46', '2019-12-23 18:28:46', NULL, 5, 12, NULL, NULL, NULL, NULL, 0, '10 to 20', NULL, NULL, NULL),
(39, NULL, 407, NULL, 'Martina Ventures', 'martina-ventures-06-58', NULL, NULL, NULL, NULL, NULL, NULL, 'info@martina.com', NULL, 'supplier', 'Construction and Consulting', '2019-12-23 18:33:58', '2019-12-23 18:33:58', NULL, 5, 12, NULL, NULL, NULL, NULL, 0, '10 to 20', NULL, NULL, NULL),
(40, NULL, 407, NULL, 'Martina Ventures', 'martina-ventures-06-57', NULL, NULL, NULL, NULL, NULL, NULL, 'info@martina.com', NULL, 'supplier', 'Construction and Consulting', '2019-12-23 18:35:57', '2019-12-23 18:35:57', NULL, 5, 12, NULL, NULL, NULL, NULL, 0, '10 to 20', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_category`
--

CREATE TABLE `company_category` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `practitioner` varchar(55) NOT NULL,
  `icon` varchar(55) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_category`
--

INSERT INTO `company_category` (`id`, `name`, `slug`, `practitioner`, `icon`, `image`, `description`) VALUES
(1, 'Roads & Bridge Design', 'roads-and-bridge-design', '', NULL, NULL, NULL),
(2, 'Building Design', 'building-design', '', NULL, NULL, NULL),
(3, 'Roads & Bridge Construction', 'roads-and-bridge-construction', '', NULL, NULL, NULL),
(4, 'Building Construction', 'building-construction', '', NULL, NULL, NULL),
(5, 'Electrical Works', 'electrical-works', '', NULL, NULL, NULL),
(6, 'Waste Management', 'waste-management', '', NULL, NULL, NULL),
(7, 'Dredging Works', 'dredging-works', '', NULL, NULL, NULL),
(8, 'Water Works & Irrigation', 'water-works-and-irrigation', '', NULL, NULL, NULL),
(9, 'Railway Design & Construction', 'railway-design-and-construction', '', NULL, NULL, NULL),
(10, 'Interior Finishing', 'interior-finishing', '', NULL, NULL, NULL),
(11, 'Landscape Gardening', 'landscape-gardening', '', NULL, NULL, NULL),
(12, 'Well & Borehole Drilling Work', 'well-and-borehole-drilling-work', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_client`
--

CREATE TABLE `company_client` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_person_id` int(11) DEFAULT NULL,
  `phone` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_preference`
--

CREATE TABLE `company_preference` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `is_equipment` tinyint(1) DEFAULT '1',
  `is_rentals` tinyint(1) DEFAULT '1',
  `is_ads` tinyint(1) DEFAULT '1',
  `is_training` tinyint(1) DEFAULT '1',
  `is_internship` tinyint(1) DEFAULT '1',
  `is_store` tinyint(1) DEFAULT '1',
  `is_apps` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_preference`
--

INSERT INTO `company_preference` (`id`, `company_id`, `is_equipment`, `is_rentals`, `is_ads`, `is_training`, `is_internship`, `is_store`, `is_apps`, `created_at`, `updated_at`) VALUES
(2, 7, 1, 1, 1, 1, 1, 1, 1, '2017-10-23 11:28:46', '2017-10-23 09:28:46'),
(3, 18, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2017-12-21 23:19:43', '2017-12-21 22:19:43'),
(4, 19, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2017-12-23 13:00:01', '2017-12-23 12:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `company_service`
--

CREATE TABLE `company_service` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(55) DEFAULT NULL,
  `summary` text,
  `link` varchar(255) DEFAULT NULL,
  `feature_image` varchar(55) DEFAULT NULL,
  `image_caption` text,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_service`
--

INSERT INTO `company_service` (`id`, `company_id`, `user_id`, `title`, `summary`, `link`, `feature_image`, `image_caption`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 22, 376, 'Structural Designs', 'We have experience', NULL, NULL, NULL, 1, '2018-12-21 04:08:27', '2018-12-21 03:08:27'),
(2, 22, 376, 'Project Management', 'We help you take full control of your construction project from start to finish', NULL, NULL, NULL, 1, '2018-12-23 19:40:36', '2018-12-23 18:40:36'),
(3, 22, 376, 'Feasibility Studies', 'We have a team of experienced engineers and technical people capable of carrying out feasibility studies of engineering projects of varying complexities under limited budgets', NULL, NULL, NULL, 1, '2018-12-23 19:58:31', '2018-12-23 18:58:31'),
(4, 22, 376, '3D Modeling', 'We carry out construct of various engineering models to simulate design scenarios based a set design parameters', NULL, NULL, NULL, 1, '2018-12-28 02:55:27', '2018-12-28 01:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `short_name` varchar(55) NOT NULL,
  `capital` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `short_name`, `capital`) VALUES
(1, 'Ghana', 'GH', 'Accra');

-- --------------------------------------------------------

--
-- Table structure for table `c_order`
--

CREATE TABLE `c_order` (
  `id` int(11) NOT NULL,
  `order_number` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_number` varchar(55) DEFAULT NULL,
  `quote_number` varchar(55) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sub_total` double(10,3) DEFAULT NULL,
  `tax` double(10,3) DEFAULT NULL,
  `total` double(10,3) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_order`
--

INSERT INTO `c_order` (`id`, `order_number`, `customer_id`, `invoice_number`, `quote_number`, `quantity`, `sub_total`, `tax`, `total`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'CPRNORDER-04-Jul-18_12:42:29', 376, NULL, 'PQR-04-Jul-18_12:42:29', 2, 3153.000, 551.775, 3704.775, '2018-07-18 12:42:29', '2018-07-04 12:42:29', '2018-07-04 10:42:29'),
(2, 'BHUBORDER-24-Apr-19_20:43:04', 376, NULL, NULL, 2, 847.000, 148.225, 995.225, '2019-05-08 20:43:04', '2019-04-24 20:43:04', '2019-04-24 18:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `c_user`
--

CREATE TABLE `c_user` (
  `id` int(11) NOT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `username_canonical` varchar(255) NOT NULL,
  `email_canonical` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_user`
--

INSERT INTO `c_user` (`id`, `facebook_id`, `company_id`, `firstname`, `lastname`, `email`, `username`, `password`, `password_reset_token`, `contact_no`, `username_canonical`, `email_canonical`, `enabled`, `salt`, `last_login`, `locked`, `expired`, `is_active`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `created_at`, `updated_at`) VALUES
(2, NULL, 28, 'Edmond', 'Balika', 'balikaem@gmail.com', 'Balika', '$2y$13$4Dl0CmuUFeZUsWu9/63/c.oqUhSccAWKkUi7h.Ht1VKfE2lJI1Y5a', '7e5e13def459962979daa22e92257e5d39cb64a65769941e4c70fcee56d14f0c1c44f98ae054829980d10af525318be7d0dc', '0246738954', 'balika', 'balikaem@gmail.com', 1, 's5m0krn1upcog408socckwgs8cww0gs', '2018-02-17 12:14:17', 0, 0, 1, NULL, NULL, NULL, 'a:3:{i:0;s:17:\"ROLE_PROFESSIONAL\";i:1;s:9:\"ROLE_FIRM\";i:2;s:12:\"ROLE_STUDENT\";}', 0, NULL, '2016-06-11 18:42:18', '2017-12-18 19:56:32'),
(5, NULL, NULL, 'Simon', 'Ametepe', 'simonofori@ciphon.com', 'Rosa', '$2y$13$Ix1na2WztkxiBfyYXkDEfeYL6yjohZ/MH/ea354xPqJJEoykwkCJW', NULL, '0202902092', 'rosa', 'simonofori@ciphon.com', 1, '23s6f0d6u1z484gkc84soss0scc0wwo', '2017-01-31 16:05:39', 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2016-06-13 16:01:22', '2016-06-13 15:01:23'),
(10, NULL, NULL, 'Simon', 'Ametepe', 'simon@gmail.com', 'ametepesimon', '$2y$13$AoVuUbHnXUQUM/vN526dcOm2wE42cA/MEo7x0m719Sp.5ok/Kh2kS', NULL, '0208299200', 'ametepesimon', 'simon@gmail.com', 0, 'm94723hlq6sokogos8w804w8404sckg', NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2016-12-08 09:50:25', '2016-12-08 08:50:25'),
(12, NULL, NULL, 'Artisan', 'Artisan Last', 'artisan@cipron.com', 'artisan.artisanlast', '$2y$13$fWyf.zspA7F1JwK2Q/p7B.Ge4dftrayDdsdIMbCe4G01Go5FMAxZ2', NULL, NULL, 'artisan.artisanlast', 'artisan@cipron.com', 0, 'bppy3j6656gwwg4kww04k04cwg8s4gw', NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-01-29 19:39:43', '2017-01-29 18:39:43'),
(13, NULL, NULL, 'Professional', 'Professional Last', 'professional@cipron.com', 'professional.professionallast', '$2y$13$HKhCEnoIZfY2viZmAEu6eOVb/ZZ.gB2s2oEDoO.z5DBOjRc8mizqG', NULL, NULL, 'professional.professionallast', 'professional@cipron.com', 0, 'hhe1kabj6q88kowkssocc044oow0gk0', '2017-01-31 18:04:42', 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-01-29 20:50:22', '2017-01-29 19:50:23'),
(14, NULL, NULL, 'Student', 'Student Last', 'student@cipron.com', 'student.studentlast', '$2y$13$CC8CtL.gWVQw3OPSY5dBu.H9PPXVjVMLCUZAhh5GY4iEgPwdMZNBW', NULL, NULL, 'student.studentlast', 'student@cipron.com', 0, '4neh5jtinpmo8co0c44wgk0o0owwcww', NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-01-31 16:17:15', '2017-01-31 15:17:15'),
(15, NULL, NULL, 'Public', 'Public Last', 'public@cipron.com', 'public.publiclast', '$2y$13$8nOWE.ZhnUW.xj9.6Fj6teQQK.0RGbqlbmsbElrSDVmX2z4LLTIfG', NULL, NULL, 'public.publiclast', 'public@cipron.com', 0, '1tkaw47suhs0s8wg0ss8cs0ccwks48g', NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-02-06 21:39:57', '2017-02-06 20:39:57'),
(16, NULL, NULL, 'Artisan 2', 'Artisan2 Last', 'artisan2@cipron.com', 'artisan 2.artisan2last', '$2y$13$cRyM.0kMTxiby1YYOdUTU.uUJaoNcckkwHSYObO4MIw9uToXQ4c6a', NULL, NULL, 'artisan2.artisan2last', 'artisan2@cipron.com', 0, 'qpwzcgftz0g0cgsw88w48ccskk8kg80', NULL, 0, 0, 1, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-02-08 15:28:59', '2017-02-08 14:29:00'),
(20, NULL, NULL, 'Cresantus', 'Dumba', 'cresantus@cipron.com', 'cresantus.dumba', '$2y$13$6ZXfQD0a2C1Gcsb8oLYfXetwM/S03.1ZAoWjxYjZqRNE2Yp3.gpzm', NULL, '02456444', 'cresantus.dumba', 'cresantus@cipron.com', 0, 'hyrr5x71qrwogo8s04cgockwsg8s44k', NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-03-23 23:44:09', '2017-03-23 22:44:09'),
(21, NULL, NULL, 'Alfred', 'Kunfiri', 'alfredk@cipron.com', 'alfred.kunfiri', '$2y$13$X8VTNunJ15x9eYgPfmH2IuDWCj.JURhZpAP4AnhlIZhv0myEvWoCy', NULL, '024568763', 'alfred.kunfiri', 'alfredk@cipron.com', 1, 'tq2062u1olwoksso8k4g00ow8ss0kww', NULL, 0, 0, 1, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-03-26 12:24:37', '2017-03-26 10:24:37'),
(26, NULL, NULL, 'John', 'Doe', 'john.doe@cipron.com', 'john.doe', '$2y$13$aohXWRni0h9c3dBsE4dUxeC9e/x26FB4QZIopjQONtrOYMzAGao5K', NULL, '0246738954', 'john.doe', 'john.doe@cipron.com', 0, '5g7hk5f5dgkk4c8sgo8wkooc0c0sccc', NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-06-06 05:15:16', '2017-06-06 03:15:16'),
(27, NULL, NULL, 'Big', 'Adu', 'bigadu@gmail.com', 'bigadu', '$2y$13$gBd9MaB4EooP2A7YgIimLu5T4APD6n9RnGC2M5YlTHA/P3Z0mZERW', NULL, NULL, 'bigadu', 'bigadu@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2017-06-19 22:58:29', '2017-06-19 20:58:29'),
(39, NULL, NULL, 'simon', 'ametepey', 'oforipmp@gmail.com', 'simon.ametepey', '$2y$13$Kb0UcQ2BJAp.ahpKseVR.OnYUZmpHp1v/oBaiweWvgRPlknTcegiC', NULL, '0244975790', 'simon.ametepey', 'oforipmp@gmail.com', 1, NULL, '2018-03-25 06:54:15', 0, 0, 1, NULL, '3f45c30a192247b78dffe74bf61012e3dac517100ed47f188a6aa5a7f37e7fc55cf9d756a8f04796e8ec24a234a022732adb', NULL, 'a:3:{i:0;s:12:\"ROLE_ARTISAN\";i:1;s:16:\"ROLE_CIPRON_USER\";i:2;s:9:\"ROLE_FIRM\";}', 0, NULL, '2017-12-05 09:10:14', '2018-01-30 17:19:37'),
(40, NULL, NULL, 'Rashid', 'Adams', 'rashid.adams@gmail.com', 'rashid.adams', '$2y$13$yyUODGa3/mvtB6XUTU7oPu4m/NrW6/mZrlkjsi4MWRl/1Ly8EjXWi', NULL, '0245511032', 'rashid.adams', 'rashid.adams@gmail.com', 1, NULL, '2018-01-13 15:51:38', 0, 0, 1, NULL, 'ca0079a1fae0e7ee3c3bfae4a85c38d69f025e60606ba37bf6106dfc8e0da6991278c1934568a894235acc26a90e1efe3fc0', NULL, 'a:2:{i:0;s:12:\"ROLE_ARTISAN\";i:1;s:9:\"ROLE_FIRM\";}', 0, NULL, '2018-01-13 12:26:52', '2018-01-13 12:26:53'),
(45, NULL, NULL, 'Peter', 'Bawa', 'peterb@gmail.com', 'peter.bawa', '$2y$13$sahLss9enxJ6ME91Cr.ZXe7ly565o8ePY2oamObHbbHekCljbhVY.', NULL, '0248904224', 'peter.bawa', 'peterb@gmail.com', 1, NULL, '2018-01-31 15:33:06', 0, 0, 1, NULL, '31e7da59f401fc569a69eb4807f3b3b74cbb47a27af8e522632367e65aeb82b0e5302415262fe9a31ec9605823cba5824f5e', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-01-31 15:26:40', '2018-01-31 15:26:41'),
(46, NULL, NULL, 'Ama', 'Baidoo', 'yesunti@gmail.com', 'amabaidoo', '$2y$13$ZZbJm4N.NV3NBMhbG6FbOOcCnIyyluE85JtzsX7Et.5OybAcCZZIO', NULL, '024012457', 'amabaidoo', 'yesunti@gmail.com', 1, NULL, '2018-01-31 17:11:18', 0, 0, 1, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2018-01-31 17:09:53', '2018-01-31 17:09:54'),
(47, NULL, NULL, 'NELSON', 'ASMAH', 'nelsonasmah@gmail.com', 'nelson.asmah', '$2y$13$0YHrxDdia2uT5spPcQ8TAe/KjorCGSkrUBh8fhyj/iUVdNtDnRj4G', NULL, '0244224266', 'nelson.asmah', 'nelsonasmah@gmail.com', 1, NULL, '2018-02-14 15:49:43', 0, 0, 1, NULL, '1550f7f24ececba3ed15ade07ecb98ad047ba19bc9d10d99492b190efe08cdb9265a2ceec4da9bf114afd3d55130790f691b', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-02-14 15:32:13', '2018-02-14 15:32:14'),
(50, NULL, NULL, 'Darrylsip', 'Darrylsip', 'monicalee923@yahoo.com', 'darrylsip.darrylsip', '$2y$13$r4QPDED6q85TyjR7rCptM.jW1mvm4dqU947RnN6q.Tc8WqFmwSNa2', NULL, '83147377775', 'darrylsip.darrylsip', 'monicalee923@yahoo.com', 0, NULL, NULL, 0, 0, 0, NULL, 'd413c917252e0458797fe5ebd68f22bfabec32b751218415fad54ed0a101d2e1b8dc94db1683358e2858ec44fb4740e18d3b', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-02-16 17:56:13', '2018-02-16 17:56:14'),
(51, NULL, NULL, 'Michael', 'Essien', 'talktomekings@gmail.com', 'michael.essien', '$2y$13$BiQ7LcyvCcH1XUcBbXNt8utvpLdZdgCQNrw1Zg0v1uiSpp9L.7PYO', NULL, '0266249183', 'michael.essien', 'talktomekings@gmail.com', 1, NULL, '2018-03-19 16:04:37', 0, 0, 1, NULL, '585c99080dfd5a8f1bc7b2dce2a0b4d420f8ef559e666d6ade2c16e89296ff9847e436717227c15f1bd1f69d98a8a7f741e4', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-03-19 15:55:53', '2018-03-19 15:55:54'),
(61, NULL, NULL, 'Maxwell', 'Ryan Freeman', 'maxwellryanfreeman@gmail.com', 'maxwell.ryanfreeman', '$2y$13$kJZ4/OSLj9r.H4Qa6RscHOHNu0p/QjBy60UZC9do6SEl1NqmjjPie', NULL, '0248660245', 'maxwell.ryanfreeman', 'maxwellryanfreeman@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, '4f890b339fc2dd47f59c7d40b8fc19bf59edc36cc2dba4d9305188acc77f8ec6c9f229fcdda0dea38e05990215fa44686733', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-03-21 09:43:03', '2018-03-21 09:43:04'),
(71, NULL, NULL, 'Aziz', 'Fuseini', 'professormayni1995@gmail.com', 'aziz.fuseini', '$2y$13$OaDrK8FtK.hBdrq41YYfU.BjFgH05Xp4h8283gIWzCLCnjYUCaB2u', NULL, '0270681601', 'aziz.fuseini', 'professormayni1995@gmail.com', 1, NULL, '2018-03-22 12:19:52', 0, 0, 1, NULL, 'b8a186bdd39668afe2e448fe025a1fd11204cb04fde59a2ba2ddbd09b2e893cdd7451aece03d3336ffb7b5e4c18dc2469bd1', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-22 12:16:31', '2018-03-22 12:16:32'),
(81, NULL, NULL, 'Evans', 'Angmor', 'angmorevans@gmail.com', 'evans.angmor', '$2y$13$noBki/ig8YSBIfzU0Ntt3Ov9DZ1y2yXl1zNvPb2L0JWqMKg1C2URS', NULL, '0260544498', 'evans.angmor', 'angmorevans@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, 'e7d423c53c17a227bb659ddf574f3c54529e27674a1f1ff640beb228bfbc05c3519ef70d134f7d0bb0b2e2d5cebc6894f22e', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-03-22 12:38:55', '2018-03-22 12:38:56'),
(91, NULL, NULL, 'Justice', 'Bonney', 'justicebonney10@gmail.com', 'justice.bonney', '$2y$13$Jzw9nRbcftYya0I5k7mvWug0RvOF.8NyOhp9DmzxnevGGwtDaIYeG', NULL, '0540761149', 'justice.bonney', 'justicebonney10@gmail.com', 1, NULL, NULL, 0, 0, 1, NULL, '7f85436d787a403e35914e73a67efea62d2c31b08ee9d595b35eaff5ab3d48a0dd7019ce3fa7a809c0294773d6c21020714f', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-29 09:23:45', '2018-03-29 09:23:46'),
(101, NULL, NULL, 'Anthony', 'Darkwa Gyening', 'tonygyening@gmail.com', 'anthony.darkwagyening', '$2y$13$rbbL7tyqYdF8/pzG5OHlIunNO9DqybOfCYPqpI5rs1T..CJNs6uaK', NULL, '0550795118', 'anthony.darkwagyening', 'tonygyening@gmail.com', 1, NULL, '2018-04-05 18:04:02', 0, 0, 1, NULL, '172b19a85454fac7b0a13907a0bb3e6c2de72648e9e5f64b8b6bc535f0b273b20142b8de66bf34bd460734449157569f04c9', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-29 10:35:16', '2018-03-29 10:35:17'),
(111, NULL, NULL, 'Jonas', 'Amoo', 'jonasniiquayeamoo@gmail.com', 'jonas.amoo', '$2y$13$AOeqiNUdz5cAm/Sq1Ym4he/yO0BbjZ9xgea20Qk19cYy/QDuLk7cy', NULL, '0267142112', 'jonas.amoo', 'jonasniiquayeamoo@gmail.com', 1, NULL, '2018-03-29 11:33:57', 0, 0, 1, NULL, '24e99bcbb858a6d34a8df196fab9efafd0ebc93b4eff83a72e295c50b1a75080c773044744b19fcbd1404b460f17a0d98b1a', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-29 11:29:31', '2018-03-29 11:29:31'),
(121, NULL, NULL, 'Collins', 'Biney', 'collinsbiney15@gmail.com', 'collins.biney', '$2y$13$Yo28FzV77X1HFgiTxvUAfOlggRndXJpkNbSMCj0kwoHUUOtTsRsSK', NULL, '0277202100', 'collins.biney', 'collinsbiney15@gmail.com', 1, NULL, NULL, 0, 0, 1, NULL, '9b9b0c5423a6813cadbca1cf1287fc57f6642c470f1b91e25cbaa3d6f98cd2eb736878f8a27e2871760a4b7cf6514ecc8346', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-29 11:56:23', '2018-03-29 11:56:24'),
(131, NULL, NULL, 'Solomon', 'Narh Martey', 'Marteys490@gmail.com', 'solomon.narhmartey', '$2y$13$OEdqA9PPRHePFdq07v10Be4qn2QzE8Ajs./sgtOAtFlc.wHb/nBda', NULL, '0241842380', 'solomon.narhmartey', 'marteys490@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, '28e85f18ea10a7f458c1a8b73d04361893282f753cc80afaa6d576cecffcf8ae879664e89998f5f30e8769bb938ffd8149ce', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-29 12:04:23', '2018-03-29 12:04:24'),
(141, NULL, NULL, 'Francis', 'Asiedu', 'asiedufrancis87@gmail.com', 'francis.asiedu', '$2y$13$.3ZMkCaH76F5VCOp5rMX3OkGBjkTBjwlJaM/yhPFNdcT2bPeaU/oK', NULL, '0249456083', 'francis.asiedu', 'asiedufrancis87@gmail.com', 1, NULL, '2018-03-29 12:07:03', 0, 0, 1, NULL, '03b7877d7f25d6be86402990958ea94e5a23e4e2b49878a3d8c1275c0aafb30fb7ad8a3bf1faccb9416cf962933287f1a94d', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-29 12:05:45', '2018-03-29 12:05:46'),
(151, NULL, NULL, 'baidu', 'michael', 'baidumichael@GMAIL.COM', 'baidu.michael', '$2y$13$XexNzWZSJtYK0XnAG7NbSOrPrZXyUix7Z9YfTP5C8RdO/OgK0KZly', NULL, '0240704461', 'baidu.michael', 'baidumichael@gmail.com', 1, NULL, NULL, 0, 0, 1, NULL, '9c7d1cb0bf47e8e6142838c44bae9e2875f937ee2dd9dacebc4691c0bd9da3a9bcaf4b9927de2199b9a6ef217f0a484cbacd', NULL, 'a:1:{i:0;s:12:\"ROLE_STUDENT\";}', 0, NULL, '2018-03-29 16:42:25', '2018-03-29 16:42:25'),
(161, NULL, NULL, 'NANOR', 'FRANCIS', 'Deflamezjuda@gmai.com', 'nanor.francis', '$2y$13$3EzoLQCWauuMI/ryBQiav.2Zebk8elBPSQQdiR.TJv/Z2CJ78eLHm', NULL, '0546209038', 'nanor.francis', 'deflamezjuda@gmai.com', 0, NULL, NULL, 0, 0, 0, NULL, '27e1136b2664462d9068c9d62d823cb365254064741d0c3a00d11a3a2e897722e07767eb074cd46431cc4c52f5a1dad4f40d', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-29 17:08:27', '2018-03-29 17:08:28'),
(171, NULL, NULL, 'Ofori Duah', 'Joseph', 'jduah89@yahoo.com', 'ofori duah.joseph', '$2y$13$Bqg9sU5bd683UQfPlhjlfe2eWrboaSqbJyOdB7vy.0p2JQp0qcT5G', NULL, '+233269213426', 'ofori duah.joseph', 'jduah89@yahoo.com', 0, NULL, NULL, 0, 0, 0, NULL, '5f382bab6d2a50ce66db21d30dd55c74f67d22240bef9110ff581131c6d0bf127ebc9c2e8d5eb209f91fe265fac09859331c', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-03-29 21:01:12', '2018-03-29 21:01:13'),
(181, NULL, NULL, 'Frederick', 'Quansah', 'frederickadomquansah@gmail.com', 'frederick.quansah', '$2y$13$ccBaZSJMIsIGClZzNuIXvu5oiA/gfNpp6Nym1LnPyKRtdRaqCT9ZG', NULL, '0505630070', 'frederick.quansah', 'frederickadomquansah@gmail.com', 1, NULL, '2018-03-30 06:20:59', 0, 0, 1, NULL, '1af825bd7cc01751b8ba1765a02e0125f7853cd6312c9017e6b073a9ccb319aac6e261e8d5edfc722a66bf2a80476c36579c', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-30 06:04:37', '2018-03-30 06:04:38'),
(211, NULL, NULL, 'Afedzi', 'Ebenezer', 'afedziebenezer4@gmail.com', 'afedzi.ebenezer', '$2y$13$SAJReXk/yQQCk6UiCCN0s.cfS8tz0jPUk8q7gvB.vs/kkDA5muFda', NULL, '0544895047', 'afedzi.ebenezer', 'afedziebenezer4@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, '5b68dfdfb50a6789a31314d5abc3eb04588525a12bcd7d08c7ef2cb32bda1e6fb011f30c6b496a6942b9c3521d806665e400', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-30 10:29:00', '2018-03-30 10:29:00'),
(221, NULL, NULL, 'Tetteh', 'Francis', 'francistt206@gmail.com', 'tetteh.francis', '$2y$13$8rfB7x8/Xu1zCNjt1Yf1hO6lW12AwTaSorE0TTQKKH056cLP44FDa', NULL, '0245458348', 'tetteh.francis', 'francistt206@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, '771b8d5ae0b415d41b39f03bee002883b0602cbb1b0f2a968d1dcb7d848b7d822dd55d8e9310c2143278b20deb395572f066', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-03-30 13:21:37', '2018-03-30 13:21:37'),
(231, NULL, NULL, 'Ismaila', 'Quarshie', 'ismailaquarshie2017@gmail.com', 'ismaila.quarshie', '$2y$13$EvLUtRRmh72mkxRLPAaWg.Ic5mwH9WFkreOSCSjE/9lVsPIMXANHO', NULL, '0277101310', 'ismaila.quarshie', 'ismailaquarshie2017@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, 'ad9de4e04dd66d5d384ac74b4535258e79bca1632f92fa9eca3d8e14888dc8f5124cc422777b890af070c696652f89dfa9c7', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-03-31 17:45:51', '2018-03-31 17:45:52'),
(241, NULL, NULL, 'Joshua', 'Okang', 'kniitek9@gmail.com', 'joshua.okang', '$2y$13$GLm1BZRUj63pmml2SjahcOdO5D9rPJ0w8JVdZKt8ZOlt6nM5T812e', NULL, '0245521493', 'joshua.okang', 'kniitek9@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, 'ac9cdd3ad821529a4dbb0fb116cd0e42907761194647a2dc6fee0107c3133f9631ccbdb8818c55f3319323ac8aae69e716c9', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-04-01 00:17:16', '2018-04-01 00:17:17'),
(251, NULL, NULL, 'Abigail', 'Mantey', 'abipadmore@gmail.com', 'abigail.mantey', '$2y$13$EEOAyImxFuoOr6ngwIOwP.2uK/I5ON1iwYUka47nlBbYXI04E2NAG', NULL, '0554492145', 'abigail.mantey', 'abipadmore@gmail.com', 1, NULL, '2018-04-01 01:26:03', 0, 0, 1, NULL, '1688a0d3bd56605772097107cb4ccd0aef067ab8ea88e2bff4c979726a04aa650f21c4552d477d7027cde4a6ceea0b3feb63', NULL, 'a:1:{i:0;s:12:\"ROLE_STUDENT\";}', 0, NULL, '2018-04-01 01:23:20', '2018-04-01 01:31:12'),
(261, NULL, NULL, 'GEORGE', 'TENGE', 'georgetenge.gt@gmail.com', 'george.tenge', '$2y$13$gK76RImhmRvtlZp4l905ZuCu9qALQk3aWHfrk0SKCZL.GO1Y6IQoK', NULL, '0240091523', 'george.tenge', 'georgetenge.gt@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, '4619fcdf4af10c4d187b99071e3d2bf9ee352981e945fd2aff632d00e5c3746c382e4092412488b3c64334bb82bf7a1ce2ad', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-04-01 17:15:08', '2018-04-01 17:15:09'),
(271, NULL, NULL, 'Isaac', 'Wiafe Debrah', 'isaacwiafedebrah@gmail.com', 'isaac.wiafedebrah', '$2y$13$PwyI0f3jg28HFWAOzfEJ7OLrIkRL4nlb2ijQK0LIADzi0ebmGwPS.', NULL, '0554224063', 'isaac.wiafedebrah', 'isaacwiafedebrah@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, '2e6b998d1844caf6fb140a88d1dcc7999cb8760a92fe9c70ce8d23e3ade9f8b900503725ed92ff68dd9428f06a243c411096', NULL, 'a:1:{i:0;s:11:\"ROLE_PUBLIC\";}', 0, NULL, '2018-04-04 10:28:50', '2018-04-04 10:28:50'),
(281, NULL, NULL, 'John', 'okine', 'slimgeegh@yahoo.com', 'john.okine', '$2y$13$wilU1/rjm9A9YTIupyiEWuL9roHsk/.gF478anoZMsQqM5BbVglAG', NULL, '0549166115', 'john.okine', 'slimgeegh@yahoo.com', 0, NULL, NULL, 0, 0, 0, NULL, '5b5cfe7d554a661f3657a9a63435293482317a2588cfebb77cd2108d69ea9b369edc520be73e41293c5fbef5ff0808c2ff18', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-04-04 10:35:22', '2018-04-04 10:35:23'),
(301, NULL, NULL, 'Nugah', 'Samuel', 'samuelnugah@gmail.com', 'nugah.samuel', '$2y$13$ZemnXneUu4HOuGAK9KJMte1WJDBvX2/cj15PKuAuLItHv.q3gs4mG', NULL, '0542929082', 'nugah.samuel', 'samuelnugah@gmail.com', 1, NULL, '2018-04-05 06:13:36', 0, 0, 1, NULL, '62f55b0c3af0740554004f2f1e21e7b101889bda65caa1ceedf85b0c6162bb7caeba59b224a2356a4c7a64d180dd5f9544a8', NULL, 'a:1:{i:0;s:12:\"ROLE_STUDENT\";}', 0, NULL, '2018-04-05 05:54:31', '2018-04-05 05:54:32'),
(331, NULL, NULL, 'Evans', 'Sakyiamah Senior', 'evanstsikata57@gmail.com', 'evans.sakyiamahsenior', '$2y$13$1UEaECGUuGxSS1fBJ4nvV.WW/NIXUz718uE1OfaWIFJQYCsH1rTby', NULL, '0558150940', 'evans.sakyiamahsenior', 'evanstsikata57@gmail.com', 1, NULL, '2018-04-05 19:11:16', 0, 0, 1, NULL, 'c5bfbcd8a50b02c44da30392a5fbc493bd45570f446712b0286f329501a4604cbd69cffd073e9bf590055ebb87d466d3bac8', NULL, 'a:1:{i:0;s:12:\"ROLE_STUDENT\";}', 0, NULL, '2018-04-05 19:05:06', '2018-04-05 19:16:37'),
(341, NULL, NULL, 'Asare', 'Isaac', 'asarei36@yahoo.com', 'asare.isaac', '$2y$13$rkIW7UizV9Eup6LRAqHUhedGcsu.lA4t3QQK.JascU4jBg1xNNu/G', NULL, '0548349033', 'asare.isaac', 'asarei36@yahoo.com', 0, NULL, NULL, 0, 0, 0, NULL, '7af189c49a103d5e5452be77bf2a39b691c9bb256976259fce2c9d8b3df54643d0fa164ca632827ec3338f355916f4409c80', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-04-08 15:34:06', '2018-04-08 15:34:07'),
(351, NULL, NULL, 'Christian', 'Mensah', 'Oruavuni@gmail.com', 'christian.mensah', '$2y$13$4p78R6DWM3ul7hHxMzfIe.VzchvKLhuh1kud96UFlZhfSU9RSQ6tG', NULL, '0240165829', 'christian.mensah', 'oruavuni@gmail.com', 1, NULL, '2018-04-11 11:02:38', 0, 0, 1, NULL, '88e77624a4db53b38d189175e594ace2578912639acfb80530b394480f15966abd2659322d81dd1c610e77d8ca7f89f2f6c7', NULL, 'a:1:{i:0;s:12:\"ROLE_STUDENT\";}', 0, NULL, '2018-04-11 10:54:39', '2018-04-11 10:54:40'),
(361, NULL, NULL, 'FELIX', 'ABIAMANYO', 'fabiamanyo@gmail.com', 'felix.abiamanyo', '$2y$13$dN.6pDTLsWk5gj8seEqab..UlYDnj3HG2GGnw3HgSwPu8T5Jaobxu', NULL, '0545110875', 'felix.abiamanyo', 'fabiamanyo@gmail.com', 1, NULL, NULL, 0, 0, 1, NULL, 'fa789927fa3791a847b432b2d80b30ca3b45f451a69195d3a2164e36d7f7a75d333c631179545858e9952fe2ae58246235d5', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-04-11 11:32:33', '2018-04-11 11:32:34'),
(371, NULL, NULL, 'Archibald', 'Appiah', 'achibaldappiah@gmail.com', 'archibald.appiah', '$2y$13$4tPjHnh9HgivhQbwecz8s.r2j8Acxr6h9ojGKU6q.u5OcgN.AWPxi', NULL, '0263581966', 'archibald.appiah', 'achibaldappiah@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, '66ca1a113168515ac271c1b8a105f592ebc22e28f3fc30cb86bd6d66d7aed812abd41fa2fa3dd53f7f5239206fb86a39c1e6', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-04-11 12:20:23', '2018-04-11 12:20:24'),
(372, NULL, NULL, 'Michael', 'Kofi', 'odeefuor@gmail.com', 'michael.kofi', '$2y$13$xTrw57dDhMLpbQJnAkIAfe/JLdWRstJyEo2ROGMF1JW1fQUtjifDO', NULL, '0547270189', 'michael.kofi', 'odeefuor@gmail.com', 1, NULL, NULL, 0, 0, 1, NULL, '24678059a6343a0edd2848e930b3ffb36187c13c76b5c58d274a99a6b2cc3980943424a0386e5289a72352877711d536b553', NULL, 'a:1:{i:0;s:12:\"ROLE_STUDENT\";}', 0, NULL, '2018-04-13 17:39:28', '2018-04-13 17:39:28'),
(376, NULL, 22, 'Alverna', 'Balika', 'info@zibblesmp.com', 'info@zibblesmp.com', '$2y$13$VNC1MqotQG14vUtsq7m41OgS.SqQflbSEZWuJDl5jZqVOPe5eKFeS', '2e390aa96914f99cf7de3468b1e868591f020e2788fd87dae40724bbc964f91c5560a7b4193b2fde40d46641a8cae7eaf48f', '+233246738954', 'alverna.balika', 'info@zibblesmp.com', 1, NULL, NULL, 0, 0, 1, NULL, '22BIRY', NULL, 'a:4:{i:0;s:12:\"ROLE_ARTISAN\";i:1;s:13:\"ROLE_SUPPLIER\";i:2;s:14:\"ROLE_HUB_ADMIN\";i:3;s:14:\"ROLE_HUBERNIZE\";}', 0, NULL, '2018-06-10 18:42:10', '2018-06-10 16:42:11'),
(379, NULL, NULL, 'Daniel', 'Amadu', 'bedbamon@yahoo.com', 'bedbamon@yahoo.com', '$2y$13$Dln4w2MwvXkAV4hW9oBn/.PulmOL7CyhNxB8T3Cd6.0Wey4eSlJdy', NULL, NULL, 'daniel.amadu', 'bedbamon@yahoo.com', 0, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_SUPPLIER\";}', 0, NULL, '2018-07-25 17:35:48', '2018-07-25 15:35:49'),
(380, NULL, NULL, 'Patience', 'Quashigah', 'mawuenaq@gmail.com', 'mawuenaq@gmail.com', '$2y$13$4UsT5FqSlPjlPXcDt4PcPexC.7z/WDdt.hD/iD/XadXeZ/JwKgvRO', NULL, '0208621611', 'patience.quashigah', 'mawuenaq@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, 'HFMDQ4', NULL, 'a:1:{i:0;s:13:\"ROLE_SUPPLIER\";}', 0, NULL, '2018-07-29 20:35:58', '2018-07-29 18:35:59'),
(381, NULL, NULL, 'Baseline', 'Technologies', 'btlclients@gmail.com', 'btlclients@gmail.com', '$2y$13$9FTDgeOeEnTf0HPThU4T8.GSORDp/d52siDd8HRz8ENc6k.QgpJD2', '3e7961323eae6d7d98657da5895304674755515a4b934ce45a5ec920bafcb76fbe64eed3e45db7f7bc9121226527c2dc003d', NULL, 'baseline.technologies', 'btlclients@gmail.com', 1, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 'a:1:{i:0;s:17:\"ROLE_PROFESSIONAL\";}', 0, NULL, '2018-08-29 08:33:18', '2018-08-29 06:33:19'),
(383, NULL, NULL, 'Francis', 'Tuuli', 'ftuulijnr@yahoo.com', 'ftuulijnr@yahoo.com', '$2y$13$ryWkYAjm8sZp1ZFO15ykje0nXiCoOwtig7.CTtMr7aBhcCMIazI5O', NULL, '+233203577536', 'francis.tuuli', 'ftuulijnr@yahoo.com', 0, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2018-10-12 16:50:18', '2018-10-12 14:50:19'),
(387, NULL, NULL, 'John', 'Karlson', 'gaetinkunfiri2000.gk@gmail.com', 'gaetinkunfiri2000.gk@gmail.com', '$2y$13$lJqz7BmVGThtr1O68TfcxO8xVaMPYfgu1m3vaozyiYtwZCxDID7zq', NULL, '+233246738954', 'john.karlson', 'gaetinkunfiri2000.gk@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, 'ZMAQCV', NULL, 'a:2:{i:0;s:12:\"ROLE_ARTISAN\";i:1;s:13:\"ROLE_SUPPLIER\";}', 0, NULL, '2018-10-13 16:19:34', '2018-10-13 14:19:36'),
(390, NULL, NULL, 'Joel', 'Mensah', 'info@buildershub.net', 'info@buildershub.net', '$2y$13$5dlHC.O2yZ6SLcKxJyud8u8k12eqZ.Q49U6.pPRt5cXjMu8vh0/Vi', NULL, '208621611', 'joel.mensah', 'info@buildershub.net', 0, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2018-11-03 21:47:23', '2018-11-03 20:47:24'),
(392, NULL, 26, 'Gerald', 'Anaman', '0246738954', '0246738954', '$2y$13$Y3htSxMl1EYNldGhX3uGdeBlegLLICkEc.bLTtc3WUA8Vk..mdW2O', NULL, '+233203577536', 'gerald.anaman', '0246738954', 0, NULL, NULL, 0, 0, 0, NULL, '7C3H00', NULL, 'a:1:{i:0;s:10:\"ROLE_GUEST\";}', 0, NULL, '2018-11-08 15:46:13', '2018-11-08 14:46:14'),
(393, NULL, NULL, 'Kwame', 'Tuffour', '0546401593', '0546401593', '$2y$13$ulyXE/7IA1GWwUoqNWVFyeMm42HZu3qBUoTKJeFcfbKnbH1.hqnEO', NULL, '+233546401593', 'kwame.tuffour', '0546401593', 1, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_GUEST\";}', 0, NULL, '2019-04-25 18:36:18', '2019-04-25 16:36:20'),
(394, NULL, NULL, 'Patience', 'Balika', '0208621611', '0208621611', '$2y$13$akwrBrXa6356u8dFWmYK/u2bTGusKK7eoic4l3tCzpRJe7pRtni.C', NULL, '+233208621611', 'patience.balika', '0208621611', 1, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_GUEST\";}', 0, NULL, '2019-04-25 20:06:23', '2019-04-25 18:06:24'),
(399, NULL, NULL, 'Florence', 'Dwumfour', 'me@gmail.com', 'me@gmail.com', '$2y$13$tQed4tiMq0fEteOOLfbYsOqsiRSIKEn354mUIPs8YHiLuYyWObBma', NULL, '+233246389635', 'florence.dwumfour', 'me@gmail.com', 0, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 'a:2:{i:0;s:12:\"ROLE_ARTISAN\";i:1;s:13:\"ROLE_SUPPLIER\";}', 0, NULL, '2019-05-17 17:14:00', '2019-05-17 15:14:01'),
(400, NULL, NULL, 'Samuel', 'Inkoom', 'sammink2000@yahoo.com', 'sammink2000@yahoo.com', '$2y$13$nMAPlm3C.MbKg5Ve3amFp.wrqiL6HaImVL.HE6FkZSEIi7RAp/43m', NULL, '+233246738954', 'samuel.inkoom', 'sammink2000@yahoo.com', 1, NULL, NULL, 0, 0, 1, NULL, 'F6R99D', NULL, 'a:1:{i:0;s:17:\"ROLE_PROFESSIONAL\";}', 0, NULL, '2019-10-14 16:04:30', '2019-10-14 14:04:31'),
(407, NULL, NULL, 'Phanuel', 'Balika', 'info@baselinetechlab.com', 'info@baselinetechlab.com', '$2y$13$EhrUlzd3aD0Z1x5lXX8.lutheSaxQFM3dQ8b4/Y/vXkyqDf6lUecK', 'ab8bbd28e656088b54381469a2d6cdd8137b6ede890556c836076c03d407267d4c382f8ca61cba8bcfd37cfa48946667de36', '+233546401593', 'phanuel.balika', 'info@baselinetechlab.com', 1, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 'a:3:{i:0;s:10:\"ROLE_GUEST\";i:1;s:9:\"ROLE_FIRM\";i:2;s:13:\"ROLE_SUPPLIER\";}', 0, NULL, '2019-11-27 14:47:35', '2019-11-27 13:47:35'),
(410, NULL, NULL, 'Evans', 'Baah', 'evansbaah18@yahoo.com', 'evansbaah18@yahoo.com', '$2y$13$39nKPSqN1SDFr7GTNzrRnefxS8dFmiiY188MvQDdotl5qBdHLTm8u', NULL, NULL, 'evans.baah', 'evansbaah18@yahoo.com', 0, NULL, NULL, 0, 0, 0, NULL, 'a6c47b3951d73265da626f09b69b3b850ad31f4cf4843624c3c1334116b6b00781ba0c1e85219f9886f9fe6d96cf1199dc48', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2019-12-12 16:42:14', '2019-12-12 15:42:15'),
(411, NULL, NULL, 'Julius', 'Balika', 'sales@baselinetechlab.com', 'sales@baselinetechlab.com', '$2y$13$NWlczGy.w7coR3lkao3b7.L5DZWkfDDQp/eZVK5YDhx0xwIBx2HoK', NULL, NULL, 'julius.balika', 'sales@baselinetechlab.com', 0, NULL, NULL, 0, 0, 0, NULL, 'd7b4d533d592a0012780339f343401c3bd97234cea792cd9ef630e8fb27c611af59b6966baec7d26917377d19c4c62934eb3', NULL, 'a:1:{i:0;s:12:\"ROLE_ARTISAN\";}', 0, NULL, '2019-12-12 18:48:45', '2019-12-12 17:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `entity_image`
--

CREATE TABLE `entity_image` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `entity` varchar(55) NOT NULL,
  `caption` text,
  `image` varchar(55) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entity_image`
--

INSERT INTO `entity_image` (`id`, `user_id`, `entity_id`, `entity`, `caption`, `image`, `is_featured`, `created_at`, `updated_at`) VALUES
(10, 376, 12, 'App:Work', 'Replastering of 3-bedroom house at Okpoi-Gonno', '5b2bd0be1b2be570496040.jpg', 0, '2018-06-21 18:22:21', '2018-06-21 18:22:22'),
(11, 376, 12, 'App:Work', 'Truck hauling in smooth sand for the plastering excercise', '5b2bdbbd87f37485147147.jpg', 0, '2018-06-21 19:09:17', '2018-06-21 19:09:17'),
(12, 376, 12, 'App:Work', 'Breaking of old plastering', '5b6dba1dd27cf000101279.jpg', 0, '2018-08-10 18:15:25', '2018-08-10 18:15:26'),
(13, 376, 13, 'App:Work', 'Collapsed Bridge', '5b6dbde45d535741249264.jpg', 0, '2018-08-10 18:31:31', '2018-08-10 18:31:32'),
(14, 376, 13, 'App:Work', 'Showing failed abutment of Steel bridge', '5b6e5bad3d0e2332852597.jpg', 0, '2018-08-11 05:44:44', '2018-08-11 05:44:45'),
(15, 376, 13, 'App:Work', 'Completed Steel bridge', '5b6e5bdd8db20580299001.jpg', 0, '2018-08-11 05:45:33', '2018-08-11 05:45:33'),
(16, 376, 13, 'App:Work', 'State of bridge at commissioning', '5b7c21ad8710d424424768.jpg', 0, '2018-08-21 16:29:00', '2018-08-21 16:29:01'),
(17, 376, 12, 'App:Work', 'Removal of existing roof', 'Entity_Image_.jpg', 0, '2018-11-09 17:57:11', '2018-11-09 17:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `asset_label` varchar(55) DEFAULT NULL,
  `description` text,
  `feature_image` varchar(255) DEFAULT NULL,
  `gallery` longtext,
  `type_id` int(55) DEFAULT NULL,
  `output` double(10,3) DEFAULT NULL,
  `output_unit` varchar(55) DEFAULT NULL,
  `brand` varchar(55) DEFAULT NULL,
  `color` varchar(55) DEFAULT NULL,
  `registration_number` varchar(55) DEFAULT NULL,
  `chasis_number` varchar(55) DEFAULT NULL,
  `no_of_axles` int(2) DEFAULT NULL,
  `status` varchar(55) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `slug`, `company_id`, `user_id`, `asset_label`, `description`, `feature_image`, `gallery`, `type_id`, `output`, `output_unit`, `brand`, `color`, `registration_number`, `chasis_number`, `no_of_axles`, `status`, `is_active`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Concrete Mixer', 'concrete-mixer', 22, 376, 'BTL/CM/2014/003', 'Used for mixing concrete. Has a rotating drum', 'equipment_feature_imaged9ph874k.png', 'N;', NULL, 6.000, 'M3', 'Tongline', 'Orange', NULL, NULL, NULL, NULL, 1, 0, '2019-05-05 23:48:50', '2019-05-05 23:48:57'),
(2, 'Excavator', 'excavator', 22, 376, 'BTL/CM/2016/001', 'A brand new Caterpillar excavator', 'equipment_feature_image_q80v48bl.jpg', 'N;', NULL, 2.000, 'M3', 'Caterpillar', 'Orange', 'GT-3022-16', 'CTA239002', 2, 'In Good Condition', 1, 0, '2019-05-10 10:37:43', '2019-05-10 10:37:45'),
(3, 'Wheel Barrow', 'wheel-barrow', 22, 376, NULL, 'Brand new wheelbarrows', 'equipment_feature_image_wi5badoi.jpg', 'N;', NULL, 0.050, 'm3', 'Jumbo', 'Gray', NULL, NULL, NULL, 'In Good Condition', 0, 0, '2019-08-28 12:19:25', '2019-08-28 12:19:25'),
(7, 'Concrete Mixer', 'concrete-mixer-03-36', 22, 376, NULL, 'Electricity-powered concrete mixer with a solar panel to supply backup power for 30 miutes', 'equipment_feature_image_i7ib0qcn.jpg', 'a:3:{i:0;s:37:\"a69fe644d2dc81b4ca2776b2711401e4.jpeg\";i:1;s:37:\"0cd49e6b07f97985b0f284e76651ddd1.jpeg\";i:2;s:37:\"cb57d0587bbb8d9c70da2db570fafcad.jpeg\";}', NULL, 3.000, 'm3', 'Conmart', NULL, NULL, NULL, NULL, 'In Good Condition', 0, 0, '2019-08-28 14:39:09', '2019-08-28 15:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_assignment`
--

CREATE TABLE `equipment_assignment` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `equipment_id` int(11) NOT NULL,
  `assignment_type` varchar(55) DEFAULT NULL,
  `description` text,
  `project_id` int(11) DEFAULT NULL,
  `garage_name` varchar(255) DEFAULT NULL,
  `garage_contact` varchar(55) DEFAULT NULL,
  `cost` double(10,3) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `estate`
--

CREATE TABLE `estate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `region_id` int(11) NOT NULL,
  `town_id` int(11) DEFAULT NULL,
  `sub_location` varchar(55) DEFAULT NULL,
  `feature_image` varchar(55) NOT NULL,
  `description` text,
  `sale_price` double(10,3) DEFAULT NULL,
  `currency` varchar(55) NOT NULL DEFAULT 'GH¢',
  `min_price` double(10,3) DEFAULT NULL,
  `max_price` double(10,3) DEFAULT NULL,
  `regular_price` double(10,3) DEFAULT NULL,
  `listing_type` varchar(55) NOT NULL,
  `renewal_cycle` int(11) DEFAULT NULL,
  `advance_duration` int(11) DEFAULT NULL,
  `building_type` varchar(55) NOT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `parking_lots` int(11) DEFAULT NULL,
  `neighbourhood` varchar(55) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `available_units` int(11) DEFAULT NULL,
  `area` double(10,3) DEFAULT NULL,
  `unit` varchar(55) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `realtor_name` varchar(55) DEFAULT NULL,
  `is_agent` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estate`
--

INSERT INTO `estate` (`id`, `name`, `slug`, `region_id`, `town_id`, `sub_location`, `feature_image`, `description`, `sale_price`, `currency`, `min_price`, `max_price`, `regular_price`, `listing_type`, `renewal_cycle`, `advance_duration`, `building_type`, `bedrooms`, `bathrooms`, `parking_lots`, `neighbourhood`, `is_available`, `available_units`, `area`, `unit`, `user_id`, `company_id`, `realtor_name`, `is_agent`, `is_featured`, `enabled`, `views`, `created_at`, `updated_at`) VALUES
(1, '3 Bedroom Apartment for Sale', '3-bedroom-apartment-for-sale', 1, 7, 'Dzowulu No. 2', '5b612dde40c3c607000185.jpg', NULL, NULL, 'GH¢', NULL, NULL, 250000.000, 'For Sale', NULL, NULL, 'Apartment', 3, 3, 2, 'Gated Community', 1, 3, 2000.000, 'm2', 376, 22, NULL, 0, 1, 1, 0, '2018-07-31 00:02:54', '2018-08-01 05:49:50'),
(2, '5 Bedroom House for Sale', '5-bedroom-house-for-sale', 1, 8, 'Coastal Estates', '5b604b95c5881090982183.png', NULL, NULL, '$', NULL, NULL, 200000.000, 'For Sale', NULL, NULL, 'Villa', 5, 6, 5, 'Level 5 Residential Area', 1, 2, 2400.000, 'm2', 376, 22, NULL, 0, 1, 1, 3, '2018-07-31 13:44:21', '2018-07-31 13:44:21'),
(3, 'Duplex House for Rent', 'duplex-house-for-rent', 2, NULL, 'Ahodwo', '5b604ebe4080a252369606.JPG', NULL, 3000.000, '$', NULL, NULL, NULL, 'For Rent', 1, 2, 'Villa', 6, 6, 5, 'Level 5 Residential Area', 1, 1, 4000.000, 'm2', 376, 22, NULL, 0, 1, 1, 0, '2018-07-31 13:57:50', '2018-07-31 13:57:50'),
(4, 'Single Roof Top Suite for Sale', 'single-roof-top-suite-for-sale', 4, 3, 'SSNIT', '5b604f610af99519006660.jpg', NULL, NULL, 'GH¢', NULL, NULL, 3000000.000, 'For Sale', NULL, NULL, 'Villa', 5, 6, 4, 'Level 5 Residential Area', 1, 2, 3000.000, 'm2', 376, 22, NULL, 0, 0, 1, 4, '2018-07-31 14:00:33', '2018-07-31 14:00:33'),
(5, '3 Bedroom Modern Bungalow for Rent', '3-bedroom-modern-bungalow-for-rent', 5, NULL, 'Kambali', '5b60501311a54168956787.jpg', NULL, 1500.000, 'GH¢', NULL, NULL, NULL, 'For Rent', 2, 2, 'Apartment', 4, 4, 4, 'Gated Community', 1, 5, 2500.000, 'm2', 376, 22, NULL, 0, 1, 1, 0, '2018-07-31 14:03:31', '2018-07-31 14:03:31'),
(6, '5 Bedroom Plush House for Sale', '5-bedroom-plush-house-for-sale', 1, 1, 'Airport Residential Area', '5b6050d377b02946454507.jpg', NULL, NULL, '$', NULL, NULL, 2000000.000, 'For Sale', NULL, NULL, 'Apartment', 5, 6, 3, 'Level 5 Residential Area', 1, 2, 3000.000, 'm2', 376, 22, NULL, 0, 1, 1, 3, '2018-07-31 14:06:43', '2018-07-31 14:06:43'),
(7, 'Mansion for Sale', 'mansion-for-sale', 1, NULL, 'Ababio Lane', '5b613544d9f64378941170.jpg', NULL, NULL, '$', NULL, NULL, 2500000.000, 'For Sale', NULL, NULL, 'Villa', 8, 8, 5, 'Level 5 Residential Area', 1, 1, 5000.000, 'm2', 376, 22, NULL, 0, 1, 1, 0, '2018-08-01 06:21:24', '2018-08-01 06:21:24');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `place_of_work` text,
  `job_title` varchar(255) DEFAULT NULL,
  `job_description` text,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_present` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `user_id`, `place_of_work`, `job_title`, `job_description`, `start_date`, `end_date`, `is_present`, `created_at`, `updated_at`) VALUES
(6, 376, 'Ministry of Roads & Highways', 'Assistant Engineer', 'I am generally responsible for monthly cost indices preparation and collaborative research with development partners.', '2014-11-03 00:00:00', NULL, 0, '2018-08-21 07:40:04', '2018-08-21 05:40:04'),
(7, 376, 'International Labour Organisation', 'Labour Based Training Engineer', 'Was responsible for organising training workshops for contractor supervisor in the construction and rehabilitation of rural roads and earth dams. My duties also included updating training manuals to reflect current engineering practice', '2011-12-14 00:00:00', '2014-11-30 00:00:00', 0, '2018-08-21 13:10:17', '2018-08-21 11:10:18'),
(8, 376, 'N-Dimension Engineering', 'GIS Expert', 'Responsible for GIS management', '2019-04-10 00:00:00', '2019-12-25 00:00:00', 0, '2019-12-25 02:07:50', '2019-12-25 01:07:50'),
(9, 376, 'Baseline Technologies Laboratory Ltd', 'Database Aministrator', 'Database design and administration', '2019-12-03 00:00:00', NULL, 1, '2019-12-25 03:47:21', '2019-12-25 02:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `featured_category`
--

CREATE TABLE `featured_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `featured_category`
--

INSERT INTO `featured_category` (`id`, `category_id`, `start_date`, `end_date`, `user_id`, `supplier_id`, `is_current`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 9, '2019-04-26 00:00:00', '2019-05-15 00:00:00', 376, NULL, 0, 0, '2019-04-29 01:10:47', '2019-04-28 23:10:47'),
(2, 34, '2019-04-25 00:00:00', '2019-06-16 00:00:00', 376, NULL, 1, 0, '2019-04-29 17:35:18', '2019-04-29 15:35:18');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `firm`
--

CREATE TABLE `firm` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `firm`
--

INSERT INTO `firm` (`id`) VALUES
(21),
(32);

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `follower` int(11) NOT NULL,
  `following` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`follower`, `following`) VALUES
(376, 387);

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`id`) VALUES
(4),
(7),
(8),
(11),
(12),
(16),
(17),
(18),
(19),
(21),
(23),
(25),
(27),
(33),
(379);

-- --------------------------------------------------------

--
-- Table structure for table `hub_app`
--

CREATE TABLE `hub_app` (
  `id` int(11) NOT NULL,
  `label` varchar(55) NOT NULL,
  `code` varchar(25) NOT NULL,
  `description` text,
  `icon` varchar(55) DEFAULT NULL,
  `alt_icon` varchar(55) DEFAULT NULL,
  `logo` varchar(55) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `is_hubernized` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `default_uri` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hub_app`
--

INSERT INTO `hub_app` (`id`, `label`, `code`, `description`, `icon`, `alt_icon`, `logo`, `user_id`, `is_hubernized`, `rank`, `is_enabled`, `default_uri`) VALUES
(1, 'Site Diary', 'Site_Diary', 'Don\'t get cheated out of legitimate claims, get smart! Keep daily site records in real time.', 'fa fa-newspaper-o', 'icon-browser', NULL, 376, 1, 1, 1, 'site-diary/entries'),
(2, 'Equipment Inventory', 'EquiPack', 'A very intuitive tool for managing inventory of construction equipment, tools & machinery', 'fa fa-truck', 'icon-mobile', NULL, 376, 1, 2, 1, 'equipment-inventory/list'),
(3, 'Projects Portfolio', 'SmartFolio', 'A Comprehensive Portfolio Management software for construction and consulting firms', 'fa fa-folder-open', 'icon-layers', NULL, 376, 1, 3, 1, NULL),
(4, 'Suppliers Management', 'SuppliersOnline', 'Place online orders for construction materials, equipment, tools and other supplies', 'fa fa-shopping-cart', 'icon-basket', NULL, 376, 1, 4, 1, NULL),
(5, 'Accounting & Payroll', 'Accounting', 'This module caters for all your accounting, human resources & payroll needs', 'fa fa-briefcase', 'icon-briefcase', NULL, 376, 1, 5, 1, NULL),
(6, 'Resource Planning', 'ResourcePlanner', 'Manages supplies inventory, materials, equipment, tools and personnel dispatch to projects sites', 'fa fa-cube', 'icon-tablet', NULL, 376, 1, 7, 1, NULL),
(7, 'Share Drawings', 'DrawShare', 'Share design drawings & docs with teams and access them from multiple devices and from multiple locations.', 'fa fa-share', 'icon-share', NULL, 376, 1, 8, 0, NULL),
(8, 'Reporting', 'Reporting & Dashboard', 'Comprehensive reporting engine to give a holistic view of the business', 'fa fa-bar-chart', 'icon-bar-chart', NULL, 376, 1, 9, 1, NULL),
(9, 'Staff/Users Setup', 'Manage_Staff', 'Users mandated to access store backend', 'fa fa-users', NULL, NULL, 376, 0, 1, 1, NULL),
(10, 'Online Store Setup', 'Online_Store', 'Store front used to manage retail items on sale', 'fa fa-shopping-cart', NULL, NULL, 376, 0, 2, 1, NULL),
(11, 'Properties Setup', 'Properties', 'Manage property marked for rent or sale', 'fa fa-building', NULL, NULL, 376, 0, 3, 1, NULL),
(12, 'HR Manager', 'HR_Manager', 'Human resource Management to take care of all of a companies human resource needs', 'fa fa-users', 'icon-users', NULL, 376, 1, 6, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hub_bid`
--

CREATE TABLE `hub_bid` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `bid_code` varchar(25) DEFAULT NULL,
  `description` text,
  `feature_image` varchar(55) DEFAULT NULL,
  `gallery` longtext,
  `bid_duration` int(4) NOT NULL,
  `flat_fee` double(10,3) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  `starting_at` datetime DEFAULT NULL,
  `ending_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hub_bid`
--

INSERT INTO `hub_bid` (`id`, `name`, `bid_code`, `description`, `feature_image`, `gallery`, `bid_duration`, `flat_fee`, `is_enabled`, `is_open`, `starting_at`, `ending_at`) VALUES
(3, 'Top Suppliers Premium Placement', 'TOP_SUPPLIER', NULL, '9fa0b088cf19dd7a65ca0b63203423d8.jpeg', 'a:3:{i:0;s:36:\"e29589b39f925fecd347409960188013.png\";i:1;s:36:\"bdd00b54a41c03e5d990f63b44320641.png\";i:2;s:36:\"d83300658a38d57e80e1f8a13f1ecb27.png\";}', 2, NULL, 1, 1, '2019-04-29 00:00:00', '2019-05-03 00:00:00'),
(4, 'Premium Product', 'PREMIUM_PRODUCT', NULL, '32a8ed73268d13c6afeed91933bfa5b3.png', 'N;', 2, NULL, 1, 0, '2019-04-27 00:00:00', '2019-04-30 00:00:00'),
(5, 'Weekly Deals Slot', 'WEEKLY_DEALS', 'Allows suppliers to promote specific products on a weekly basis by offering discounts or price reduction. This is aimed moving certain products from the shelf', NULL, NULL, 2, NULL, 1, 0, '2019-09-21 00:00:00', '2019-09-28 00:00:00'),
(6, 'Mid Page Slot', 'MID_PAGE_SLOT', NULL, NULL, 'N;', 2, NULL, 1, 1, '2019-10-07 00:00:00', '2019-10-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `institution`
--

CREATE TABLE `institution` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(25) DEFAULT NULL,
  `slug` varchar(225) NOT NULL,
  `description` text,
  `logo` varchar(55) DEFAULT NULL,
  `type` varchar(25) NOT NULL DEFAULT 'academic',
  `country_code` varchar(10) NOT NULL DEFAULT 'GH',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institution`
--

INSERT INTO `institution` (`id`, `user_id`, `name`, `short_name`, `slug`, `description`, `logo`, `type`, `country_code`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Ghana Institute of Engineers', 'GhIE', 'ghana-institute-of-engineers', NULL, NULL, 'professional', 'GH', '0000-00-00 00:00:00', '2018-08-22 13:03:09'),
(2, NULL, 'Ghana Institution of Surveyors', 'GhIS', 'ghana-institution-ofsurveyors', NULL, NULL, 'professional', 'GH', '0000-00-00 00:00:00', '2018-08-22 13:03:09'),
(3, NULL, 'University of Ghana, Legon', 'UG', 'university-of-ghana', NULL, NULL, 'academic', 'GH', '0000-00-00 00:00:00', '2018-08-22 13:03:09'),
(4, NULL, 'Kwame Nkrumah University of Science and Technology, Kumasi', 'KNUST', 'kwame-nkrumah-university-of-science-and-technology', NULL, NULL, 'academic', 'GH', '0000-00-00 00:00:00', '2018-08-22 13:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

CREATE TABLE `invite` (
  `id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `invited_by` int(11) NOT NULL,
  `user_type` varchar(55) DEFAULT NULL,
  `has_responded` tinyint(1) NOT NULL DEFAULT '0',
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `response_date` datetime DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(55) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invite`
--

INSERT INTO `invite` (`id`, `email`, `invited_by`, `user_type`, `has_responded`, `is_sent`, `response_date`, `agent`, `ip_address`, `created_at`, `updated_at`) VALUES
(9, 'mawuenaq@gmail.com', 376, 'SUPPLIER', 0, 0, NULL, NULL, NULL, '2018-09-01 19:29:43', '2018-09-01 17:29:43'),
(10, 'btlclients@gmail.com', 376, 'PROFESSIONAL', 0, 0, NULL, NULL, NULL, '2018-09-01 19:29:43', '2018-09-01 17:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `town_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `town_id`, `name`, `slug`) VALUES
(1, 1, 'Spintex Road', 'spintex-road'),
(2, 1, 'Zongo Junction', 'zongo-junction');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `entity` varchar(100) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `emailed_to` varchar(55) DEFAULT NULL,
  `sms_to` varchar(55) DEFAULT NULL,
  `is_viewed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `subject`, `body`, `user_id`, `entity`, `entity_id`, `company_id`, `emailed_to`, `sms_to`, `is_viewed`, `created_at`, `updated_at`) VALUES
(5, 'Quotation Request', 'Your request on BuildersHub has been received. You will soon be contacted.', NULL, 'App:QuotationRequest', 53, NULL, '0208621611', '+233208621611', 0, '2019-04-27 01:34:34', '2019-04-26 23:34:34'),
(6, 'Quotation Request', 'Your request on BuildersHub has been received. You will soon be contacted.', NULL, 'App:QuotationRequest', 54, NULL, '0546401593', '+233546401593', 0, '2019-05-04 13:12:38', '2019-05-04 11:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `open_bid`
--

CREATE TABLE `open_bid` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bid_amount` double(10,3) DEFAULT NULL,
  `banner` varchar(55) DEFAULT NULL,
  `end_date` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `open_bid`
--

INSERT INTO `open_bid` (`id`, `supplier_id`, `product_id`, `bid_id`, `user_id`, `bid_amount`, `banner`, `end_date`, `created_at`, `updated_at`) VALUES
(2, 22, 26, 4, NULL, 200.000, NULL, '2018-07-26 00:00:00', '2018-07-12 17:58:00', '2018-07-12 15:58:01'),
(3, 22, 23, 4, NULL, 200.000, NULL, '2018-07-26 00:00:00', '2018-07-13 12:09:18', '2018-07-13 10:09:20'),
(4, 22, 20, 4, NULL, 150.000, NULL, '2018-07-26 00:00:00', '2018-07-13 12:28:09', '2018-07-13 10:28:09'),
(5, 22, 21, 4, 376, 150.000, '5b4cfac1bbced349296715.jpg', '2018-07-26 00:00:00', '2018-07-14 05:31:39', '2018-07-16 22:06:25'),
(6, 22, 40, 4, 376, 80.000, NULL, '2018-07-26 00:00:00', '2018-07-16 23:30:45', '2018-07-16 21:30:45'),
(7, 22, 37, 4, 376, 75.000, NULL, '2018-07-26 00:00:00', '2018-07-16 23:36:11', '2018-07-16 21:36:11'),
(8, 22, 33, 4, 376, 300.000, NULL, '2018-10-27 00:00:00', '2018-10-13 20:09:45', '2018-10-13 18:09:45'),
(9, 22, 40, 4, 376, 250.000, NULL, '2018-10-27 00:00:00', '2018-10-13 21:04:49', '2018-10-13 19:04:49'),
(10, 22, 21, 4, 376, 300.000, NULL, '2018-11-27 00:00:00', '2018-11-09 15:17:20', '2018-11-09 14:17:21'),
(11, 22, 25, 4, 376, 80.000, NULL, '2018-11-27 00:00:00', '2018-11-09 16:30:08', '2018-11-09 15:30:08'),
(12, 22, 20, 4, 376, 320.000, NULL, '2019-02-22 00:00:00', '2019-02-09 18:08:52', '2019-02-09 17:08:52'),
(13, 22, 23, 4, 376, 50.000, NULL, '2019-02-22 00:00:00', '2019-03-06 12:21:38', '2019-03-06 11:21:38'),
(14, 22, 32, 4, 376, 200.000, NULL, '2019-03-30 00:00:00', '2019-03-09 01:57:18', '2019-03-09 00:57:19'),
(15, 22, 32, 4, 376, 400.000, NULL, '2019-05-14 00:00:00', '2019-05-14 00:00:00', '2019-04-29 13:58:45'),
(16, 22, 26, 4, 376, 500.000, NULL, '2019-05-14 00:00:00', '2019-04-29 16:36:12', '2019-04-29 14:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `line` int(3) DEFAULT NULL,
  `quantity_ordered` int(11) NOT NULL,
  `sub_total` double(10,3) DEFAULT NULL,
  `tax` double(10,3) DEFAULT NULL,
  `total` double(10,3) DEFAULT NULL,
  `sale_price` double(10,3) DEFAULT NULL,
  `discount_percent` int(3) DEFAULT NULL,
  `serial_number` varchar(55) DEFAULT NULL,
  `promo_code` varchar(55) DEFAULT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'Pending',
  `remarks` text,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `line`, `quantity_ordered`, `sub_total`, `tax`, `total`, `sale_price`, `discount_percent`, `serial_number`, `promo_code`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 20, NULL, 2, 978.000, 171.150, 1149.150, 489.000, NULL, NULL, NULL, 'Pending', NULL, '2018-07-04 12:42:29', '2018-07-04 10:42:29'),
(2, 1, 31, NULL, 5, 2175.000, 380.625, 2555.625, 435.000, NULL, NULL, NULL, 'Pending', NULL, '2018-07-04 12:42:29', '2018-07-04 10:42:30'),
(3, 2, 6, NULL, 1, 820.000, 143.500, 963.500, 820.000, NULL, NULL, NULL, 'Pending', NULL, '2019-04-24 20:43:02', '2019-04-24 18:43:05'),
(4, 2, 28, NULL, 6, 27.000, 4.725, 31.725, 4.500, NULL, NULL, NULL, 'Pending', NULL, '2019-04-24 20:43:02', '2019-04-24 18:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `page_view`
--

CREATE TABLE `page_view` (
  `id` int(11) NOT NULL,
  `viewed_by` int(11) DEFAULT NULL,
  `date_viewed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agent` varchar(255) DEFAULT NULL,
  `page` varchar(55) DEFAULT NULL,
  `entity` varchar(55) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `ip_address` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_view`
--

INSERT INTO `page_view` (`id`, `viewed_by`, `date_viewed`, `agent`, `page`, `entity`, `entity_id`, `ip_address`) VALUES
(135, 376, '2018-07-18 17:22:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 41, '127.0.0.1'),
(136, 376, '2018-07-18 17:31:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 41, '127.0.0.1'),
(137, 376, '2018-07-18 17:37:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(138, 376, '2018-07-18 17:39:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(139, 376, '2018-07-18 18:04:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 6, '127.0.0.1'),
(140, 376, '2018-07-18 19:01:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(141, 376, '2018-07-18 19:02:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 31, '127.0.0.1'),
(142, 376, '2018-07-18 23:20:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(143, 376, '2018-07-18 23:21:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(144, 376, '2018-07-18 23:23:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(145, 376, '2018-07-18 23:25:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(146, 376, '2018-07-19 16:05:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 6, '127.0.0.1'),
(147, 376, '2018-07-19 17:57:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(148, 376, '2018-07-19 18:15:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(149, 376, '2018-07-19 18:22:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(150, 376, '2018-07-19 18:24:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(151, 376, '2018-07-19 18:24:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(152, 376, '2018-07-19 18:25:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(153, 376, '2018-07-19 18:28:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(154, 376, '2018-07-19 18:30:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(155, 376, '2018-07-19 18:35:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(156, 376, '2018-07-19 18:51:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(157, 376, '2018-07-19 18:52:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(158, 376, '2018-07-19 18:52:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(159, 376, '2018-07-19 18:53:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(160, 376, '2018-07-19 19:04:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(161, 376, '2018-07-19 19:05:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(162, 376, '2018-07-19 19:06:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(163, 376, '2018-07-19 19:21:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(164, 376, '2018-07-19 22:24:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(165, 376, '2018-07-19 22:26:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(166, 376, '2018-07-20 12:36:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(167, NULL, '2018-07-20 23:35:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 6, '127.0.0.1'),
(168, NULL, '2018-07-20 23:38:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 6, '127.0.0.1'),
(169, NULL, '2018-07-24 13:59:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(170, NULL, '2018-07-24 14:09:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(171, 376, '2018-07-24 14:12:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(172, 376, '2018-07-24 15:14:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(173, 376, '2018-07-25 00:03:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(174, 376, '2018-07-25 00:04:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(175, 376, '2018-07-25 00:05:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(176, 376, '2018-07-25 00:06:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(177, 376, '2018-07-25 00:07:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(178, 376, '2018-07-25 00:08:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(179, 376, '2018-07-25 00:18:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(180, 376, '2018-07-25 00:21:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(181, 376, '2018-07-25 00:26:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(182, 376, '2018-07-25 00:27:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 34, '127.0.0.1'),
(183, 376, '2018-07-25 00:27:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(184, 376, '2018-07-25 10:24:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 33, '127.0.0.1'),
(185, 376, '2018-07-25 10:44:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 33, '127.0.0.1'),
(186, 379, '2018-07-25 19:59:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(187, 379, '2018-07-25 20:02:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(188, 379, '2018-07-25 20:02:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(189, 379, '2018-07-25 20:03:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(190, 379, '2018-07-25 20:03:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(191, 379, '2018-07-25 20:03:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(192, 379, '2018-07-26 11:00:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(193, 379, '2018-07-26 18:00:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(194, NULL, '2018-07-26 18:13:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(195, NULL, '2018-07-26 18:13:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 42, '127.0.0.1'),
(196, NULL, '2018-07-26 18:15:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 42, '127.0.0.1'),
(197, 379, '2018-07-26 18:37:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 42, '127.0.0.1'),
(198, 379, '2018-07-26 18:41:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 42, '127.0.0.1'),
(199, 376, '2018-07-31 18:47:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 3, '127.0.0.1'),
(200, 376, '2018-07-31 18:48:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 3, '127.0.0.1'),
(201, 376, '2018-07-31 19:54:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 5, '127.0.0.1'),
(202, 376, '2018-07-31 20:17:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 2, '127.0.0.1'),
(203, NULL, '2018-08-01 05:44:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0', 'PropertyDetailsPage', 'App:Property', 6, '127.0.0.1'),
(204, 376, '2018-08-01 06:28:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 7, '127.0.0.1'),
(205, 376, '2018-08-01 18:15:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 2, '127.0.0.1'),
(206, 376, '2018-08-01 18:32:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 2, '127.0.0.1'),
(207, 376, '2018-08-01 18:34:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 4, '127.0.0.1'),
(208, 376, '2018-08-01 18:37:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 6, '127.0.0.1'),
(209, 376, '2018-08-01 19:16:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 4, '127.0.0.1'),
(210, 376, '2018-08-01 19:16:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 4, '127.0.0.1'),
(211, 376, '2018-08-01 22:00:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(212, NULL, '2018-08-03 16:12:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 2, '127.0.0.1'),
(213, 376, '2018-08-05 12:03:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(214, 376, '2018-08-05 12:04:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(215, 376, '2018-08-05 12:04:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(216, 376, '2018-08-11 07:20:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(217, 376, '2018-08-11 15:43:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36', 'ProductDetailsPage', 'App:Product', 5, '127.0.0.1'),
(218, 376, '2018-08-13 21:46:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 4, '127.0.0.1'),
(219, 376, '2018-08-13 21:47:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 4, '127.0.0.1'),
(220, 376, '2018-08-13 21:48:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 4, '127.0.0.1'),
(221, 376, '2018-09-02 22:44:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(222, 376, '2018-09-07 19:41:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 6, '127.0.0.1'),
(223, 376, '2018-09-07 19:44:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'PropertyDetailsPage', 'App:Property', 6, '127.0.0.1'),
(224, 376, '2018-09-08 17:43:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(225, 376, '2018-09-16 03:58:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'ProfilePage', 'App:User', 381, '127.0.0.1'),
(226, 376, '2018-09-16 04:15:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(227, 376, '2018-09-16 04:30:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(228, 376, '2018-09-17 13:34:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(229, 376, '2018-09-25 12:49:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(230, 376, '2018-09-26 15:03:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(231, 376, '2018-10-02 23:16:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(232, 376, '2018-10-03 01:02:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(233, 376, '2018-10-03 12:26:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 381, '127.0.0.1'),
(234, NULL, '2018-10-07 11:07:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0', 'ProductDetailsPage', 'App:Product', 3, '127.0.0.1'),
(235, 376, '2018-10-07 21:46:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProductDetailsPage', 'App:Product', 8, '127.0.0.1'),
(236, 376, '2018-10-13 19:31:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 379, '127.0.0.1'),
(237, 376, '2018-10-13 21:03:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProductDetailsPage', 'App:Product', 40, '127.0.0.1'),
(238, 376, '2018-10-13 21:13:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(239, 376, '2018-10-13 21:21:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProductDetailsPage', 'App:Product', 41, '127.0.0.1'),
(240, 376, '2018-10-13 21:24:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProductDetailsPage', 'App:Product', 41, '127.0.0.1'),
(241, 376, '2018-10-15 17:45:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(242, 376, '2018-10-15 17:59:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(243, 376, '2018-10-15 18:05:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(244, 376, '2018-10-15 18:09:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(245, 376, '2018-10-15 18:13:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(246, 376, '2018-10-15 18:32:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(247, 376, '2018-10-15 18:35:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(248, 376, '2018-10-15 18:42:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(249, 376, '2018-10-15 18:50:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(250, 376, '2018-10-15 18:59:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(251, 376, '2018-10-15 19:00:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(252, 376, '2018-10-15 19:01:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(253, 376, '2018-10-17 00:40:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(254, 376, '2018-10-17 00:43:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(255, 376, '2018-10-17 00:45:46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(256, 376, '2018-10-17 00:47:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(257, 376, '2018-10-17 00:50:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(258, NULL, '2018-10-20 20:45:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(259, NULL, '2018-10-20 21:00:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(260, NULL, '2018-10-20 23:17:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 27, '127.0.0.1'),
(261, NULL, '2018-10-20 23:22:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 27, '127.0.0.1'),
(262, NULL, '2018-10-22 16:28:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(263, NULL, '2018-10-22 16:41:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(264, NULL, '2018-10-22 16:44:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(265, NULL, '2018-10-22 16:46:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(266, NULL, '2018-10-22 16:58:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(267, NULL, '2018-10-22 19:01:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(268, NULL, '2018-10-22 19:06:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(269, NULL, '2018-10-22 19:08:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(270, NULL, '2018-10-22 19:11:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(271, NULL, '2018-10-22 19:17:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(272, NULL, '2018-10-22 19:19:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(273, NULL, '2018-10-22 19:22:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(274, NULL, '2018-10-22 19:23:43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(275, NULL, '2018-10-22 19:24:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(276, NULL, '2018-10-22 19:26:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(277, NULL, '2018-10-22 19:27:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(278, NULL, '2018-10-22 19:38:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(279, NULL, '2018-10-23 09:36:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(280, NULL, '2018-10-23 09:42:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(281, NULL, '2018-10-23 09:53:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(282, NULL, '2018-10-23 09:56:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(283, NULL, '2018-10-23 10:06:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(284, NULL, '2018-10-23 10:12:24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(285, NULL, '2018-10-23 10:14:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(286, NULL, '2018-10-23 10:16:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(287, NULL, '2018-10-23 10:18:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(288, NULL, '2018-10-23 10:21:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(289, NULL, '2018-10-23 10:23:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(290, NULL, '2018-10-23 10:24:24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(291, NULL, '2018-10-23 10:30:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(292, NULL, '2018-10-23 10:32:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(293, NULL, '2018-10-23 10:43:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(294, NULL, '2018-10-23 10:44:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 25, '127.0.0.1'),
(295, NULL, '2018-10-23 10:45:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(296, NULL, '2018-10-23 10:46:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(297, NULL, '2018-10-23 10:49:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(298, NULL, '2018-10-23 10:52:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 27, '127.0.0.1'),
(299, NULL, '2018-10-23 11:15:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'SupplierStore', 'App:Supplier', 27, '127.0.0.1'),
(300, 376, '2018-10-28 21:38:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(301, 376, '2018-11-06 10:10:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 387, '127.0.0.1'),
(302, 376, '2018-11-06 17:26:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 387, '127.0.0.1'),
(303, 376, '2018-11-06 17:59:43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(304, 376, '2018-11-06 22:00:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(305, 376, '2018-11-09 11:22:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(306, 376, '2018-11-09 12:49:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(307, 376, '2018-11-09 13:02:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProductDetailsPage', 'App:Product', 41, '127.0.0.1'),
(308, 376, '2018-11-09 13:08:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(309, 376, '2018-11-09 17:10:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(310, 376, '2018-11-09 17:10:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(311, 376, '2018-11-09 17:13:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(312, 376, '2018-11-12 16:56:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 381, '127.0.0.1'),
(313, 376, '2018-11-12 16:59:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(314, 376, '2018-11-12 17:15:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(315, 376, '2018-11-12 17:18:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(316, 376, '2018-11-16 10:57:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(317, 376, '2018-11-24 11:15:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(318, 376, '2018-11-24 12:13:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(319, 376, '2018-11-28 09:34:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 25, '127.0.0.1'),
(320, 376, '2018-11-28 11:59:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 28, '127.0.0.1'),
(321, 376, '2018-11-28 12:01:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(322, 376, '2018-11-28 12:06:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(323, 376, '2018-11-28 12:08:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(324, 376, '2018-11-28 12:10:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(325, 376, '2018-11-28 12:13:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(326, 376, '2018-11-28 12:41:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(327, 376, '2018-11-28 12:42:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(328, 376, '2018-11-28 13:08:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(329, 376, '2018-11-28 13:09:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(330, 376, '2018-11-28 13:14:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(331, 376, '2018-11-28 13:15:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(332, 376, '2018-12-09 14:23:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(333, 376, '2018-12-09 14:40:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(334, 376, '2018-12-09 15:05:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(335, 376, '2018-12-10 08:03:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(336, 376, '2018-12-10 08:15:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(337, 376, '2018-12-10 17:15:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(338, 376, '2018-12-10 17:18:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(339, 376, '2018-12-10 17:20:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(340, 376, '2018-12-10 17:33:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(341, 376, '2018-12-10 17:41:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(342, 376, '2018-12-10 17:43:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(343, 376, '2018-12-10 17:45:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(344, 376, '2018-12-11 11:06:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(345, NULL, '2018-12-12 13:02:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(346, 376, '2018-12-28 03:07:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(347, 376, '2018-12-28 03:16:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(348, 376, '2019-01-06 18:23:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(349, 376, '2019-01-06 18:30:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(350, 376, '2019-01-06 18:56:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(351, 376, '2019-01-06 18:57:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(352, NULL, '2019-01-11 21:41:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(353, NULL, '2019-01-11 21:42:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(354, 376, '2019-01-13 00:36:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(355, 376, '2019-01-17 10:39:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(356, 376, '2019-01-30 00:12:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(357, 376, '2019-01-31 17:33:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(358, 376, '2019-02-02 22:48:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(359, 376, '2019-02-02 22:51:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', 'ProfilePage', 'App:User', 387, '127.0.0.1'),
(360, 376, '2019-02-09 14:00:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36', 'SupplierStore', 'App:Supplier', 26, '127.0.0.1'),
(361, 376, '2019-02-09 20:47:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(362, NULL, '2019-02-12 13:41:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(363, 376, '2019-03-29 11:41:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(364, 376, '2019-03-29 12:01:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', 'SupplierStore', 'App:Supplier', 26, '127.0.0.1'),
(365, 376, '2019-03-29 13:03:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', 'SupplierStore', 'App:Supplier', 26, '127.0.0.1'),
(366, 376, '2019-03-29 13:03:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(367, 376, '2019-04-18 02:48:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', 'ProfilePage', 'App:User', 390, '127.0.0.1'),
(368, 376, '2019-04-23 18:52:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(369, NULL, '2019-04-23 19:34:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', 'ProductDetailsPage', 'App:Product', 42, '127.0.0.1'),
(370, 376, '2019-04-24 20:27:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(371, 376, '2019-04-24 20:28:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(372, 376, '2019-04-29 02:29:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', 'ProductDetailsPage', 'App:Product', 14, '127.0.0.1'),
(373, 376, '2019-04-29 18:02:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', 'ProductDetailsPage', 'App:Product', 26, '127.0.0.1'),
(374, 376, '2019-04-30 12:23:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(375, 376, '2019-04-30 12:25:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(376, 376, '2019-04-30 12:27:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(377, 376, '2019-05-03 21:54:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(378, 376, '2019-05-07 01:35:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(379, 376, '2019-05-07 23:33:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(380, 376, '2019-05-09 21:31:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(381, 376, '2019-05-15 13:15:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'ProductDetailsPage', 'App:Product', 4, '127.0.0.1'),
(382, NULL, '2019-05-17 17:27:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1');
INSERT INTO `page_view` (`id`, `viewed_by`, `date_viewed`, `agent`, `page`, `entity`, `entity_id`, `ip_address`) VALUES
(383, NULL, '2019-05-17 17:34:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(384, NULL, '2019-05-17 17:36:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(385, NULL, '2019-05-17 17:37:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(386, NULL, '2019-05-17 17:54:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(387, NULL, '2019-05-17 17:59:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(388, NULL, '2019-05-27 12:05:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', 'ProductDetailsPage', 'App:Product', 42, '127.0.0.1'),
(389, NULL, '2019-05-28 19:22:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(390, NULL, '2019-05-28 19:30:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(391, 376, '2019-07-27 23:46:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(392, 376, '2019-07-28 01:35:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(393, 376, '2019-07-28 02:19:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(394, 376, '2019-08-01 14:53:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(395, NULL, '2019-08-05 13:45:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(396, NULL, '2019-08-05 13:55:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(397, NULL, '2019-08-05 14:08:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(398, NULL, '2019-08-05 15:49:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(399, NULL, '2019-08-05 17:09:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(400, NULL, '2019-08-05 17:11:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(401, NULL, '2019-08-05 17:14:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(402, NULL, '2019-08-05 17:16:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(403, NULL, '2019-08-05 17:36:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(404, NULL, '2019-08-06 16:38:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(405, NULL, '2019-08-06 17:16:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(406, NULL, '2019-08-06 18:16:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(407, NULL, '2019-08-06 18:21:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(408, NULL, '2019-08-06 18:24:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(409, NULL, '2019-08-07 10:00:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(410, NULL, '2019-08-07 10:18:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(411, NULL, '2019-08-07 10:40:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(412, NULL, '2019-08-07 11:28:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(413, NULL, '2019-08-07 11:41:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(414, NULL, '2019-08-07 12:11:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(415, NULL, '2019-08-07 12:15:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(416, NULL, '2019-08-07 12:27:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(417, NULL, '2019-08-07 12:48:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(418, NULL, '2019-08-07 13:09:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(419, NULL, '2019-08-07 14:57:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(420, NULL, '2019-08-07 14:59:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(421, NULL, '2019-08-07 15:10:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(422, NULL, '2019-08-07 16:43:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(423, NULL, '2019-08-07 16:53:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(424, 376, '2019-08-07 17:09:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(425, 376, '2019-08-07 17:11:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(426, 376, '2019-08-07 17:13:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(427, 376, '2019-08-07 17:17:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(428, 376, '2019-08-07 22:09:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(429, 376, '2019-08-07 22:13:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(430, 376, '2019-08-07 22:20:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'ProductDetailsPage', 'App:Product', 4, '127.0.0.1'),
(431, 376, '2019-08-07 22:24:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(432, 376, '2019-08-07 22:30:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(433, 376, '2019-08-07 22:36:46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(434, 376, '2019-08-07 22:41:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(435, 376, '2019-08-07 22:44:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(436, 376, '2019-08-07 22:47:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(437, 376, '2019-08-07 22:59:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(438, 376, '2019-08-07 23:06:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(439, 376, '2019-08-08 00:01:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(440, 376, '2019-08-08 00:13:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(441, 376, '2019-08-08 00:20:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(442, 376, '2019-08-08 00:23:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(443, 376, '2019-08-08 00:39:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(444, 376, '2019-08-08 00:47:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(445, 376, '2019-08-08 00:54:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(446, 376, '2019-08-08 00:56:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(447, 376, '2019-08-08 01:02:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(448, 376, '2019-08-08 01:04:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(449, 376, '2019-08-08 01:07:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(450, 376, '2019-08-08 01:12:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(451, 376, '2019-08-08 01:16:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(452, 376, '2019-08-08 01:20:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(453, 376, '2019-08-08 08:23:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(454, 376, '2019-08-08 10:39:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(455, 376, '2019-08-08 10:42:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(456, 376, '2019-08-08 10:51:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(457, 376, '2019-08-08 10:55:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(458, 376, '2019-08-08 10:59:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(459, 376, '2019-08-08 11:04:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(460, 376, '2019-08-08 11:24:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(461, 376, '2019-08-08 11:34:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(462, 376, '2019-08-08 11:54:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(463, 376, '2019-08-08 11:59:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(464, 376, '2019-08-08 12:04:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(465, 376, '2019-08-08 12:10:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(466, 376, '2019-08-08 12:18:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(467, 376, '2019-08-08 12:29:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(468, 376, '2019-08-08 13:34:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(469, 376, '2019-08-08 13:41:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(470, 376, '2019-08-08 14:28:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(471, 376, '2019-08-08 14:32:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(472, 376, '2019-08-08 14:43:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(473, 376, '2019-08-08 15:05:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(474, 376, '2019-08-08 16:36:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(475, 376, '2019-08-08 16:39:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(476, 376, '2019-08-08 16:43:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(477, 376, '2019-08-08 16:51:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(478, 376, '2019-08-08 16:58:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(479, 376, '2019-08-08 17:00:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(480, 376, '2019-08-08 17:02:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(481, 376, '2019-08-08 17:06:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 25, '127.0.0.1'),
(482, 376, '2019-08-08 21:37:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 25, '127.0.0.1'),
(483, 376, '2019-08-08 22:01:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 25, '127.0.0.1'),
(484, 376, '2019-08-08 22:07:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(485, 376, '2019-08-08 22:12:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(486, 376, '2019-08-08 22:33:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(487, 376, '2019-08-08 22:44:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(488, 376, '2019-08-08 22:47:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(489, 376, '2019-08-08 22:48:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(490, 376, '2019-08-08 22:51:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(491, 376, '2019-08-08 22:54:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(492, 376, '2019-08-08 22:57:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(493, 376, '2019-08-08 23:00:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(494, 376, '2019-08-08 23:01:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(495, 376, '2019-08-08 23:07:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(496, NULL, '2019-08-08 23:29:24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(497, NULL, '2019-08-08 23:29:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(498, NULL, '2019-08-08 23:32:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(499, NULL, '2019-08-08 23:37:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(500, 376, '2019-08-29 10:02:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(501, 376, '2019-08-29 10:07:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(502, 376, '2019-09-24 20:10:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(503, 376, '2019-09-24 20:18:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(504, 376, '2019-09-24 20:44:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(505, 376, '2019-09-24 20:47:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(506, 376, '2019-09-24 20:51:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(507, 376, '2019-09-24 20:58:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(508, 376, '2019-09-24 21:01:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(509, 376, '2019-09-24 21:25:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(510, 376, '2019-09-24 21:29:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(511, 376, '2019-09-24 21:32:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 5, '127.0.0.1'),
(512, 376, '2019-09-30 15:00:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(513, 376, '2019-09-30 15:06:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(514, 376, '2019-09-30 15:08:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(515, 376, '2019-09-30 15:16:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(516, 376, '2019-09-30 15:18:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(517, 376, '2019-09-30 18:29:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(518, 376, '2019-10-01 11:12:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(519, 376, '2019-10-01 11:14:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(520, 376, '2019-10-01 11:16:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(521, 376, '2019-10-01 11:18:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(522, 376, '2019-10-01 11:21:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(523, 376, '2019-10-01 11:23:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(524, 376, '2019-10-01 11:24:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(525, 376, '2019-10-01 11:30:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(526, 376, '2019-10-01 11:45:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 3, '127.0.0.1'),
(527, NULL, '2019-10-01 14:41:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(528, NULL, '2019-10-01 16:03:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(529, NULL, '2019-10-01 16:07:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(530, NULL, '2019-10-01 16:16:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(531, NULL, '2019-10-01 16:20:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(532, NULL, '2019-10-01 16:22:46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(533, NULL, '2019-10-01 16:39:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(534, NULL, '2019-10-01 17:23:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(535, NULL, '2019-10-01 17:30:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(536, NULL, '2019-10-01 17:35:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(537, NULL, '2019-10-01 17:38:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(538, NULL, '2019-10-01 17:39:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(539, NULL, '2019-10-01 17:40:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 7, '127.0.0.1'),
(540, 376, '2019-10-18 11:04:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36', 'ProductDetailsPage', 'App:Product', 9, '127.0.0.1'),
(541, NULL, '2019-11-18 10:48:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(542, NULL, '2019-11-18 10:55:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(543, NULL, '2019-11-18 13:49:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(544, NULL, '2019-11-18 13:51:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(545, NULL, '2019-11-18 15:21:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(546, NULL, '2019-11-19 14:11:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(547, 376, '2019-11-26 17:59:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(548, 376, '2019-11-26 19:46:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(549, 376, '2019-11-26 19:47:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(550, 376, '2019-11-26 19:48:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(551, 376, '2019-11-27 10:17:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'RentalPlacementPage', 'App:RentalAd', 6, '127.0.0.1'),
(552, 407, '2019-11-27 16:13:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'ProfilePage', 'App:User', 407, '127.0.0.1'),
(553, 407, '2019-11-27 16:15:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'ProfilePage', 'App:User', 407, '127.0.0.1'),
(554, 407, '2019-11-27 16:18:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'ProfilePage', 'App:User', 407, '127.0.0.1'),
(555, 407, '2019-11-27 16:19:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'ProfilePage', 'App:User', 407, '127.0.0.1'),
(556, 376, '2019-12-07 12:11:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(557, 376, '2019-12-07 12:14:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'ProfilePage', 'App:User', 387, '127.0.0.1'),
(558, 376, '2019-12-07 12:14:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'SupplierStore', 'App:Supplier', 22, '127.0.0.1'),
(559, NULL, '2019-12-18 18:57:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36', 'SupplierStore', 'App:Supplier', 24, '127.0.0.1'),
(560, 407, '2019-12-19 19:01:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36', 'ProfilePage', 'App:User', 407, '127.0.0.1'),
(561, 376, '2019-12-21 15:26:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(562, 376, '2019-12-21 15:30:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(563, 376, '2019-12-23 10:00:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(564, 376, '2019-12-23 21:20:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(565, 376, '2019-12-25 02:23:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(566, 376, '2019-12-25 02:46:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(567, 376, '2019-12-25 04:04:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(568, 376, '2019-12-25 04:06:24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(569, 376, '2019-12-25 04:08:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1'),
(570, 376, '2019-12-26 09:10:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36', 'ProfilePage', 'App:User', 376, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `person_type` varchar(55) NOT NULL,
  `title` varchar(55) DEFAULT NULL,
  `gender` varchar(55) DEFAULT NULL,
  `address` text,
  `contact_no` varchar(55) DEFAULT NULL,
  `alternate_email` varchar(55) DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `cover_picture` varchar(55) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `user_id`, `person_type`, `title`, `gender`, `address`, `contact_no`, `alternate_email`, `date_of_birth`, `profile_picture`, `cover_picture`, `created_at`, `updated_at`) VALUES
(2, 376, 'builder', NULL, NULL, 'P.O. Box 123', '0246738954', NULL, NULL, 'Alverna_Balika_ProfilePicture_2.jpg', 'Alverna_Balika_ProfileCover_2.jpg', '2018-09-08 09:15:51', '2019-12-26 09:09:02'),
(3, 379, 'guest', NULL, 'Male', NULL, NULL, NULL, NULL, '5b59c9904a473933696467.jpg', '5b59d90d19912100169138.jpg', '2018-07-26 15:16:00', '2018-07-26 16:22:05'),
(4, 380, 'guest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-29 20:35:59', '2018-07-29 18:35:59'),
(5, 381, 'builder', NULL, NULL, NULL, NULL, NULL, NULL, '5b8641418418f231329660.jpg', NULL, '2018-08-29 08:46:25', '2018-08-29 06:33:20'),
(10, 387, 'builder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-13 16:19:35', '2018-10-13 14:19:36'),
(11, 387, 'guest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-13 16:19:36', '2018-10-13 14:19:36'),
(12, 376, 'guest', NULL, NULL, NULL, '+233246738954', NULL, NULL, NULL, NULL, '2018-10-28 20:24:46', '2018-10-28 19:24:47'),
(14, 390, 'builder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-03 21:47:24', '2018-11-03 20:47:24'),
(17, 392, 'guest', NULL, NULL, NULL, '0246738954', NULL, NULL, NULL, NULL, '2018-11-08 15:46:14', '2018-11-08 14:46:14'),
(18, 393, 'guest', NULL, NULL, NULL, '0546401593', NULL, NULL, NULL, NULL, '2019-04-25 18:36:20', '2019-04-25 16:36:20'),
(19, 394, 'guest', NULL, NULL, NULL, '0208621611', NULL, NULL, NULL, NULL, '2019-04-25 20:06:24', '2019-04-25 18:06:24'),
(28, 399, 'builder', NULL, NULL, NULL, '+233246389635', NULL, NULL, NULL, NULL, '2019-05-17 17:14:01', '2019-05-17 17:14:01'),
(29, 400, 'builder', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2019-10-14 16:04:31', '2019-10-14 16:04:31'),
(33, 407, 'guest', NULL, NULL, NULL, '+233546401593', NULL, NULL, 'phanuel_balikaprofile_picture_ux9b1.jpg', 'phanuel_balika_profile_cover_6zl9p.jpg', '2019-11-27 16:15:07', '2019-11-27 16:17:44'),
(36, 410, 'builder', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2019-12-12 16:42:15', '2019-12-12 16:42:15'),
(37, 411, 'builder', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2019-12-12 18:48:46', '2019-12-12 18:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `content` text,
  `slug` varchar(255) DEFAULT NULL,
  `excerpt` text,
  `status` varchar(55) DEFAULT NULL,
  `post_type` varchar(55) DEFAULT NULL,
  `is_commentable` tinyint(1) NOT NULL DEFAULT '1',
  `comment_count` int(11) NOT NULL DEFAULT '0',
  `publish_date` datetime DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `feature_image` varchar(55) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `company_id`, `title`, `content`, `slug`, `excerpt`, `status`, `post_type`, `is_commentable`, `comment_count`, `publish_date`, `is_published`, `feature_image`, `created_at`, `updated_at`) VALUES
(1, 376, NULL, 'Baseline Technologies Ltd Launches e-Commerce Platform for the Building and Construction Sector', 'After years of research and dialog and through personal experiences, a team of construction industry players have come out with a comprehensive platform that bring together artisans, engineers, architects, surveyors, cost estimators, supplies, property owners etc. This makes the exchange of goods and services easy and seemless.', 'baseline-technologies-ltd-launches-e-commerce-platform-for-the-building-and-construction-sector', 'After years of research and dialog and through personal experiences, a team of construction industry players have come out with a comprehensive platform that bring together artisans, engineers, architects, surveyors, cost estimators, supplies, property owners etc. This makes the exchange of goods and services easy and seamless.', 'published', 'blog', 1, 0, NULL, 1, '5b5c561d648d2276803410.jpg', '2018-07-28 13:40:13', '2018-07-28 11:12:53'),
(2, 376, NULL, 'Taking Advantage of eCommerce to power growth', 'Electronic Commerce (eCommerce for short) has become a powerful revolution that has the potential to propel small and medium size businesses to grow and reach a wide range of potential buyers', 'taking-advantage-of-ecommerce-to-power-growth', 'Electronic Commerce (eCommerce for short) has become a powerful revolution that has the potential to propel small and medium size businesses to grow and reach a wide range of potential buyers', 'published', 'blog', 1, 0, NULL, 1, '5b5c6a42a478c970513444.jpg', '2018-07-28 15:06:10', '2018-07-28 13:06:10'),
(3, 376, NULL, 'Our infrastructure is broken and needs some serious minds to help fix it', NULL, 'our-infrastructure-is-broken-and-needs-some-serious-minds-to-help-fix-it', NULL, NULL, 'status', 1, 1, NULL, 1, '5b6f023674917411602757.jpg', '2018-08-11 17:35:18', '2018-08-11 15:35:18'),
(4, 376, NULL, 'Is it possible to get all our rural roads paved within 10 years from now? Experts please share your thoughts', NULL, 'is-it-possible-to-get-all-our-rural-roads-paved-within-10-years-from-now-experts-please-share-your-thoughts', NULL, NULL, 'status', 1, 0, NULL, 1, '5b6f0dfe34e23510540882.jpg', '2018-08-11 18:25:34', '2018-08-11 16:25:34'),
(5, 376, NULL, 'What\'s you view on the decision of the government to suspend all infrastructure investments for the next 3 years?', NULL, 'what-s-you-view-on-the-decision-of-the-government-to-suspend-all-infrastructure-investments-for-the-next-3-years', NULL, NULL, 'status', 1, 0, NULL, 1, NULL, '2018-08-11 20:58:13', '2018-08-11 18:58:13'),
(6, 376, NULL, 'Making the most of BuildersHub - The One-Stop-Hub for Builders', NULL, 'making-the-most-of-buildershub-the-one-stop-hub-for-builders', 'I bring the latest update on the getting maximum value out you BuildersHub account. In the first post,  I am going to take your the Getting Started section.', 'published', 'blog', 1, 0, NULL, 1, 'Post_Featured_Photo_.jpg', '2018-11-16 13:46:23', '2018-11-16 12:46:23'),
(7, 376, NULL, 'What\'s ur view on Veep directive to construct concrete roads?', NULL, 'what-s-ur-view-on-veep-directive-to-construct-concrete-roads', NULL, NULL, 'status', 1, 0, NULL, 1, NULL, '2018-12-10 17:15:38', '2018-12-10 16:15:38'),
(10, 376, 22, 'Visualizing information with Civil 3D', 'Baseline Trading Enterprise is partnering with N-Dimension Engineering Services Ltd to bring the best in 3D data visualization with the most popular civil engineering software', 'visualizing-information-with-civil-3d', NULL, NULL, 'status', 1, 0, NULL, 1, NULL, '2019-01-30 17:33:41', '2019-01-30 16:33:41'),
(11, 376, 22, 'Express Services for all Projects Before March 2019', 'Baseline Technologies Limited is reducing the prices of all its services from February to end of March 2019. Any services requested within this period will also be delivered half the the usual delivery time', 'express-services-for-all-projects-before-march-2019', NULL, NULL, 'status', 1, 0, NULL, 1, 'Post_Featured_Photo_.jpg', '2019-01-31 09:48:41', '2019-01-31 08:48:41'),
(12, 376, 22, 'Bridge Project Completed and Handed Over', 'We have just completed our flagship bridge design project for the Government of Ghana through the Ghana Highways Authority', 'bridge-project-completed-and-handed-over', NULL, NULL, 'status', 1, 0, NULL, 1, 'Post_Featured_Photo_.jpg', '2019-02-09 14:44:56', '2019-02-09 13:44:56'),
(13, 376, 22, 'Stakeholder Engagement with Road Sector Players', 'BTL held a stakeholder engagement with players in the road transport sector to deliberate on some of the innovative technologies that can be leveraged to accelerate economic development', 'stakeholder-engagement-with-road-sector-players', NULL, NULL, 'status', 1, 0, NULL, 1, 'Post_Featured_Photo_25941OM9.jpg', '2019-02-09 15:22:59', '2019-02-09 14:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `post_category`
--

CREATE TABLE `post_category` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `type` varchar(55) NOT NULL,
  `description` text,
  `image` varchar(55) DEFAULT NULL,
  `icon` varchar(55) DEFAULT NULL,
  `slug` varchar(55) NOT NULL,
  `count` int(11) DEFAULT '0',
  `rank` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_category`
--

INSERT INTO `post_category` (`id`, `user_id`, `name`, `parent_id`, `type`, `description`, `image`, `icon`, `slug`, `count`, `rank`, `deleted`) VALUES
(75, 376, 'E-Commerce', NULL, 'category', 'This holds all posts that talk about eCommerce in Ghana and Africa as  a whole. Specific areas of focus include  current trends, best practices, future outlook, opportunity and risks etc.', NULL, NULL, 'e-commerce', NULL, 2, 0),
(76, 376, 'Building Materials', NULL, 'tag', 'All building materials', NULL, NULL, 'building-materials', NULL, 2, 0),
(77, 376, 'e-Commerce Trends', NULL, 'tag', NULL, NULL, NULL, 'e-commerce-trends', NULL, 2, 0),
(78, 376, 'News', NULL, 'category', NULL, NULL, NULL, 'news', NULL, 1, 0),
(79, 376, 'Blog', NULL, 'category', NULL, NULL, NULL, 'blog', NULL, 1, 0),
(80, 376, 'Article', NULL, 'category', NULL, NULL, NULL, 'article', NULL, 1, 0),
(81, 376, 'Video', NULL, 'category', NULL, NULL, NULL, 'video', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_category_relationship`
--

CREATE TABLE `post_category_relationship` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_category_relationship`
--

INSERT INTO `post_category_relationship` (`post_id`, `category_id`) VALUES
(1, 75),
(2, 75),
(2, 76),
(2, 77);

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'published',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`id`, `post_id`, `user_id`, `comment`, `comment_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 376, 'Couldn\'t agree more. We need to put our minds together', NULL, 'published', '2018-08-12 14:32:28', '2018-08-12 12:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE `post_like` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_like`
--

INSERT INTO `post_like` (`post_id`, `user_id`) VALUES
(3, 376),
(5, 376);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `category_id` varchar(11) NOT NULL,
  `vehicle_brand_id` int(11) DEFAULT NULL,
  `model` varchar(55) DEFAULT NULL,
  `description` text,
  `feature_image` varchar(255) DEFAULT NULL,
  `tags` longtext,
  `slug` varchar(55) NOT NULL,
  `gallery` longtext,
  `categories` longtext,
  `related_products` longtext,
  `enabled` tinyint(1) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_new_arrival` tinyint(1) NOT NULL DEFAULT '0',
  `validity_date` datetime DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `supplier_id`, `company_name`, `user_id`, `name`, `category_id`, `vehicle_brand_id`, `model`, `description`, `feature_image`, `tags`, `slug`, `gallery`, `categories`, `related_products`, `enabled`, `is_featured`, `is_new_arrival`, `validity_date`, `views`, `created_at`, `updated_at`) VALUES
(2, 22, NULL, 2, 'Iron Rods', '2', NULL, NULL, NULL, '47aa6e90c9d626b51d9c411ce7fcee77.jpeg', 'N;', 'iron-rods', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 1, 1, NULL, 0, '2016-12-21 13:35:39', '2017-06-13 14:05:50'),
(3, 22, NULL, 2, 'Azar Paint', '2', NULL, NULL, NULL, '9fb38e18b94fc776d855598a67adc214.jpeg', 'N;', 'azar-paint', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 0, 1, NULL, 11, '2016-12-21 18:25:26', '2019-12-07 12:28:15'),
(4, 22, NULL, 2, 'Smooth Sand', '34', NULL, NULL, 'Sand for platering', '9e86d9830753068db6ee9d14845db09f.jpeg', 'N;', 'smooth-sand', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 0, 1, NULL, 6, '2017-06-12 15:41:07', '2019-08-07 22:20:55'),
(5, 22, 'Wong-waana Sand Weaners Ltd', 2, 'Rough Sand', '34', NULL, NULL, 'Sand for concrete works', '7828d75f5c7b60752784ad67033469e5.png', 'N;', 'rough-sand', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 0, 1, NULL, 5, '2017-06-13 14:07:41', '2017-06-13 14:07:41'),
(6, 22, NULL, 2, 'Avani Smooth Sand', '34', NULL, NULL, 'Sand for plastering and block work', 'fb565c239366347c9af7b047aa602c74.jpeg', 'N;', 'avani-smooth-sand', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 1, 1, NULL, 18, '2017-06-13 14:17:16', '2017-06-13 14:17:16'),
(8, 22, NULL, 2, 'Soakaway Boulders', '34', NULL, NULL, 'Used to fill pits for soakaways', 'e1a7829afe8c54bcfb9cc310b4299057.jpeg', 'N;', 'soakaway-boulders', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 1, 1, '2017-11-17 00:00:00', 7, '2017-06-13 15:17:12', '2017-06-13 15:17:12'),
(9, 22, NULL, 2, 'EQ Quarry Dust', '34', NULL, NULL, 'Quarry dust for various purposes', '350abab16203caac0e436c58b4c0c8c2.jpeg', 'N;', 'eq-quarry-dust', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 1, 1, '2017-11-17 00:00:00', 20, '2017-06-13 15:45:22', '2019-10-18 11:04:05'),
(11, 22, NULL, 2, 'Pavement Blocks', '34', NULL, NULL, NULL, '22_product_feature_image_i370ksf5.jpg', 'N;', 'pavement-blocks', 'N;', 's:0:\"\";', 'a:1:{i:0;s:0:\"\";}', 0, 0, 1, '2017-11-17 00:00:00', 6, '2017-06-13 15:48:01', '2019-12-27 15:30:27'),
(13, 22, NULL, 27, 'Azar Paint', '2', NULL, NULL, NULL, '6dba95511458187fe07b13f8f95e751b.jpeg', 'N;', 'azar-paint', 'N;', 's:2:\"30\";', NULL, 0, 0, 0, NULL, 0, '2017-06-29 23:30:54', '2017-06-29 23:30:54'),
(14, 22, NULL, 2, 'Hoe', '9', NULL, NULL, 'This tool is used to digging and to place concrete, cement mortar in head pan', 'ac5f11a01531ab013d10f5600e734001.jpeg', 'N;', 'hoe', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 1, 1, '1923-06-03 00:00:00', 5, '2017-10-24 13:50:30', '2019-04-29 02:29:11'),
(15, 22, NULL, 2, 'Head pan', '9', NULL, NULL, 'This one is used to transport materials within short distances', 'ee31f6eb0d7abfe4063bad5770c5ff16.jpeg', 'N;', 'head-pan', 'N;', 's:0:\"\";', 'a:3:{i:0;s:2:\"19\";i:1;s:2:\"20\";i:2;s:0:\"\";}', 0, 0, 0, '1923-05-18 00:00:00', 0, '2017-10-24 13:59:58', '2017-10-24 13:59:57'),
(16, 22, NULL, 2, 'Masonry Trowel', '9', NULL, NULL, 'This tool is used to place cement mortar', 'f06cd7b34e3ee2179e0f19ba05f51cd1.jpeg', 'N;', 'masonry-trowel', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 0, 0, NULL, 0, '2017-10-24 14:01:32', '2017-10-24 14:01:32'),
(17, 22, NULL, 2, 'Measuring Tape', '9', NULL, NULL, 'This is used to measure', '0a4d4f7937d5b0d096032c0980f65970.jpeg', 'N;', 'measuring-tape', 'N;', 's:0:\"\";', NULL, 0, 0, 0, NULL, 0, '2017-10-24 14:02:33', '2017-10-24 14:02:56'),
(18, 22, NULL, 2, 'Plumb Bob', '9', NULL, NULL, 'This tool is used to check the vertical alignment of civil works', 'd51bbcc0f72ffc7c81e97678e2918684.jpeg', 'N;', 'plumb-bob', 'N;', 's:1:\"9\";', 'a:1:{i:0;s:0:\"\";}', 0, 1, 1, NULL, 4, '2017-10-24 14:03:58', '2017-10-24 14:03:57'),
(19, 22, NULL, 2, 'Wheelbarrow', '9', NULL, NULL, 'This tool is used to transport cement mortar or any materials. Sometimes it also be used to measure the quantites of materials for site level concrete mixing', '0b58773ee5795bc0c4d748756c8cc93b.jpeg', 'N;', 'wheelbarrow-03-49', 'N;', 'N;', 'a:0:{}', 0, 1, 1, NULL, 2, '2017-10-24 14:06:00', '2017-10-24 14:06:00'),
(20, 22, NULL, 2, 'Concrete Mixer', '6', NULL, NULL, 'This tool is used to thoroughly mix the concrete at site.', 'a5dd7b32a5e0c344c25c175b2d8016e2.jpeg', 'N;', 'concrete-mixer', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 1, NULL, 3, '2017-10-24 14:07:00', '2017-10-24 14:07:00'),
(21, 22, NULL, 2, 'Rubber Boots', '9', NULL, NULL, 'This one is used to prevent skin from chemical contact', 'e41e43220c5739d448f10885b5fce858.jpeg', 'N;', 'rubber-boots', 'N;', 's:0:\"\";', 'a:0:{}', 0, 1, 0, NULL, 0, '2017-10-24 14:08:13', '2017-10-24 14:08:12'),
(22, 22, NULL, 2, 'Sand Screening Machine', '6', NULL, NULL, 'This tool is used to sieve sand at site.', 'ea0ec0f62ee2cc1352fa87efb62b3d77.jpeg', 'N;', 'sand-screening-machine', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 1, NULL, 0, '2017-10-24 14:09:25', '2017-10-24 14:09:24'),
(23, 22, NULL, 2, 'Hand Gloves', '9', NULL, NULL, 'This is used to avoid direct contact with dangerous tools, machines or to avoid any direct chemical material contact', '753bdeb37c563023cf5f2ea49cbbf5bb.jpeg', 'N;', 'hand-gloves', 'N;', 's:2:\"72\";', 'a:1:{i:0;s:0:\"\";}', 0, 0, 0, NULL, 0, '2017-10-24 14:11:01', '2017-10-24 14:11:01'),
(24, 22, NULL, 2, 'Safety Glasses', '9', NULL, NULL, 'Used for safety purpose while drilling, hacking/roughening, grinding', '859fa13c3b889ce3f91c6fdb546a9ebe.jpeg', 'N;', 'safety-glasses', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 1, NULL, 0, '2017-10-24 14:11:54', '2017-10-24 14:11:54'),
(25, 22, NULL, 2, 'Wooden Float', '9', NULL, NULL, 'This tool is used to give a smooth finish to the plastered area', 'ab04ac0ce3c17c8c6a2c686e6dcad207.jpeg', 'N;', 'wooden-float', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 0, NULL, 0, '2017-10-24 14:13:04', '2017-10-24 14:13:04'),
(26, 22, NULL, 2, 'Chisel', '9', NULL, NULL, 'This tool is used to remove excess or waste hard concrete', '1fd7555e30ea57e06783120e64a5d6f9.jpeg', 'N;', 'chisel-03-26', 'N;', 'N;', 'a:0:{}', 0, 1, 1, NULL, 1, '2017-10-24 14:14:26', '2019-04-29 18:02:27'),
(27, 22, NULL, 2, 'Framing Square', '9', NULL, NULL, 'This tool is used in Brickwork, Plastering to check right angle', '27429a60f7f84dfe4a91dfe120531077.jpeg', 'N;', 'framing-square', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 0, 1, NULL, 0, '2017-10-24 14:15:34', '2017-10-24 14:15:34'),
(28, 22, NULL, 2, 'Hammer', '9', NULL, NULL, 'This tool is used to drive and remove nails', 'daff9617fb5bd3de87c5d443010fdd6a.jpeg', 'N;', 'hammer', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 1, NULL, 0, '2017-10-24 14:16:26', '2017-10-24 14:16:25'),
(29, 22, NULL, 2, 'Line Level', '9', NULL, NULL, 'This tool is used to check horizontal level in brickwork, plastering , flooring and tile works', 'fde0bb8b76c8b9a7f2a96c3d8c1e9dca.jpeg', 'N;', 'line-level', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 0, NULL, 0, '2017-10-24 14:17:12', '2017-10-24 14:17:11'),
(30, 22, NULL, 376, 'Torpedo Square', '9', NULL, NULL, 'Combination of line level and framing square', 'a96758ff3c3fca0dd5c220026de9616f.jpeg', 'N;', 'torpedo-square', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 0, NULL, 0, '2017-10-24 14:18:25', '2017-10-24 14:18:25'),
(31, 22, NULL, 376, 'Cordless Drill', '9', NULL, NULL, 'This tool is used to make pilot holes, replacing jumper (special type of drill should be used while drilling concrete)', 'f5c0cf7e74d4a62b1fe477433f451b18.jpeg', 'N;', 'cordless-drill', 'N;', 's:0:\"\";', 'a:0:{}', 0, 1, 0, NULL, 8, '2017-10-24 14:19:34', '2017-10-24 14:19:34'),
(32, 22, NULL, 376, 'Hand Saw', '9', NULL, NULL, 'This tool is used in wood works and shuttering', '1c8bab549b627b063defba2a69aedc6d.jpeg', 'N;', 'hand-saw-03-58', 'N;', 'N;', 'a:0:{}', 0, 1, 0, NULL, 0, '2017-10-24 14:20:30', '2017-10-24 14:20:30'),
(33, 22, NULL, 376, 'Jack Plane', '9', NULL, NULL, 'This tool is used in Door and window wood works', 'd8aa6b72ae3c479d2e38cb1a677fa429.jpeg', 'N;', 'jack-plane', 'N;', 's:0:\"\";', 'a:0:{}', 0, 1, 0, NULL, 4, '2017-10-24 14:22:18', '2017-10-24 14:22:17'),
(34, 22, NULL, 376, 'Polisher', '9', NULL, NULL, 'This tool is used to smoothen the surface (wood or marble flooring)', '5be1776a14c828c523599f934f4b2890.jpeg', 'N;', 'polisher', 'N;', 's:0:\"\";', 'a:0:{}', 0, 1, 1, NULL, 1, '2017-10-24 14:23:32', '2017-10-24 14:23:32'),
(35, 22, NULL, 376, 'Measuring Wheel', '9', NULL, NULL, 'This tool is used to measure lengths. It varies by length', 'daf6249af33b58f0ddb65421c6eeec8b.jpeg', 'N;', 'measuring-wheel', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 1, 1, NULL, 2, '2017-10-24 14:24:25', '2017-10-24 14:24:25'),
(36, 22, NULL, 376, 'Gauge Box', '9', NULL, NULL, 'This tool is used to measure the cement and sand while site mix', '018bcaf160632b1e8940347e6a20bea7.jpeg', 'N;', 'gauge-box-01-17', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 0, 1, NULL, 0, '2017-10-24 14:25:10', '2017-10-24 14:25:10'),
(37, 22, NULL, 376, 'Tile Cutter', '9', NULL, NULL, 'This tool is used to cut the tiles', 'e62f4f79ac4e95e2fd46b2e6855b149c.jpeg', 'N;', 'tile-cutter', 'N;', 'N;', 'a:1:{i:0;s:0:\"\";}', 0, 1, 0, NULL, 0, '2017-10-24 14:26:17', '2017-10-24 14:26:17'),
(38, 22, NULL, 376, 'Putty Knife', '9', NULL, NULL, 'This tool is used in putty finishing to limit the thickness of the putty', '70bdaa12cf33d938539b3b76a9575aa3.png', 'N;', 'putty-knife', 'N;', 's:0:\"\";', 'a:0:{}', 0, 0, 1, NULL, 0, '2017-10-24 14:35:22', '2017-10-24 14:35:22'),
(39, 22, NULL, 376, 'Vacuum Blower', '9', NULL, NULL, 'This tools is used to clean the surface area from impurities (In flooring, Slab concrete etc.)', '701f5666a31166713a01917ec0dce7ce.jpeg', 'N;', 'vacuum-blower', 'N;', 's:0:\"\";', 'a:0:{}', 0, 1, 1, NULL, 2, '2017-10-24 14:36:11', '2017-10-24 14:36:11'),
(40, 22, NULL, 376, 'Water Tanker', '6', NULL, NULL, 'Used to convey water to construction site', '22_product_feature_image_0w8vacz2.jfif', 'N;', 'water-tanker', 'N;', 's:0:\"\";', 'a:1:{i:0;s:0:\"\";}', 0, 0, 1, NULL, 1, '2018-06-24 22:12:36', '2019-12-26 19:53:32'),
(41, 22, NULL, 376, 'Living Furniture Set', '40', NULL, NULL, NULL, '5b71e85cc3cd8163613045.jpg', 'N;', 'living-furniture-set', 'N;', 's:0:\"\";', 'a:1:{i:0;s:0:\"\";}', 0, 1, 0, NULL, 5, '2018-07-18 15:57:45', '2018-08-13 22:21:48'),
(42, 24, NULL, 379, 'Delhine Cement', '2', NULL, NULL, 'Rapid hardening cement for high strength concrete production. Suitable for tropical weather conditions', '5b59f8a3cbc71404425352.jpg', 'N;', 'delhine-cement', 'N;', 's:2:\"37\";', 'a:1:{i:0;s:0:\"\";}', 0, 1, 0, NULL, 6, '2018-07-25 19:49:57', '2019-05-27 12:05:49'),
(45, 22, NULL, 376, 'Builders Level', '9', NULL, NULL, NULL, '22_product_feature_image_wwj1j91h.jfif', 'N;', 'builders-level', 'N;', 's:0:\"\";', 'a:1:{i:0;s:0:\"\";}', 0, 0, 0, '2020-02-29 00:00:00', NULL, '2019-12-26 10:33:57', '2019-12-26 10:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text,
  `image` varchar(55) DEFAULT NULL,
  `icon` varchar(55) DEFAULT NULL,
  `slug` varchar(55) NOT NULL,
  `count` int(11) DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  `is_store_item` tinyint(1) NOT NULL DEFAULT '1',
  `rank` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `supplier_id`, `user_id`, `name`, `parent_id`, `description`, `image`, `icon`, `slug`, `count`, `level`, `is_store_item`, `rank`, `deleted`) VALUES
(2, NULL, 376, 'Construction Materials & Accessories', NULL, NULL, '5b420c27d4539720754678.jpg', NULL, 'construction-materials-accessories', 0, 1, 1, 2, 0),
(4, NULL, 376, 'Pumping Machines', 6, NULL, NULL, NULL, 'pumping-machines-07-37', 0, 2, 1, 0, 0),
(5, NULL, 376, 'Material Handling Equipment, Trucks & Dumpers', 6, NULL, NULL, NULL, 'material-handling-equipment-trucks-dumpers', 0, 2, 1, 0, 0),
(6, NULL, 376, 'Construction Equipment', NULL, NULL, '5b420d91c8e32833618220.png', NULL, 'construction-equipment', 0, 1, 1, 0, 0),
(9, NULL, 376, 'Hand Tools & Accessories', NULL, NULL, '5b421eb360f0e375442595.png', NULL, 'hand-tools-accessories', 0, 1, 1, 0, 0),
(10, NULL, 376, 'Excavators', 6, NULL, NULL, NULL, 'excavators-07-46', 0, 2, 1, 0, 0),
(11, NULL, 376, 'Graders', 6, NULL, NULL, NULL, 'graders-07-08', 0, 2, 1, 0, 0),
(12, NULL, 376, 'Loading Equipment', 6, NULL, NULL, NULL, 'loading-equipment', 0, 2, 1, 0, 0),
(13, NULL, 376, 'Tractors & Bulldozers', 6, NULL, NULL, NULL, 'tractors-bulldozers', 0, 2, 1, 0, 0),
(14, NULL, 376, 'Backhoes', 6, NULL, NULL, NULL, 'backhoes-07-15', 0, 2, 1, 0, 0),
(15, NULL, 376, 'Trenchers', 6, NULL, NULL, NULL, 'trenchers-07-51', 0, 2, 1, 0, 0),
(16, NULL, 376, 'Scrapers', 6, NULL, NULL, NULL, 'scrapers-07-11', 0, 2, 1, 0, 0),
(17, NULL, 376, 'Paving Equipment', 6, NULL, NULL, NULL, 'paving-equipment', 0, 2, 1, 0, 0),
(19, NULL, 376, 'Trailers', 6, NULL, NULL, NULL, 'trailers-07-17', 0, 2, 1, 0, 0),
(20, NULL, 376, 'Water Tankers', 6, NULL, NULL, NULL, 'water-tankers', 0, 2, 1, 0, 0),
(21, NULL, 376, 'Cranes', 5, NULL, NULL, NULL, 'cranes-07-45', 0, 2, 1, 0, 0),
(22, NULL, 376, 'Conveyors', 5, NULL, NULL, NULL, 'conveyors-07-08', NULL, 2, 1, 0, 0),
(23, NULL, 376, 'Hoists', 5, NULL, NULL, NULL, 'hoists-07-45', 0, 2, 1, 0, 0),
(24, NULL, 376, 'ForkLifts', 5, NULL, NULL, NULL, 'forklifts-07-04', 0, 2, 1, 0, 0),
(26, NULL, 2, 'Stones/Coarse Aggregates', 34, NULL, NULL, NULL, 'stones-or-coarse-aggregates', 0, 2, 0, 0, 0),
(27, NULL, 2, 'Sand/Fine Aggregates', 34, NULL, NULL, NULL, 'sand-or-fine-aggregates', 0, 2, 0, 0, 0),
(28, NULL, 2, 'Chippings', 34, NULL, NULL, NULL, 'chippings', 0, 2, 0, 0, 0),
(29, NULL, 2, 'Quarry Dust', 34, NULL, NULL, NULL, 'quarry-dust', 0, 2, 0, 0, 0),
(30, NULL, 2, 'Bitumen', 34, NULL, NULL, NULL, 'bitumen', 0, 2, 0, 0, 0),
(31, NULL, 2, 'Pavement Blocks', 34, NULL, NULL, NULL, 'pavement-block', 0, 2, 0, 0, 0),
(32, NULL, 2, 'Curb Stones', 34, NULL, NULL, NULL, 'curb-stones', 0, 2, 0, 0, 0),
(33, NULL, 2, 'Cement Blocks', 34, NULL, NULL, NULL, 'cement-blocks', 0, 2, 0, 0, 0),
(34, NULL, 376, 'Material Supplies & Products', NULL, NULL, '5b421de364237933153960.jpg', NULL, 'material-supplies-products', 0, 1, 0, 3, 0),
(35, NULL, 376, 'Paints', 2, NULL, NULL, NULL, 'paints-07-18', 0, 2, 1, NULL, 0),
(36, NULL, 376, 'Tiles', 2, NULL, NULL, NULL, 'tiles-07-37', 0, 2, 1, NULL, 0),
(37, NULL, 376, 'Cement', 2, NULL, NULL, NULL, 'cement-07-54', 0, 2, 1, NULL, 0),
(38, NULL, 11, 'Iron Rods', 2, NULL, NULL, NULL, 'iron-rods', 0, 2, 1, NULL, 0),
(40, 7, 376, 'Doors and Furniture', NULL, NULL, '5b42100eb96a3092377994.jpg', NULL, 'doors-and-furniture', 0, 1, 1, NULL, 0),
(41, NULL, 376, 'Interior Decor', NULL, NULL, '5b4215e08a0f1530698611.jpg', NULL, 'interior-decor', 0, 1, 0, NULL, 0),
(42, NULL, 376, 'Exterior Decor', NULL, NULL, '5b42160148af5923603245.jpg', NULL, 'exterior-decor', 0, 1, 1, NULL, 0),
(43, NULL, 376, 'Lighting & Security', NULL, 'Light bulbs, switches, sockets, security cameras, alarm systems and any other gadgets that help illuminate and keep the home safe', '5b421dc4b5016605991688.png', NULL, 'lighting-security', NULL, 1, 1, NULL, 0),
(44, NULL, 376, 'Equipment Spare Parts', NULL, 'Spare parts of construction equipment and heavy duty machines', '5b4212408513d551524091.jpg', NULL, 'equipment-spare-parts', NULL, 1, 0, NULL, 0),
(45, NULL, 376, 'Pipes, Fittings & Sanitary Ware', NULL, NULL, '5b421e08e13f6105497805.png', NULL, 'pipes-fittings-sanitary-ware', NULL, 1, 1, NULL, 0),
(46, NULL, 376, 'Heaters & Pumps', NULL, NULL, '5b422c3849542421934799.png', NULL, 'heaters-pumps', NULL, 1, 1, NULL, 0),
(47, NULL, 376, 'Bath Tubs & Bathroom Accessories', NULL, NULL, '5b422eb091f41840812474.png', NULL, 'bath-tubs-bathroom-accessories', NULL, 1, 1, NULL, 0),
(48, NULL, 376, 'Water Tanks & Water Hose', NULL, NULL, '5b421e5f68b8f709060290.png', NULL, 'water-tanks-water-hose', NULL, 1, 1, NULL, 0),
(49, NULL, 376, 'Security Cameras', 43, NULL, NULL, NULL, 'security-cameras', NULL, 2, 1, NULL, 0),
(50, NULL, 376, 'Security Alarm Systems', 43, NULL, NULL, NULL, 'security-alarm-systems', NULL, 2, 1, NULL, 0),
(51, NULL, 376, 'Chandeliers', 43, NULL, NULL, NULL, 'chandeliers', NULL, 2, 1, NULL, 0),
(52, NULL, 376, 'Waterproofing Products', 2, NULL, NULL, NULL, 'waterproofing-products', NULL, 2, 1, NULL, 0),
(53, NULL, 376, 'Benders', 9, NULL, NULL, NULL, 'benders', NULL, 2, 1, NULL, 0),
(54, NULL, 376, 'Clamps', 9, NULL, NULL, NULL, 'clamps', NULL, 2, 1, NULL, 0),
(55, NULL, 376, 'Hammers and Striking Tools', 9, NULL, NULL, NULL, 'hammers-and-striking-tools', NULL, 2, 1, NULL, 0),
(56, NULL, 376, 'Measuring Tapes', 9, NULL, NULL, NULL, 'measuring-tapes', NULL, 2, 1, NULL, 0),
(57, NULL, 376, 'Levels and Layout Tools', 9, NULL, NULL, NULL, 'levels-and-layout-tools', NULL, 2, 1, NULL, 0),
(58, NULL, 376, 'Pullers and Separators', 9, NULL, NULL, NULL, 'pullers-and-separators-11-44', NULL, 2, 1, NULL, 0),
(59, NULL, 376, 'Prying & Lifting Tools', 9, NULL, NULL, NULL, 'prying-lifting-tools', NULL, 2, 1, NULL, 0),
(60, NULL, 376, 'Screwdrivers and Nutdrivers', 9, NULL, NULL, NULL, 'screwdrivers-and-nutdrivers', NULL, 2, 1, NULL, 0),
(61, NULL, 376, 'Pliers', 9, NULL, NULL, NULL, 'pliers', NULL, 2, 1, NULL, 0),
(62, NULL, 376, 'Wrenches', 9, NULL, NULL, NULL, 'wrenches', NULL, 2, 1, NULL, 0),
(63, NULL, 376, 'Vices', 9, NULL, NULL, NULL, 'vices', NULL, 2, 1, NULL, 0),
(64, NULL, 376, 'Hand Drills', 9, NULL, NULL, NULL, 'hand-drills', NULL, 2, 1, NULL, 0),
(65, NULL, 376, 'Chisels', 9, NULL, NULL, NULL, 'chisels', NULL, 2, 1, NULL, 0),
(66, NULL, 376, 'Punches', 9, NULL, NULL, NULL, 'punches', NULL, 2, 1, NULL, 0),
(67, NULL, 376, 'Hand Drills', 9, NULL, NULL, NULL, 'hand-drills-11-43', NULL, 2, 1, NULL, 0),
(68, NULL, 376, 'Wire Brushes', 9, NULL, NULL, NULL, 'wire-brushes', NULL, 2, 1, NULL, 0),
(69, NULL, 376, 'Putty and Joint Knives', 9, NULL, NULL, NULL, 'putty-and-joint-knives', NULL, 2, 1, NULL, 0),
(70, NULL, 376, 'Drywall and Plastering Tools', 9, NULL, NULL, NULL, 'drywall-and-plastering-tools', NULL, 2, 1, NULL, 0),
(71, NULL, 376, 'Concrete Mixers', 9, NULL, NULL, NULL, 'concrete-mixers', NULL, 2, 1, NULL, 0),
(72, NULL, 376, 'Boots & Gloves', 9, NULL, NULL, NULL, 'boots-gloves', NULL, 2, 1, NULL, 0),
(73, NULL, 376, 'Ladders', 9, NULL, NULL, NULL, 'ladders', NULL, 2, 1, NULL, 0),
(74, NULL, 379, 'Italian Doors', 40, 'High quality security doors specially imported from Italy', '5b59a659cf1eb284514119.jpg', NULL, 'italian-doors', NULL, 2, 1, NULL, 0),
(75, NULL, 376, 'Electrical Appliances & Accessories', NULL, 'Electrical appliances and accessories', 'Product_Category_Photo_.jpg', NULL, 'electrical-appliances-accessories', NULL, 1, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_data`
--

CREATE TABLE `product_data` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `regular_price` double(10,3) DEFAULT NULL,
  `sale_price` double(10,3) DEFAULT NULL,
  `sale_volume` int(11) DEFAULT '1',
  `unit` varchar(55) DEFAULT NULL,
  `sale_price_date_from` datetime DEFAULT NULL,
  `sale_price_date_to` datetime DEFAULT NULL,
  `sku` varchar(55) DEFAULT NULL,
  `is_stock_managed` tinyint(1) DEFAULT '0',
  `stock_quantity` double(10,3) DEFAULT NULL,
  `back_orders` varchar(55) DEFAULT NULL,
  `stock_status` varchar(55) DEFAULT NULL,
  `is_sold_individually` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_data`
--

INSERT INTO `product_data` (`id`, `product_id`, `regular_price`, `sale_price`, `sale_volume`, `unit`, `sale_price_date_from`, `sale_price_date_to`, `sku`, `is_stock_managed`, `stock_quantity`, `back_orders`, `stock_status`, `is_sold_individually`, `created_at`, `updated_at`) VALUES
(1, 2, 80.000, 70.000, NULL, NULL, '2012-01-01 00:00:00', '2012-01-01 00:00:00', 'RODS/001', 1, 700.000, 'Do Not Allow', 'In Stock', 1, NULL, '2016-12-21 12:35:40'),
(2, 3, 120.000, 65.000, NULL, NULL, '2012-01-01 00:00:00', '2012-01-01 00:00:00', 'PAINT/0001', 1, 450.000, 'Do Not Allow', 'In Stock', 1, '2016-12-21 18:25:27', '2016-12-21 17:25:27'),
(3, 4, 970.000, 950.000, NULL, NULL, '2012-01-01 00:00:00', '2012-01-01 00:00:00', 'PROD123', 1, 100.000, 'Allow, But Inform', 'In Stock', 1, '2017-06-12 15:41:07', '2017-06-12 13:41:08'),
(4, 5, 1000.000, 980.000, NULL, NULL, '2012-01-01 00:00:00', '2012-01-01 00:00:00', 'RSAND001', 1, NULL, 'Allow', 'In Stock', 1, '2017-06-13 14:07:41', '2017-06-13 12:07:41'),
(5, 6, 900.000, 820.000, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'Do Not Allow', 'In Stock', 0, '2017-06-13 14:17:16', '2017-06-13 12:17:16'),
(6, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, '2017-06-13 15:14:59', '2017-06-13 13:15:00'),
(7, 8, 1500.000, 1450.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-06-13 15:17:12', '2017-06-13 13:17:12'),
(8, 9, 400.000, 365.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-06-13 15:45:22', '2017-06-13 13:45:22'),
(9, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, '2017-06-13 15:47:05', '2017-06-13 13:47:05'),
(10, 11, 10.000, 9.990, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-06-13 15:48:01', '2017-06-13 13:48:01'),
(11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, '2017-06-13 15:50:34', '2017-06-13 13:50:35'),
(12, 13, 45.000, 40.000, NULL, NULL, '2012-01-01 00:00:00', '2012-01-01 00:00:00', NULL, 1, 50.000, 'Do Not Allow', 'In Stock', 0, '2017-06-29 23:30:54', '2017-06-29 21:30:54'),
(13, 14, 10.000, 9.890, NULL, 'No.', NULL, NULL, NULL, 0, 100.000, 'Do Not Allow', 'In Stock', 0, '2017-10-24 13:50:29', '2017-10-24 11:50:30'),
(14, 15, 25.000, 24.000, NULL, 'No', NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 13:59:57', '2017-10-24 11:59:58'),
(15, 16, 15.000, 14.000, NULL, 'Nr.', NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:01:32', '2017-10-24 12:01:33'),
(16, 17, 5.000, 4.500, NULL, 'Nr.', NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:02:33', '2017-10-24 12:02:33'),
(17, 18, 7.000, 6.900, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:03:57', '2017-10-24 12:03:58'),
(18, 19, 150.000, 145.000, NULL, 'Nr.', NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:06:00', '2017-10-24 12:06:00'),
(19, 20, 500.000, 489.000, NULL, 'Nr.', NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:07:00', '2017-10-24 12:07:00'),
(20, 21, 18.000, 17.500, NULL, 'Pair', NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:08:12', '2017-10-24 12:08:13'),
(21, 22, 120.000, 115.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:09:24', '2017-10-24 12:09:25'),
(22, 23, 20.000, 18.500, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:11:01', '2017-10-24 12:11:01'),
(23, 24, 10.000, 9.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:11:54', '2017-10-24 12:11:54'),
(24, 25, 65.000, 63.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:13:04', '2017-10-24 12:13:04'),
(25, 26, 70.000, 65.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:14:25', '2017-10-24 12:14:26'),
(26, 27, 45.000, 39.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:15:34', '2017-10-24 12:15:34'),
(27, 28, 5.000, 4.500, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:16:25', '2017-10-24 12:16:26'),
(28, 29, 15.000, 14.900, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:17:11', '2017-10-24 12:17:12'),
(29, 30, 78.000, 76.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:18:25', '2017-10-24 12:18:25'),
(30, 31, 450.000, 435.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:19:34', '2017-10-24 12:19:34'),
(31, 32, 45.000, 35.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:20:30', '2017-10-24 12:20:30'),
(32, 33, 210.000, 209.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:22:17', '2017-10-24 12:22:18'),
(33, 34, 150.000, 145.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:23:32', '2017-10-24 12:23:32'),
(34, 35, 95.000, 80.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:24:25', '2017-10-24 12:24:25'),
(35, 36, 85.000, 70.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:25:10', '2017-10-24 12:25:11'),
(36, 37, 320.000, 298.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:26:17', '2017-10-24 12:26:17'),
(37, 38, 45.000, 38.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:35:22', '2017-10-24 12:35:22'),
(38, 39, 480.000, 475.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2017-10-24 14:36:11', '2017-10-24 12:36:11'),
(39, 40, 200000.000, 180000.000, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Do Not Allow', 'In Stock', 0, '2018-06-24 22:12:35', '2018-06-24 20:12:36'),
(40, 41, 1890.000, 1799.000, NULL, NULL, NULL, NULL, 'FUR001', 0, NULL, 'Do Not Allow', 'In Stock', 0, '2018-07-18 15:57:44', '2018-07-18 13:57:45'),
(41, 42, 30.000, 28.500, 1, NULL, NULL, NULL, 'DELCEMENT-0001', 0, NULL, 'Do Not Allow', 'In Stock', 0, '2018-07-25 19:49:57', '2018-07-25 17:49:57'),
(42, 45, 10.000, 9.660, 1, 'Number (Nr)', NULL, NULL, 'LL-0201', 1, 30.000, 'Do Not Allow', 'In Stock', 1, '2019-12-26 10:33:57', '2019-12-26 09:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_sale_options`
--

CREATE TABLE `product_sale_options` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale_volume` double(10,3) DEFAULT NULL,
  `dimension` varchar(55) DEFAULT NULL,
  `brand` text,
  `price` double(10,3) DEFAULT NULL,
  `unit` varchar(55) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_sale_options`
--

INSERT INTO `product_sale_options` (`id`, `product_id`, `sale_volume`, `dimension`, `brand`, `price`, `unit`, `created_at`, `updated_at`) VALUES
(1, 9, 20.000, NULL, NULL, 800.000, 'm3', '2017-10-23 18:43:55', '2017-10-23 16:43:55'),
(3, 18, NULL, NULL, 'Italian Mark2', 50.000, 'Nr.', '2017-10-24 21:26:37', '2017-10-24 19:26:37');

-- --------------------------------------------------------

--
-- Table structure for table `professional`
--

CREATE TABLE `professional` (
  `id` int(11) NOT NULL,
  `profession_id` int(11) DEFAULT NULL,
  `specialties` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `professional`
--

INSERT INTO `professional` (`id`, `profession_id`, `specialties`, `created_at`, `updated_at`) VALUES
(5, NULL, NULL, '0000-00-00 00:00:00', '2018-08-29 06:33:20'),
(29, NULL, NULL, '0000-00-00 00:00:00', '2019-10-14 14:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(55) NOT NULL,
  `project_type` varchar(55) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `summary` text NOT NULL,
  `budget` varchar(55) DEFAULT NULL,
  `request_details` text,
  `feature_image` varchar(255) DEFAULT NULL,
  `gallery` longtext,
  `region_id` int(11) DEFAULT NULL,
  `town_id` int(11) DEFAULT NULL,
  `sub_location` varchar(55) DEFAULT NULL,
  `artisans` longtext,
  `professionals` longtext,
  `expected_start_date` datetime DEFAULT NULL,
  `expected_end_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `user_id`, `title`, `project_type`, `slug`, `summary`, `budget`, `request_details`, `feature_image`, `gallery`, `region_id`, `town_id`, `sub_location`, `artisans`, `professionals`, `expected_start_date`, `expected_end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(14, 390, 'Design and Construction of 4 Bedroom Aprtment', 'Major Rehabilitation Works', 'design-and-construction-of-4-bedroom-aprtment', 'I need an architect to design and supervise the construction of a 4 Bedroom Apartment at Dobile', 'GH?26000', 'I need design drawings, cost estimates and number of artisans needed at the project site', NULL, 'N;', 5, 12, 'Dobile', 'a:3:{i:0;s:1:\"7\";i:1;s:1:\"9\";i:2;s:2:\"18\";}', 'a:3:{i:0;s:2:\"19\";i:1;s:2:\"24\";i:2;s:2:\"17\";}', '2018-11-15 00:00:00', '2019-05-24 00:00:00', 1, '2018-11-03 21:47:22', '2018-11-03 20:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `project_comment`
--

CREATE TABLE `project_comment` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'published',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_comment`
--

INSERT INTO `project_comment` (`id`, `project_id`, `user_id`, `comment`, `comment_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 376, 'Work great work. I need you to do similar work for me', NULL, 'published', '2018-08-12 15:30:23', '2018-08-12 13:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `project_like`
--

CREATE TABLE `project_like` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promoted_product`
--

CREATE TABLE `promoted_product` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `promo_code` varchar(25) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `discounted_price` double(10,3) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promoted_product`
--

INSERT INTO `promoted_product` (`id`, `supplier_id`, `product_id`, `campaign_id`, `promo_code`, `expiry_date`, `user_id`, `discounted_price`, `created_at`, `updated_at`) VALUES
(3, 22, 9, 1, 'R?rY', NULL, 376, 80.000, '2017-10-12 13:43:46', '2017-10-12 11:43:46'),
(4, 22, 19, 1, '?b>O??', NULL, 376, 30.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(5, 22, 31, 1, '^?\0?n?', NULL, 376, 90.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(6, 22, 39, 1, '???t', NULL, 376, 96.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(7, 22, 36, 1, '	?:?.?', NULL, 376, 17.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(8, 22, 33, 1, 'k?;T??', NULL, 376, 42.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(9, 22, 29, 1, 'OT?*?i', NULL, 376, 3.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(10, 22, 25, 1, '???`?', NULL, 376, 13.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(11, 22, 22, 1, '?@???', NULL, 376, 24.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24'),
(12, 22, 26, 1, '?&x$', NULL, 376, 14.000, '2017-10-24 14:42:24', '2017-10-24 12:42:24');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_request`
--

CREATE TABLE `quotation_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request` text NOT NULL,
  `request_type` varchar(55) DEFAULT NULL,
  `quantity` int(8) NOT NULL,
  `contact` varchar(55) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_request`
--

INSERT INTO `quotation_request` (`id`, `user_id`, `request`, `request_type`, `quantity`, `contact`, `unit_id`, `product_id`, `vendor_id`, `created_at`, `updated_at`) VALUES
(1, 42, 'Give quotation for 20 brand  wheelbarrows', NULL, 20, 'btlclients@gmail.com', 19, 5, 2, '2018-03-29 17:23:51', '2018-03-29 15:23:51'),
(2, 376, 'I want  brand new wheelbarrows', 'Quotation Request', 5, NULL, 19, NULL, NULL, '2018-10-07 12:36:11', '2018-10-07 10:36:15'),
(25, 383, '300 bags of grade 42 Ghacem cement', 'Quotation Request', 300, 'ftuulijnr@yahoo.com', 5, NULL, NULL, '2018-10-12 16:45:11', '2018-10-12 14:45:12'),
(26, 376, 'Please supply me with 2 trips of boulders', NULL, 2, '+233246738954', 19, 8, 22, '2018-10-15 17:25:41', '2018-10-15 15:25:43'),
(27, NULL, 'I want 5 cubic meter of quarry dust', NULL, 5, '0546401593', 3, NULL, 22, '2019-04-23 19:31:56', '2019-04-23 17:31:57'),
(44, 394, 'I need 5 bags of Cement urgent', NULL, 5, '0208621611', 5, 42, 24, '2019-04-25 20:05:05', '2019-04-25 18:05:05'),
(45, NULL, 'Can you supplier me with a wheelbarrow', 'Quotation Request', 6, '0208621611', 19, NULL, NULL, '2019-04-27 00:09:08', '2019-04-26 22:09:11'),
(53, NULL, '5 bags of cement needed', 'Quotation Request', 5, '0208621611', 19, NULL, NULL, '2019-04-27 01:34:33', '2019-04-26 23:34:34'),
(54, NULL, 'I need 300 units of Italian tiles, white in color', 'Quotation Request', 300, '0546401593', 19, NULL, NULL, '2019-05-04 13:12:37', '2019-05-04 11:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `rating_measure`
--

CREATE TABLE `rating_measure` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `measure_key` varchar(25) DEFAULT NULL,
  `type` varchar(55) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating_measure`
--

INSERT INTO `rating_measure` (`id`, `name`, `measure_key`, `type`, `description`) VALUES
(1, 'Workmanship/Finishing', 'workmanship', 'ARTISAN', 'The quality of the finished work'),
(2, 'Time Consciousness', 'time', 'BOTH', 'How well does the artisan respect time, punctuality to work etc'),
(3, 'Professionalism', 'professionalism', 'BOTH', 'How professional is the artisan in the execution of his/her work');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `name`, `short_name`, `slug`, `country_code`) VALUES
(1, 'Greater Accra', 'GAR', 'greater-accra-region', 'GH'),
(2, 'Ashanti', 'AR', 'ashanti-region', 'GH'),
(3, 'Western', 'WR', 'western-region', 'GH'),
(4, 'Northern ', 'NR', 'northern-region', 'GH'),
(5, 'Upper West', 'UWR', 'upper-west-region', 'GH'),
(6, 'Upper East', 'UER', 'upper-east-region', 'GH'),
(7, 'Eastern', 'ER', 'eastern-region', 'GH'),
(8, 'Volta', 'VR', 'volta-region', 'GH'),
(9, 'Brong-Ahafo', 'BAR', 'brong-ahafo-region', 'GH'),
(10, 'Central', 'CR', 'central-region', 'GH');

-- --------------------------------------------------------

--
-- Table structure for table `rental_ad`
--

CREATE TABLE `rental_ad` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` text,
  `equipment_id` int(11) DEFAULT NULL,
  `feature_image` varchar(255) DEFAULT NULL,
  `rental_rate` double(10,3) DEFAULT NULL,
  `billing_cycle` varchar(55) DEFAULT NULL,
  `units_available` int(11) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `is_promoted` tinyint(1) NOT NULL DEFAULT '0',
  `is_on_deal` tinyint(1) NOT NULL DEFAULT '0',
  `region_id` int(11) DEFAULT NULL,
  `town_id` int(11) DEFAULT NULL,
  `sub_location` varchar(55) DEFAULT NULL,
  `publish_date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental_ad`
--

INSERT INTO `rental_ad` (`id`, `title`, `slug`, `company_id`, `user_id`, `description`, `equipment_id`, `feature_image`, `rental_rate`, `billing_cycle`, `units_available`, `is_published`, `is_promoted`, `is_on_deal`, `region_id`, `town_id`, `sub_location`, `publish_date`, `deleted`, `created_at`, `updated_at`) VALUES
(3, 'Concrete Mixers for Hiring', 'concrete-mixers-for-hiring', 22, 376, 'This concrete mixer is electric powered and very energy efficient', 1, NULL, 600.000, 'Daily', 5, 1, 1, 1, NULL, NULL, 'Rail Crossing', '2019-05-10 00:00:00', 0, '2019-05-10 11:01:00', '2019-09-21 19:49:35'),
(5, 'Excavator with Backhoe for rent', 'excavator-with-backhoe-for-rent', 22, 376, 'Comes with well trained and experienced operator', 2, NULL, 500.000, 'Hourly', 5, 1, 0, 1, NULL, NULL, 'Gumani', '2019-05-10 13:37:34', 0, '2019-05-10 13:37:34', '2019-09-21 20:04:32'),
(6, 'Concrete Mixers for Rents', 'concrete-mixers-for-rents-03-59', 22, 376, 'Electricity powered concrete mixer', 7, NULL, 250.000, 'Daily', 4, 1, 1, 1, NULL, NULL, 'Suame', '2019-08-28 00:00:00', 0, '2019-08-28 15:23:14', '2019-09-21 20:13:08'),
(7, 'Wheelbarrow', 'wheelbarrow', 22, 376, 'We have wheelbarrows of sizes for rent. Just call us', 3, NULL, 20.000, 'Daily', 4, 1, 1, 1, NULL, NULL, 'Gumani', '2019-08-28 00:00:00', 0, '2019-08-28 15:34:41', '2019-09-21 20:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `rental_promo`
--

CREATE TABLE `rental_promo` (
  `id` int(11) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `promo_amount` double(10,3) NOT NULL,
  `promo_start_date` datetime NOT NULL,
  `promo_end_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental_promo`
--

INSERT INTO `rental_promo` (`id`, `rental_id`, `user_id`, `promo_amount`, `promo_start_date`, `promo_end_date`, `created_at`, `updated_at`) VALUES
(1, 3, 376, 500.000, '2019-09-03 00:00:00', '2019-09-10 00:00:00', '2019-09-03 22:47:31', '2019-09-03 20:47:31'),
(2, 6, 376, 180.000, '2019-09-03 00:00:00', '2019-09-10 00:00:00', '2019-09-03 23:04:43', '2019-09-03 21:04:43'),
(3, 7, 376, 180.000, '2019-09-11 00:00:00', '2019-09-18 00:00:00', '2019-09-03 23:08:07', '2019-09-03 21:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `rental_request`
--

CREATE TABLE `rental_request` (
  `id` int(11) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `phone` varchar(55) NOT NULL,
  `number_requested` int(3) NOT NULL DEFAULT '1',
  `message` text NOT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'Requested',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental_request`
--

INSERT INTO `rental_request` (`id`, `rental_id`, `user_id`, `email`, `phone`, `number_requested`, `message`, `status`, `created_at`, `updated_at`) VALUES
(3, 6, 376, NULL, '+233246738954', 2, 'I want this concrete mixer for 10 days', 'Requested', '2019-09-24 21:27:41', '2019-09-24 19:27:41'),
(10, 7, NULL, NULL, '+233208621611', 1, 'I need this wheelbarrow as soon as possible for rent', 'Requested', '2019-10-01 17:29:13', '2019-10-01 15:29:13'),
(11, 7, NULL, NULL, '+233208621611', 1, 'I need this wheelbarrow as soon as possible for rent', 'Requested', '2019-10-01 17:34:01', '2019-10-01 15:34:01'),
(12, 7, NULL, NULL, '+233208621611', 1, 'I need this wheelbarrow as soon as possible for rent', 'Requested', '2019-10-01 17:37:00', '2019-10-01 15:37:00'),
(13, 7, NULL, NULL, '+233208621611', 1, 'I need this wheelbarrow as soon as possible for rent', 'Requested', '2019-10-01 17:38:37', '2019-10-01 15:38:38'),
(14, 7, NULL, NULL, '+233208621611', 1, 'I need this wheelbarrow as soon as possible for rent', 'Requested', '2019-10-01 17:39:41', '2019-10-01 15:39:41'),
(15, 6, NULL, 'edmond.balika@baselinetechlab.com', '+233546401593', 2, 'I need 2 concrete mixers', 'Requested', '2019-11-18 10:54:23', '2019-11-18 09:54:24'),
(16, 6, NULL, 'mawurnaq@gmail.com', '+233208621611', 3, 'I need this machine for 3 days', 'Requested', '2019-11-18 13:50:53', '2019-11-18 12:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `rented_out`
--

CREATE TABLE `rented_out` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request_id` int(11) DEFAULT NULL,
  `remarks` text,
  `payment_status` varchar(55) DEFAULT NULL,
  `agreement_docs` text,
  `authorized_by` int(11) DEFAULT NULL,
  `rental_rate` double(10,3) DEFAULT NULL,
  `billing_cycle` varchar(55) DEFAULT NULL,
  `rental_duration` double(10,3) DEFAULT NULL,
  `quantity` int(4) DEFAULT NULL,
  `total_amount` double(10,3) DEFAULT NULL,
  `payment_due_date` datetime DEFAULT NULL,
  `is_fully_paid` tinyint(1) NOT NULL DEFAULT '0',
  `rented_to` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `date_paid` datetime DEFAULT NULL,
  `amount_paid` double(10,3) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE `service_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lead_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `request_type` varchar(55) NOT NULL,
  `request` text NOT NULL,
  `status` varchar(55) DEFAULT NULL,
  `is_viewed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`id`, `user_id`, `lead_id`, `company_id`, `request_type`, `request`, `status`, `is_viewed`, `created_at`, `updated_at`) VALUES
(5, 376, 376, NULL, 'Request for Proposal', 'Could you kindly tell me how much it will cost to build a 3 bedroom house?', NULL, 0, '2018-06-18 11:20:14', '2018-06-18 09:20:14'),
(6, 390, 376, NULL, 'Technical Advice', 'Please i need advice on how to setup a block factory', NULL, 0, '2018-12-10 17:13:07', '2018-12-10 16:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `snapshare`
--

CREATE TABLE `snapshare` (
  `id` int(11) NOT NULL,
  `gallery` longtext,
  `latitude` varchar(55) DEFAULT NULL,
  `longitude` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `specialty`
--

CREATE TABLE `specialty` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specialty`
--

INSERT INTO `specialty` (`id`, `user_id`, `name`, `slug`, `type`, `created_at`, `updated_at`) VALUES
(1, 376, 'POP Ceiling Installation', 'pop-ceiling-installation', 'ARTISAN', '2018-08-24 16:39:47', '2018-08-24 14:39:48'),
(2, 376, 'Stone Wall Masonry', 'stone-wall-masonry', 'ARTISAN', '2018-08-24 22:45:14', '2018-08-24 20:45:15'),
(3, 376, 'T&J and Wooden batten ceiling', 't-j-and-wooden-batten-ceiling', 'ARTISAN', '2018-08-24 22:56:03', '2018-08-24 20:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `status_post`
--

CREATE TABLE `status_post` (
  `id` int(11) NOT NULL,
  `target_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_post`
--

INSERT INTO `status_post` (`id`, `target_id`) VALUES
(3, NULL),
(4, NULL),
(5, 379),
(7, 390),
(10, NULL),
(11, NULL),
(12, NULL),
(13, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_ad`
--

CREATE TABLE `store_ad` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `banner` varchar(55) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `product_category` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store_options`
--

CREATE TABLE `store_options` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `allow_price_request` tinyint(1) DEFAULT '1',
  `allow_quotation_request` tinyint(1) DEFAULT '1',
  `manage_stock` tinyint(1) DEFAULT '1',
  `show_stock_level` tinyint(1) DEFAULT '1',
  `show_featured_products` tinyint(1) DEFAULT '1',
  `store_banner` varchar(255) DEFAULT NULL,
  `show_prices` tinyint(1) DEFAULT '1',
  `display_banner` tinyint(1) DEFAULT '0',
  `digital_signature` varchar(255) DEFAULT NULL,
  `merchandise` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_options`
--

INSERT INTO `store_options` (`id`, `supplier_id`, `allow_price_request`, `allow_quotation_request`, `manage_stock`, `show_stock_level`, `show_featured_products`, `store_banner`, `show_prices`, `display_banner`, `digital_signature`, `merchandise`, `created_at`, `updated_at`) VALUES
(4, 22, 1, 1, 0, 1, 1, NULL, 1, 1, NULL, NULL, '2018-07-09 22:58:53', '2018-07-09 20:58:53'),
(5, 24, 1, 1, 0, 1, 1, NULL, 1, 0, NULL, 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:7:{i:0;O:26:\"App\\Entity\\ProductCategory\":16:{s:5:\"\0*\0id\";i:45;s:7:\"\0*\0name\";s:31:\"Pipes, Fittings & Sanitary Ware\";s:8:\"\0*\0count\";N;s:7:\"\0*\0rank\";N;s:8:\"\0*\0level\";i:1;s:14:\"\0*\0isStoreItem\";b:1;s:15:\"\0*\0featureImage\";s:26:\"5b421e08e13f6105497805.png\";s:12:\"\0*\0imageFile\";N;s:7:\"\0*\0icon\";N;s:7:\"\0*\0slug\";s:28:\"pipes-fittings-sanitary-ware\";s:10:\"\0*\0deleted\";b:0;s:14:\"\0*\0description\";N;s:11:\"\0*\0supplier\";N;s:7:\"\0*\0user\";C:30:\"Proxies\\__CG__\\App\\Entity\\User\":214:{a:8:{i:0;s:60:\"$2y$13$VNC1MqotQG14vUtsq7m41OgS.SqQflbSEZWuJDl5jZqVOPe5eKFeS\";i:1;N;i:2;s:14:\"alverna.balika\";i:3;s:14:\"alverna.balika\";i:4;b:1;i:5;i:376;i:6;s:18:\"info@zibblesmp.com\";i:7;s:18:\"info@zibblesmp.com\";}}s:9:\"\0*\0parent\";N;s:16:\"\0*\0subCategories\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}}i:1;O:26:\"App\\Entity\\ProductCategory\":16:{s:5:\"\0*\0id\";i:46;s:7:\"\0*\0name\";s:15:\"Heaters & Pumps\";s:8:\"\0*\0count\";N;s:7:\"\0*\0rank\";N;s:8:\"\0*\0level\";i:1;s:14:\"\0*\0isStoreItem\";b:1;s:15:\"\0*\0featureImage\";s:26:\"5b422c3849542421934799.png\";s:12:\"\0*\0imageFile\";N;s:7:\"\0*\0icon\";N;s:7:\"\0*\0slug\";s:13:\"heaters-pumps\";s:10:\"\0*\0deleted\";b:0;s:14:\"\0*\0description\";N;s:11:\"\0*\0supplier\";N;s:7:\"\0*\0user\";r:17;s:9:\"\0*\0parent\";N;s:16:\"\0*\0subCategories\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}}i:2;O:26:\"App\\Entity\\ProductCategory\":16:{s:5:\"\0*\0id\";i:47;s:7:\"\0*\0name\";s:32:\"Bath Tubs & Bathroom Accessories\";s:8:\"\0*\0count\";N;s:7:\"\0*\0rank\";N;s:8:\"\0*\0level\";i:1;s:14:\"\0*\0isStoreItem\";b:1;s:15:\"\0*\0featureImage\";s:26:\"5b422eb091f41840812474.png\";s:12:\"\0*\0imageFile\";N;s:7:\"\0*\0icon\";N;s:7:\"\0*\0slug\";s:30:\"bath-tubs-bathroom-accessories\";s:10:\"\0*\0deleted\";b:0;s:14:\"\0*\0description\";N;s:11:\"\0*\0supplier\";N;s:7:\"\0*\0user\";r:17;s:9:\"\0*\0parent\";N;s:16:\"\0*\0subCategories\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}}i:3;O:26:\"App\\Entity\\ProductCategory\":16:{s:5:\"\0*\0id\";i:48;s:7:\"\0*\0name\";s:24:\"Water Tanks & Water Hose\";s:8:\"\0*\0count\";N;s:7:\"\0*\0rank\";N;s:8:\"\0*\0level\";i:1;s:14:\"\0*\0isStoreItem\";b:1;s:15:\"\0*\0featureImage\";s:26:\"5b421e5f68b8f709060290.png\";s:12:\"\0*\0imageFile\";N;s:7:\"\0*\0icon\";N;s:7:\"\0*\0slug\";s:22:\"water-tanks-water-hose\";s:10:\"\0*\0deleted\";b:0;s:14:\"\0*\0description\";N;s:11:\"\0*\0supplier\";N;s:7:\"\0*\0user\";r:17;s:9:\"\0*\0parent\";N;s:16:\"\0*\0subCategories\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}}i:4;O:26:\"App\\Entity\\ProductCategory\":16:{s:5:\"\0*\0id\";i:6;s:7:\"\0*\0name\";s:22:\"Construction Equipment\";s:8:\"\0*\0count\";i:0;s:7:\"\0*\0rank\";i:0;s:8:\"\0*\0level\";i:1;s:14:\"\0*\0isStoreItem\";b:1;s:15:\"\0*\0featureImage\";s:26:\"5b420d91c8e32833618220.png\";s:12:\"\0*\0imageFile\";N;s:7:\"\0*\0icon\";N;s:7:\"\0*\0slug\";s:22:\"construction-equipment\";s:10:\"\0*\0deleted\";b:0;s:14:\"\0*\0description\";N;s:11:\"\0*\0supplier\";N;s:7:\"\0*\0user\";r:17;s:9:\"\0*\0parent\";N;s:16:\"\0*\0subCategories\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}}i:5;O:26:\"App\\Entity\\ProductCategory\":16:{s:5:\"\0*\0id\";i:9;s:7:\"\0*\0name\";s:24:\"Hand Tools & Accessories\";s:8:\"\0*\0count\";i:0;s:7:\"\0*\0rank\";i:0;s:8:\"\0*\0level\";i:1;s:14:\"\0*\0isStoreItem\";b:1;s:15:\"\0*\0featureImage\";s:26:\"5b421eb360f0e375442595.png\";s:12:\"\0*\0imageFile\";N;s:7:\"\0*\0icon\";N;s:7:\"\0*\0slug\";s:22:\"hand-tools-accessories\";s:10:\"\0*\0deleted\";b:0;s:14:\"\0*\0description\";N;s:11:\"\0*\0supplier\";N;s:7:\"\0*\0user\";r:17;s:9:\"\0*\0parent\";N;s:16:\"\0*\0subCategories\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}}i:6;O:26:\"App\\Entity\\ProductCategory\":16:{s:5:\"\0*\0id\";i:2;s:7:\"\0*\0name\";s:36:\"Construction Materials & Accessories\";s:8:\"\0*\0count\";i:0;s:7:\"\0*\0rank\";i:2;s:8:\"\0*\0level\";i:1;s:14:\"\0*\0isStoreItem\";b:1;s:15:\"\0*\0featureImage\";s:26:\"5b420c27d4539720754678.jpg\";s:12:\"\0*\0imageFile\";N;s:7:\"\0*\0icon\";N;s:7:\"\0*\0slug\";s:34:\"construction-materials-accessories\";s:10:\"\0*\0deleted\";b:0;s:14:\"\0*\0description\";N;s:11:\"\0*\0supplier\";N;s:7:\"\0*\0user\";r:17;s:9:\"\0*\0parent\";N;s:16:\"\0*\0subCategories\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}}}}', '2018-07-25 17:45:38', '2018-07-25 15:45:38'),
(6, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N;', '2019-08-07 16:56:25', '2019-08-07 14:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `institution_id` int(11) NOT NULL,
  `course_of_study` varchar(255) NOT NULL,
  `current_year` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `user_id`, `institution_id`, `course_of_study`, `current_year`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'BSc Civil ENgineering', 'Year 3', '2017-04-05 17:03:59', '2017-04-05 15:03:59'),
(3, 8, 3, 'BSc. Building Technology', 'Year 2', '2017-12-12 09:25:36', '2017-12-12 08:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`) VALUES
(22),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_product_category`
--

CREATE TABLE `supplier_product_category` (
  `supplier_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_product_category`
--

INSERT INTO `supplier_product_category` (`supplier_id`, `product_category_id`) VALUES
(22, 2),
(22, 4),
(22, 5),
(22, 6),
(22, 27),
(22, 32),
(22, 33),
(22, 35),
(22, 36),
(22, 37),
(22, 40),
(24, 4),
(24, 26),
(24, 35),
(24, 36),
(24, 37),
(24, 38),
(24, 52);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `vendor_id`, `user_id`, `name`, `slug`, `count`) VALUES
(1, 8, 27, 'Sea Sand', 'sea-sand', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `top_supplier`
--

CREATE TABLE `top_supplier` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid_amount` double(10,3) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `feature_image` varchar(255) DEFAULT NULL,
  `product_categories` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `top_supplier`
--

INSERT INTO `top_supplier` (`id`, `supplier_id`, `bid_id`, `user_id`, `bid_amount`, `start_date`, `end_date`, `feature_image`, `product_categories`, `created_at`, `updated_at`) VALUES
(1, 22, 3, 376, 300.000, '2018-07-10 00:00:00', '2018-07-22 00:00:00', NULL, NULL, '2018-07-14 00:00:00', '2018-07-14 18:28:44'),
(5, 22, 3, 376, 100.000, '2018-07-13 00:00:00', '2018-07-23 00:00:00', NULL, 'a:3:{i:0;s:0:\"\";i:1;s:1:\"6\";i:2;s:2:\"40\";}', '2018-07-14 23:26:27', '2018-07-16 10:49:57'),
(6, 22, 3, 376, 500.000, '2018-07-24 00:00:00', '2018-07-31 00:00:00', NULL, 'a:3:{i:0;s:2:\"35\";i:1;s:1:\"6\";i:2;s:2:\"27\";}', '2018-07-24 18:51:03', '2018-07-24 16:51:03'),
(7, 22, 3, 376, 120.000, '2018-10-13 00:00:00', '2018-10-27 00:00:00', NULL, 'a:3:{i:0;s:1:\"2\";i:1;s:2:\"37\";i:2;s:2:\"40\";}', '2018-10-13 20:11:08', '2018-10-13 18:11:08'),
(8, 22, 3, 376, 350.000, '2019-04-29 00:00:00', '2019-05-03 00:00:00', NULL, 'a:1:{i:0;s:1:\"2\";}', '2019-04-30 17:13:51', '2019-04-30 17:13:51'),
(9, 22, 3, 376, 500.000, '2019-04-29 00:00:00', '2019-05-03 00:00:00', NULL, 'a:1:{i:0;s:1:\"5\";}', '2019-04-30 17:16:27', '2019-04-30 17:16:27'),
(10, 22, 3, 376, 200.000, '2019-04-29 00:00:00', '2019-05-03 00:00:00', NULL, 'a:2:{i:0;s:2:\"37\";i:1;s:2:\"40\";}', '2019-04-30 17:22:09', '2019-04-30 17:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `town`
--

CREATE TABLE `town` (
  `id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_capital` tinyint(1) NOT NULL,
  `is_city` tinyint(1) NOT NULL DEFAULT '0',
  `is_spare_parts_hub` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `town`
--

INSERT INTO `town` (`id`, `region_id`, `name`, `slug`, `is_capital`, `is_city`, `is_spare_parts_hub`, `parent_id`, `description`, `deleted`) VALUES
(1, 1, 'Accra', 'accra', 1, 1, 0, NULL, NULL, 0),
(2, 2, 'Kumasi', 'kumasi', 1, 1, 0, NULL, '', 0),
(3, 4, 'Tamale', 'tamale', 1, 1, 0, NULL, '', 0),
(4, 1, 'Adenta', 'adenta', 0, 0, 0, 1, '', 0),
(5, 1, 'Tema', 'tema', 0, 0, 0, NULL, '', 0),
(6, 1, 'Madina', 'madina', 0, 0, 0, 1, '', 0),
(7, 1, 'Dzowulu', 'dzowulu', 0, 0, 0, 1, '', 0),
(8, 1, 'Spintex Road', 'spintex-road', 0, 0, 0, 1, '', 0),
(10, 1, 'Osu', 'osu', 0, 0, 0, 1, '', 0),
(11, 1, 'Adabraka', 'adabraka', 0, 0, 0, 1, '', 0),
(12, 5, 'Charia', 'charia', 0, 0, 0, NULL, '', 0),
(13, 5, 'Kaleo', 'kaleo', 0, 0, 0, NULL, '', 1),
(14, 5, 'Nandom', 'nandom', 0, 0, 0, NULL, '', 0),
(15, 5, 'Jirapa', 'jirapa', 0, 0, 0, NULL, '', 0),
(16, 3, 'Takoradi', 'takoradi', 1, 1, 0, NULL, '', 0),
(18, 2, 'Magazine', 'magazine', 0, 0, 1, 2, '', 0),
(19, 3, 'Konkompe', 'konkompe', 0, 0, 1, 16, '', 0),
(21, 7, 'Koforidua', 'koforidua', 1, 0, 0, NULL, NULL, 0),
(22, 1, 'Abosokai', 'abosokai', 0, 0, 1, 1, NULL, 0),
(23, 4, 'Aboabo', 'aboabo', 0, 0, 1, 3, NULL, 0),
(24, 1, 'Victoriaborg', 'victoriaborg', 0, 0, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `singular` varchar(55) NOT NULL,
  `plural` varchar(55) DEFAULT NULL,
  `abbr` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `singular`, `plural`, `abbr`) VALUES
(1, 'Meter', 'Meters', 'm'),
(2, 'Centimeter', 'Centimeters', 'cm'),
(3, 'Cubic Meter', 'Cubic Meters', 'm3'),
(4, 'Cubic Centimeter', 'Cubic Centimeters', 'cm3'),
(5, 'Bag', 'Bags', 'Bg'),
(6, 'Tonne', 'Tonnes', 'T'),
(7, 'Box', 'Boxes', 'Box'),
(8, 'Case', 'Cases', NULL),
(9, 'Liter', 'Liters', 'L'),
(10, 'Barrel', 'Barrels', NULL),
(11, 'Square Meter', 'Square Meter', 'm2'),
(12, 'Carton', 'Cartons', NULL),
(13, 'Inch', 'Inches', 'in'),
(14, 'Foot', 'Feet', 'ft'),
(15, 'Millimeter', 'Millimeters', 'mm'),
(16, 'Kilogram', 'Kilograms', 'Kg'),
(17, 'Gram', 'Grams', 'g'),
(18, 'Cubic Foot', 'Cubic Feet', 'ft3'),
(19, 'Number', 'Number', 'Nr'),
(20, 'Piece', 'Pieces', 'Pcs');

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

CREATE TABLE `user_company` (
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_company`
--

INSERT INTO `user_company` (`user_id`, `company_id`) VALUES
(376, 22),
(376, 26),
(407, 35),
(407, 36),
(407, 37),
(407, 38),
(407, 39),
(407, 40);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text,
  `sub_location` varchar(55) DEFAULT NULL,
  `profile` text,
  `help` text,
  `interests` text,
  `drive` text,
  `region_id` int(11) DEFAULT NULL,
  `country_code` varchar(5) DEFAULT 'GH',
  `town_id` int(11) DEFAULT NULL,
  `latitude` varchar(25) DEFAULT NULL,
  `longitude` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `address`, `sub_location`, `profile`, `help`, `interests`, `drive`, `region_id`, `country_code`, `town_id`, `latitude`, `longitude`) VALUES
(1, 2, NULL, 'Kejetia', 'I specialize in masonry works and all forms of brick laying', NULL, NULL, NULL, 1, 'GH', 8, NULL, NULL),
(2, 5, NULL, NULL, 'I am passionate about research and in the building sector', NULL, NULL, NULL, 1, 'GH', 1, NULL, NULL),
(5, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'GH', 1, NULL, NULL),
(6, 12, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'GH', 1, NULL, NULL),
(7, 13, NULL, 'Ahensan', 'I am a determined person and someone who is very passionate about what i do. I love to interact with great minds', NULL, NULL, NULL, 2, 'GH', 2, NULL, NULL),
(8, 14, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'GH', 1, NULL, NULL),
(9, 15, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'GH', 1, NULL, NULL),
(10, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'GH', 1, NULL, NULL),
(14, 20, NULL, NULL, 'I carry out creative designs for all kinds of metal works', NULL, NULL, NULL, 5, 'GH', 12, NULL, NULL),
(18, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GH', NULL, NULL, NULL),
(19, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GH', NULL, NULL, NULL),
(23, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GH', NULL, NULL, NULL),
(26, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GH', NULL, NULL, NULL),
(30, 35, NULL, 'Okpoi-Gonno', NULL, NULL, NULL, NULL, 1, 'GH', 8, NULL, NULL),
(31, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 38, NULL, 'Okpoi-Gonno', 'I specialize in P.O.P ceiling works, plaster ceiling and wall skimming', NULL, NULL, NULL, 1, NULL, 8, NULL, NULL),
(34, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 375, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 376, NULL, 'Okpoi-Gonno', 'I have specialty in the use of labour-based work method for construction and rehabilitation of rural roads. I am also very conversant with the use of GIS for Road Asset Management.', NULL, NULL, NULL, 1, 'GH', 8, NULL, NULL),
(40, 379, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 380, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 381, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 383, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 385, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 387, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 390, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 392, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 393, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 394, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 399, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 401, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 405, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 406, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 407, NULL, 'Oyarifa, Owusu-Ansah', NULL, NULL, NULL, NULL, 1, 'GH', 4, NULL, NULL),
(62, 408, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 409, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 410, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 411, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `weekly_deal`
--

CREATE TABLE `weekly_deal` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rental_ad_id` int(11) DEFAULT NULL,
  `bid_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `discount_rate` double(10,3) DEFAULT NULL,
  `deal_price` double(10,3) DEFAULT NULL,
  `end_date` datetime NOT NULL,
  `is_discounted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weekly_deal`
--

INSERT INTO `weekly_deal` (`id`, `supplier_id`, `product_id`, `rental_ad_id`, `bid_id`, `user_id`, `discount_rate`, `deal_price`, `end_date`, `is_discounted`, `created_at`, `updated_at`) VALUES
(1, 22, 33, NULL, 5, 376, 50.000, NULL, '2018-07-31 00:00:00', 0, '2018-07-24 22:40:00', '2018-07-24 20:40:01'),
(2, 22, 34, NULL, 5, 376, NULL, 132.000, '2018-07-31 00:00:00', 1, '2018-07-24 22:59:15', '2018-07-24 20:59:15'),
(3, 22, 8, NULL, 5, 376, 20.000, NULL, '2018-07-31 00:00:00', 0, '2018-07-25 00:16:00', '2018-07-24 22:16:01'),
(4, 24, 42, NULL, 5, 379, 60.000, NULL, '2018-07-31 00:00:00', 0, '2018-07-26 18:40:16', '2018-07-26 16:40:17'),
(5, 22, 22, NULL, 5, 376, NULL, 780.000, '2018-07-31 00:00:00', 1, '2018-10-13 19:31:56', '2018-10-13 17:31:58'),
(6, 22, 40, NULL, 5, 376, 15.000, NULL, '2018-10-20 00:00:00', 1, '2018-10-13 20:12:08', '2018-10-13 18:12:08'),
(7, 22, 15, NULL, 5, 376, NULL, 85.000, '2018-10-20 00:00:00', 0, '2018-10-13 21:05:51', '2018-10-13 19:05:52'),
(8, 22, NULL, 3, 5, 376, NULL, 550.000, '2019-09-28 00:00:00', 0, '2019-09-21 19:49:34', '2019-09-21 17:49:35'),
(9, 22, NULL, 5, 5, 376, NULL, 400.000, '2019-09-28 00:00:00', 0, '2019-09-21 20:04:32', '2019-09-21 18:04:32'),
(10, 22, NULL, 7, 5, 376, 15.000, NULL, '2019-09-28 00:00:00', 1, '2019-09-21 20:08:09', '2019-09-21 18:08:09'),
(11, 22, NULL, 6, 5, 376, NULL, 220.000, '2019-09-28 00:00:00', 0, '2019-09-21 20:13:08', '2019-09-21 18:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `works`
--

CREATE TABLE `works` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `summary` text NOT NULL,
  `client` varchar(55) DEFAULT NULL,
  `status` varchar(55) DEFAULT NULL,
  `description` text,
  `feature_image` varchar(255) DEFAULT NULL,
  `gallery` longtext,
  `region_id` int(11) DEFAULT NULL,
  `town_id` int(11) DEFAULT NULL,
  `sub_location` varchar(55) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `completion_date` datetime DEFAULT NULL,
  `is_commentable` tinyint(1) NOT NULL DEFAULT '1',
  `comment_count` int(11) NOT NULL DEFAULT '0',
  `value_of_works` double(10,3) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `works`
--

INSERT INTO `works` (`id`, `user_id`, `company_id`, `title`, `slug`, `summary`, `client`, `status`, `description`, `feature_image`, `gallery`, `region_id`, `town_id`, `sub_location`, `start_date`, `completion_date`, `is_commentable`, `comment_count`, `value_of_works`, `created_at`, `updated_at`) VALUES
(12, 376, NULL, 'Re-roofing of Greda Estates', 're-roofing-of-greda-extates', 'I carried out some roofing for  a major real estate. We used domod roofing technology for the assignment.', 'Greda Estate Ltd', 'Completed', NULL, '5b2bd0be1b2be570496040.jpg', 'N;', 1, 7, 'No. 2 Round About', '2017-02-15 00:00:00', '2017-12-28 00:00:00', 1, 0, NULL, '2018-06-20 12:31:50', '2018-06-20 10:31:51'),
(13, 376, NULL, 'Renovation of Steel Bridge at Okpoi-Gonno, Teshie', 'renovation-of-steel-bridge-at-okpoi-gonno-teshie', 'The Okpoi-Gonno steel bridge has been in a poor state of disrepair for the past 5 years. I worked with a team of structural engineers, masons, steel benders and other professionals to reinstate the bridge.', 'Government of Ghana', 'Completed', NULL, '5b6dbde45d535741249264.jpg', 'N;', 1, 8, 'Okpoi-Gonno', '2017-02-23 00:00:00', '2018-07-09 00:00:00', 1, 1, NULL, '2018-08-10 18:08:14', '2018-08-10 16:08:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_tracker`
--
ALTER TABLE `activity_tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertiser`
--
ALTER TABLE `advertiser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_menu_item`
--
ALTER TABLE `app_menu_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_code` (`code`);

--
-- Indexes for table `app_subscription`
--
ALTER TABLE `app_subscription`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_app_idx` (`app_id`,`company_id`);

--
-- Indexes for table `association`
--
ALTER TABLE `association`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `award`
--
ALTER TABLE `award`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `builder`
--
ALTER TABLE `builder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `builder_overall_rating`
--
ALTER TABLE `builder_overall_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `builder_rating`
--
ALTER TABLE `builder_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `builder_rating_summary`
--
ALTER TABLE `builder_rating_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `builder_specialty`
--
ALTER TABLE `builder_specialty`
  ADD PRIMARY KEY (`builder_id`,`specialty_id`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certs_obtained`
--
ALTER TABLE `certs_obtained`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_category`
--
ALTER TABLE `company_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_client`
--
ALTER TABLE `company_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_preference`
--
ALTER TABLE `company_preference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_service`
--
ALTER TABLE `company_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_order`
--
ALTER TABLE `c_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_user`
--
ALTER TABLE `c_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_29368D1892FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_29368D18A0D96FBF` (`email_canonical`);

--
-- Indexes for table `entity_image`
--
ALTER TABLE `entity_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `estate`
--
ALTER TABLE `estate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured_category`
--
ALTER TABLE `featured_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `firm`
--
ALTER TABLE `firm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`follower`,`following`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hub_app`
--
ALTER TABLE `hub_app`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label` (`label`,`code`);

--
-- Indexes for table `hub_bid`
--
ALTER TABLE `hub_bid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institution`
--
ALTER TABLE `institution`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invite`
--
ALTER TABLE `invite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `open_bid`
--
ALTER TABLE `open_bid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_view`
--
ALTER TABLE `page_view`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_category_relationship`
--
ALTER TABLE `post_category_relationship`
  ADD PRIMARY KEY (`post_id`,`category_id`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`post_id`,`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_data`
--
ALTER TABLE `product_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sale_options`
--
ALTER TABLE `product_sale_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professional`
--
ALTER TABLE `professional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_comment`
--
ALTER TABLE `project_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_like`
--
ALTER TABLE `project_like`
  ADD PRIMARY KEY (`project_id`,`user_id`);

--
-- Indexes for table `promoted_product`
--
ALTER TABLE `promoted_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_request`
--
ALTER TABLE `quotation_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_measure`
--
ALTER TABLE `rating_measure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F62F1765E237E06` (`name`);

--
-- Indexes for table `rental_ad`
--
ALTER TABLE `rental_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_promo`
--
ALTER TABLE `rental_promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_request`
--
ALTER TABLE `rental_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rented_out`
--
ALTER TABLE `rented_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snapshare`
--
ALTER TABLE `snapshare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialty`
--
ALTER TABLE `specialty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_post`
--
ALTER TABLE `status_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_ad`
--
ALTER TABLE `store_ad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_options`
--
ALTER TABLE `store_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_product_category`
--
ALTER TABLE `supplier_product_category`
  ADD PRIMARY KEY (`supplier_id`,`product_category_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_supplier`
--
ALTER TABLE `top_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `town`
--
ALTER TABLE `town`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_company`
--
ALTER TABLE `user_company`
  ADD PRIMARY KEY (`user_id`,`company_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`company_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekly_deal`
--
ALTER TABLE `weekly_deal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_tracker`
--
ALTER TABLE `activity_tracker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `app_menu_item`
--
ALTER TABLE `app_menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `app_subscription`
--
ALTER TABLE `app_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `association`
--
ALTER TABLE `association`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `award`
--
ALTER TABLE `award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `builder`
--
ALTER TABLE `builder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `builder_overall_rating`
--
ALTER TABLE `builder_overall_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `builder_rating`
--
ALTER TABLE `builder_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `builder_rating_summary`
--
ALTER TABLE `builder_rating_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `certs_obtained`
--
ALTER TABLE `certs_obtained`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `company_category`
--
ALTER TABLE `company_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `company_client`
--
ALTER TABLE `company_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_preference`
--
ALTER TABLE `company_preference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_service`
--
ALTER TABLE `company_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `c_order`
--
ALTER TABLE `c_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `c_user`
--
ALTER TABLE `c_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `entity_image`
--
ALTER TABLE `entity_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `estate`
--
ALTER TABLE `estate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `featured_category`
--
ALTER TABLE `featured_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hub_app`
--
ALTER TABLE `hub_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hub_bid`
--
ALTER TABLE `hub_bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `institution`
--
ALTER TABLE `institution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invite`
--
ALTER TABLE `invite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `open_bid`
--
ALTER TABLE `open_bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `page_view`
--
ALTER TABLE `page_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=571;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `post_category`
--
ALTER TABLE `post_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `product_data`
--
ALTER TABLE `product_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product_sale_options`
--
ALTER TABLE `product_sale_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `professional`
--
ALTER TABLE `professional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `project_comment`
--
ALTER TABLE `project_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promoted_product`
--
ALTER TABLE `promoted_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quotation_request`
--
ALTER TABLE `quotation_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `rating_measure`
--
ALTER TABLE `rating_measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rental_ad`
--
ALTER TABLE `rental_ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rental_promo`
--
ALTER TABLE `rental_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rental_request`
--
ALTER TABLE `rental_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rented_out`
--
ALTER TABLE `rented_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `snapshare`
--
ALTER TABLE `snapshare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specialty`
--
ALTER TABLE `specialty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_ad`
--
ALTER TABLE `store_ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_options`
--
ALTER TABLE `store_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `top_supplier`
--
ALTER TABLE `top_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `town`
--
ALTER TABLE `town`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `weekly_deal`
--
ALTER TABLE `weekly_deal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `works`
--
ALTER TABLE `works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
