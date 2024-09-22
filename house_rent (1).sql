-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 03:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `house_rent`
--

-- --------------------------------------------------------

--
-- Table structure for table `advanced_amounts`
--

CREATE TABLE `advanced_amounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `inv_id` varchar(100) NOT NULL,
  `deposit` double(20,2) NOT NULL DEFAULT 0.00,
  `withdraw` double(20,2) NOT NULL DEFAULT 0.00,
  `balance` double(20,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `particular` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advanced_amounts`
--

INSERT INTO `advanced_amounts` (`id`, `client_id`, `auth_id`, `tenant_id`, `agreement_id`, `inv_id`, `deposit`, `withdraw`, `balance`, `date`, `particular`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 8, 1, '000001', 25000.00, 0.00, 25000.00, '21-Sep-2024', 'Advanced', '2024-09-21 00:27:08', '2024-09-21 00:27:08'),
(2, 1002, 1002, 7, 2, '000002', 30000.00, 0.00, 30000.00, '21-Sep-2024', 'Advanced', '2024-09-21 01:32:14', '2024-09-21 01:32:14'),
(3, 1004, 1004, 12, 3, '000001', 50000.00, 0.00, 50000.00, '22-Sep-2024', 'Advanced', '2024-09-22 07:18:25', '2024-09-22 07:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` varchar(255) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `total_income` double(20,2) NOT NULL DEFAULT 0.00,
  `total_expense` double(20,2) NOT NULL DEFAULT 0.00,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `flag` tinyint(4) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_setups`
--

CREATE TABLE `bill_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `inv_id` varchar(255) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `flat_rent` double(20,2) NOT NULL DEFAULT 0.00,
  `service_charge` double(20,2) NOT NULL DEFAULT 0.00,
  `utility_bill` double(20,2) NOT NULL DEFAULT 0.00,
  `total_current_month_rent` double(20,2) NOT NULL DEFAULT 0.00,
  `previous_due` double(20,2) NOT NULL DEFAULT 0.00,
  `total_collection_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `total_collection` double(20,2) NOT NULL DEFAULT 0.00,
  `current_due` double(20,2) NOT NULL DEFAULT 0.00,
  `bill_setup_date` varchar(255) DEFAULT NULL,
  `collection_date` varchar(255) DEFAULT NULL,
  `created_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_setups`
--

INSERT INTO `bill_setups` (`id`, `client_id`, `auth_id`, `agreement_id`, `inv_id`, `tenant_id`, `flat_id`, `flat_rent`, `service_charge`, `utility_bill`, `total_current_month_rent`, `previous_due`, `total_collection_amount`, `total_collection`, `current_due`, `bill_setup_date`, `collection_date`, `created_date`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 1, NULL, 8, 1, 20000.00, 3500.00, 2000.00, 25500.00, 0.00, 25500.00, 22000.00, 3500.00, '2024-09', '2024-09-21', '2024-09-21', '2024-09-21 01:57:44', '2024-09-21 02:01:29'),
(2, 1002, 1002, 1, NULL, 8, 2, 20000.00, 3500.00, 2000.00, 25500.00, 0.00, 25500.00, 25000.00, 500.00, '2024-09', '2024-09-21', '2024-09-21', '2024-09-21 01:57:44', '2024-09-21 02:01:29'),
(3, 1002, 1002, 1, NULL, 8, 3, 20000.00, 3500.00, 2000.00, 25500.00, 0.00, 25500.00, 25500.00, 0.00, '2024-09', '2024-09-21', '2024-09-21', '2024-09-21 01:57:44', '2024-09-21 02:01:30'),
(4, 1002, 1002, 2, NULL, 7, 9, 25000.00, 3000.00, 2000.00, 30000.00, 0.00, 30000.00, 30000.00, 0.00, '2024-09', '2024-09-21', '2024-09-21', '2024-09-21 02:05:41', '2024-09-21 02:06:19'),
(5, 1004, 1004, 3, NULL, 12, 17, 22000.00, 3500.00, 2200.00, 27700.00, 0.00, 27700.00, 25000.00, 2700.00, '2024-10', '2024-09-22', '2024-09-22', '2024-09-22 07:19:21', '2024-09-22 07:20:54'),
(6, 1004, 1004, 3, NULL, 12, 18, 22000.00, 3500.00, 2200.00, 27700.00, 0.00, 27700.00, 27700.00, 0.00, '2024-10', '2024-09-22', '2024-09-22', '2024-09-22 07:19:21', '2024-09-22 07:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `building_rent` double(20,2) NOT NULL DEFAULT 0.00,
  `service_charge` double(20,2) NOT NULL DEFAULT 0.00,
  `utility_bill` double(20,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `auth_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `client_id`, `name`, `building_rent`, `service_charge`, `utility_bill`, `date`, `auth_id`, `created_at`, `updated_at`) VALUES
