-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 12:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipms`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_charges`
--

CREATE TABLE `additional_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_charges`
--

INSERT INTO `additional_charges` (`id`, `name`, `description`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Mineral Water', NULL, 20.00, '2025-01-05 01:43:34', '2025-01-05 01:43:34'),
(2, 'Tea', NULL, 50.00, '2025-01-05 01:44:05', '2025-01-05 01:44:05'),
(3, 'Coffee', NULL, 70.00, '2025-01-05 01:44:17', '2025-01-05 01:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `additional_charge_booking`
--

CREATE TABLE `additional_charge_booking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `additional_charge_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_charge_booking`
--

INSERT INTO `additional_charge_booking` (`id`, `booking_id`, `additional_charge_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 11, 1, 20.00, '2025-01-14 07:06:50', '2025-01-14 07:06:50'),
(2, 11, 2, 30.00, '2025-01-14 07:06:50', '2025-01-14 07:06:50'),
(5, 10, 1, 50.00, '2025-01-18 06:05:50', '2025-01-18 06:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` varchar(255) DEFAULT NULL,
  `meal_plan_id` varchar(255) DEFAULT NULL,
  `room_type` varchar(255) DEFAULT NULL,
  `pax` int(11) DEFAULT NULL,
  `room_tariff` decimal(10,2) DEFAULT NULL,
  `advance_payment` decimal(10,2) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `status` enum('pending','confirmed','checked_in','checked_out','canceled') NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `remaining_balance` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_amount` varchar(255) NOT NULL,
  `payment_methods_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `reservation_id`, `customer_id`, `room_id`, `agent_id`, `meal_plan_id`, `room_type`, `pax`, `room_tariff`, `advance_payment`, `check_in_date`, `check_out_date`, `status`, `total_amount`, `remaining_balance`, `created_at`, `updated_at`, `tax_amount`, `payment_methods_id`) VALUES
(7, NULL, 3, NULL, 'bnm', 'half_board', NULL, NULL, NULL, 2000.00, '2025-01-03', '2025-01-04', 'confirmed', NULL, NULL, '2025-01-02 08:05:21', '2025-01-02 08:05:21', '', ''),
(8, NULL, 4, NULL, NULL, 'MAP', NULL, NULL, NULL, NULL, '2025-01-04', '2025-01-06', 'confirmed', NULL, NULL, '2025-01-04 04:39:39', '2025-01-04 04:39:39', '', ''),
(9, NULL, 3, NULL, 'bnm', 'EP', NULL, NULL, NULL, 2000.00, '2025-01-03', '2025-01-04', 'confirmed', 1000.00, NULL, '2025-01-04 06:12:51', '2025-01-04 06:12:51', '', ''),
(10, NULL, 3, NULL, 'bn', 'AP', NULL, NULL, 2000.00, 2000.00, '2025-01-10', '2025-01-21', 'confirmed', 43800.00, 43800.00, '2025-01-04 07:16:14', '2025-01-04 07:16:14', '4714.29', '1'),
(11, NULL, 10, NULL, 'BNM', 'MAP', NULL, NULL, NULL, 2000.00, '2025-01-06', '2025-01-07', 'confirmed', 6000.00, 6000.00, '2025-01-06 01:09:56', '2025-01-06 01:09:56', '1220.34', '2'),
(12, NULL, 5, NULL, 'aaaa', 'EP', NULL, NULL, NULL, 2000.00, '2025-01-25', '2025-01-31', 'confirmed', 46000.00, 46000.00, '2025-01-14 12:18:53', '2025-01-14 12:18:53', '7322.03', '1'),
(13, NULL, 7, NULL, 'bnm', 'EP', NULL, NULL, 3000.00, 2000.00, '2025-01-17', '2025-01-24', 'confirmed', 19000.00, 19000.00, '2025-01-14 12:29:57', '2025-01-14 12:29:57', '2250.00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `booking_room`
--

CREATE TABLE `booking_room` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_room`
--

INSERT INTO `booking_room` (`id`, `booking_id`, `room_id`, `check_in_date`, `check_out_date`, `created_at`, `updated_at`) VALUES
(7, 7, 1, '2025-01-03', '2025-01-04', '2025-01-02 08:05:21', '2025-01-02 08:05:21'),
(8, 8, 1, '2025-01-04', '2025-01-06', '2025-01-04 04:39:39', '2025-01-04 04:39:39'),
(9, 9, 2, '2025-01-03', '2025-01-04', '2025-01-04 06:12:51', '2025-01-04 06:12:51'),
(10, 10, 3, '2025-01-10', '2025-01-21', '2025-01-04 07:16:14', '2025-01-05 03:00:19'),
(11, 10, 1, '2025-01-10', '2025-01-21', '2025-01-05 03:00:19', '2025-01-05 03:00:19'),
(12, 10, 2, '2025-01-10', '2025-01-21', '2025-01-05 03:00:19', '2025-01-05 03:00:19'),
(13, 11, 1, '2025-01-06', '2025-01-07', '2025-01-06 01:09:56', '2025-01-06 01:09:56'),
(14, 12, 1, '2025-01-25', '2025-01-31', '2025-01-14 12:18:53', '2025-01-14 12:18:53'),
(15, 13, 4, '2025-01-17', '2025-01-24', '2025-01-14 12:29:57', '2025-01-14 12:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('vahid.snackeye@gmail.com|::1', 'i:1;', 1735383997),
('vahid.snackeye@gmail.com|::1:timer', 'i:1735383997;', 1735383997),
('vahidsnackeyes@gmail.com|::1', 'i:1;', 1736507344),
('vahidsnackeyes@gmail.com|::1:timer', 'i:1736507344;', 1736507344);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_ins`
--

CREATE TABLE `check_ins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `room_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`room_ids`)),
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `status` enum('Checked In','Checked Out') NOT NULL DEFAULT 'Checked In',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `check_ins`
--

