-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2026 at 01:48 PM
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
-- Database: `db_garam`
--

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
(4, '2026_02_27_045642_create_products_table', 1),
(5, '2026_02_27_071341_create_orders_table', 1),
(6, '2026_02_27_071344_create_order_items_table', 1),
(7, '2026_02_27_081544_add_user_id_to_orders_table', 1),
(8, '2026_02_28_132704_create_testimonials_table', 1),
(9, '2026_04_28_030738_create_password_reset_requests_table', 2),
(10, '2026_04_28_032732_add_owner_to_user_role_enum', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_address` text NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','processed','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  `snap_token` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `invoice_number`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_price`, `status`, `snap_token`, `tracking_number`, `created_at`, `updated_at`) VALUES
(18, 1, 'INV-20260612-C5HV1', 'ferdian', 'Ferdyanwardana123@gmail.com', '+62 838 7476 7450', 'metro', 6500.00, 'completed', '6831b78e-c8d1-4409-a5c3-8c01dc48cbfc', NULL, '2026-06-11 19:24:36', '2026-06-11 19:28:41'),
(19, 3, 'INV-20260626-DMOBG', 'ferdian', 'ferdyanwardana123@gmail.com', '+62 838 7476 7450', 'Jambi', 650000.00, 'completed', 'ffc1c34f-a03f-4b10-a6cc-37932c73b48e', NULL, '2026-06-26 10:00:34', '2026-06-26 10:01:57'),
(20, 2, 'INV-20260627-ERRLS', 'ferdian ari wardana', 'ferdyanwardana123@gmail.com', '081122334455', 'metro lampung', 51500.00, 'completed', '3c180171-e91c-48a5-a20a-d4922a977725', NULL, '2026-06-27 09:00:52', '2026-06-27 09:36:06'),
(21, 2, 'INV-20260629-8S3YL', 'ferdian', 'Ferdyanwardana123@gmail.com', '+62 838 7476 7450', 'metro', 23000000.00, 'completed', '60d287e5-5148-4cfb-a76f-d8f486c0508b', NULL, '2026-06-28 23:29:05', '2026-06-28 23:30:36'),
(22, 2, 'INV-20260629-MKVFQ', 'ferdian', 'Ferdyanwardana123@gmail.com', '+62 838 7476 7450', 'metro', 23000.00, 'paid', '237282a9-c4aa-4df0-a0a6-30fca1ed2b21', NULL, '2026-06-28 23:38:39', '2026-06-28 23:39:31'),
(23, 2, 'INV-20260709-ULXUH', 'ferdian', 'Ferdyanwardana123@gmail.com', '+62 838 7476 7450', 'METRO', 3000.00, 'shipped', '8d2cc177-6396-4a7c-b1de-63601d4743c7', NULL, '2026-07-08 23:31:20', '2026-07-08 23:34:14'),
(24, 2, 'INV-20260709-TD0WC', 'ferdian', 'owner@merisajaya.com', '08000000000', 'metro', 3000.00, 'pending', '87423a11-e6e7-4feb-980d-ba5df0db2bc8', NULL, '2026-07-09 11:20:20', '2026-07-09 11:20:21'),
(25, 2, 'INV-20260709-KOYAQ', 'ferdian', 'owner@merisajaya.com', '08000000000', 'metro', 0.00, 'pending', NULL, NULL, '2026-07-09 11:22:29', '2026-07-09 11:22:29'),
(26, 2, 'INV-20260709-LPGQ3', 'ferdian', 'owner@merisajaya.com', '08000000000', 'metro', 0.00, 'pending', NULL, NULL, '2026-07-09 11:22:45', '2026-07-09 11:22:45'),
(27, 2, 'INV-20260712-KEKRG', 'budi', 'budi312123@gmail.com', '08000000000', 'metro', 3450000.00, 'pending', '28f562e7-6e59-49b2-92fb-b88270d55d0a', NULL, '2026-07-12 09:22:44', '2026-07-12 09:22:46'),
(28, 2, 'INV-20260712-IFUKR', 'ferdian', 'Ferdyanwardana123@gmail.com', '+62 838 7476 7450', 'lampung', 300000.00, 'paid', '4b497219-ecfc-4fea-91d7-053df4736318', NULL, '2026-07-12 09:29:42', '2026-07-12 09:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(18, 19, 16, 'garam halus raisa jaya', 100, 6500.00, '2026-06-26 10:00:34', '2026-06-26 10:00:34'),
(19, 20, 20, 'garam halus raisa jaya 1kg', 1, 5500.00, '2026-06-27 09:00:52', '2026-06-27 09:00:52'),
(20, 20, 16, 'garam halus raisa jaya 4kg', 1, 23000.00, '2026-06-27 09:00:52', '2026-06-27 09:00:52'),
(21, 20, 15, 'garam kasar merisa jaya 10kg', 1, 23000.00, '2026-06-27 09:00:52', '2026-06-27 09:00:52'),
(22, 21, 15, 'garam kasar merisa jaya 10kg', 1000, 23000.00, '2026-06-28 23:29:05', '2026-06-28 23:29:05'),
(23, 22, 15, 'garam kasar merisa jaya 10kg', 1, 23000.00, '2026-06-28 23:38:39', '2026-06-28 23:38:39'),
(24, 23, 23, 'garam kasar merisa jaya 1kg', 1, 3000.00, '2026-07-08 23:31:20', '2026-07-08 23:31:20'),
(25, 24, 23, 'garam kasar merisa jaya 1kg', 1, 3000.00, '2026-07-09 11:20:20', '2026-07-09 11:20:20'),
(26, 27, 22, 'garam kasar merisa jaya 5kg', 100, 11500.00, '2026-07-12 09:22:44', '2026-07-12 09:22:44'),
(27, 27, 16, 'garam halus raisa jaya 4kg', 100, 23000.00, '2026-07-12 09:22:44', '2026-07-12 09:22:44'),
(28, 28, 23, 'garam kasar merisa jaya 1kg', 100, 3000.00, '2026-07-12 09:29:42', '2026-07-12 09:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_requests`
--

CREATE TABLE `password_reset_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_requests`
--

INSERT INTO `password_reset_requests` (`id`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ferdyanwardana123@gmail.com', 'completed', '2026-04-28 05:24:43', '2026-04-28 05:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `original_price` decimal(12,2) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `original_price`, `weight`, `stock`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(15, 'garam kasar merisa jaya 10kg', 'garam-kasar-merisa-jaya-10kg', 'Garam kasar berkualitas tinggi yang dihasilkan melalui proses seleksi dan pengolahan yang menjaga kemurnian serta kualitasnya.', 23000.00, NULL, 10, 1000000, 'products/AdOpVbC6zRHdw2XfZEnNZKJGoeV15E6zpgLLjqyU.png', 1, '2026-06-10 08:20:10', '2026-06-28 22:54:33'),
(16, 'garam halus raisa jaya 4kg', 'garam-halus-raisa-jaya-4kg', 'Garam halus berkualitas tinggi yang dihasilkan melalui proses seleksi dan pengolahan yang menjaga kemurnian serta kualitasnya.', 23000.00, NULL, 4, 1000000, 'products/4UIGII5pit1PD4Y9rdteGVXVgwzGOO3ABs1kxzI4.png', 1, '2026-06-10 08:24:56', '2026-06-27 08:38:30'),
(20, 'garam halus raisa jaya 1kg', 'garam-halus-raisa-jaya-1kg', 'Garam halus berkualitas tinggi yang dihasilkan melalui proses seleksi dan pengolahan yang menjaga kemurnian serta kualitasnya.', 5500.00, NULL, 1, 9999, 'products/zDWkkzmCSYfY491oOJoPgLpxBLaQfQnFF68WHj8O.png', 1, '2026-06-27 08:35:07', '2026-06-27 08:39:35'),
(21, 'garam halus raisa jaya 2kg', 'garam-halus-raisa-jaya-2kg', 'garam halus dengan kualitas terbaik', 12000.00, NULL, 2, 99999, 'products/PQm4aZuIlfksb52mNvh9d1k8IaZPLwKZYE0CPZ0q.png', 1, '2026-06-28 22:51:09', '2026-06-28 22:52:16'),
(22, 'garam kasar merisa jaya 5kg', 'garam-kasar-merisa-jaya-5kg', 'garam kasar dengan  kualitas terbaik', 11500.00, NULL, 5, 99999, 'products/sldN2IltVPgQbjcQbpYiGpGVDoLYp3I3SgY1bsMW.png', 1, '2026-06-28 22:53:51', '2026-06-28 22:53:51'),
(23, 'garam kasar merisa jaya 1kg', 'garam-kasar-merisa-jaya-1kg', 'garam kasar dengan kualitas terbaik', 3000.00, NULL, 1, 99999, 'products/S9zClFWNvXurchMzjgzRonmBuOoZWl1rIDOUsumC.png', 1, '2026-06-28 22:55:55', '2026-06-28 23:27:16');

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
('BwldZJSbVDPcllgmTJ2x2R6OpMDV16KiyPVkFK7A', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQXV3c3dQUHZUNjBvT3B4b2Z1dDNYOUtsVjNtRkUwM1dOUUI1MW9GUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1783626524),
('mgMi3Rca8SNhpNkzpKvj39CEfPxThfYoJhX29eij', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHladGNOa0RIeTNwbkphWHNEazVsNUF0WUpQSzRTQWJ3WE5IdkQwVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0L2RhdGEiO3M6NToicm91dGUiO3M6OToiY2FydC5kYXRhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783873243),
('ORZHOq3N88ErJYi5QpuavCE75EzFZerrVs0Jexvm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoickJyTU5JRW1SWkpDTHZKZDZjVjYzRnZpNHFINDV2WEpvYlY4SjlJYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnRzIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5yZXBvcnRzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1783874231),
('xWGSdScFfwPBdrDdWnr5JkRYJVSzfxcdoz0ccW4x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiT2ZFVHE5bXg4eExTbzhneG16aUNrUzVIYU5SSnRiS0FtQ2hybzV4diI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783873245),
('YQ1HGYK3VnZ9d6crgQs4tyfh6dONDcsMVDRS0vdL', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3FBWEo1amFoRExrbUNiY0dkSllQa1RuZ2JpbzhCMXE4bzJqTWZsMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vd25lci9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6Im93bmVyLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1785930484);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `profession`, `message`, `rating`, `avatar`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'ferdian', 'pemilik resto', 'produk berkualitas harga terjangkau', 5, 'testimonials/IdF7X0C4OcvbVkI7VseCb1XN1HupFv2dcL4ylHPQ.png', 1, '2026-06-10 08:32:44', '2026-06-10 08:32:44');

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
  `role` enum('admin','customer','owner') NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ferdian', 'akunpertama653@gmail.com', NULL, '$2y$12$BJJRqBBXaJufM.A3nWGCDODTuM8LT.hgjMO6SfRoQuNSon7tjTQ0.', 'admin', NULL, '2026-03-03 06:26:17', '2026-03-03 06:26:17'),
(2, 'ari wardana', 'ferdyanwardana123@gmail.com', NULL, '$2y$12$B2HPee7EbZmr4NzV0Dr9q.KA.UwE6.YnFqgfDIHQndyFfz8agPnia', 'customer', NULL, '2026-04-20 08:02:02', '2026-07-09 10:58:44'),
(3, 'Merisa Jaya', 'owner@merisajaya.com', NULL, '$2y$12$1qMpPtUMBTkPtZfM9uLz7.U1R7yMAfy/X3XsJSsabo40jcMT3E/xm', 'owner', NULL, '2026-04-28 05:21:03', '2026-06-26 09:52:50'),
(4, 'Wardana', 'catatanar07@gmail.com', NULL, '$2y$12$P2Dh/1TH3n00Q4jERT.OS.38/X2.tYWHjJ8xnueIDpGPgNnbKk/G.', 'admin', NULL, '2026-05-06 07:48:43', '2026-06-09 09:36:38'),
(5, 'dhika', 'dhika123@gmail.com', NULL, '$2y$12$iKcaieHnDwUa2qRazi5/O..9iODpaoqmrE3f8JtOwm8u7ZGDYlH7i', 'customer', NULL, '2026-07-09 10:36:02', '2026-07-09 10:36:02'),
(6, 'ari wardana', 'ariwardana1207@gmail.com', NULL, '$2y$12$UPWrya9P6CbZyOpixAFniuUQp6FNQDpiyZUxIZzct1ZWbuG21HsnS', 'owner', NULL, '2026-08-05 04:46:55', '2026-08-05 04:46:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_number_unique` (`invoice_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