(1, 1002, 'Sarnolota 01', 500000.00, 20000.00, 20000.00, '02-07-2024', '1002', '2024-07-02 02:24:21', '2024-07-02 02:24:21'),
(2, 1002, 'Sarnolota 02', 500000.00, 5000.00, 2500.00, '03-07-2024', '1002', '2024-07-02 23:26:12', '2024-07-02 23:26:12'),
(3, 1002, 'Sarnolota 03', 400000.00, 25000.00, 20000.00, '08-07-2024', '1002', '2024-07-08 01:15:08', '2024-07-08 01:15:08'),
(4, 1002, 'Sarnolota 04', 550000.00, 30000.00, 25000.00, '08-07-2024', '1002', '2024-07-08 01:15:52', '2024-07-08 01:15:52'),
(5, 1002, 'Sarnolota 05', 600000.00, 35000.00, 25000.00, '08-07-2024', '1002', '2024-07-08 01:16:35', '2024-07-11 07:37:34'),
(6, 1003, 'Building 01', 500000.00, 3500.00, 2500.00, '09-07-2024', '1003', '2024-07-09 01:09:50', '2024-07-09 01:09:50'),
(7, 1003, 'Building 02', 400000.00, 30000.00, 20000.00, '09-07-2024', '1003', '2024-07-09 01:10:28', '2024-07-09 01:10:28'),
(8, 1004, 'Building 01', 500000.00, 50000.00, 50000.00, '22-09-2024', '1004', '2024-09-22 07:13:25', '2024-09-22 07:13:25'),
(9, 1004, 'Building 02', 6000000.00, 60000.00, 60000.00, '22-09-2024', '1004', '2024-09-22 07:13:59', '2024-09-22 07:13:59');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `client_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1002, 'Electricity', '2024-09-21 04:13:20', '2024-09-21 04:13:20'),
(2, 1002, 'Wash', '2024-09-22 04:41:07', '2024-09-22 04:41:07'),
(3, 1002, 'Maintainence', '2024-09-22 04:47:39', '2024-09-22 04:47:39'),
(4, 1004, 'dfghfh', '2024-09-22 07:24:44', '2024-09-22 07:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `nid_no` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `role` tinyint(4) NOT NULL DEFAULT 1,
  `isVerified` varchar(255) NOT NULL DEFAULT '0',
  `otp` varchar(255) NOT NULL,
  `package_id` tinyint(4) DEFAULT NULL,
  `package_start_date` varchar(255) DEFAULT NULL,
  `client_balance` double(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `nid_no`, `address`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `status`, `role`, `isVerified`, `otp`, `package_id`, `package_start_date`, `client_balance`, `created_at`, `updated_at`) VALUES
(1001, 'Admin', '55555', '6464654', 'Dhaka, Bangladesh', NULL, 'admin@gmail.com', NULL, '$2y$12$bQ9V15j3AFplib8Wlee0Ne2Fj0YZ9.2NhPHAILXl6G/1kkSTzq6s.', '', 1, 0, '1', 'g188', NULL, NULL, 0.00, '2024-06-30 00:35:07', '2024-06-30 00:35:25'),
(1002, 'Anam', '01847309892', '6464654', 'Faridpur, Dhaka', NULL, 'anam@gmail.com', NULL, '$2y$12$WNyaMBszoUL4r71AZgvcseo/37Y18SuIxXNWI3r7WOjgaSuXCnhgK', '', 1, 1, '1', '1Lqq', 1, '2024-07-03', 1500.00, '2024-06-30 00:37:59', '2024-09-18 03:50:16'),
(1003, 'Khairul Islam', '55555', '6464654', 'Kushtia', NULL, 'khairul@gmail.com', NULL, '$2y$12$8hb1Yewh5sI6k8FmiTQUmOa58PSkAHaDC19JuYkIj9iF0fTY.aMqu', '', 1, 1, '1', 'P9bT', 1, '2024-09-18', -4500.00, '2024-07-09 01:07:29', '2024-09-18 03:58:47'),
(1004, 'kamal', '123456', '6546545', 'Manikgonj, Dhaka.', NULL, 'Kamal@gmail.com', NULL, '$2y$12$4dMHRNFUsC0xz3.spQSey.zUQtzF5TIb7WMJEMy5.MNcJJ62igHqC', '', 1, 1, '1', 'kRrZ', 2, '2024-09-22', 6500.00, '2024-09-22 07:00:59', '2024-09-22 07:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `collection_master_id` int(11) NOT NULL,
  `inv_id` varchar(255) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `flat_rent` double(20,2) NOT NULL DEFAULT 0.00,
  `service_charge` double(20,2) NOT NULL DEFAULT 0.00,
  `utility_bill` double(20,2) NOT NULL DEFAULT 0.00,
  `total_current_month_rent` double(20,2) NOT NULL DEFAULT 0.00,
  `previous_due` double(20,2) NOT NULL DEFAULT 0.00,
  `total_collection_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `total_collection` double(20,2) NOT NULL DEFAULT 0.00,
  `current_due` double(20,2) NOT NULL DEFAULT 0.00,
  `bill_setup_date` varchar(255) DEFAULT NULL,
  `collection_date` varchar(255) DEFAULT NULL,
  `created_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `client_id`, `auth_id`, `agreement_id`, `collection_master_id`, `inv_id`, `tenant_id`, `flat_id`, `flat_rent`, `service_charge`, `utility_bill`, `total_current_month_rent`, `previous_due`, `total_collection_amount`, `total_collection`, `current_due`, `bill_setup_date`, `collection_date`, `created_date`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 1, 1, NULL, 8, 1, 20000.00, 3500.00, 2000.00, 25500.00, 0.00, 25500.00, 22000.00, 3500.00, '2024-09', '2024-09-21', NULL, '2024-09-21 02:01:29', '2024-09-21 02:01:29'),
(2, 1002, 1002, 1, 1, NULL, 8, 2, 20000.00, 3500.00, 2000.00, 25500.00, 0.00, 25500.00, 25000.00, 500.00, '2024-09', '2024-09-21', NULL, '2024-09-21 02:01:29', '2024-09-21 02:01:29'),
(3, 1002, 1002, 1, 1, NULL, 8, 3, 20000.00, 3500.00, 2000.00, 25500.00, 0.00, 25500.00, 25500.00, 0.00, '2024-09', '2024-09-21', NULL, '2024-09-21 02:01:30', '2024-09-21 02:01:30'),
(4, 1002, 1002, 2, 2, NULL, 7, 9, 25000.00, 3000.00, 2000.00, 30000.00, 0.00, 30000.00, 30000.00, 0.00, '2024-09', '2024-09-21', NULL, '2024-09-21 02:06:19', '2024-09-21 02:06:19'),
(5, 1004, 1004, 3, 3, NULL, 12, 17, 22000.00, 3500.00, 2200.00, 27700.00, 0.00, 27700.00, 25000.00, 2700.00, '2024-10', '2024-09-22', NULL, '2024-09-22 07:20:54', '2024-09-22 07:20:54'),
(6, 1004, 1004, 3, 3, NULL, 12, 18, 22000.00, 3500.00, 2200.00, 27700.00, 0.00, 27700.00, 27700.00, 0.00, '2024-10', '2024-09-22', NULL, '2024-09-22 07:20:54', '2024-09-22 07:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `collection_masters`
--

CREATE TABLE `collection_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `inv_id` varchar(255) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `total_rent_collection` double(20,2) NOT NULL DEFAULT 0.00,
  `collection_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_masters`
