-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 02:02 AM
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
-- Database: `stockmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `description`, `properties`, `created_at`, `updated_at`) VALUES
(1, 2, 'CREATED', 'Dispatch', 1, 'Created dispatch draft #DISP-69FBF5C73DA14 for Queen Denis', NULL, '2026-05-07 01:15:35', '2026-05-07 01:15:35'),
(2, 1, 'STATUS_CHANGE', 'Dispatch', 1, 'Changed dispatch #DISP-69FBF5C73DA14 status to CANCELLED', NULL, '2026-05-07 01:30:02', '2026-05-07 01:30:02'),
(3, 2, 'CREATED', 'Order', 2, 'Created purchase order #PO-QDN6KRL0', NULL, '2026-05-07 05:36:07', '2026-05-07 05:36:07'),
(4, 2, 'STATUS_CHANGE', 'Order', 2, 'Completed purchase order #PO-QDN6KRL0 and updated stock', NULL, '2026-05-07 05:37:43', '2026-05-07 05:37:43'),
(5, 2, 'CREATED', 'Order', 3, 'Created purchase order #PO-OL7O3MDK', NULL, '2026-05-07 05:38:22', '2026-05-07 05:38:22'),
(6, 2, 'STATUS_CHANGE', 'Order', 3, 'Completed purchase order #PO-OL7O3MDK and updated stock', NULL, '2026-05-07 05:38:29', '2026-05-07 05:38:29'),
(7, 2, 'CREATED', 'Dispatch', 2, 'Created dispatch draft #DISP-69FC33B600233 for Queen Denis', NULL, '2026-05-07 05:39:50', '2026-05-07 05:39:50'),
(8, 2, 'STATUS_CHANGE', 'Dispatch', 2, 'Changed dispatch #DISP-69FC33B600233 status to SHIPPED', NULL, '2026-05-07 05:40:08', '2026-05-07 05:40:08'),
(9, 2, 'CREATED', 'Dispatch', 3, 'Created dispatch draft #DISP-69FC341324808 for Queen Denis', NULL, '2026-05-07 05:41:23', '2026-05-07 05:41:23'),
(10, 2, 'STATUS_CHANGE', 'Dispatch', 3, 'Changed dispatch #DISP-69FC341324808 status to SHIPPED', NULL, '2026-05-07 05:41:29', '2026-05-07 05:41:29'),
(11, 1, 'CREATED', 'Order', 4, 'Created purchase order #PO-E6AATA2T', NULL, '2026-05-07 10:18:34', '2026-05-07 10:18:34'),
(12, 1, 'STATUS_CHANGE', 'Order', 4, 'Completed purchase order #PO-E6AATA2T and updated stock', NULL, '2026-05-07 10:18:40', '2026-05-07 10:18:40');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@gmail.com|127.0.0.1', 'i:1;', 1777554516),
('laravel-cache-admin@gmail.com|127.0.0.1:timer', 'i:1777554516;', 1777554516);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Electronics', 'Electronic items', '2026-04-30 11:47:53', '2026-04-30 11:47:53', NULL),
(2, 'Furniture', 'Office furniture', '2026-04-30 11:47:53', '2026-04-30 11:47:53', NULL),
(3, 'beverages', 'odoksdksdo', '2026-05-04 05:58:58', '2026-05-04 06:15:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `contact_person`, `email`, `phone`, `address`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Queen Denis', 'Queen Denis', 'queendenis372@gmail.com', '655555578', 'jkjlkjh', NULL, '2026-05-07 01:15:04', '2026-05-07 01:15:04');

-- --------------------------------------------------------

--
-- Table structure for table `dispatches`
--

CREATE TABLE `dispatches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dispatch_number` varchar(255) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `status` enum('draft','pending','shipped','cancelled') NOT NULL DEFAULT 'draft',
  `dispatch_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dispatches`
--

INSERT INTO `dispatches` (`id`, `dispatch_number`, `client_id`, `created_by`, `status`, `dispatch_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'DISP-69FBF5C73DA14', 1, 2, 'cancelled', '2026-05-06 23:00:00', NULL, '2026-05-07 01:15:35', '2026-05-07 01:30:02'),
(2, 'DISP-69FC33B600233', 1, 2, 'shipped', '2026-05-06 23:00:00', NULL, '2026-05-07 05:39:50', '2026-05-07 05:40:08'),
(3, 'DISP-69FC341324808', 1, 2, 'shipped', '2026-05-06 23:00:00', NULL, '2026-05-07 05:41:23', '2026-05-07 05:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_items`
--

CREATE TABLE `dispatch_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dispatch_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dispatch_items`
--

INSERT INTO `dispatch_items` (`id`, `dispatch_id`, `item_id`, `quantity`, `unit_price`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 44, 150.00, '2026-05-07 01:15:35', '2026-05-07 01:15:35'),
(2, 2, 5, 100, 20000.00, '2026-05-07 05:39:50', '2026-05-07 05:39:50'),
(3, 3, 1, 20, 1200.00, '2026-05-07 05:41:23', '2026-05-07 05:41:23'),
(4, 3, 2, 50, 150.00, '2026-05-07 05:41:23', '2026-05-07 05:41:23'),
(5, 3, 5, 25, 20000.00, '2026-05-07 05:41:23', '2026-05-07 05:41:23');

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
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_change` int(11) NOT NULL,
  `type` enum('IN','OUT','ADJUSTMENT') NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_transactions`
--

INSERT INTO `inventory_transactions` (`id`, `item_id`, `user_id`, `quantity_change`, `type`, `reference`, `transaction_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, 'IN', 'Initial Stock', '2026-04-30 12:47:53', '2026-04-30 11:47:53', '2026-04-30 11:47:53'),
(2, 2, 1, 20, 'IN', 'Initial Stock', '2026-04-30 12:47:54', '2026-04-30 11:47:54', '2026-04-30 11:47:54'),
(3, 1, 1, 1, 'IN', 'Order PO-6UYBXHLO', '2026-05-04 07:46:10', '2026-05-04 06:46:10', '2026-05-04 06:46:10'),
(4, 2, 1, 2, 'IN', 'Order PO-6UYBXHLO', '2026-05-04 07:46:10', '2026-05-04 06:46:10', '2026-05-04 06:46:10'),
(5, 5, 1, 40, 'IN', 'Order PO-6UYBXHLO', '2026-05-04 07:46:10', '2026-05-04 06:46:10', '2026-05-04 06:46:10'),
(6, 2, 1, -44, 'OUT', 'DISP-69FBF5C73DA14', '2026-05-07 01:21:45', '2026-05-07 01:21:45', '2026-05-07 01:21:45'),
(7, 2, 2, 20, 'IN', 'PO-QDN6KRL0', '2026-05-07 05:37:42', '2026-05-07 05:37:42', '2026-05-07 05:37:42'),
(8, 2, 2, 20, 'IN', 'Order PO-QDN6KRL0', '2026-05-07 06:37:42', '2026-05-07 05:37:42', '2026-05-07 05:37:42'),
(9, 2, 2, 30, 'IN', 'PO-OL7O3MDK', '2026-05-07 05:38:29', '2026-05-07 05:38:29', '2026-05-07 05:38:29'),
(10, 2, 2, 30, 'IN', 'Order PO-OL7O3MDK', '2026-05-07 06:38:29', '2026-05-07 05:38:29', '2026-05-07 05:38:29'),
(11, 5, 2, -100, 'OUT', 'DISP-69FC33B600233', '2026-05-07 05:40:08', '2026-05-07 05:40:08', '2026-05-07 05:40:08'),
(12, 1, 2, -20, 'OUT', 'DISP-69FC341324808', '2026-05-07 05:41:29', '2026-05-07 05:41:29', '2026-05-07 05:41:29'),
(13, 2, 2, -50, 'OUT', 'DISP-69FC341324808', '2026-05-07 05:41:29', '2026-05-07 05:41:29', '2026-05-07 05:41:29'),
(14, 5, 2, -25, 'OUT', 'DISP-69FC341324808', '2026-05-07 05:41:29', '2026-05-07 05:41:29', '2026-05-07 05:41:29'),
(15, 1, 1, 20, 'IN', NULL, '2026-05-07 10:16:00', '2026-05-07 10:16:37', '2026-05-07 10:16:37'),
(16, 1, 1, -20, 'OUT', NULL, '2026-05-07 10:17:00', '2026-05-07 10:17:51', '2026-05-07 10:17:51'),
(17, 1, 1, 20, 'IN', 'PO-E6AATA2T', '2026-05-07 10:18:40', '2026-05-07 10:18:40', '2026-05-07 10:18:40'),
(18, 2, 1, 20, 'IN', 'PO-E6AATA2T', '2026-05-07 10:18:40', '2026-05-07 10:18:40', '2026-05-07 10:18:40'),
(19, 5, 1, 20, 'IN', 'PO-E6AATA2T', '2026-05-07 10:18:40', '2026-05-07 10:18:40', '2026-05-07 10:18:40'),
(20, 1, 1, 20, 'IN', 'Order PO-E6AATA2T', '2026-05-07 11:18:40', '2026-05-07 10:18:40', '2026-05-07 10:18:40'),
(21, 2, 1, 20, 'IN', 'Order PO-E6AATA2T', '2026-05-07 11:18:40', '2026-05-07 10:18:40', '2026-05-07 10:18:40'),
(22, 5, 1, 20, 'IN', 'Order PO-E6AATA2T', '2026-05-07 11:18:40', '2026-05-07 10:18:40', '2026-05-07 10:18:40');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) NOT NULL DEFAULT 10,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `sku`, `description`, `image`, `price`, `quantity`, `reorder_level`, `category_id`, `last_updated`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Laptop', NULL, 'Development laptop', 'items/Zr5vgl6aHH2IHWaNAobiIBxbitM72ndqkbfy3P8o.png', 1200.00, 42, 10, 1, '2026-05-07 11:18:40', '2026-04-30 11:47:53', '2026-05-07 10:18:40', NULL),
(2, 'Desk Chair', NULL, 'Ergonomic chair', 'items/34IPECLc6dtIYIBgABqq51MW3o7i24SWjTlLziBZ.jpg', 150.00, 46, 10, 2, '2026-05-07 11:18:40', '2026-04-30 11:47:53', '2026-05-07 10:18:40', NULL),
(5, 'ssdsdsd', 'dsdsd200', 'sdsd', 'items/2YJPIELUKko4beW4jDL4PImS7KJvzqqeDGq3OlZN.jpg', 20000.00, 45, 10, 3, '2026-05-07 11:18:40', '2026-05-04 06:41:07', '2026-05-07 10:18:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
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
(4, '2026_04_30_123931_create_categories_table', 1),
(5, '2026_04_30_123931_create_items_table', 1),
(6, '2026_04_30_123932_create_inventory_transactions_table', 1),
(7, '2026_04_30_123932_create_orders_table', 1),
(8, '2026_04_30_123933_create_order_items_table', 1),
(9, '2026_04_30_123933_create_reports_table', 1),
(10, '2026_05_03_005929_add_image_to_items_table', 2),
(11, '2026_05_03_005934_add_image_to_items_table', 2),
(12, '2026_05_04_074002_add_sku_and_reorder_level_to_items_table', 3),
(14, '2026_05_07_013619_create_suppliers_table', 4),
(15, '2026_05_07_013653_add_supplier_id_to_orders_table', 5),
(16, '2026_05_07_020059_add_soft_deletes_to_core_tables', 6),
(17, '2026_05_07_020354_create_clients_table', 7),
(18, '2026_05_07_020424_create_dispatches_table', 7),
(19, '2026_05_07_020425_create_dispatch_items_table', 7),
(20, '2026_05_07_021255_create_activity_logs_table', 8),
(21, '2026_05_07_022405_create_notifications_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('004a09d2-1b96-41dc-8d54-48a1e7cbaf5f', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 2, '{\"item_id\":2,\"item_name\":\"Desk Chair\",\"quantity\":-4,\"message\":\"Low stock alert for Desk Chair. Only -4 remaining.\"}', '2026-05-07 05:40:41', '2026-05-07 05:37:43', '2026-05-07 05:40:41'),
('24b31e24-3c12-4bcf-bc24-3c9010e18528', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 1, '{\"item_id\":2,\"item_name\":\"Desk Chair\",\"quantity\":6,\"message\":\"Low stock alert for Desk Chair. Only 6 remaining.\"}', '2026-05-07 10:15:37', '2026-05-07 05:41:29', '2026-05-07 10:15:37'),
('2d9646e0-6fed-49ea-9b32-0e43931a96d8', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 1, '{\"item_id\":2,\"item_name\":\"Desk Chair\",\"quantity\":-4,\"message\":\"Low stock alert for Desk Chair. Only -4 remaining.\"}', '2026-05-07 10:15:37', '2026-05-07 05:37:42', '2026-05-07 10:15:37'),
('45d1279a-2cd4-4980-8aec-97ca7f4bdd5a', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 2, '{\"item_id\":2,\"item_name\":\"Desk Chair\",\"quantity\":-24,\"message\":\"Low stock alert for Desk Chair. Only -24 remaining.\"}', '2026-05-07 05:40:41', '2026-05-07 05:37:42', '2026-05-07 05:40:41'),
('4615a919-73d3-4f30-848b-a6d4f5616dcb', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 2, '{\"item_id\":5,\"item_name\":\"ssdsdsd\",\"quantity\":5,\"message\":\"Low stock alert for ssdsdsd. Only 5 remaining.\"}', NULL, '2026-05-07 05:41:29', '2026-05-07 05:41:29'),
('7febe8bc-39c3-4268-9148-78e797653a77', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 2, '{\"item_id\":2,\"item_name\":\"Desk Chair\",\"quantity\":6,\"message\":\"Low stock alert for Desk Chair. Only 6 remaining.\"}', NULL, '2026-05-07 05:41:29', '2026-05-07 05:41:29'),
('aa67247f-2bfb-4241-b792-995e8eae0f5a', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 1, '{\"item_id\":1,\"item_name\":\"Laptop\",\"quantity\":2,\"message\":\"Low stock alert for Laptop. Only 2 remaining.\"}', '2026-05-07 10:15:37', '2026-05-07 05:41:29', '2026-05-07 10:15:37'),
('bdcc5f4e-e865-4aae-ac15-2206840b3ef0', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 1, '{\"item_id\":2,\"item_name\":\"Desk Chair\",\"quantity\":-24,\"message\":\"Low stock alert for Desk Chair. Only -24 remaining.\"}', '2026-05-07 10:15:37', '2026-05-07 05:37:42', '2026-05-07 10:15:37'),
('e38b5fa5-014f-4228-88cb-9ffb9525992c', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 1, '{\"item_id\":5,\"item_name\":\"ssdsdsd\",\"quantity\":5,\"message\":\"Low stock alert for ssdsdsd. Only 5 remaining.\"}', '2026-05-07 10:15:37', '2026-05-07 05:41:29', '2026-05-07 10:15:37'),
('f49983de-c09e-41aa-b683-a1497c49e6a9', 'App\\Notifications\\RestockAlert', 'App\\Models\\User', 2, '{\"item_id\":1,\"item_name\":\"Laptop\",\"quantity\":2,\"message\":\"Low stock alert for Laptop. Only 2 remaining.\"}', NULL, '2026-05-07 05:41:29', '2026-05-07 05:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `status` enum('draft','pending','completed','cancelled') NOT NULL DEFAULT 'draft',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `expected_delivery` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `supplier_id`, `created_by`, `status`, `order_date`, `expected_delivery`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'PO-6UYBXHLO', NULL, 1, 'completed', '2026-05-04 06:44:52', NULL, 'jjjj', '2026-05-04 06:44:52', '2026-05-04 06:46:10'),
(2, 'PO-QDN6KRL0', 1, 2, 'completed', '2026-05-07 05:36:07', NULL, NULL, '2026-05-07 05:36:07', '2026-05-07 05:37:42'),
(3, 'PO-OL7O3MDK', 1, 2, 'completed', '2026-05-07 05:38:22', NULL, NULL, '2026-05-07 05:38:22', '2026-05-07 05:38:29'),
(4, 'PO-E6AATA2T', 1, 1, 'completed', '2026-05-07 10:18:34', NULL, NULL, '2026-05-07 10:18:34', '2026-05-07 10:18:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_ordered` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity_received` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity_ordered`, `unit_price`, `quantity_received`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1200.00, 0, '2026-05-04 06:44:52', '2026-05-04 06:44:52'),
(2, 1, 2, 2, 150.00, 0, '2026-05-04 06:44:52', '2026-05-04 06:44:52'),
(3, 1, 5, 40, 20000.00, 0, '2026-05-04 06:44:52', '2026-05-04 06:44:52'),
(4, 2, 2, 20, 150.00, 0, '2026-05-07 05:36:07', '2026-05-07 05:36:07'),
(5, 3, 2, 30, 150.00, 0, '2026-05-07 05:38:22', '2026-05-07 05:38:22'),
(6, 4, 1, 20, 1200.00, 0, '2026-05-07 10:18:34', '2026-05-07 10:18:34'),
(7, 4, 2, 20, 150.00, 0, '2026-05-07 10:18:34', '2026-05-07 10:18:34'),
(8, 4, 5, 20, 20000.00, 0, '2026-05-07 10:18:34', '2026-05-07 10:18:34');

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
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `generated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameters`)),
  `file_path` varchar(255) DEFAULT NULL,
  `generated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `type`, `generated_date`, `parameters`, `file_path`, `generated_by`, `created_at`, `updated_at`) VALUES
(1, 'transaction_logs', '2026-05-01 04:02:24', '{\"type\":\"transaction_logs\",\"start_date\":\"2026-05-01\",\"end_date\":\"2026-05-01\",\"format\":\"pdf\"}', 'reports/temp_1777611744.pdf', 1, '2026-05-01 04:02:24', '2026-05-01 04:02:24'),
(2, 'stock_summary', '2026-05-03 00:02:47', '{\"type\":\"stock_summary\",\"start_date\":\"2026-05-01\",\"end_date\":\"2026-05-03\",\"format\":\"pdf\"}', 'reports/temp_1777770167.pdf', 1, '2026-05-03 00:02:47', '2026-05-03 00:02:47');

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
('8Hz3ACssRwG8vO4FGnBn9E4WI9Whr4zSvMgkgnLG', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI4SHVQaW1yT3JsbWViTFR6c3JhM1ZDVXhBekNuTUV0Nmt0V1NCMHQ5IiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjMsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvZGFzaGJvYXJkIiwicm91dGUiOiJkYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1778148800),
('GkYNKmTHkphLzXwTw6XAZpweOt8eFjXrV0IEPLMn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJOaWJMZUNleXlWSlJTY05ncFhRR3FhM3hIQWUxVW1Ka3YwTGd4d1NmIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC90cmFuc2FjdGlvbnMiLCJyb3V0ZSI6InRyYW5zYWN0aW9ucy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1778152738),
('u7ocDOqXb850jQGZFhDGArGUQPt15ojemoFTMuqo', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJLM2x5eldCS052ckpoRzl1ODZZMDFGbGNkQkpicGVwOG9udDFTcFZ0IiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjIsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvY2F0ZWdvcmllcyIsInJvdXRlIjoiY2F0ZWdvcmllcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1778148810);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `email`, `phone`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Florence', 'florence', 'florence@gmail.com', '6584588', 'kolbison', '2026-05-07 05:35:54', '2026-05-07 05:35:54', NULL);

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
  `role` enum('admin','stock_manager','warehouse_staff') NOT NULL DEFAULT 'warehouse_staff',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2026-04-30 11:47:53', '$2y$12$Y/Ip1CB4mIvZeONdkHNB3eTJgJ5iSlWS3ZfURaHAYRsOQrwkAbKpS', 'admin', 1, 'Ig9TUpRX3ja2Sx6XUB4Xi3abf1CDyMSrpvpcfB4d8u4RSFvPzKa8aZytJhuF', '2026-04-30 11:47:53', '2026-04-30 11:47:53', NULL),
(2, 'Manager User', 'manager@example.com', '2026-04-30 11:47:53', '$2y$12$kgRuMOAuoeanSh85mnqh1eQS1WkrvWQnj87OHOcwh6vpC7XKAww8i', 'stock_manager', 1, 'SX93cOt452CZ8f1TcpVTg8jZznrZ2Q1geHLVGqQ72Aemj7xcyNthrjKA4dox', '2026-04-30 11:47:53', '2026-04-30 11:47:53', NULL),
(3, 'Staff User', 'staff@example.com', '2026-04-30 11:47:53', '$2y$12$KR8nsaY4hsV2iy2D2Tbe8OuXxkqXQkfyTdfPAmQ0nFCmwV3UYi/ea', 'warehouse_staff', 1, '5A06lnaiDz', '2026-04-30 11:47:53', '2026-04-30 11:47:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispatches`
--
ALTER TABLE `dispatches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dispatches_dispatch_number_unique` (`dispatch_number`),
  ADD KEY `dispatches_client_id_foreign` (`client_id`),
  ADD KEY `dispatches_created_by_foreign` (`created_by`);

--
-- Indexes for table `dispatch_items`
--
ALTER TABLE `dispatch_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dispatch_items_dispatch_id_foreign` (`dispatch_id`),
  ADD KEY `dispatch_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_transactions_item_id_foreign` (`item_id`),
  ADD KEY `inventory_transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_category_id_foreign` (`category_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_created_by_foreign` (`created_by`),
  ADD KEY `orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_generated_by_foreign` (`generated_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dispatches`
--
ALTER TABLE `dispatches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dispatch_items`
--
ALTER TABLE `dispatch_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dispatches`
--
ALTER TABLE `dispatches`
  ADD CONSTRAINT `dispatches_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dispatches_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dispatch_items`
--
ALTER TABLE `dispatch_items`
  ADD CONSTRAINT `dispatch_items_dispatch_id_foreign` FOREIGN KEY (`dispatch_id`) REFERENCES `dispatches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dispatch_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD CONSTRAINT `inventory_transactions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_generated_by_foreign` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