INSERT INTO `check_ins` (`id`, `booking_id`, `room_ids`, `room_id`, `check_in_date`, `status`, `created_at`, `updated_at`) VALUES
(6, 10, '[3,1,2]', NULL, '2025-01-10', 'Checked In', '2025-01-10 00:44:07', '2025-01-18 05:36:44'),
(7, 11, '[1]', NULL, '2025-01-11', 'Checked In', '2025-01-10 23:52:45', '2025-01-10 23:52:45'),
(8, 13, '[4]', NULL, '2025-01-14', 'Checked In', '2025-01-14 12:30:16', '2025-01-14 12:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `check_in_additional_charges`
--

CREATE TABLE `check_in_additional_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `check_in_id` bigint(20) UNSIGNED NOT NULL,
  `additional_charge_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_outs`
--

CREATE TABLE `check_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `check_in_id` bigint(20) UNSIGNED NOT NULL,
  `rest_payment` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `additional_charges` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_charges`)),
  `discount` decimal(8,2) DEFAULT NULL,
  `discount_remarks` varchar(255) DEFAULT NULL,
  `gst` decimal(8,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `identity_type` varchar(255) DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `id_front` varchar(255) DEFAULT NULL,
  `id_back` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `f_name`, `l_name`, `email`, `phone`, `address`, `city`, `state`, `country`, `gender`, `dob`, `nationality`, `identity_type`, `id_no`, `id_front`, `id_back`, `created_at`, `updated_at`) VALUES
(1, 'ghj', 'ghj', 'ghj@ghj.cjk', 'jk', 'jkjk', 'jk', 'jkjk', 'jkjk', 'Male', '2024-01-01', 'ertyui', 'Passport', '5678', 'uploads/customers/04wrNidZvTtA3mhUXzLTbZeS5G3riWuWUWIi6MMu.jpg', 'uploads/customers/cGe5lDfOLO81jOwfGAcFPyzgZmsdqeIdazninNdl.jpg', '2024-12-28 06:52:26', '2024-12-28 06:52:26'),
(2, 'Vahid', 'Sumra', 'vahid@gmail.com', '9874563210', 'fgh', 'ghj', 'ghj', 'gh', 'Male', '1993-05-04', 'dfgh', 'bbbs', '2345', NULL, NULL, '2024-12-29 01:18:40', '2024-12-29 01:37:36'),
(3, 'Vahid', 'sumra', 'vahid@ggg.com', '234567', 'rtyu', 'ghj', 'bn', 'bnm', 'Male', '1997-04-05', 'iii', 'Passport', '7899', 'uploads/customers/EL9qqUFPhZnRAJlKul10F23JuzvbvRmoziJzmRrq.jpg', 'uploads/customers/3EQiuHkrpEmr22bDi7MNT6SLpIHHgfHXPKPGpwoe.jpg', '2024-12-29 01:30:07', '2024-12-29 01:30:07'),
(4, 'Vahid', 'vahid', 'vahhu@hjk.com', '74108520963', NULL, NULL, NULL, NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-03 07:33:38', '2025-01-03 07:33:38'),
(5, 'xc', 'xcv', 'xcv@gmail.co', '2345678', 'ert', 'ert', 'rt', 'rty', 'Male', '2025-01-01', 'rty', 'Passport', NULL, NULL, NULL, '2025-01-05 08:03:21', '2025-01-05 08:03:21'),
(6, 'xc', 'xcv', 'wertyu@yyyd.com', '123456789', 'ert', 'ert', 'rt', 'rty', 'Male', '2025-01-01', 'rty', 'Passport', NULL, NULL, NULL, '2025-01-05 08:04:51', '2025-01-05 08:04:51'),
(7, 'cvb', 'vbn', 'vbn@ggg.ccc', '32847876', 'wertyu', 'rty', 'ty', 'tyu', 'Male', '2025-01-01', 'qty', 'Passport', NULL, NULL, NULL, '2025-01-05 08:07:44', '2025-01-05 08:07:44'),
(8, 'jkk', 'kkk', 'vvb@ol.com', '9876543210', 'jhghj', 'kjh', 'kjh', 'kjjh', 'Male', '2025-01-01', 'oio', 'Passport', NULL, NULL, NULL, '2025-01-06 00:08:56', '2025-01-06 00:08:56'),
(9, 'kjh', 'kjhu', 'uuih@hhjk.com', '34567896', 'fdgcfbh', 'ghj', 'gh', 'ghj', 'Male', '2025-12-31', 'fgh', 'Passport', NULL, NULL, NULL, '2025-01-06 01:00:37', '2025-01-06 01:00:37'),
(10, 'IOIO', 'OIOI', 'IOI@gmail.com', '23456789', 'ERTY', 'FRFY', 'DFG', 'DFG', 'Female', '2025-01-01', '3456789', 'Other', NULL, NULL, NULL, '2025-01-06 01:07:54', '2025-01-06 01:07:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'First Floor', '2024-12-28 08:02:13', '2024-12-28 08:02:13'),
(2, 'Second Floor', '2024-12-28 08:02:27', '2024-12-28 08:02:27'),
(3, 'Third Floor', '2024-12-28 08:02:37', '2024-12-28 08:02:37'),
(4, 'Five Floor', '2024-12-28 08:02:46', '2024-12-28 08:02:46'),
(5, 'Sixth', '2024-12-28 08:02:54', '2024-12-28 08:02:54'),
(6, 'Fourth', '2025-01-03 04:30:27', '2025-01-03 04:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_27_153732_create_permissions_table', 2),
(5, '2024_12_27_153732_create_roles_table', 2),
(6, '2024_12_27_154506_update_users_table', 3),
(7, '2024_12_27_155712_create_permission_role_table', 4),
(11, '2024_12_27_160815_create_floors_table', 5),
(12, '2024_12_27_160816_create_room_types_table', 5),
(13, '2024_12_27_160816_create_rooms_table', 5),
(18, '2024_12_27_193427_add_status_column_rooms', 7),
(19, '2024_12_27_194644_create_customers_table', 8),
(20, '2024_12_28_145832_create_reservation_room_table', 9),
(22, '2024_12_28_151940_update_reservation_date_in_reservations_table', 11),
(24, '2024_12_27_192811_create_reservations_table', 12),
(25, '2024_12_29_103549_create_booking_room_table', 13),
(27, '2024_12_27_193220_create_bookings_table', 14),
(28, '2024_12_29_144537_create_agents_table', 14),
(29, '2025_01_03_140833_create_taxes_table', 15),
(30, '2025_01_04_112144_create_payment_methods_table', 16),
(31, '2025_01_04_121854_add_fields_in_booking_table', 17),
(32, '2025_01_05_052756_create_additional_charges_table', 18),
(34, '2025_01_05_071855_create_check_ins_table', 19),
(35, '2025_01_05_112847_add_room_ids_to_check_ins_table', 20),
(36, '2025_01_10_054005_create_check_outs_table', 21),
(37, '2025_01_11_071050_add_fields_to_check_outs_table', 22),
(38, '2025_01_11_152026_create_additional_charges_table', 23),
(39, '2025_01_14_120522_create_additional_charge_booking_table', 24);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `payment_option` enum('None','Credit Card','Check','Loyalty') NOT NULL,
  `surcharge_amount` decimal(8,2) DEFAULT NULL,
  `surcharge_percentage` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `payment_option`, `surcharge_amount`, `surcharge_percentage`, `created_at`, `updated_at`) VALUES
(1, 'UPI', 'None', 0.00, 0.00, '2025-01-04 06:03:22', '2025-01-04 06:03:22'),
(2, 'Cash', 'None', 0.00, 0.00, '2025-01-04 06:03:30', '2025-01-04 06:03:30'),
(3, 'Credit Card', 'Credit Card', 0.00, 0.00, '2025-01-04 06:03:48', '2025-01-04 06:03:48'),
(4, 'Bill To Company', 'None', 0.00, 0.00, '2025-01-04 06:07:24', '2025-01-04 06:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `purpose_of_visit` text DEFAULT NULL,
  `source_of_booking` varchar(255) DEFAULT NULL,
  `arrival_from` varchar(255) DEFAULT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `room_tariff` decimal(10,2) DEFAULT NULL,
  `meal_plan` varchar(255) DEFAULT NULL,
  `advance_payment` decimal(10,2) DEFAULT NULL,
  `agent_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `customer_id`, `check_in`, `check_out`, `status`, `remarks`, `purpose_of_visit`, `source_of_booking`, `arrival_from`, `room_type_id`, `adults`, `children`, `room_tariff`, `meal_plan`, `advance_payment`, `agent_name`, `created_at`, `updated_at`) VALUES
