-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2026 at 10:11 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tinggal_klik`
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
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `lapangan`
--

CREATE TABLE `lapangan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama_lapangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_olahraga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_per_jam` int NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_lapangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('tersedia','pemeliharaan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`id`, `user_id`, `nama_lapangan`, `jenis_olahraga`, `harga_per_jam`, `deskripsi`, `foto_lapangan`, `lokasi`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Lapangan Futsal Merdeka', 'Futsal', 100000, 'Lapangan futsal indoor berstandar nasional dengan rumput sintetis berkualitas tinggi, pencahayaan LED, dan ruang ganti tersedia.', NULL, 'Sudirman, Jakarta Pusat', 'tersedia', '2026-07-12 04:20:08', '2026-07-13 04:34:43'),
(2, 4, 'Lapangan Badminton Sentosa', 'Badminton', 75000, 'Lapangan badminton indoor dengan lantai kayu parket anti-slip, net standar BWF, dan sistem ventilasi yang baik.', NULL, 'Kelapa Gading, Jakarta Utara', 'tersedia', '2026-07-12 04:20:08', '2026-07-13 04:34:43'),
(3, 4, 'Lapangan Basket Hall Diponegoro', 'Basket', 120000, 'Lapangan basket outdoor half-court dengan ring standar NBA, permukaan aspal halus, dan tersedia penerangan untuk malam hari.', NULL, 'Menteng, Jakarta Pusat', 'pemeliharaan', '2026-07-12 04:20:08', '2026-07-13 04:34:43'),
(4, 4, 'Tennis Court Bukit Mas', 'Tennis', 95000, 'Lapangan tennis outdoor berkualitas tinggi dengan permukaan keras (hard court).', NULL, 'Dago, Bandung', 'tersedia', '2026-07-12 04:20:08', '2026-07-13 04:34:43'),
(5, 4, 'Voli Pantai Ancol', 'Voli', 60000, 'Lapangan voli pantai dengan pasir putih lembut di kawasan pantai Ancol.', NULL, 'Ancol, Jakarta Utara', 'tersedia', '2026-07-12 04:20:08', '2026-07-13 04:34:43'),
(6, 4, 'Erlangga Futsal', 'Futsal', 15000, 'lapangan ini bagus sekali', 'lapangan/j2AZjmgkcFOWZ7oXjZr9aZScjlGSUypol6QBTste.jpg', 'Jalan Bandung', 'tersedia', '2026-07-13 05:24:35', '2026-07-13 05:24:35'),
(7, 4, 'Kolam Renang Sukohati', 'Renang', 25000, 'Tempat renang yang bagus', 'lapangan/NZngXHwjsqSw7GNfeIFDSBKhVA2dQqXh9inyNq9X.png', '|-6.940751941383672, 107.72985741738205', 'tersedia', '2026-07-13 06:35:25', '2026-07-13 07:06:48'),
(8, 4, 'Lapangan Bung Rehan', 'Futsal', 7000, 'fasilitas bagus lapangan mantap', 'lapangan/wDzmhlKNpRgnOQzNWlC6gNurz23V2DOFCQ598stE.jpg', 'Jl paviliun nomor 69|-6.938516742144495, 107.71014224922118', 'tersedia', '2026-07-13 10:41:54', '2026-07-13 10:41:54');

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
(4, '2026_07_06_052709_create_lapangan_table', 1),
(5, '2026_07_06_052825_create_pemesanan_table', 1),
(6, '2026_07_06_052927_create_ulasan_table', 1),
(7, '2026_07_06_100000_add_role_to_users_table', 1),
(8, '2026_07_12_000001_create_bookings_table', 1),
(9, '2026_07_12_000002_create_transactions_table', 1),
(10, '2026_07_12_100000_update_lapangan_table_add_user_id_lokasi_indexes', 1),
(11, '2026_07_13_111635_create_withdrawals_table', 2),
(12, '2026_07_13_162341_add_foto_to_users_table', 3);

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
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lapangan_id` bigint UNSIGNED NOT NULL,
  `tanggal_pesan` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_durasi` tinyint UNSIGNED NOT NULL,
  `total_harga` int NOT NULL,
  `status_pembayaran` enum('belum_bayar','lunas','batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_bayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `user_id`, `lapangan_id`, `tanggal_pesan`, `jam_mulai`, `jam_selesai`, `total_durasi`, `total_harga`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 2, 5, '2026-07-13', '14:34:00', '17:34:00', 3, 180000, 'belum_bayar', '2026-07-12 06:39:40', '2026-07-12 06:39:40'),
(2, 2, 2, '2026-07-12', '20:40:00', '21:40:00', 1, 75000, 'belum_bayar', '2026-07-12 06:41:43', '2026-07-12 06:41:43'),
(3, 2, 2, '2026-07-12', '12:00:00', '13:00:00', 1, 75000, 'belum_bayar', '2026-07-12 06:42:42', '2026-07-12 06:42:42'),
(4, 2, 1, '2026-07-12', '21:47:00', '22:47:00', 1, 100000, 'batal', '2026-07-12 07:47:50', '2026-07-12 08:04:14'),
(5, 2, 1, '2026-07-12', '16:47:00', '18:47:00', 2, 200000, 'lunas', '2026-07-12 07:52:09', '2026-07-12 08:04:15'),
(6, 2, 5, '2026-07-12', '22:06:00', '23:06:00', 1, 60000, 'lunas', '2026-07-12 08:06:47', '2026-07-12 08:07:05'),
(7, 3, 1, '2026-07-13', '18:48:00', '19:48:00', 1, 100000, 'lunas', '2026-07-13 04:49:26', '2026-07-13 04:51:26'),
(8, 2, 7, '2026-07-13', '21:08:00', '22:08:00', 1, 25000, 'lunas', '2026-07-13 07:08:09', '2026-07-13 07:08:49'),
(9, 2, 7, '2026-07-13', '09:20:00', '10:20:00', 1, 25000, 'lunas', '2026-07-13 07:21:16', '2026-07-13 07:21:38'),
(10, 2, 5, '2026-07-14', '15:30:00', '19:30:00', 4, 240000, 'lunas', '2026-07-13 10:30:52', '2026-07-13 10:31:18'),
(11, 2, 8, '2026-07-14', '11:43:00', '12:43:00', 1, 7000, 'belum_bayar', '2026-07-13 10:43:29', '2026-07-13 10:43:29'),
(12, 2, 8, '2026-07-14', '13:43:00', '14:43:00', 1, 7000, 'belum_bayar', '2026-07-13 10:45:03', '2026-07-13 10:45:03'),
(13, 2, 8, '2026-07-14', '15:43:00', '16:43:00', 1, 7000, 'lunas', '2026-07-13 10:45:32', '2026-07-13 10:46:02');

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
('A5RIZIYi9hk8ZXfUWzVgVCbCi2qXUg55ODcKhCM5', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'eyJfdG9rZW4iOiJvU1ZDWXUzRE1DNkRtSXdZSWlRbWRlbU1idjVWbEJCS1N3TU5xTnVOIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL293bmVyXC93aXRoZHJhd2FsXC9yZXF1ZXN0Iiwicm91dGUiOiJvd25lci53aXRoZHJhd2FsLmNyZWF0ZSJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NH0=', 1783964865),
('buQq277zFAXb0gaqjdGgLNuIdIzWX7RMMUsy67IQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'eyJfdG9rZW4iOiJrN0JRenNrQWtxRlpFbjNobWQ0NXpIOWFOWkt4MnJJcjZIZjdKWWVtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1784023290);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `pemesanan_id` bigint UNSIGNED NOT NULL,
  `gross_amount` int NOT NULL,
  `platform_fee` int NOT NULL,
  `net_amount` int NOT NULL,
  `kode_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `pemesanan_id`, `gross_amount`, `platform_fee`, `net_amount`, `kode_transaksi`, `bukti_transfer`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(2, 4, 100000, 2000, 98000, 'TRX-1783867670-U2', NULL, 'failed', '2026-07-12 07:47:50', '2026-07-12 08:04:14'),
