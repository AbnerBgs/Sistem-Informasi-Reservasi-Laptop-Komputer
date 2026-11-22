-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Nov 2026 pada 11.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_service_laptop`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `estimated_cost` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `estimated_cost`) VALUES
(1, 'Perbaikan Hardware (LCD/Keyboard/Baterai)', 'Rp 150.000 - Rp 1.500.000'),
(2, 'Install Ulang & Software', 'Rp 75.000 - Rp 150.000'),
(3, 'Upgrade RAM/SSD & Maintenance', 'Rp 100.000 - Rp 800.000'),
(4, 'Mati Total / Cek Awal', 'Gratis Cek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `ticket_code` varchar(30) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `device_type` enum('Laptop', 'PC / Komputer', 'MacBook') NOT NULL,
  `device_brand` varchar(100) NOT NULL,
  `problem_description` text NOT NULL,
  `damage_photo` varchar(255) DEFAULT NULL,
  `status` enum('pending','proses','selesai','diambil') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `ticket_code`, `customer_name`, `customer_phone`, `category_id`, `device_type`, `device_brand`, `problem_description`, `damage_photo`, `status`, `created_at`) VALUES
(2, 'TK-20261118-7A0C', 'Tes admin 1', '089638401426', NULL, 'Laptop', 'Asus', 'gagal menerima sinyal wifi dengan baik, padahal di rumah, anggota yang makai aman aman aja tapi pas aku pakai tuh mengalami nge lag.', NULL, 'pending', '2026-11-18 05:17:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktur dari tabel `service_status_history`
--

CREATE TABLE `service_status_history` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `status` enum('pending','proses','selesai','diambil') NOT NULL,
  `changed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Admin Utama', 'admin@gmail.com', '$2y$10$tLskXnnbRre07iZAE7AsKO4jMxgvek9duqGInd2LYOArlLlLDum1O', '2026-11-17 16:52:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_code` (`ticket_code`),
  ADD KEY `fk_service_category` (`category_id`);

ALTER TABLE `service_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status_history_service` (`service_id`),
  ADD KEY `idx_status_history_user` (`changed_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `service_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_service_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

ALTER TABLE `service_status_history`
  ADD CONSTRAINT `fk_status_history_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_status_history_user` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `services`
  MODIFY `device_type` enum('Laptop','PC / Komputer','MacBook') NOT NULL;

INSERT INTO `service_status_history` (`service_id`, `status`, `changed_by`, `created_at`)
SELECT `id`, `status`, NULL, `created_at`
FROM `services`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
