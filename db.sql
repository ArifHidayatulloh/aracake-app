-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for store_app
CREATE DATABASE IF NOT EXISTS `store_app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `store_app`;

-- Dumping structure for table store_app.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.cache: ~0 rows (approximately)
DELETE FROM `cache`;

-- Dumping structure for table store_app.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table store_app.delivery_methods
CREATE TABLE IF NOT EXISTS `delivery_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `base_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost_per_km` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_pickup` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `delivery_methods_method_name_unique` (`method_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.delivery_methods: ~2 rows (approximately)
DELETE FROM `delivery_methods`;
INSERT INTO `delivery_methods` (`id`, `method_name`, `description`, `base_cost`, `cost_per_km`, `is_pickup`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Ambil di Toko', 'Ambil pesanan langsung di toko kami', 0.00, 0.00, 1, 1, '2025-07-27 05:23:33', '2025-07-27 05:23:33'),
	(2, 'Pengiriman Standar', 'Pengiriman estimasi 3-5 hari kerja', 15000.00, 0.00, 0, 1, '2025-07-27 05:26:40', '2025-07-27 05:26:40');

-- Dumping structure for table store_app.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `events_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.events: ~0 rows (approximately)
DELETE FROM `events`;

-- Dumping structure for table store_app.event_products
CREATE TABLE IF NOT EXISTS `event_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_products_event_id_foreign` (`event_id`),
  KEY `event_products_product_id_foreign` (`product_id`),
  CONSTRAINT `event_products_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.event_products: ~0 rows (approximately)
DELETE FROM `event_products`;

-- Dumping structure for table store_app.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table store_app.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table store_app.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table store_app.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_07_22_062536_create_user_addresses_table', 1),
	(5, '2025_07_22_062542_create_product_categories_table', 1),
	(6, '2025_07_22_062548_create_products_table', 1),
	(7, '2025_07_22_062551_create_product_images_table', 1),
	(8, '2025_07_22_062555_create_order_statuses_table', 1),
	(9, '2025_07_22_062600_create_delivery_methods_table', 1),
	(10, '2025_07_22_062607_create_orders_table', 1),
	(11, '2025_07_22_062611_create_order_items_table', 1),
	(12, '2025_07_22_062616_create_payment_methods_table', 1),
	(13, '2025_07_22_062620_create_payments_table', 1),
	(14, '2025_07_22_062624_create_pre_orders_table', 1),
	(15, '2025_07_22_062628_create_system_settings_table', 1),
	(16, '2025_07_22_062632_create_system_logs_table', 1),
	(17, '2025_07_22_062636_create_order_logs_table', 1),
	(18, '2025_07_27_065309_create_events_table', 1),
	(19, '2025_07_27_065317_create_event_products_table', 1),
	(20, '2025_07_29_080238_create_working_hours_table', 2);

-- Dumping structure for table store_app.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `order_status_id` bigint unsigned NOT NULL,
  `delivery_method_id` bigint unsigned NOT NULL,
  `pickup_delivery_address_id` bigint unsigned DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pickup_delivery_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_order_status_id_foreign` (`order_status_id`),
  KEY `orders_delivery_method_id_foreign` (`delivery_method_id`),
  KEY `orders_pickup_delivery_address_id_foreign` (`pickup_delivery_address_id`),
  CONSTRAINT `orders_delivery_method_id_foreign` FOREIGN KEY (`delivery_method_id`) REFERENCES `delivery_methods` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `orders_order_status_id_foreign` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `orders_pickup_delivery_address_id_foreign` FOREIGN KEY (`pickup_delivery_address_id`) REFERENCES `user_addresses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.orders: ~0 rows (approximately)
DELETE FROM `orders`;

-- Dumping structure for table store_app.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.order_items: ~0 rows (approximately)
DELETE FROM `order_items`;

-- Dumping structure for table store_app.order_logs
CREATE TABLE IF NOT EXISTS `order_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actor_user_id` bigint unsigned DEFAULT NULL,
  `event_type` enum('STATUS_CHANGE','COMMENT','PAYMENT_CONFIRMED','DELIVERY_ASSIGNED','ORDER_CREATED','ORDER_CANCELLED') COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_logs_order_id_foreign` (`order_id`),
  KEY `order_logs_actor_user_id_foreign` (`actor_user_id`),
  CONSTRAINT `order_logs_actor_user_id_foreign` FOREIGN KEY (`actor_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.order_logs: ~0 rows (approximately)
DELETE FROM `order_logs`;

-- Dumping structure for table store_app.order_statuses
CREATE TABLE IF NOT EXISTS `order_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status_color` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_statuses_status_name_unique` (`status_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.order_statuses: ~6 rows (approximately)
DELETE FROM `order_statuses`;
INSERT INTO `order_statuses` (`id`, `status_name`, `description`, `status_color`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Menunggu Pembayaran', 'Pesanan telah dibuat, menunggu pembayaran dari pelanggan.', '#FFD700', 1, '2025-07-28 01:09:16', '2025-07-28 01:09:16'),
	(2, 'Menunggu Konfirmasi Pembayaran', 'Pelanggan telah mengunggah bukti pembayaran, menunggu konfirmasi admin.', '#FFA500', 1, '2025-07-28 01:09:55', '2025-07-28 01:09:55'),
	(3, 'Diproses', 'Pembayaran telah dikonfirmasi, pesanan sedang diproses/disiapkan.', '#4169E1', 1, '2025-07-28 01:10:38', '2025-07-28 01:10:38'),
	(4, 'Siap Diambil/Dikirim', 'Pesanan sudah siap untuk diambil atau dikirim.', '#32CD32', 1, '2025-07-28 01:11:05', '2025-07-28 01:11:05'),
	(5, 'Selesai', 'Pesanan telah diambil/dikirim dan transaksi selesai.', '#228B22', 1, '2025-07-28 01:11:53', '2025-07-28 01:11:53'),
	(6, 'Dibatalkan', 'Pesanan telah dibatalkan.', '#808080', 1, '2025-07-28 01:12:33', '2025-07-28 01:12:33'),
	(7, 'Gagal', 'Pesanan gagal diproses karena suatu alasan.', '#DC143C', 1, '2025-07-28 01:13:02', '2025-07-28 01:13:02');

-- Dumping structure for table store_app.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table store_app.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `payment_method_id` bigint unsigned NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_of_payment_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed_by_user_id` bigint unsigned DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_order_id_unique` (`order_id`),
  KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  KEY `payments_confirmed_by_user_id_foreign` (`confirmed_by_user_id`),
  CONSTRAINT `payments_confirmed_by_user_id_foreign` FOREIGN KEY (`confirmed_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.payments: ~0 rows (approximately)
DELETE FROM `payments`;

-- Dumping structure for table store_app.payment_methods
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_details` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_methods_method_name_unique` (`method_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.payment_methods: ~2 rows (approximately)
DELETE FROM `payment_methods`;
INSERT INTO `payment_methods` (`id`, `method_name`, `account_details`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Transfer Bank BCA', 'Bank BCA - No. Rek: 1234567890 - An. Ara Cake', 1, '2025-07-28 00:32:37', '2025-07-28 00:32:37'),
	(2, 'Transfer Bank Mandiri', 'Bank Mandiri - No. Rek: 0987654321 - An. Ara Cake', 1, '2025-07-28 00:33:29', '2025-07-28 00:41:42');

-- Dumping structure for table store_app.pre_orders
CREATE TABLE IF NOT EXISTS `pre_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `preorder_start_date` date DEFAULT NULL,
  `preorder_end_date` date DEFAULT NULL,
  `estimated_completion_date` date DEFAULT NULL,
  `down_payment_required` tinyint(1) NOT NULL DEFAULT '0',
  `down_payment_amount` decimal(10,2) DEFAULT NULL,
  `final_payment_due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pre_orders_order_id_unique` (`order_id`),
  CONSTRAINT `pre_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.pre_orders: ~0 rows (approximately)
DELETE FROM `pre_orders`;

-- Dumping structure for table store_app.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `preparation_time_days` int NOT NULL DEFAULT '2',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `is_preorder_only` tinyint(1) NOT NULL DEFAULT '0',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_recommended` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.products: ~15 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `description`, `price`, `preparation_time_days`, `is_available`, `is_preorder_only`, `image_url`, `is_recommended`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Donat Matcha', 'donat-matcha-ZxEOC', '2AUV1LY7', 'Sunt sapiente officiis autem aperiam est suscipit deserunt dicta harum repudiandae perferendis.', 35670.00, 2, 1, 0, NULL, 1, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(2, 1, 'Donat Coklat', 'donat-coklat-NLu9B', 'T7TXFSER', 'Et temporibus autem aperiam natus et sint repudiandae.', 36359.00, 2, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(3, 1, 'Donat Matcha', 'donat-matcha-7uxrD', 'DEW3X5AE', 'Voluptatem dolorem est molestiae consequatur voluptates aspernatur ex perspiciatis.', 29888.00, 3, 1, 0, NULL, 0, 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(4, 1, 'Donat Keju', 'donat-keju-p6xsY', '7AYVL7VP', 'Ipsa voluptatem dolorum dignissimos officiis qui ullam sed voluptas.', 44360.00, 1, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(5, 1, 'Donat Matcha', 'donat-matcha-qoOCS', 'XXGDCOYJ', 'Quibusdam dolor dolores ab et et aut veritatis.', 22209.00, 2, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(6, 2, 'Snack Box Komplit', 'snack-box-komplit-6Kf4E', 'MILVVVBD', 'Occaecati optio molestias reiciendis sed numquam sint quod necessitatibus laborum eum.', 46250.00, 2, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(7, 2, 'Snack Box Komplit', 'snack-box-komplit-JScYV', '5JTDKRAY', 'Velit suscipit illo deserunt repudiandae ducimus exercitationem ut.', 34709.00, 2, 1, 0, NULL, 1, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(8, 2, 'Snack Box Komplit', 'snack-box-komplit-g2nmk', 'BELSM3SK', 'Est qui quis rem dolorem quia aspernatur.', 45818.00, 1, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(9, 2, 'Snack Box Komplit', 'snack-box-komplit-jDKUn', 'CPXSWYWV', 'Quibusdam mollitia enim iusto consectetur deleniti vel.', 33398.00, 3, 1, 0, NULL, 1, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(10, 2, 'Snack Box Rapat', 'snack-box-rapat-uUPBM', 'YNDAWL6H', 'Quidem perferendis reiciendis nobis eum incidunt veniam totam.', 34028.00, 1, 1, 0, NULL, 1, 0, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(11, 3, 'Nasi Ikan Bakar', 'nasi-ikan-bakar-XfSur', 'DYPGRRTI', 'Est esse et suscipit sit delectus culpa labore totam.', 15356.00, 2, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:14', '2025-07-27 03:27:14'),
	(12, 3, 'Nasi Ayam Bakar', 'nasi-ayam-bakar-ubjuT', 'P4Y74KOG', 'Id debitis id nesciunt nulla veniam expedita facere est consequatur sit est id.', 21603.00, 2, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:14', '2025-07-27 03:27:14'),
	(13, 3, 'Nasi Ayam Geprek', 'nasi-ayam-geprek-TQ2bp', 'AAMITDJR', 'Facilis quibusdam maxime adipisci qui voluptatem illum labore deserunt.', 35194.00, 2, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:14', '2025-07-27 03:27:14'),
	(14, 3, 'Nasi Ikan Bakar', 'nasi-ikan-bakar-3IZlA', 'GVDUJ87E', 'Et alias quis quia corporis voluptatem et porro optio impedit quo.', 44992.00, 2, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:14', '2025-07-27 03:27:14'),
	(15, 3, 'Nasi Rendang', 'nasi-rendang-S7jMe', 'K2LY1FP0', 'Voluptatem a sapiente nisi culpa in laborum natus alias ex rerum omnis vel.', 29251.00, 1, 1, 0, NULL, 0, 0, 1, '2025-07-27 03:27:14', '2025-07-27 03:27:14');

-- Dumping structure for table store_app.product_categories
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_name_unique` (`name`),
  UNIQUE KEY `product_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.product_categories: ~4 rows (approximately)
DELETE FROM `product_categories`;
INSERT INTO `product_categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Donat', 'donat', 'Donat yang mengandung berbagai macam rasa dan tekstur.', 'category/EmhtCG5bYW0wxmGo81QrIg6nhtvMqhiBHD5q0FuR.jpg', 1, NULL, '2025-07-27 03:41:33'),
	(2, 'Snack Box', 'snack-box', 'Snack box yang mengandung berbagai macam makanan dan minuman.', NULL, 1, NULL, NULL),
	(3, 'Nasi Box', 'nasi-box', 'Nasi box yang mengandung berbagai macam makanan dan minuman.', NULL, 1, NULL, NULL),
	(4, 'John', 'john', 'asdwadwd', 'category/AkrqCwR4xl8eqmT228t1SibwXA2n3e7g5BX5NHe2.jpg', 1, '2025-07-27 03:36:24', '2025-07-27 03:36:24');

-- Dumping structure for table store_app.product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.product_images: ~0 rows (approximately)
DELETE FROM `product_images`;

-- Dumping structure for table store_app.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.sessions: ~1 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('EQtK43lTyywBnwNkaVNY8iOusPJhYxy7WWS5kPjq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmF3SmNraEpTc1NIWmJSaVF1UDVWR2tvYVJHd1Z3WGp6bkh0U0szMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wcm9kdWN0L2NyZWF0ZSI7fX0=', 1753851383);

-- Dumping structure for table store_app.system_logs
CREATE TABLE IF NOT EXISTS `system_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_level` enum('INFO','WARN','ERROR','DEBUG') COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `system_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.system_logs: ~34 rows (approximately)
DELETE FROM `system_logs`;
INSERT INTO `system_logs` (`id`, `timestamp`, `log_level`, `event_type`, `message`, `user_id`, `ip_address`, `metadata`, `created_at`, `updated_at`) VALUES
	(1, '2025-07-27 03:36:24', 'INFO', 'PRODUCT_CATEGORY_CREATED', 'Kategori produk "John" telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"category_id": 4, "request_data": {"name": "John", "slug": "john", "image": "category/AkrqCwR4xl8eqmT228t1SibwXA2n3e7g5BX5NHe2.jpg", "is_active": "1", "description": "asdwadwd"}, "category_name": "John", "created_by_user_id": null}', NULL, NULL),
	(2, '2025-07-27 03:40:57', 'INFO', 'PRODUCT_CATEGORY_UPDATED', 'Kategori produk "Donat" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"category_id": 1, "request_data": {"name": "Donat", "slug": "donat", "image": "category/20wL25YxVcieV3nDjOQ6y8MgiU2EjgMFDpeZvf8K.png", "is_active": "1", "description": "Donat yang mengandung berbagai macam rasa dan tekstur."}, "category_name": "Donat", "updated_by_user_id": null}', NULL, NULL),
	(3, '2025-07-27 03:41:19', 'INFO', 'PRODUCT_CATEGORY_UPDATED', 'Kategori produk "Donatu" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"category_id": 1, "request_data": {"name": "Donatu", "slug": "donatu", "is_active": "1", "description": "Donat yang mengandung berbagai macam rasa dan tekstur."}, "category_name": "Donatu", "updated_by_user_id": null}', NULL, NULL),
	(4, '2025-07-27 03:41:33', 'INFO', 'PRODUCT_CATEGORY_UPDATED', 'Kategori produk "Donat" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"category_id": 1, "request_data": {"name": "Donat", "slug": "donat", "image": "category/EmhtCG5bYW0wxmGo81QrIg6nhtvMqhiBHD5q0FuR.jpg", "is_active": "1", "description": "Donat yang mengandung berbagai macam rasa dan tekstur."}, "category_name": "Donat", "updated_by_user_id": null}', NULL, NULL),
	(5, '2025-07-27 05:23:33', 'INFO', 'DELIVERY_METHOD_CREATED', 'Metode pengiriman baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"base_cost": "0", "is_active": "1", "is_pickup": "1", "cost_per_km": "0", "description": "Ambil pesanan langsung di toko kami", "method_name": "Ambil di Toko", "request_data": {"base_cost": "0", "is_active": "1", "is_pickup": "1", "cost_per_km": "0", "description": "Ambil pesanan langsung di toko kami", "method_name": "Ambil di Toko"}, "created_by_user_id": null}', NULL, NULL),
	(6, '2025-07-27 05:26:40', 'INFO', 'DELIVERY_METHOD_CREATED', 'Metode pengiriman baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"base_cost": "15000", "is_active": "1", "is_pickup": "0", "cost_per_km": "0", "description": "Pengiriman estimasi 3-5 hari kerja", "method_name": "Pengiriman Standar", "request_data": {"base_cost": "15000", "is_active": "1", "is_pickup": "0", "cost_per_km": "0", "description": "Pengiriman estimasi 3-5 hari kerja", "method_name": "Pengiriman Standar"}, "created_by_user_id": null}', NULL, NULL),
	(7, '2025-07-28 00:32:38', 'INFO', 'PAYMENT_METHOD_CREATED', 'Metode pembayaran baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "method_name": "Transfer Bank BCA", "request_data": {"is_active": "1", "method_name": "Transfer Bank BCA", "account_details": "Bank BCA - No. Rek: 1234567890 - An. Ara Cake"}, "account_details": "Bank BCA - No. Rek: 1234567890 - An. Ara Cake", "created_by_user_id": null}', NULL, NULL),
	(8, '2025-07-28 00:33:29', 'INFO', 'PAYMENT_METHOD_CREATED', 'Metode pembayaran baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "method_name": "Transfer Bank Mandiri", "request_data": {"is_active": "1", "method_name": "Transfer Bank Mandiri", "account_details": "Bank Mandiri - No. Rek: 0987654321 - An. Ara Cake"}, "account_details": "Bank Mandiri - No. Rek: 0987654321 - An. Ara Cake", "created_by_user_id": null}', NULL, NULL),
	(9, '2025-07-28 00:41:33', 'INFO', 'PAYMENT_METHOD_UPDATED', 'Metode pembayaran "Transfer Bank Mandiriy" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "method_name": "Transfer Bank Mandiriy", "request_data": {"is_active": "1", "method_name": "Transfer Bank Mandiriy", "account_details": "Bank Mandiri - No. Rek: 0987654321 - An. Ara Cake"}, "account_details": "Bank Mandiri - No. Rek: 0987654321 - An. Ara Cake", "updated_by_user_id": null}', NULL, NULL),
	(10, '2025-07-28 00:41:42', 'INFO', 'PAYMENT_METHOD_UPDATED', 'Metode pembayaran "Transfer Bank Mandiri" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "method_name": "Transfer Bank Mandiri", "request_data": {"is_active": "1", "method_name": "Transfer Bank Mandiri", "account_details": "Bank Mandiri - No. Rek: 0987654321 - An. Ara Cake"}, "account_details": "Bank Mandiri - No. Rek: 0987654321 - An. Ara Cake", "updated_by_user_id": null}', NULL, NULL),
	(11, '2025-07-28 01:09:16', 'INFO', 'ORDER_STATUS_CREATED', 'Status pesanan baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "description": "Pesanan telah dibuat, menunggu pembayaran dari pelanggan.", "status_name": "Menunggu Pembayaran", "request_data": {"is_active": "1", "description": "Pesanan telah dibuat, menunggu pembayaran dari pelanggan.", "status_name": "Menunggu Pembayaran", "status_color": "#FFD700"}, "status_color": "#FFD700", "created_by_user_id": null}', NULL, NULL),
	(12, '2025-07-28 01:09:55', 'INFO', 'ORDER_STATUS_CREATED', 'Status pesanan baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "description": "Pelanggan telah mengunggah bukti pembayaran, menunggu konfirmasi admin.", "status_name": "Menunggu Konfirmasi Pembayaran", "request_data": {"is_active": "1", "description": "Pelanggan telah mengunggah bukti pembayaran, menunggu konfirmasi admin.", "status_name": "Menunggu Konfirmasi Pembayaran", "status_color": "#FFA500"}, "status_color": "#FFA500", "created_by_user_id": null}', NULL, NULL),
	(13, '2025-07-28 01:10:38', 'INFO', 'ORDER_STATUS_CREATED', 'Status pesanan baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "description": "Pembayaran telah dikonfirmasi, pesanan sedang diproses/disiapkan.", "status_name": "Diproses", "request_data": {"is_active": "1", "description": "Pembayaran telah dikonfirmasi, pesanan sedang diproses/disiapkan.", "status_name": "Diproses", "status_color": "#4169E1"}, "status_color": "#4169E1", "created_by_user_id": null}', NULL, NULL),
	(14, '2025-07-28 01:11:05', 'INFO', 'ORDER_STATUS_CREATED', 'Status pesanan baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "description": "Pesanan sudah siap untuk diambil atau dikirim.", "status_name": "Siap Diambil/Dikirim", "request_data": {"is_active": "1", "description": "Pesanan sudah siap untuk diambil atau dikirim.", "status_name": "Siap Diambil/Dikirim", "status_color": "#32CD32"}, "status_color": "#32CD32", "created_by_user_id": null}', NULL, NULL),
	(15, '2025-07-28 01:11:53', 'INFO', 'ORDER_STATUS_CREATED', 'Status pesanan baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "description": "Pesanan telah diambil/dikirim dan transaksi selesai.", "status_name": "Selesai", "request_data": {"is_active": "1", "description": "Pesanan telah diambil/dikirim dan transaksi selesai.", "status_name": "Selesai", "status_color": "#228B22"}, "status_color": "#228B22", "created_by_user_id": null}', NULL, NULL),
	(16, '2025-07-28 01:12:33', 'INFO', 'ORDER_STATUS_CREATED', 'Status pesanan baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "description": "Pesanan telah dibatalkan.", "status_name": "Dibatalkan", "request_data": {"is_active": "1", "description": "Pesanan telah dibatalkan.", "status_name": "Dibatalkan", "status_color": "#808080"}, "status_color": "#808080", "created_by_user_id": null}', NULL, NULL),
	(17, '2025-07-28 01:13:02', 'INFO', 'ORDER_STATUS_CREATED', 'Status pesanan baru telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "1", "description": "Pesanan gagal diproses karena suatu alasan.", "status_name": "Gagal", "request_data": {"is_active": "1", "description": "Pesanan gagal diproses karena suatu alasan.", "status_name": "Gagal", "status_color": "#DC143C"}, "status_color": "#DC143C", "created_by_user_id": null}', NULL, NULL),
	(18, '2025-07-29 00:08:03', 'INFO', 'SYSTEM_SETTING_CREATED', 'Pengaturan sistem "min_preparation_days" telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 1, "setting_key": "min_preparation_days", "request_data": {"type": "int", "is_active": "1", "description": "Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).", "setting_key": "min_preparation_days", "setting_value": "2"}, "setting_value": "2", "created_by_user_id": null}', NULL, NULL),
	(19, '2025-07-29 00:08:39', 'INFO', 'SYSTEM_SETTING_CREATED', 'Pengaturan sistem "store_address" telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 2, "setting_key": "store_address", "request_data": {"type": "string", "is_active": "1", "description": "Alamat fisik toko Ara Cake.", "setting_key": "store_address", "setting_value": "Jl. Bunga Melati No. 12, Kel. Harapan, Kec. Jaya, Kota Jakarta Timur, Kode Pos 13120"}, "setting_value": "Jl. Bunga Melati No. 12, Kel. Harapan, Kec. Jaya, Kota Jakarta Timur, Kode Pos 13120", "created_by_user_id": null}', NULL, NULL),
	(20, '2025-07-29 00:09:01', 'INFO', 'SYSTEM_SETTING_CREATED', 'Pengaturan sistem "store_phone" telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 3, "setting_key": "store_phone", "request_data": {"type": "string", "is_active": "1", "description": "Nomor telepon kontak toko.", "setting_key": "store_phone", "setting_value": "021-7890123"}, "setting_value": "021-7890123", "created_by_user_id": null}', NULL, NULL),
	(21, '2025-07-29 00:09:27', 'INFO', 'SYSTEM_SETTING_CREATED', 'Pengaturan sistem "store_email" telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 4, "setting_key": "store_email", "request_data": {"type": "string", "is_active": "1", "description": "Alamat email kontak toko.", "setting_key": "store_email", "setting_value": "info@aracake.com"}, "setting_value": "info@aracake.com", "created_by_user_id": null}', NULL, NULL),
	(22, '2025-07-29 00:09:49', 'INFO', 'SYSTEM_SETTING_CREATED', 'Pengaturan sistem "delivery_radius_km" telah berhasil dibuat oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 5, "setting_key": "delivery_radius_km", "request_data": {"type": "decimal", "is_active": "1", "description": "Radius maksimum pengiriman lokal dalam kilometer.", "setting_key": "delivery_radius_km", "setting_value": "15.5"}, "setting_value": "15.5", "created_by_user_id": null}', NULL, NULL),
	(23, '2025-07-29 00:34:04', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "working_hours" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 6, "setting_key": "working_hours", "request_data": {"type": "json", "is_active": "0", "description": "Jam operasional toko.", "setting_key": "working_hours", "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}"}, "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}", "updated_by_user_id": null}', NULL, NULL),
	(24, '2025-07-29 00:34:18', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "working_hours" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 6, "setting_key": "working_hours", "request_data": {"type": "json", "is_active": "0", "description": "Jam operasional toko.", "setting_key": "working_hours", "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}"}, "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}", "updated_by_user_id": null}', NULL, NULL),
	(25, '2025-07-29 00:34:59', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "min_preparation_days" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 1, "setting_key": "min_preparation_days", "request_data": {"type": "int", "is_active": "1", "description": "Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).", "setting_key": "min_preparation_days", "setting_value": "3"}, "setting_value": "3", "updated_by_user_id": null}', NULL, NULL),
	(26, '2025-07-29 00:35:53', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "min_preparation_days" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 1, "setting_key": "min_preparation_days", "request_data": {"type": "int", "is_active": "0", "description": "Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).", "setting_key": "min_preparation_days", "setting_value": "2"}, "setting_value": "2", "updated_by_user_id": null}', NULL, NULL),
	(27, '2025-07-29 00:36:00', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "min_preparation_days" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 1, "setting_key": "min_preparation_days", "request_data": {"type": "int", "is_active": "0", "description": "Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).", "setting_key": "min_preparation_days", "setting_value": "2"}, "setting_value": "2", "updated_by_user_id": null}', NULL, NULL),
	(28, '2025-07-29 00:36:08', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "min_preparation_days" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 1, "setting_key": "min_preparation_days", "request_data": {"type": "int", "is_active": "0", "description": "Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).", "setting_key": "min_preparation_days", "setting_value": "2"}, "setting_value": "2", "updated_by_user_id": null}', NULL, NULL),
	(29, '2025-07-29 00:36:46', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "working_hours" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "0", "setting_id": 6, "setting_key": "working_hours", "request_data": {"is_active": "0", "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}"}, "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}", "updated_by_user_id": null}', NULL, NULL),
	(30, '2025-07-29 00:36:46', 'ERROR', 'SYSTEM_SETTING_UPDATE_FAILED', 'Gagal memperbarui pengaturan sistem "working_hours". Error: Route [admin.system-settings.index] not defined.', NULL, '127.0.0.1', '{"user_id": null, "ip_address": "127.0.0.1", "setting_id": 6, "error_trace": "#0 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Redirector.php(154): Illuminate\\\\Routing\\\\UrlGenerator->route(\'admin.system-se...\', Array)\\n#1 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\app\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\SystemSettingController.php(111): Illuminate\\\\Routing\\\\Redirector->route(\'admin.system-se...\')\\n#2 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\ControllerDispatcher.php(47): App\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\SystemSettingController->update(Object(Illuminate\\\\Http\\\\Request), Object(App\\\\Models\\\\SystemSetting))\\n#3 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Route.php(266): Illuminate\\\\Routing\\\\ControllerDispatcher->dispatch(Object(Illuminate\\\\Routing\\\\Route), Object(App\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\SystemSettingController), \'update\')\\n#4 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Route.php(212): Illuminate\\\\Routing\\\\Route->runController()\\n#5 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(808): Illuminate\\\\Routing\\\\Route->run()\\n#6 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(170): Illuminate\\\\Routing\\\\Router->Illuminate\\\\Routing\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#7 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Middleware\\\\SubstituteBindings.php(51): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#8 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Routing\\\\Middleware\\\\SubstituteBindings->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#9 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\VerifyCsrfToken.php(88): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#10 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\VerifyCsrfToken->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#11 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\View\\\\Middleware\\\\ShareErrorsFromSession.php(49): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#12 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\View\\\\Middleware\\\\ShareErrorsFromSession->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#13 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Session\\\\Middleware\\\\StartSession.php(121): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#14 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Session\\\\Middleware\\\\StartSession.php(64): Illuminate\\\\Session\\\\Middleware\\\\StartSession->handleStatefulRequest(Object(Illuminate\\\\Http\\\\Request), Object(Illuminate\\\\Session\\\\Store), Object(Closure))\\n#15 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Session\\\\Middleware\\\\StartSession->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#16 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Cookie\\\\Middleware\\\\AddQueuedCookiesToResponse.php(37): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#17 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Cookie\\\\Middleware\\\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#18 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Cookie\\\\Middleware\\\\EncryptCookies.php(75): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#19 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Cookie\\\\Middleware\\\\EncryptCookies->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#20 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(127): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#21 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(807): Illuminate\\\\Pipeline\\\\Pipeline->then(Object(Closure))\\n#22 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(786): Illuminate\\\\Routing\\\\Router->runRouteWithinStack(Object(Illuminate\\\\Routing\\\\Route), Object(Illuminate\\\\Http\\\\Request))\\n#23 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(750): Illuminate\\\\Routing\\\\Router->runRoute(Object(Illuminate\\\\Http\\\\Request), Object(Illuminate\\\\Routing\\\\Route))\\n#24 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(739): Illuminate\\\\Routing\\\\Router->dispatchToRoute(Object(Illuminate\\\\Http\\\\Request))\\n#25 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(201): Illuminate\\\\Routing\\\\Router->dispatch(Object(Illuminate\\\\Http\\\\Request))\\n#26 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(170): Illuminate\\\\Foundation\\\\Http\\\\Kernel->Illuminate\\\\Foundation\\\\Http\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#27 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest.php(21): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#28 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\ConvertEmptyStringsToNull.php(31): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#29 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#30 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest.php(21): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#31 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TrimStrings.php(51): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#32 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TrimStrings->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#33 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\ValidatePostSize.php(27): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#34 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\ValidatePostSize->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#35 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\PreventRequestsDuringMaintenance.php(110): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#36 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#37 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\HandleCors.php(49): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#38 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\HandleCors->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#39 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\TrustProxies.php(58): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#40 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\TrustProxies->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#41 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\InvokeDeferredCallbacks.php(22): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#42 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\InvokeDeferredCallbacks->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#43 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(127): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#44 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(176): Illuminate\\\\Pipeline\\\\Pipeline->then(Object(Closure))\\n#45 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(145): Illuminate\\\\Foundation\\\\Http\\\\Kernel->sendRequestThroughRouter(Object(Illuminate\\\\Http\\\\Request))\\n#46 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Application.php(1220): Illuminate\\\\Foundation\\\\Http\\\\Kernel->handle(Object(Illuminate\\\\Http\\\\Request))\\n#47 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\public\\\\index.php(17): Illuminate\\\\Foundation\\\\Application->handleRequest(Object(Illuminate\\\\Http\\\\Request))\\n#48 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\resources\\\\server.php(23): require_once(\'D:\\\\\\\\Arif\\\\\\\\FREELAN...\')\\n#49 {main}", "request_data": {"type": "json", "_token": "egmthvmEh30svd19negnUo0TYxNq9Xr94LwMIFB1", "_method": "PUT", "is_active": "0", "description": "Jam operasional toko.", "setting_key": "working_hours", "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}"}, "error_message": "Route [admin.system-settings.index] not defined."}', NULL, NULL),
	(31, '2025-07-29 00:37:10', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "working_hours" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "0", "setting_id": 6, "setting_key": "working_hours", "request_data": {"is_active": "0", "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}"}, "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}", "updated_by_user_id": null}', NULL, NULL),
	(32, '2025-07-29 00:37:25', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "working_hours" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"is_active": "0", "setting_id": 6, "setting_key": "working_hours", "request_data": {"is_active": "0", "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}"}, "setting_value": "{\\"Monday\\":\\"09:00-17:00\\",\\"Tuesday\\":\\"09:00-17:00\\",\\"Wednesday\\":\\"09:00-17:00\\",\\"Thursday\\":\\"09:00-17:00\\",\\"Friday\\":\\"09:00-17:00\\",\\"Saturday\\":\\"10:00-15:00\\",\\"Sunday\\":\\"Closed\\"}", "updated_by_user_id": null}', NULL, NULL),
	(33, '2025-07-29 01:00:53', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "delivery_radius_km" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 5, "setting_key": "delivery_radius_km", "request_data": {"type": "decimal", "is_active": "1", "description": "Radius maksimum pengiriman lokal dalam kilometer.", "setting_key": "delivery_radius_km", "setting_value": "15.5"}, "setting_value": "15.5", "updated_by_user_id": null}', NULL, NULL),
	(34, '2025-07-29 01:01:03', 'INFO', 'SYSTEM_SETTING_UPDATED', 'Pengaturan sistem "min_preparation_days" telah berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"setting_id": 1, "setting_key": "min_preparation_days", "request_data": {"type": "int", "is_active": "1", "description": "Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).", "setting_key": "min_preparation_days", "setting_value": "2"}, "setting_value": "2", "updated_by_user_id": null}', NULL, NULL),
	(35, '2025-07-29 01:35:34', 'INFO', 'WORKING_HOUR_UPDATED', 'Jam kerja untuk "Saturday" berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"end_time": null, "is_closed": true, "start_time": null, "day_of_week": "Saturday", "request_data": {"is_closed": "1"}, "working_hour_id": 6, "updated_by_user_id": null}', NULL, NULL),
	(36, '2025-07-29 01:35:34', 'ERROR', 'WORKING_HOUR_UPDATE_FAILED', 'Gagal memperbarui jam kerja untuk "Saturday". Error: Route [admin.working-hours.index] not defined.', NULL, '127.0.0.1', '{"user_id": null, "error_trace": "#0 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Redirector.php(154): Illuminate\\\\Routing\\\\UrlGenerator->route(\'admin.working-h...\', Array)\\n#1 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\app\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\WorkingHourController.php(108): Illuminate\\\\Routing\\\\Redirector->route(\'admin.working-h...\')\\n#2 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\ControllerDispatcher.php(47): App\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\WorkingHourController->update(Object(Illuminate\\\\Http\\\\Request), Object(App\\\\Models\\\\WorkingHour))\\n#3 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Route.php(266): Illuminate\\\\Routing\\\\ControllerDispatcher->dispatch(Object(Illuminate\\\\Routing\\\\Route), Object(App\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\WorkingHourController), \'update\')\\n#4 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Route.php(212): Illuminate\\\\Routing\\\\Route->runController()\\n#5 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(808): Illuminate\\\\Routing\\\\Route->run()\\n#6 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(170): Illuminate\\\\Routing\\\\Router->Illuminate\\\\Routing\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#7 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Middleware\\\\SubstituteBindings.php(51): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#8 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Routing\\\\Middleware\\\\SubstituteBindings->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#9 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\VerifyCsrfToken.php(88): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#10 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\VerifyCsrfToken->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#11 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\View\\\\Middleware\\\\ShareErrorsFromSession.php(49): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#12 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\View\\\\Middleware\\\\ShareErrorsFromSession->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#13 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Session\\\\Middleware\\\\StartSession.php(121): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#14 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Session\\\\Middleware\\\\StartSession.php(64): Illuminate\\\\Session\\\\Middleware\\\\StartSession->handleStatefulRequest(Object(Illuminate\\\\Http\\\\Request), Object(Illuminate\\\\Session\\\\Store), Object(Closure))\\n#15 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Session\\\\Middleware\\\\StartSession->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#16 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Cookie\\\\Middleware\\\\AddQueuedCookiesToResponse.php(37): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#17 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Cookie\\\\Middleware\\\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#18 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Cookie\\\\Middleware\\\\EncryptCookies.php(75): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#19 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Cookie\\\\Middleware\\\\EncryptCookies->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#20 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(127): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#21 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(807): Illuminate\\\\Pipeline\\\\Pipeline->then(Object(Closure))\\n#22 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(786): Illuminate\\\\Routing\\\\Router->runRouteWithinStack(Object(Illuminate\\\\Routing\\\\Route), Object(Illuminate\\\\Http\\\\Request))\\n#23 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(750): Illuminate\\\\Routing\\\\Router->runRoute(Object(Illuminate\\\\Http\\\\Request), Object(Illuminate\\\\Routing\\\\Route))\\n#24 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(739): Illuminate\\\\Routing\\\\Router->dispatchToRoute(Object(Illuminate\\\\Http\\\\Request))\\n#25 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(201): Illuminate\\\\Routing\\\\Router->dispatch(Object(Illuminate\\\\Http\\\\Request))\\n#26 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(170): Illuminate\\\\Foundation\\\\Http\\\\Kernel->Illuminate\\\\Foundation\\\\Http\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#27 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest.php(21): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#28 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\ConvertEmptyStringsToNull.php(31): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#29 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#30 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest.php(21): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#31 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TrimStrings.php(51): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#32 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TrimStrings->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#33 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\ValidatePostSize.php(27): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#34 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\ValidatePostSize->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#35 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\PreventRequestsDuringMaintenance.php(110): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#36 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#37 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\HandleCors.php(49): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#38 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\HandleCors->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#39 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\TrustProxies.php(58): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#40 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\TrustProxies->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#41 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\InvokeDeferredCallbacks.php(22): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#42 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\InvokeDeferredCallbacks->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#43 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(127): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#44 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(176): Illuminate\\\\Pipeline\\\\Pipeline->then(Object(Closure))\\n#45 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(145): Illuminate\\\\Foundation\\\\Http\\\\Kernel->sendRequestThroughRouter(Object(Illuminate\\\\Http\\\\Request))\\n#46 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Application.php(1220): Illuminate\\\\Foundation\\\\Http\\\\Kernel->handle(Object(Illuminate\\\\Http\\\\Request))\\n#47 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\public\\\\index.php(17): Illuminate\\\\Foundation\\\\Application->handleRequest(Object(Illuminate\\\\Http\\\\Request))\\n#48 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\resources\\\\server.php(23): require_once(\'D:\\\\\\\\Arif\\\\\\\\FREELAN...\')\\n#49 {main}", "request_data": {"_token": "egmthvmEh30svd19negnUo0TYxNq9Xr94LwMIFB1", "_method": "PUT", "is_closed": "1", "start_time_if_not_closed": null}, "error_message": "Route [admin.working-hours.index] not defined.", "working_hour_id": 6}', NULL, NULL),
	(37, '2025-07-29 01:36:11', 'INFO', 'WORKING_HOUR_UPDATED', 'Jam kerja untuk "Saturday" berhasil diperbarui oleh Pengguna Tidak Dikenal.', NULL, '127.0.0.1', '{"end_time": "17:00", "is_closed": false, "start_time": "09:00", "day_of_week": "Saturday", "request_data": {"end_time": "17:00", "is_closed": "0", "start_time": "09:00"}, "working_hour_id": 6, "updated_by_user_id": null}', NULL, NULL),
	(38, '2025-07-29 01:36:11', 'ERROR', 'WORKING_HOUR_UPDATE_FAILED', 'Gagal memperbarui jam kerja untuk "Saturday". Error: Route [admin.working-hours.index] not defined.', NULL, '127.0.0.1', '{"user_id": null, "error_trace": "#0 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Redirector.php(154): Illuminate\\\\Routing\\\\UrlGenerator->route(\'admin.working-h...\', Array)\\n#1 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\app\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\WorkingHourController.php(108): Illuminate\\\\Routing\\\\Redirector->route(\'admin.working-h...\')\\n#2 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\ControllerDispatcher.php(47): App\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\WorkingHourController->update(Object(Illuminate\\\\Http\\\\Request), Object(App\\\\Models\\\\WorkingHour))\\n#3 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Route.php(266): Illuminate\\\\Routing\\\\ControllerDispatcher->dispatch(Object(Illuminate\\\\Routing\\\\Route), Object(App\\\\Http\\\\Controllers\\\\Admin\\\\System\\\\WorkingHourController), \'update\')\\n#4 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Route.php(212): Illuminate\\\\Routing\\\\Route->runController()\\n#5 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(808): Illuminate\\\\Routing\\\\Route->run()\\n#6 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(170): Illuminate\\\\Routing\\\\Router->Illuminate\\\\Routing\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#7 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Middleware\\\\SubstituteBindings.php(51): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#8 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Routing\\\\Middleware\\\\SubstituteBindings->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#9 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\VerifyCsrfToken.php(88): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#10 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\VerifyCsrfToken->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#11 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\View\\\\Middleware\\\\ShareErrorsFromSession.php(49): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#12 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\View\\\\Middleware\\\\ShareErrorsFromSession->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#13 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Session\\\\Middleware\\\\StartSession.php(121): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#14 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Session\\\\Middleware\\\\StartSession.php(64): Illuminate\\\\Session\\\\Middleware\\\\StartSession->handleStatefulRequest(Object(Illuminate\\\\Http\\\\Request), Object(Illuminate\\\\Session\\\\Store), Object(Closure))\\n#15 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Session\\\\Middleware\\\\StartSession->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#16 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Cookie\\\\Middleware\\\\AddQueuedCookiesToResponse.php(37): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#17 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Cookie\\\\Middleware\\\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#18 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Cookie\\\\Middleware\\\\EncryptCookies.php(75): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#19 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Cookie\\\\Middleware\\\\EncryptCookies->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#20 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(127): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#21 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(807): Illuminate\\\\Pipeline\\\\Pipeline->then(Object(Closure))\\n#22 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(786): Illuminate\\\\Routing\\\\Router->runRouteWithinStack(Object(Illuminate\\\\Routing\\\\Route), Object(Illuminate\\\\Http\\\\Request))\\n#23 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(750): Illuminate\\\\Routing\\\\Router->runRoute(Object(Illuminate\\\\Http\\\\Request), Object(Illuminate\\\\Routing\\\\Route))\\n#24 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Routing\\\\Router.php(739): Illuminate\\\\Routing\\\\Router->dispatchToRoute(Object(Illuminate\\\\Http\\\\Request))\\n#25 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(201): Illuminate\\\\Routing\\\\Router->dispatch(Object(Illuminate\\\\Http\\\\Request))\\n#26 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(170): Illuminate\\\\Foundation\\\\Http\\\\Kernel->Illuminate\\\\Foundation\\\\Http\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#27 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest.php(21): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#28 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\ConvertEmptyStringsToNull.php(31): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#29 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#30 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest.php(21): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#31 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TrimStrings.php(51): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TransformsRequest->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#32 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\TrimStrings->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#33 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\ValidatePostSize.php(27): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#34 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\ValidatePostSize->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#35 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\PreventRequestsDuringMaintenance.php(110): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#36 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#37 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\HandleCors.php(49): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#38 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\HandleCors->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#39 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Http\\\\Middleware\\\\TrustProxies.php(58): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#40 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Http\\\\Middleware\\\\TrustProxies->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#41 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\InvokeDeferredCallbacks.php(22): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#42 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(209): Illuminate\\\\Foundation\\\\Http\\\\Middleware\\\\InvokeDeferredCallbacks->handle(Object(Illuminate\\\\Http\\\\Request), Object(Closure))\\n#43 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Pipeline\\\\Pipeline.php(127): Illuminate\\\\Pipeline\\\\Pipeline->Illuminate\\\\Pipeline\\\\{closure}(Object(Illuminate\\\\Http\\\\Request))\\n#44 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(176): Illuminate\\\\Pipeline\\\\Pipeline->then(Object(Closure))\\n#45 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Http\\\\Kernel.php(145): Illuminate\\\\Foundation\\\\Http\\\\Kernel->sendRequestThroughRouter(Object(Illuminate\\\\Http\\\\Request))\\n#46 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Application.php(1220): Illuminate\\\\Foundation\\\\Http\\\\Kernel->handle(Object(Illuminate\\\\Http\\\\Request))\\n#47 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\public\\\\index.php(17): Illuminate\\\\Foundation\\\\Application->handleRequest(Object(Illuminate\\\\Http\\\\Request))\\n#48 D:\\\\Arif\\\\FREELANCE\\\\TOKO KUE\\\\terbaru\\\\store-app\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\resources\\\\server.php(23): require_once(\'D:\\\\\\\\Arif\\\\\\\\FREELAN...\')\\n#49 {main}", "request_data": {"_token": "egmthvmEh30svd19negnUo0TYxNq9Xr94LwMIFB1", "_method": "PUT", "end_time": "17:00", "is_closed": "0", "start_time": "09:00", "start_time_if_not_closed": "09:00"}, "error_message": "Route [admin.working-hours.index] not defined.", "working_hour_id": 6}', NULL, NULL);

-- Dumping structure for table store_app.system_settings
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('string','int','decimal','boolean','json') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_settings_setting_key_unique` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.system_settings: ~6 rows (approximately)
DELETE FROM `system_settings`;
INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `description`, `type`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'min_preparation_days', '2', 'Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).', 'int', 1, '2025-07-29 00:08:03', '2025-07-29 01:01:03'),
	(2, 'store_address', 'Jl. Bunga Melati No. 12, Kel. Harapan, Kec. Jaya, Kota Jakarta Timur, Kode Pos 13120', 'Alamat fisik toko Ara Cake.', 'string', 1, '2025-07-29 00:08:39', '2025-07-29 00:08:39'),
	(3, 'store_phone', '021-7890123', 'Nomor telepon kontak toko.', 'string', 1, '2025-07-29 00:09:01', '2025-07-29 00:09:01'),
	(4, 'store_email', 'info@aracake.com', 'Alamat email kontak toko.', 'string', 1, '2025-07-29 00:09:27', '2025-07-29 00:09:27'),
	(5, 'delivery_radius_km', '15.5', 'Radius maksimum pengiriman lokal dalam kilometer.', 'decimal', 1, '2025-07-29 00:09:49', '2025-07-29 00:09:49');

-- Dumping structure for table store_app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.users: ~21 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `phone_number`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Admin Toko', 'admin', 'admin@example.com', '081234567890', '2025-07-27 03:26:59', '$2y$12$6sXxFkrLuJCQMH/ajheWXu2OPaWjZi6HqTW.ek0UR7JpWByiH8WIW', 'admin', NULL, '2025-07-27 03:27:00', '2025-07-27 03:27:00', NULL),
	(2, 'Tira Melinda Usada', 'osuryatmi', 'wage.firgantoro@gmail.co.id', '028 8010 461', '2025-07-27 03:27:02', '$2y$12$gQIRcXs4xTMDuTyicdxj..Fsjcl2IkFUC1R8GDyM3UOphNbdo5sz2', 'customer', NULL, '2025-07-27 03:27:03', '2025-07-27 03:27:03', NULL),
	(3, 'Chelsea Permata', 'okto.oktaviani', 'mursita.purnawati@yahoo.com', '(+62) 26 3902 2027', '2025-07-27 03:27:03', '$2y$12$ZitPwJsO6CFj0aw1vH0lO.olSt1oKw7jQI2Pc5j1zn4CP4tJW/Yv.', 'customer', NULL, '2025-07-27 03:27:03', '2025-07-27 03:27:03', NULL),
	(4, 'Hamima Calista Sudiati', 'hilda80', 'rriyanti@namaga.ac.id', '(+62) 273 3384 0764', '2025-07-27 03:27:03', '$2y$12$ca2ge2zBFSIighZkZvhJ3u/braBsV2KcFU5AxGYflKJz/PK/ln6qG', 'customer', NULL, '2025-07-27 03:27:04', '2025-07-27 03:27:04', NULL),
	(5, 'Ajeng Puspita', 'empluk.purwanti', 'bahuraksa77@handayani.tv', '(+62) 837 8050 007', '2025-07-27 03:27:04', '$2y$12$soDV0z4PKlzQORiQp39D3OSdOuiBYtzEVmvyMGsezm.GFPVg3nzpe', 'customer', NULL, '2025-07-27 03:27:05', '2025-07-27 03:27:05', NULL),
	(6, 'Jelita Purwanti', 'vadriansyah', 'earyani@firmansyah.in', '(+62) 490 6597 7543', '2025-07-27 03:27:05', '$2y$12$vcVeQe8MzGmuDkB3Fvmboe7IvHIFGLiI5v9GbpIw1cqSUM9JarEyG', 'customer', NULL, '2025-07-27 03:27:06', '2025-07-27 03:27:06', NULL),
	(7, 'Cindy Julia Aryani', 'nababan.gasti', 'bakianto49@farida.mil.id', '0242 0045 538', '2025-07-27 03:27:06', '$2y$12$vEv89Lr6dVUqWAGRWGbTm.M9iK2AjG2t7SWWptK0OioTWekbO8hHC', 'customer', NULL, '2025-07-27 03:27:06', '2025-07-27 03:27:06', NULL),
	(8, 'Lurhur Prasetya', 'bnamaga', 'etamba@yahoo.co.id', '(+62) 631 4130 687', '2025-07-27 03:27:06', '$2y$12$mfChZFt8tO9A0orfvJ7q2uO46dIjuGHxhK.KsdOtpTS2J1/toMVoK', 'customer', NULL, '2025-07-27 03:27:07', '2025-07-27 03:27:07', NULL),
	(9, 'Daryani Tarihoran M.Ak', 'rafid.nasyidah', 'outami@uyainah.web.id', '(+62) 699 3978 353', '2025-07-27 03:27:07', '$2y$12$eE0VGJ7cuQyjDS1QBPGsy.hzjmCXliXrFTmybR8utEkeitE.3d9Zm', 'customer', NULL, '2025-07-27 03:27:07', '2025-07-27 03:27:07', NULL),
	(10, 'Aisyah Safitri', 'yulianti.surya', 'agustina.vivi@saputra.name', '0826 598 203', '2025-07-27 03:27:07', '$2y$12$S3cfYhwoD37gaKmmS0NjLOMJpQbyxvuMBn5xNd5BPU0vcO72JDDuK', 'customer', NULL, '2025-07-27 03:27:08', '2025-07-27 03:27:08', NULL),
	(11, 'Shania Amelia Anggraini M.Pd', 'dalima.uyainah', 'iharyanto@gmail.co.id', '(+62) 883 5776 7928', '2025-07-27 03:27:08', '$2y$12$Sszxmm.pI79DB.73dyGT..AzAnwBldqlB2hzbuVMhMFwwfiJ42t5y', 'customer', NULL, '2025-07-27 03:27:08', '2025-07-27 03:27:08', NULL),
	(12, 'Tami Puspita', 'ajimin.mulyani', 'nugraha.andriani@yahoo.com', '(+62) 376 1657 383', '2025-07-27 03:27:08', '$2y$12$bQOjWPF8MYzV/jDd4u/hLOGJErhru5L2m2bfm/8KdCCFA8Vpagw8G', 'customer', NULL, '2025-07-27 03:27:09', '2025-07-27 03:27:09', NULL),
	(13, 'Lurhur Edi Megantara', 'calista33', 'daryani@gmail.com', '0448 1574 9523', '2025-07-27 03:27:09', '$2y$12$8u.hVjtKE5yEMsg1rgTkeu4dogDNYNosKeqwbWw49iXlWb/D0zA4K', 'customer', NULL, '2025-07-27 03:27:09', '2025-07-27 03:27:09', NULL),
	(14, 'Nabila Puspasari', 'prabowo.jamal', 'uriyanti@sihombing.biz.id', '0890 7770 6508', '2025-07-27 03:27:09', '$2y$12$BMmTRBa05mSuFHB2blTOnetnFAAVyIYVPtplpwao4dZbzRLUvcljK', 'customer', NULL, '2025-07-27 03:27:10', '2025-07-27 03:27:10', NULL),
	(15, 'Mustofa Samosir', 'clara.safitri', 'daliono05@situmorang.go.id', '(+62) 425 3784 824', '2025-07-27 03:27:10', '$2y$12$hosgLhIx2JLLMSGWatu6LujmXWLxFVZo3ZMgKGAS6lWqLNF7P3l9a', 'customer', NULL, '2025-07-27 03:27:10', '2025-07-27 03:27:10', NULL),
	(16, 'Raisa Novitasari', 'utami.adiarja', 'novitasari.hasim@nasyiah.biz.id', '(+62) 871 2090 2478', '2025-07-27 03:27:10', '$2y$12$LboJJ5VBUdy7nMB4liIPUOBggM69q0OIP6jAYrQQg1qtuRBDcz3BO', 'customer', NULL, '2025-07-27 03:27:11', '2025-07-27 03:27:11', NULL),
	(17, 'Marwata Oman Suwarno', 'cinthia33', 'eharyanti@gmail.com', '0620 6889 3174', '2025-07-27 03:27:11', '$2y$12$Sj796uaY7i8pC/9mG/Y...u9XAxe2x0cJxWpvXPPRSPbFlEuEdo0a', 'customer', NULL, '2025-07-27 03:27:11', '2025-07-27 03:27:11', NULL),
	(18, 'Galur Mangunsong', 'halima19', 'hwibowo@purnawati.name', '(+62) 751 7453 7165', '2025-07-27 03:27:11', '$2y$12$PB0e8/xUf623XOehVv1eg.t2eZ5iXClVmRpoer4nCG4hNaFaRrCcy', 'customer', NULL, '2025-07-27 03:27:12', '2025-07-27 03:27:12', NULL),
	(19, 'Gantar Firmansyah', 'atmaja21', 'manggraini@sirait.web.id', '0628 6794 7406', '2025-07-27 03:27:12', '$2y$12$a9NPTInH38yvGpgF395zP.db4jIJMr4421wII4nbwWRFca6HPHqSK', 'customer', NULL, '2025-07-27 03:27:12', '2025-07-27 03:27:12', NULL),
	(20, 'Kamal Capa Wibowo', 'ira.maheswara', 'zulkarnain.ina@yahoo.com', '0806 1603 291', '2025-07-27 03:27:12', '$2y$12$Zto2gWpRaM0Pxjh91w8y4uWxNLp6.Ev4oKiLGeGkNLcLJ.pn/4wJq', 'customer', NULL, '2025-07-27 03:27:13', '2025-07-27 03:27:13', NULL),
	(21, 'Kacung Nugroho S.Kom', 'gsitumorang', 'cpalastri@lazuardi.desa.id', '(+62) 572 3410 511', '2025-07-27 03:27:13', '$2y$12$sIFh0fWFF9H9LpzYEKv1Fuwt6XwiR33S6prbaZGzXPMzIldvjBvSy', 'customer', NULL, '2025-07-27 03:27:13', '2025-07-27 03:27:13', NULL);

-- Dumping structure for table store_app.user_addresses
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `address_line1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.user_addresses: ~21 rows (approximately)
DELETE FROM `user_addresses`;
INSERT INTO `user_addresses` (`id`, `user_id`, `address_line1`, `address_line2`, `city`, `province`, `postal_code`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Dk. Baung No. 584', '107', 'Gunungsitoli', 'Kalimantan Utara', '35815', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(2, 2, 'Jr. Setiabudhi No. 145', '134', 'Madiun', 'Kalimantan Barat', '31946', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(3, 3, 'Gg. BKR No. 522', '929', 'Tegal', 'Maluku Utara', '56888', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(4, 4, 'Ds. Sunaryo No. 19', '180', 'Sorong', 'Maluku', '84819', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(5, 5, 'Psr. Bass No. 944', '593', 'Tarakan', 'Sumatera Selatan', '65688', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(6, 6, 'Jln. Baja No. 518', '209', 'Jayapura', 'Kepulauan Riau', '10602', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(7, 7, 'Jr. Jayawijaya No. 757', '442', 'Sabang', 'Banten', '37933', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(8, 8, 'Kpg. Wahid Hasyim No. 409', '898', 'Pagar Alam', 'DI Yogyakarta', '51667', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(9, 9, 'Jr. Arifin No. 525', '323', 'Subulussalam', 'Sulawesi Selatan', '52542', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(10, 10, 'Ki. Daan No. 671', '919', 'Subulussalam', 'Papua', '38807', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(11, 11, 'Psr. Untung Suropati No. 464', '450', 'Binjai', 'Kepulauan Bangka Belitung', '81784', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(12, 12, 'Ki. Gatot Subroto No. 577', '953', 'Ambon', 'Banten', '34507', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(13, 13, 'Ki. Setiabudhi No. 7', '839', 'Palopo', 'Jambi', '84058', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(14, 14, 'Dk. Astana Anyar No. 981', '881', 'Prabumulih', 'Sumatera Barat', '71117', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(15, 15, 'Kpg. Bah Jaya No. 883', '759', 'Jambi', 'Kalimantan Tengah', '92968', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(16, 16, 'Kpg. Moch. Toha No. 269', '18', 'Padangsidempuan', 'Banten', '61371', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(17, 17, 'Kpg. Panjaitan No. 957', '128', 'Sungai Penuh', 'Sulawesi Tengah', '24171', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(18, 18, 'Kpg. Pacuan Kuda No. 773', '509', 'Palangka Raya', 'Maluku Utara', '85923', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(19, 19, 'Dk. W.R. Supratman No. 30', '856', 'Ambon', 'Maluku Utara', '35957', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(20, 20, 'Kpg. Samanhudi No. 537', '624', 'Surabaya', 'Riau', '36635', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13'),
	(21, 21, 'Dk. Agus Salim No. 30', '672', 'Mataram', 'Kepulauan Bangka Belitung', '94788', 1, 1, '2025-07-27 03:27:13', '2025-07-27 03:27:13');

-- Dumping structure for table store_app.working_hours
CREATE TABLE IF NOT EXISTS `working_hours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `day_of_week` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `working_hours_day_of_week_unique` (`day_of_week`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table store_app.working_hours: ~7 rows (approximately)
DELETE FROM `working_hours`;
INSERT INTO `working_hours` (`id`, `day_of_week`, `start_time`, `end_time`, `is_closed`, `created_at`, `updated_at`) VALUES
	(1, 'Monday', '09:00:00', '17:00:00', 0, '2025-07-29 01:03:55', '2025-07-29 01:03:55'),
	(2, 'Tuesday', '09:00:00', '17:00:00', 0, '2025-07-29 01:03:55', '2025-07-29 01:03:55'),
	(3, 'Wednesday', '09:00:00', '17:00:00', 0, '2025-07-29 01:03:55', '2025-07-29 01:03:55'),
	(4, 'Thursday', '09:00:00', '17:00:00', 0, '2025-07-29 01:03:55', '2025-07-29 01:03:55'),
	(5, 'Friday', '09:00:00', '17:00:00', 0, '2025-07-29 01:03:55', '2025-07-29 01:03:55'),
	(6, 'Saturday', '09:00:00', '17:00:00', 0, '2025-07-29 01:03:55', '2025-07-29 01:36:11'),
	(7, 'Sunday', NULL, NULL, 1, '2025-07-29 01:03:55', '2025-07-29 01:03:55');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