(2, 3, '2025-01-03', '2025-01-04', 'pending', NULL, NULL, NULL, NULL, 1, 5, 2, 5000.00, 'half_board', 2000.00, 'bnm', '2025-01-02 01:51:40', '2025-01-02 08:05:08');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_room`
--

CREATE TABLE `reservation_room` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `floor_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `base_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('available','booked','maintenance') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `floor_id`, `room_type_id`, `base_price`, `created_at`, `updated_at`, `status`) VALUES
(1, '101', 1, 1, 8000, '2024-12-28 08:06:45', '2025-01-04 02:48:01', 'available'),
(2, '102', 1, 1, 3000, '2024-12-29 06:06:33', '2024-12-29 06:06:33', 'available'),
(3, '103', 1, 2, 4000, '2024-12-29 08:08:24', '2024-12-29 08:08:24', 'available'),
(4, '104', 1, 1, 3000, '2025-01-03 04:16:12', '2025-01-03 04:16:56', 'available'),
(5, '105', 1, 4, 5000, '2025-01-03 04:20:43', '2025-01-03 04:25:31', 'available'),
(6, '201', 2, 1, 3000, '2025-01-03 04:20:59', '2025-01-03 04:20:59', 'available'),
(7, '202', 2, 1, 3000, '2025-01-03 04:24:13', '2025-01-03 04:24:13', 'available'),
(8, '203', 2, 2, 3500, '2025-01-03 04:24:55', '2025-01-03 04:24:55', 'available'),
(9, '204', 2, 1, 3000, '2025-01-03 04:25:08', '2025-01-03 04:25:08', 'available'),
(10, '205', 2, 4, 5000, '2025-01-03 04:25:23', '2025-01-03 04:25:23', 'available'),
(11, '222', 2, 5, 111111, '2025-01-03 04:25:54', '2025-01-03 04:25:54', 'available'),
(12, '301', 3, 1, 3000, '2025-01-03 04:26:28', '2025-01-03 04:26:28', 'available'),
(13, '302', 3, 1, 3000, '2025-01-03 04:26:38', '2025-01-03 04:26:38', 'available'),
(14, '303', 3, 2, 3500, '2025-01-03 04:26:53', '2025-01-03 04:26:53', 'available'),
(15, '304', 3, 1, 3000, '2025-01-03 04:27:10', '2025-01-03 04:27:10', 'available'),
(16, '305', 3, 4, 5000, '2025-01-03 04:28:05', '2025-01-03 04:28:05', 'available'),
(17, '306', 3, 2, 3500, '2025-01-03 04:28:37', '2025-01-03 04:28:37', 'available'),
(18, '307', 3, 3, 4000, '2025-01-03 04:28:50', '2025-01-03 04:28:50', 'available'),
(19, '401', 6, 1, 3000, '2025-01-03 04:31:10', '2025-01-03 04:31:10', 'available'),
(20, '402', 6, 1, 3000, '2025-01-03 04:31:27', '2025-01-03 04:31:27', 'available'),
(21, '403', 6, 2, 3500, '2025-01-03 04:31:38', '2025-01-03 04:31:38', 'available'),
(22, '404', 6, 1, 3000, '2025-01-03 04:31:53', '2025-01-03 04:31:53', 'available'),
(23, '405', 6, 4, 5000, '2025-01-03 04:32:11', '2025-01-03 04:32:11', 'available'),
(24, '406', 6, 2, 3500, '2025-01-03 04:32:58', '2025-01-03 04:32:58', 'available'),
(25, '407', 6, 3, 4000, '2025-01-03 04:33:12', '2025-01-03 04:33:12', 'available'),
(26, '501', 4, 1, 3000, '2025-01-03 04:33:29', '2025-01-03 04:33:29', 'available'),
(27, '502', 4, 1, 3000, '2025-01-03 04:33:46', '2025-01-03 04:33:46', 'available'),
(28, '503', 4, 2, 3500, '2025-01-03 04:34:00', '2025-01-03 04:34:00', 'available'),
(29, '504', 4, 1, 3000, '2025-01-03 04:34:20', '2025-01-03 04:34:20', 'available'),
(30, '505', 4, 4, 5000, '2025-01-03 04:34:39', '2025-01-03 04:34:39', 'available'),
(31, '506', 4, 2, 3500, '2025-01-03 04:34:54', '2025-01-03 04:34:54', 'available'),
(32, '507', 4, 3, 4000, '2025-01-03 04:35:41', '2025-01-03 04:35:41', 'available'),
(33, '601', 5, 1, 3000, '2025-01-03 04:36:04', '2025-01-03 04:36:04', 'available'),
(34, '602', 5, 1, 3000, '2025-01-03 04:36:16', '2025-01-03 04:36:16', 'available'),
(35, '603', 5, 4, 5000, '2025-01-03 04:36:26', '2025-01-03 04:36:26', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `base_adult` int(11) NOT NULL,
  `base_child` int(11) NOT NULL,
  `max_adult` int(11) NOT NULL,
  `max_child` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `base_adult`, `base_child`, `max_adult`, `max_child`, `created_at`, `updated_at`) VALUES
(1, 'Deluxe', 2, 1, 2, 1, '2024-12-28 08:03:24', '2024-12-28 08:03:24'),
(2, 'Premium', 3, 1, 3, 1, '2024-12-28 08:05:43', '2024-12-28 08:05:43'),
(3, 'Superior', 4, 1, 4, 1, '2024-12-28 08:05:57', '2024-12-28 08:05:57'),
(4, 'Family', 5, 1, 5, 1, '2024-12-28 08:06:09', '2024-12-28 08:06:09'),
(5, 'Stuido Suit', 2, 0, 2, 0, '2024-12-28 08:06:24', '2024-12-28 08:06:24');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2Av2HlYH8vKLFTJcCiNxWzVw5v59YfmFrUlaiTvH', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSDNpZDVzVUtIOUJKTnhKU2p2bTJYazhYN1VWdnpwR3RoYUlNM1ZiNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9sb2NhbGhvc3QvaXBtcy9wdWJsaWMvY2hlY2tfb3V0cy9jcmVhdGUvNiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1737038288),
('7bSj0ywQjFpqvAHv1sgO2DSRotdVXXIg0XjTISGI', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRjZNQzY3aThMQVpEa21ZOEdrU1doaElPQlYzNmNKTXZTWHlPd3h1TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3QvaXBtcy9wdWJsaWMvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1737467264),
('dl2K1XnSg5bbnJtHOJi35LEpIml92QsFKIRpqA2V', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1RyZFBUNHNJSlQxVkpYTkU0MXdtWUFWOFA5OXRDVE5WdFpKb0V2eiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3QvaXBtcy9wdWJsaWMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1737351103),
('FQh4zB51lEY0ToH01AkMPoUr8OdQxTfcQVGaMXku', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkpEWUZiMzN5dU1ibDBqNjV4Vkw3U2J4czByc05HTjFqSTRKSDlnVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3QvaXBtcy9wdWJsaWMvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1737487688),
('RnwQeIxduDe7nW1irST1t9dZ8ZQGvbvc1QvlYLYG', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkpkZHBoRU12SzdRUnBnM2ZSekRUdm5pVnBJcUNnV3NiQjVFc3Y5SiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9sb2NhbGhvc3QvaXBtcy9wdWJsaWMvYm9va2luZ3MvMTAvY2hhcmdlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1737200151),
('wbmeT1ofz7hvaxa75ncuNvbtRoGXCrKrMOGZtlYz', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUdXY254ZVkydXN6NW1Ld3EzcVZYbFBOYzZxbFBkM0tmVGc3OUhvcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3QvaXBtcy9wdWJsaWMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1737487686),
('XNtPBqRnzGqU8TWYSnv5FYQOl7oQcLty6iyqYgZT', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVlyVjVIRkRHUXFKQzc5d2ZiN3BDNTBIY2tpakFrWFdyMUVxT2lKbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3QvaXBtcy9wdWJsaWMvYWRkaXRpb25hbF9jaGFyZ2VzLzEvZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1737263468);

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `rate`, `created_at`, `updated_at`) VALUES
(1, 'GST12', 12.00, '2025-01-03 09:12:28', '2025-01-03 09:12:28'),
(2, 'GST18', 18.00, '2025-01-03 09:12:37', '2025-01-03 09:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Vahid', 'vahid.snackeyes@gmail.com', NULL, '$2y$12$JKv6t.w6fuK0Q/YBSrmxs.zBuurhRJ/qJB6ht0eWnWTTbcAOeWZA6', NULL, '2024-12-27 07:23:27', '2024-12-27 07:23:27', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_charges`
--
ALTER TABLE `additional_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `additional_charge_booking`
--
ALTER TABLE `additional_charge_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `additional_charge_booking_booking_id_foreign` (`booking_id`),
  ADD KEY `additional_charge_booking_additional_charge_id_foreign` (`additional_charge_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agents_email_unique` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_reservation_id_foreign` (`reservation_id`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`);

