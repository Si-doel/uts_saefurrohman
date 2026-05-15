-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2026 at 03:29 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `program_uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_kategori` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(4, 'Home Appliance', 'Merchant Perabot Elektronik Rumah', '2026-05-14 03:18:42', '2026-05-14 03:23:02'),
(5, 'Workshop tools', 'Merchant Peralatan Bengkel', '2026-05-14 03:20:54', '2026-05-14 03:22:45'),
(6, 'Gardening Tools', 'Merchant peralatan perkebunan', '2026-05-14 03:22:21', '2026-05-14 03:22:21'),
(7, 'Office Tools', 'Merchant alat perkantoran', '2026-05-14 03:25:13', '2026-05-14 03:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-circle',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'merchant',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `route`, `icon`, `role`, `order`, `is_active`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Program', NULL, 'fas fa-th-large', 'merchant', 1, 1, NULL, '2026-05-14 08:07:30', '2026-05-14 09:21:49'),
(2, 'Categories', 'categories.index', 'fas fa-circle', 'merchant', 1, 1, 1, '2026-05-14 09:16:43', '2026-05-14 09:16:43'),
(3, 'Products', 'products.index', 'fas fa-circle', 'merchant', 2, 1, 1, '2026-05-14 09:16:43', '2026-05-14 09:16:43'),
(7, 'Report', NULL, 'fas fa-file-alt', 'merchant', 2, 1, NULL, '2026-05-14 09:16:43', '2026-05-14 09:16:43'),
(8, 'Cetak Laporan', NULL, 'fas fa-circle', 'merchant', 1, 0, 7, '2026-05-14 09:16:43', '2026-05-15 05:01:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_13_131747_add_role_to_users_table', 2),
(5, '2026_05_14_000000_create_categories_table', 3),
(6, '2026_05_14_000001_create_products_table', 4),
(7, '2026_05_14_045751_add_avatar_to_users_table', 5),
(8, '2026_05_14_121820_create_menus_table', 6),
(9, '2026_05_14_130041_add_is_active_to_menus_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_produk` bigint UNSIGNED NOT NULL,
  `id_kategori` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` int NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `foto`, `created_at`, `updated_at`) VALUES
(3, 4, 'Blender Philips', 'Blender Philips new products 2026', 1000000, 'uploads/products/yMUCMa7QCjxgjFdvFBStOh7ZBJXxjI9sC2ZPBgOu.jpg', '2026-05-14 04:29:58', '2026-05-14 04:29:58'),
(4, 4, 'Oven Listrik', 'Oven Listrik kapasitas 10ltr', 700000, 'uploads/products/tuZNXnJJMYFtSZneFU1Jp76TEWUOP3Oe6oN8Bqa1.jpg', '2026-05-14 04:30:45', '2026-05-14 04:30:45'),
(5, 4, 'Rice Cooker Philips', 'Rice Cooker Philips 1,8 liter', 550000, 'uploads/products/QEiPRZps6exOYoxeTfov46Q6n6XVVLpuX82kt5AV.jpg', '2026-05-14 04:32:18', '2026-05-14 04:32:18'),
(6, 7, 'Laptop ASUS', 'AMD Ryzen™ 5 Mobile Processor, 16 GB LPDDR5 5500 MHz, 512 GB SSD storage, 14\'\' FHD NanoEdge display', 8999999, 'uploads/products/H7YRKi4oU1w2P6250hVgy6DLBhuY8yLoDTxnKWF8.jpg', '2026-05-14 04:34:54', '2026-05-14 04:34:54'),
(7, 7, 'Keyboard mechanical', 'ASUS TUF Gaming K3 Gen II keyboard features optical-mechanical RGB switches and 100-million-keypress lifespan for ultimate durability', 350000, 'uploads/products/ViE7J16zDyIPPukt7u4YAItmghD5hRPNUUjwn79d.jpg', '2026-05-14 04:36:08', '2026-05-14 04:36:08'),
(8, 7, 'Mouse wireless', 'Mouse Wireless', 150000, 'uploads/products/f4ORLkDkdVezmxsW8b66CFFNnYYP8kASOOH0H0eO.jpg', '2026-05-14 04:37:02', '2026-05-14 04:37:02'),
(9, 7, 'Printer EPSON', 'Printer EPSON new generation 2026', 3000000, 'uploads/products/3WThGSNfjvKc1tRJIPJkFJj3xqlEUwM88vnpwh1W.jpg', '2026-05-14 04:37:47', '2026-05-14 04:37:47'),
(10, 5, 'Bor Listrik', 'BOSH Bor Listrik 500 watt', 1900000, 'uploads/products/MaxfdgaYBfzoFt7Up2T5jFT1ieBjcnJGCsQufHnA.jpg', '2026-05-14 04:38:43', '2026-05-14 04:38:43'),
(11, 5, 'Gerinda Cordless', 'Makita Cordless gerinda 2 battery', 1200000, 'uploads/products/uid5e1RlWFi29cmuIttezk8cURQ5NVLLvjdpt3yG.jpg', '2026-05-14 04:40:13', '2026-05-14 04:40:13'),
(12, 5, 'Kunci Ring pas Set', NULL, 150000, 'uploads/products/CYU3Z698MvoQOD3xUj0jVj3R0K2Ydzqqk4ITTzCo.jpg', '2026-05-14 04:47:18', '2026-05-15 07:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('oMaynILbcrrbkZphHjVzRY907janKa4BUYkFY07j', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJXM014cUs1WVpvMkdPMGNieWwzeFBEa2ZWTzJ6M2dDOXZqOUw4NXd2IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvcHJvZ3JhbS11dHMudGVzdFwvY2F0ZWdvcmllcyIsInJvdXRlIjoiY2F0ZWdvcmllcy5pbmRleCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NH0=', 1778858635);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'merchant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'saeful', 'saeful@merchant.com', NULL, '$2y$12$2ObssI5VzSvTh264t2x7Pe71koxVRUHrVOJ9WuVStne4AZPaYDgby', 'avatars/EK4VeeAeP8kWYddRCID1c2CRJIOAGNQTMy9n9GHh.jpg', 'CZkoQQ7sncOUquCgAxh4icBZHbmOVkEXkm1wwOHNeDwnOp8GwFF52hmadPjh', '2026-05-13 09:19:45', '2026-05-14 08:16:05', 'merchant'),
(2, 'Test User', 'test@example.com', NULL, '$2y$12$BRJKwRPZauyBMxnRtjDxVeHGKvZFgTXS8HDOkFxhb.4RQB7ntjO4K', NULL, NULL, '2026-05-13 09:51:59', '2026-05-13 09:51:59', 'merchant'),
(4, 'AdminLIS', 'admin@merchant.com', NULL, '$2y$12$m7z/f3xfm26n3s0Yaglg1u.WhHxLdjiK.SYMjB6LaDHdospN8TGge', 'avatars/EGmC7EgFWKxabhE5zRCLOp6woOm2DmRxoY9AePby.jpg', '75CKLaZZsy8faJxiNqHnKk6DHjCjlVpKXfHUZvLtitUfFG9t3X8YoSiW8ILW', '2026-05-14 05:02:35', '2026-05-14 05:11:57', 'developer'),
(5, 'Angel', 'Angel@merchant.com', NULL, '$2y$12$EEJa7onY9iVAALGqkYBRVOpBclbkdoSdudmYZAZ7IRMBG8Xzi8fQK', NULL, NULL, '2026-05-14 08:15:36', '2026-05-14 08:15:36', 'merchant');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_parent_id_foreign` (`parent_id`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `products_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_kategori` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_produk` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `categories` (`id_kategori`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