(3, 5, 200000, 4000, 196000, 'TRX-1783867929-U2', NULL, 'paid', '2026-07-12 07:52:09', '2026-07-12 08:04:15'),
(4, 6, 60000, 1200, 58800, 'TRX-1783868807-U2', NULL, 'paid', '2026-07-12 08:06:47', '2026-07-12 08:07:05'),
(5, 7, 100000, 2000, 98000, 'TRX-1783943366-U3', NULL, 'paid', '2026-07-13 04:49:26', '2026-07-13 04:51:26'),
(6, 8, 25000, 500, 24500, 'TRX-1783951689-U2', NULL, 'paid', '2026-07-13 07:08:09', '2026-07-13 07:08:49'),
(7, 9, 25000, 500, 24500, 'TRX-1783952476-U2', NULL, 'paid', '2026-07-13 07:21:16', '2026-07-13 07:21:38'),
(8, 10, 240000, 4800, 235200, 'TRX-1783963852-U2', NULL, 'paid', '2026-07-13 10:30:52', '2026-07-13 10:31:18'),
(9, 11, 7000, 140, 6860, 'TRX-1783964609-U2', NULL, 'unpaid', '2026-07-13 10:43:29', '2026-07-13 10:43:29'),
(10, 12, 7000, 140, 6860, 'TRX-1783964703-U2', NULL, 'unpaid', '2026-07-13 10:45:03', '2026-07-13 10:45:03'),
(11, 13, 7000, 140, 6860, 'TRX-1783964732-U2', NULL, 'paid', '2026-07-13 10:45:32', '2026-07-13 10:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lapangan_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id`, `user_id`, `lapangan_id`, `rating`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 5, 'lapangan nyaman enak', '2026-07-13 10:32:14', '2026-07-13 10:32:14'),
(2, 2, 8, 5, 'wah mantap sekali', '2026-07-13 10:46:34', '2026-07-13 10:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','owner','pelanggan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pelanggan',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `foto`) VALUES
(1, 'Admin TinggalKlik', 'admin@tinggalklik.com', 'admin', '2026-07-12 04:20:07', '$2y$12$7r5rlDrjvGO42yk81y0YceY.NxJrZAazVDKN4byQVukabRQzuxK9O', NULL, '2026-07-12 04:20:07', '2026-07-12 04:20:07', NULL),
(2, 'Budi Santoso', 'budi@tinggalklik.com', 'pelanggan', '2026-07-12 04:20:07', '$2y$12$1FRkF4vY7kFQSb9OkTuYq.A4D4mR8oFq2RWJiCpLKKDbayQeD9.8K', NULL, '2026-07-12 04:20:07', '2026-07-12 04:20:07', NULL),
(3, 'Siti Rahayu', 'siti@tinggalklik.com', 'pelanggan', '2026-07-12 04:20:07', '$2y$12$Dz5NxkWVQ5g8ku.k8hlAou9OM8n3nvtSQ1ptODYZHhMY1IBAKvtz6', NULL, '2026-07-12 04:20:07', '2026-07-12 04:20:07', NULL),
(4, 'Owner Lapangan Utama', 'owner@tinggalklik.com', 'owner', NULL, '$2y$12$0.8StJsM0sYsMZ8z0WG0OO5RRHDo6Kxz1oBdkKy8.cATIbmTwF16y', NULL, '2026-07-13 04:34:43', '2026-07-13 04:34:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jumlah_penarikan` int NOT NULL,
  `bank_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rekening` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `user_id`, `jumlah_penarikan`, `bank_tujuan`, `nomor_rekening`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 254800, 'BCA', '12345678', 'approved', '2026-07-13 04:41:56', '2026-07-13 04:41:56');

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

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
-- Indexes for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lapangan_jenis_olahraga` (`jenis_olahraga`),
  ADD KEY `idx_lapangan_status` (`status`),
  ADD KEY `idx_lapangan_user_id` (`user_id`);

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
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemesanan_user_id_foreign` (`user_id`),
  ADD KEY `pemesanan_lapangan_id_foreign` (`lapangan_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `transactions_pemesanan_id_foreign` (`pemesanan_id`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ulasan_user_id_foreign` (`user_id`),
  ADD KEY `ulasan_lapangan_id_foreign` (`lapangan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD CONSTRAINT `lapangan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_lapangan_id_foreign` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_pemesanan_id_foreign` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_lapangan_id_foreign` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