--

INSERT INTO `collection_masters` (`id`, `client_id`, `auth_id`, `agreement_id`, `inv_id`, `tenant_id`, `bill_id`, `total_rent_collection`, `collection_date`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 1, '000001', 8, 1, 72500.00, '2024-09', '2024-09-21 02:01:29', '2024-09-21 02:01:29'),
(2, 1002, 1002, 2, '000002', 7, 4, 30000.00, '2024-09', '2024-09-21 02:06:19', '2024-09-21 02:06:19'),
(3, 1004, 1004, 3, '000001', 12, 5, 52700.00, '2024-10', '2024-09-22 07:20:54', '2024-09-22 07:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `deed` varchar(255) DEFAULT NULL,
  `police_form` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `client_id`, `auth_id`, `tenant_id`, `nid`, `tin`, `photo`, `deed`, `police_form`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 1, 'tenant_documents/nid/1726737322_nid.jpg', 'tenant_documents/tin/1726737322_tin.jpg', 'tenant_documents/photo/1726737322_photo.jpg', 'tenant_documents/deed/1726737322_deed.png', 'tenant_documents/police_form/1726741739_police_form.jpg', '2024-09-19 03:15:22', '2024-09-19 04:28:59'),
(2, 1004, 1004, 12, 'tenant_documents/nid/1727011013_nid.png', 'tenant_documents/tin/1727011013_tin.jpg', 'tenant_documents/photo/1727011013_photo.jpg', 'tenant_documents/deed/1727011013_deed.jpg', 'tenant_documents/police_form/1727011013_police_form.jpg', '2024-09-22 07:16:53', '2024-09-22 07:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `exp_setup_id` varchar(255) NOT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `auth_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `client_id`, `year`, `month`, `exp_setup_id`, `amount`, `date`, `auth_id`, `created_at`, `updated_at`) VALUES
(1, 1002, 2024, '9', '2', 500.00, '2024-09', '1002', '2024-09-21 04:13:58', '2024-09-21 04:13:58'),
(2, 1002, 2024, '9', '1', 15000.00, '2024-09', '1002', '2024-09-21 04:27:55', '2024-09-21 04:27:55'),
(3, 1002, 2024, '9', '2', 50.00, '2024-09', '1002', '2024-09-22 05:15:39', '2024-09-22 05:15:39'),
(4, 1004, 2024, '9', '3', 12345.00, '2024-09', '1004', '2024-09-22 07:31:10', '2024-09-22 07:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `expense_vouchers`
--

CREATE TABLE `expense_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_id` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` varchar(255) NOT NULL,
  `exp_setup_id` int(11) DEFAULT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_vouchers`
--

INSERT INTO `expense_vouchers` (`id`, `voucher_id`, `month`, `year`, `date`, `client_id`, `auth_id`, `exp_setup_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, '000001', '9', 2024, '09/21/24', 1002, '1002', 2, 500.00, '2024-09-21 04:14:06', '2024-09-21 04:14:06'),
(2, '000002', '9', 2024, '09/21/24', 1002, '1002', 2, 500.00, '2024-09-21 04:25:04', '2024-09-21 04:25:04'),
(3, '000003', '9', 2024, '09/22/24', 1002, '1002', 2, 50.00, '2024-09-22 05:41:33', '2024-09-22 05:41:33'),
(4, '000001', '9', 2024, '09/22/24', 1004, '1004', 3, 12345.00, '2024-09-22 07:31:14', '2024-09-22 07:31:14'),
(5, '000002', '9', 2024, '09/22/24', 1004, '1004', 3, 12345.00, '2024-09-22 07:31:30', '2024-09-22 07:31:30'),
(6, '000003', '9', 2024, '09/22/24', 1004, '1004', 3, 12345.00, '2024-09-22 07:31:32', '2024-09-22 07:31:32'),
(7, '000004', '9', 2024, '09/22/24', 1004, '1004', 3, 12345.00, '2024-09-22 07:31:39', '2024-09-22 07:31:39'),
(8, '000005', '9', 2024, '09/22/24', 1004, '1004', 3, 12345.00, '2024-09-22 07:31:41', '2024-09-22 07:31:41'),
(9, '000006', '9', 2024, '09/22/24', 1004, '1004', 3, 12345.00, '2024-09-22 07:31:45', '2024-09-22 07:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `exp_setups`
--

CREATE TABLE `exp_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `exp_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exp_setups`
--

INSERT INTO `exp_setups` (`id`, `client_id`, `cat_id`, `created_by`, `exp_name`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1002, 1, '1002', 'Electricity bill', '2024-09', '1', '2024-09-21 04:13:39', '2024-09-21 04:13:39'),
(2, 1002, 1, '1002', 'LIght Purchase', '2024-09', '1', '2024-09-21 04:13:49', '2024-09-21 04:13:49'),
(3, 1004, 4, '1004', '541652542', '2024-09', '1', '2024-09-22 07:30:14', '2024-09-22 07:31:00');

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
-- Table structure for table `flats`
--

CREATE TABLE `flats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `flat_name` varchar(255) NOT NULL,
  `flat_location` tinyint(4) DEFAULT NULL,
  `flat_rent` double(20,2) NOT NULL DEFAULT 0.00,
  `service_charge` double(20,2) NOT NULL DEFAULT 0.00,
  `utility_bill` double(20,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `booking_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flats`
--

INSERT INTO `flats` (`id`, `client_id`, `auth_id`, `building_id`, `flat_name`, `flat_location`, `flat_rent`, `service_charge`, `utility_bill`, `date`, `status`, `booking_status`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 1, 'A-1', 1, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 1, '2024-09-20 23:54:31', '2024-09-21 00:27:09'),
(2, 1002, 1002, 1, 'A-2', 1, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 1, '2024-09-20 23:54:58', '2024-09-21 00:27:09'),
(3, 1002, 1002, 1, 'A-3', 1, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 1, '2024-09-20 23:55:23', '2024-09-21 00:27:09'),
(4, 1002, 1002, 1, 'A-4', 1, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 0, '2024-09-20 23:55:59', '2024-09-20 23:55:59'),
(5, 1002, 1002, 1, 'A-5', 2, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 0, '2024-09-20 23:56:50', '2024-09-20 23:56:50'),
(6, 1002, 1002, 1, 'A-6', 2, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 0, '2024-09-20 23:57:10', '2024-09-20 23:57:10'),
(7, 1002, 1002, 1, 'A-7', 2, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 0, '2024-09-20 23:57:39', '2024-09-20 23:57:39'),
(8, 1002, 1002, 1, 'A-8', 2, 20000.00, 3500.00, 2000.00, '21-09-2024', 1, 0, '2024-09-20 23:59:37', '2024-09-20 23:59:37'),
(9, 1002, 1002, 2, 'A-1', 1, 25000.00, 3000.00, 2000.00, '21-09-2024', 1, 1, '2024-09-21 00:00:10', '2024-09-21 01:32:14'),
(10, 1002, 1002, 2, 'A-2', 1, 20000.00, 3000.00, 2000.00, '21-09-2024', 1, 0, '2024-09-21 00:00:33', '2024-09-21 00:17:08'),
(11, 1002, 1002, 2, 'A-3', 2, 20000.00, 3000.00, 2000.00, '21-09-2024', 1, 0, '2024-09-21 00:00:55', '2024-09-21 00:00:55'),
(12, 1002, 1002, 2, 'A-4', 2, 20000.00, 3000.00, 2000.00, '21-09-2024', 1, 0, '2024-09-21 00:14:30', '2024-09-21 00:14:30'),
(13, 1002, 1002, 3, 'A-1', 1, 18000.00, 3000.00, 1000.00, '21-09-2024', 1, 0, '2024-09-21 00:15:10', '2024-09-21 00:15:10'),
(14, 1002, 1002, 3, 'A-2', 1, 18000.00, 3000.00, 1000.00, '21-09-2024', 1, 0, '2024-09-21 00:15:36', '2024-09-21 00:15:36'),
(15, 1002, 1002, 3, 'A-3', 2, 18000.00, 3000.00, 1000.00, '21-09-2024', 1, 0, '2024-09-21 00:16:07', '2024-09-21 00:16:07'),
(16, 1002, 1002, 3, 'A-4', 2, 18000.00, 3000.00, 1000.00, '21-09-2024', 1, 0, '2024-09-21 00:16:27', '2024-09-21 00:16:27'),
(17, 1004, 1004, 8, 'A-1', 1, 22000.00, 3500.00, 2200.00, '22-09-2024', 1, 1, '2024-09-22 07:14:32', '2024-09-22 07:18:25'),
(18, 1004, 1004, 8, 'A-2', 1, 22000.00, 3500.00, 2200.00, '22-09-2024', 1, 1, '2024-09-22 07:15:04', '2024-09-22 07:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `flat_ledgers`
--

CREATE TABLE `flat_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `flat_id` int(11) NOT NULL,
  `rent` double(20,2) NOT NULL DEFAULT 0.00,
  `service_charge` double(20,2) NOT NULL DEFAULT 0.00,
  `utility_bill` double(20,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flat_ledgers`
--

INSERT INTO `flat_ledgers` (`id`, `client_id`, `auth_id`, `agreement_id`, `tenant_id`, `flat_id`, `rent`, `service_charge`, `utility_bill`, `date`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 1, 8, 1, 20000.00, 3500.00, 2000.00, '09-2024', '2024-09-21 00:27:09', '2024-09-21 00:27:09'),
(2, 1002, 1002, 1, 8, 2, 20000.00, 3500.00, 2000.00, '09-2024', '2024-09-21 00:27:09', '2024-09-21 00:27:09'),
(3, 1002, 1002, 1, 8, 3, 20000.00, 3500.00, 2000.00, '09-2024', '2024-09-21 00:27:09', '2024-09-21 00:27:09'),
(4, 1002, 1002, 2, 7, 9, 25000.00, 3000.00, 2000.00, '09-2024', '2024-09-21 01:32:14', '2024-09-21 01:32:14'),
(5, 1004, 1004, 3, 12, 17, 22000.00, 3500.00, 2200.00, '09-2024', '2024-09-22 07:18:25', '2024-09-22 07:18:25'),
(6, 1004, 1004, 3, 12, 18, 22000.00, 3500.00, 2200.00, '09-2024', '2024-09-22 07:18:25', '2024-09-22 07:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_histories`
--

CREATE TABLE `guest_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `flat_id` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `entry_date` varchar(255) DEFAULT NULL,
  `exit_date` varchar(255) DEFAULT NULL,
  `create_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `month` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `auth_id` varchar(255) DEFAULT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `flat_id` varchar(255) DEFAULT NULL,
  `flat_name` varchar(255) DEFAULT NULL,
  `charge` varchar(255) DEFAULT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `due` double(20,2) NOT NULL DEFAULT 0.00,
  `paid` double(20,2) NOT NULL DEFAULT 0.00,
  `status` bigint(20) NOT NULL DEFAULT 0,
  `date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_16_103824_create_categories_table', 1),
(7, '2024_01_31_045253_create_incomes_table', 1),
(9, '2024_02_12_051323_create_opening_balances_table', 1),
(10, '2024_02_19_075928_create_others_incomes_table', 1),
(11, '2024_02_21_065637_create_expense_vouchers_table', 1),
(13, '2024_04_24_110323_create_setup_histories_table', 1),
(14, '2024_06_05_065945_create_clients_table', 1),
(16, '2024_06_05_073045_create_vendors_table', 1),
(17, '2024_06_05_073931_create_balances_table', 1),
(18, '2024_06_05_074103_create_packages_table', 1),
(19, '2024_06_05_074749_create_payments_table', 1),
(20, '2024_06_09_114451_create_guests_table', 1),
(21, '2024_06_09_115446_create_guest_histories_table', 1),
(23, '2024_06_05_072205_create_flats_table', 2),
(25, '2024_06_30_100214_create_tenants_table', 3),
(29, '2024_06_30_062134_create_buildings_table', 4),
(31, '2024_07_02_104036_create_rental_agreement_details_table', 5),
(32, '2024_07_02_104923_create_advanced_amounts_table', 5),
(33, '2024_07_02_080832_create_rental_agreements_table', 6),
(35, '2024_07_04_071017_create_flat_ledgers_table', 8),
(43, '2024_07_04_061003_create_bill_setups_table', 9),
(44, '2024_07_06_112514_create_collections_table', 9),
(45, '2024_07_07_054101_create_collection_masters_table', 9),
(47, '2024_07_10_113443_create_documents_table', 10),
(51, '2024_04_16_055510_create_exp_setups_table', 11),
(53, '2024_01_16_110642_create_expenses_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `opening_balances`
--

CREATE TABLE `opening_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `month` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` varchar(255) NOT NULL,
  `entry_datetime` varchar(255) NOT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `flag` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `others_incomes`
--

CREATE TABLE `others_incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `auth_id` varchar(255) DEFAULT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `income_info` varchar(255) DEFAULT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `duration` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `amount`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'Package 1', 3000.00, '150', '2024-07-03 07:00:23', '2024-07-03 07:00:23'),
(2, 'Package 2', 6500.00, '365', '2024-07-03 07:00:33', '2024-07-03 07:00:33');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_id` varchar(255) NOT NULL,
  `payment_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `paid` double(20,2) NOT NULL DEFAULT 0.00,
  `due` double(20,2) NOT NULL DEFAULT 0.00,
  `date` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `valid` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `client_id`, `invoice_id`, `payment_amount`, `paid`, `due`, `date`, `month`, `year`, `valid`, `created_at`, `updated_at`) VALUES
(1, 1002, 'INV-000001', 3000.00, 3000.00, 0.00, '2024-09-22', '09', 2024, 0, '2024-09-22 06:14:31', '2024-09-22 06:14:31'),
(2, 1003, 'INV-000002', 3000.00, 2000.00, -2000.00, '2024-09-22', '09', 2024, 0, '2024-09-22 06:16:21', '2024-09-22 06:16:21'),
(3, 1003, 'INV-000003', 3000.00, 500.00, -2500.00, '2024-09-22', '09', 2024, 0, '2024-09-22 06:27:03', '2024-09-22 06:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_agreements`
--

CREATE TABLE `rental_agreements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `advanced` double(20,2) NOT NULL DEFAULT 0.00,
  `created_date` varchar(255) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `notice_period` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rental_agreements`
--

INSERT INTO `rental_agreements` (`id`, `client_id`, `auth_id`, `tenant_id`, `building_id`, `advanced`, `created_date`, `from_date`, `to_date`, `duration`, `notice_period`, `status`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 8, 1, 25000.00, '21-Sep-2024', '2024-10', '2025-12', '14', '2', 1, '2024-09-21 00:27:08', '2024-09-21 00:27:08'),
(2, 1002, 1002, 7, 2, 30000.00, '21-Sep-2024', '2024-11', '2025-11', '12', '2', 1, '2024-09-21 01:32:14', '2024-09-21 01:32:14'),
(3, 1004, 1004, 12, 8, 50000.00, '22-Sep-2024', '2024-10', '2025-10', '12', '2', 1, '2024-09-22 07:18:25', '2024-09-22 07:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `rental_agreement_details`
--

CREATE TABLE `rental_agreement_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rental_agreement_id` int(11) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rental_agreement_details`
--

INSERT INTO `rental_agreement_details` (`id`, `rental_agreement_id`, `tenant_id`, `flat_id`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 1, '2024-09-21 00:27:08', '2024-09-21 00:27:08'),
(2, 1, 8, 2, '2024-09-21 00:27:08', '2024-09-21 00:27:08'),
(3, 1, 8, 3, '2024-09-21 00:27:08', '2024-09-21 00:27:08'),
(4, 2, 7, 9, '2024-09-21 01:32:14', '2024-09-21 01:32:14'),
(5, 3, 12, 17, '2024-09-22 07:18:25', '2024-09-22 07:18:25'),
(6, 3, 12, 18, '2024-09-22 07:18:25', '2024-09-22 07:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `setup_histories`
--

CREATE TABLE `setup_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` varchar(255) NOT NULL,
  `exp_id` int(11) NOT NULL,
  `vendor_id` tinyint(4) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `interval_days` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nid_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `balance` double(20,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `client_id`, `auth_id`, `name`, `phone`, `nid_no`, `address`, `email`, `balance`, `status`, `created_date`, `created_at`, `updated_at`) VALUES
(1, 1002, 1002, 'Noman', '55555', '6464654', 'Noakhali', 'noman@gmail.com', 50000.00, 1, '02-Jul-2024', NULL, '2024-09-19 04:28:26'),
(2, 1002, 1002, 'Rahim', '11111', '6464654', 'Madubpur,Gohailbari,Boalmari,Faridpur', 'rahim@gmail.com', 50000.00, 1, '06-Jul-2024', NULL, '2024-07-08 02:18:21'),
(3, 1002, 1002, 'Kamal', '55555', '6546545', 'Khulna', 'Kamal@gmail.com', 20000.00, 1, '07-Jul-2024', NULL, '2024-07-07 01:51:30'),
(4, 1002, 1002, 'Jamal', '55555', '6546545', 'Mirpur', 'jamal@gmail.com', 30000.00, 1, '07-Jul-2024', NULL, '2024-07-07 08:35:04'),
(5, 1002, 1002, 'Salam', '55555', '6464654', 'Magura', 'salam@gmail.com', 0.00, 1, '08-Jul-2024', NULL, '2024-07-08 01:43:26'),
(6, 1002, 1002, 'Hussain', '1234', '87015165', 'Madubpur', 'hussain@gmail.com', 20000.00, 1, '08-Jul-2024', NULL, '2024-07-08 02:21:07'),
(7, 1002, 1002, 'Ismail', '1234', '3156541654', 'Beljani, Boalmari.', 'ismail@gmail.com', 30000.00, 1, '08-Jul-2024', NULL, '2024-07-11 07:49:51'),
(8, 1002, 1002, 'Eiasin', '694664', '6546545', 'Madubpur', 'eiasin@gmail.com', 25000.00, 1, '08-Jul-2024', NULL, '2024-09-21 00:27:09'),
(9, 1003, 1003, 'Jakir', '55555', '6464654', 'Dhaka', 'jakir@gmail.com', 50000.00, 1, '09-Jul-2024', NULL, '2024-07-09 01:13:29'),
(10, 1003, 1003, 'Sabbir', '55555', '6546545', 'Boalmari', 'sabbir@gmail.com', 30000.00, 1, '09-Jul-2024', NULL, '2024-07-09 01:16:40'),
(12, 1004, 1004, 'Rahim', '01024', '786978', 'Khulna', 'rahim@gmail.com', 50000.00, 1, '22-Sep-2024', NULL, '2024-09-22 07:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `flat_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nid_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `charge` varchar(255) DEFAULT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `role_id` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `auth_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advanced_amounts`
--
ALTER TABLE `advanced_amounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_setups`
--
ALTER TABLE `bill_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_masters`
--
ALTER TABLE `collection_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_vouchers`
--
ALTER TABLE `expense_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exp_setups`
--
ALTER TABLE `exp_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flats`
--
ALTER TABLE `flats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flat_ledgers`
--
ALTER TABLE `flat_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_histories`
--
ALTER TABLE `guest_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opening_balances`
--
ALTER TABLE `opening_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `others_incomes`
--
ALTER TABLE `others_incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rental_agreements`
--
ALTER TABLE `rental_agreements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_agreement_details`
--
ALTER TABLE `rental_agreement_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_histories`
--
ALTER TABLE `setup_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advanced_amounts`
--
ALTER TABLE `advanced_amounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_setups`
--
ALTER TABLE `bill_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `collection_masters`
--
ALTER TABLE `collection_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_vouchers`
--
ALTER TABLE `expense_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exp_setups`
--
ALTER TABLE `exp_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flats`
--
ALTER TABLE `flats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `flat_ledgers`
--
ALTER TABLE `flat_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_histories`
--
ALTER TABLE `guest_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `opening_balances`
--
ALTER TABLE `opening_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `others_incomes`
--
ALTER TABLE `others_incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_agreements`
--
ALTER TABLE `rental_agreements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rental_agreement_details`
--
ALTER TABLE `rental_agreement_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setup_histories`
--
ALTER TABLE `setup_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