--
-- Indexes for table `booking_room`
--
ALTER TABLE `booking_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_room_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_room_room_id_foreign` (`room_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_ins_booking_id_foreign` (`booking_id`),
  ADD KEY `check_ins_room_id_foreign` (`room_id`);

--
-- Indexes for table `check_in_additional_charges`
--
ALTER TABLE `check_in_additional_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_in_additional_charges_check_in_id_foreign` (`check_in_id`),
  ADD KEY `check_in_additional_charges_additional_charge_id_foreign` (`additional_charge_id`);

--
-- Indexes for table `check_outs`
--
ALTER TABLE `check_outs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_outs_check_in_id_foreign` (`check_in_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `floors_name_unique` (`name`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_customer_id_foreign` (`customer_id`),
  ADD KEY `reservations_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `reservation_room`
--
ALTER TABLE `reservation_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_room_reservation_id_foreign` (`reservation_id`),
  ADD KEY `reservation_room_room_id_foreign` (`room_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  ADD KEY `rooms_floor_id_foreign` (`floor_id`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_types_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_charges`
--
ALTER TABLE `additional_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `additional_charge_booking`
--
ALTER TABLE `additional_charge_booking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `booking_room`
--
ALTER TABLE `booking_room`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `check_ins`
--
ALTER TABLE `check_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `check_in_additional_charges`
--
ALTER TABLE `check_in_additional_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_outs`
--
ALTER TABLE `check_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation_room`
--
ALTER TABLE `reservation_room`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_charge_booking`
--
ALTER TABLE `additional_charge_booking`
  ADD CONSTRAINT `additional_charge_booking_additional_charge_id_foreign` FOREIGN KEY (`additional_charge_id`) REFERENCES `additional_charges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `additional_charge_booking_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_room`
--
ALTER TABLE `booking_room`
  ADD CONSTRAINT `booking_room_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_room_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD CONSTRAINT `check_ins_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `check_ins_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `check_in_additional_charges`
--
ALTER TABLE `check_in_additional_charges`
  ADD CONSTRAINT `check_in_additional_charges_additional_charge_id_foreign` FOREIGN KEY (`additional_charge_id`) REFERENCES `additional_charges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `check_in_additional_charges_check_in_id_foreign` FOREIGN KEY (`check_in_id`) REFERENCES `check_ins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `check_outs`
--
ALTER TABLE `check_outs`
  ADD CONSTRAINT `check_outs_check_in_id_foreign` FOREIGN KEY (`check_in_id`) REFERENCES `check_ins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservations_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation_room`
--
ALTER TABLE `reservation_room`
  ADD CONSTRAINT `reservation_room_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_room_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
