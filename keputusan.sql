-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2021 at 03:53 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keputusan`
--

-- --------------------------------------------------------

--
-- Table structure for table `beasiswa`
--

CREATE TABLE `beasiswa` (
  `id` bigint(20) NOT NULL,
  `kd_beasiswa` varchar(5) DEFAULT NULL,
  `nm_beasiswa` varchar(191) DEFAULT NULL,
  `sumber` varchar(191) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `beasiswa`
--

INSERT INTO `beasiswa` (`id`, `kd_beasiswa`, `nm_beasiswa`, `sumber`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BTIF0', 'Beasiswa Tahun 2021', 'Kemendikbud', 125000000, '2021-07-27 17:23:30', '2021-07-27 17:24:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bobot`
--

CREATE TABLE `bobot` (
  `id` int(11) NOT NULL,
  `thn_akademik` varchar(4) DEFAULT NULL,
  `id_persyaratan` int(11) DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `bobot`
--

INSERT INTO `bobot` (`id`, `thn_akademik`, `id_persyaratan`, `bobot`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2021', 1, 5, '2021-07-27 22:55:19', '2021-07-27 22:55:19', NULL),
(2, '2021', 2, 4, '2021-07-27 22:55:43', '2021-07-27 22:55:43', NULL),
(3, '2021', 3, 3, '2021-07-27 22:56:00', '2021-07-27 22:56:00', NULL),
(4, '2021', 4, 2, '2021-07-27 22:58:28', '2021-07-27 22:58:28', NULL),
(5, '2021', 5, 2, '2021-07-27 22:58:50', '2021-07-27 23:11:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_seleksi`
--

CREATE TABLE `detail_seleksi` (
  `id` bigint(20) NOT NULL,
  `id_seleksi` bigint(20) DEFAULT NULL,
  `id_mahasiswa` bigint(20) DEFAULT NULL,
  `id_persyaratan` int(11) DEFAULT NULL,
  `jawaban` varchar(191) DEFAULT NULL,
  `bobot` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `detail_seleksi`
--

INSERT INTO `detail_seleksi` (`id`, `id_seleksi`, `id_mahasiswa`, `id_persyaratan`, `jawaban`, `bobot`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '1500000', '5', '2021-07-28 01:44:04', '2021-07-31 09:14:21', NULL),
(2, 1, 1, 2, '6', '4', '2021-07-28 01:44:04', '2021-07-31 09:14:21', NULL),
(3, 1, 1, 3, '4', '3', '2021-07-28 01:44:04', '2021-07-31 09:14:21', NULL),
(4, 1, 1, 4, '3.75', '2', '2021-07-28 01:44:04', '2021-07-31 09:14:21', NULL),
(5, 1, 1, 5, '21', '2', '2021-07-28 01:44:04', '2021-07-31 09:14:21', NULL),
(16, 6, 3, 1, '2000000', '5', '2021-07-31 09:45:35', '2021-07-31 09:45:35', NULL),
(17, 6, 3, 2, '3', '4', '2021-07-31 09:45:35', '2021-07-31 09:45:35', NULL),
(18, 6, 3, 3, '4', '3', '2021-07-31 09:45:35', '2021-07-31 09:45:35', NULL),
(19, 6, 3, 4, '3.75', '2', '2021-07-31 09:45:35', '2021-07-31 09:45:35', NULL),
(20, 6, 3, 5, '20', '2', '2021-07-31 09:45:35', '2021-07-31 09:45:35', NULL),
(21, 7, 4, 1, '1500000', '5', '2021-07-31 10:13:01', '2021-07-31 10:13:01', NULL),
(22, 7, 4, 2, '5', '4', '2021-07-31 10:13:01', '2021-07-31 10:13:01', NULL),
(23, 7, 4, 3, '4', '3', '2021-07-31 10:13:01', '2021-07-31 10:13:01', NULL),
(24, 7, 4, 4, '3.75', '2', '2021-07-31 10:13:01', '2021-07-31 10:13:01', NULL),
(25, 7, 4, 5, '17', '2', '2021-07-31 10:13:01', '2021-07-31 10:13:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kouta`
--

CREATE TABLE `kouta` (
  `id` int(11) NOT NULL,
  `thn_akademik` varchar(4) DEFAULT NULL,
  `id_beasiswa` bigint(20) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `kouta` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kouta`
--

INSERT INTO `kouta` (`id`, `thn_akademik`, `id_beasiswa`, `id_prodi`, `kouta`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2021', 1, 1, 30, '2021-07-27 18:21:49', '2021-07-27 18:22:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` bigint(20) NOT NULL,
  `npm` varchar(5) DEFAULT NULL,
  `nama` varchar(191) DEFAULT NULL,
  `jk` enum('Laki-Laki','Perempuan') DEFAULT NULL,
  `umur` tinyint(4) DEFAULT NULL,
  `asal_slta` varchar(191) DEFAULT NULL,
  `jurusan_slta` varchar(191) DEFAULT NULL,
  `thn_lulus` varchar(4) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `npm`, `nama`, `jk`, `umur`, `asal_slta`, `jurusan_slta`, `thn_lulus`, `id_prodi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '90909', 'PDF', 'Laki-Laki', 19, 'Jakarta', 'IPA', '2012', 1, '2021-07-27 12:17:36', '2021-07-27 12:25:35', NULL),
(3, '13411', 'Hendrik', 'Laki-Laki', 20, 'APO', 'IPA', '2020', 2, '2021-07-31 09:42:56', '2021-07-31 09:43:24', NULL),
(4, '13411', 'icank', 'Laki-Laki', 30, 'SMA 1 Sentani', 'IPS', '2012', 1, '2021-07-31 10:09:53', '2021-07-31 10:09:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `persyaratan`
--

CREATE TABLE `persyaratan` (
  `id` int(11) NOT NULL,
  `kd_persyaratan` varchar(5) DEFAULT NULL,
  `nm_persyaratan` varchar(191) DEFAULT NULL,
  `id_beasiswa` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `persyaratan`
--

INSERT INTO `persyaratan` (`id`, `kd_persyaratan`, `nm_persyaratan`, `id_beasiswa`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'P0121', 'Penghasilan Orang Tua', 1, '2021-07-27 18:40:05', '2021-07-27 23:10:31', NULL),
(2, 'P0221', 'Jumlah Tanggungan', 1, '2021-07-27 18:41:08', '2021-07-27 18:41:08', NULL),
(3, 'P0321', 'Semester', 1, '2021-07-27 18:41:44', '2021-07-27 18:43:21', NULL),
(4, 'P0421', 'IPK', 1, '2021-07-27 18:43:46', '2021-07-27 18:43:46', NULL),
(5, 'P0521', 'Usia', 1, '2021-07-27 18:44:04', '2021-07-27 18:44:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `kd_prodi` varchar(5) DEFAULT NULL,
  `nm_prodi` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `kd_prodi`, `nm_prodi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TIF01', 'Teknik Informatika', '2021-07-27 11:50:55', '2021-07-27 11:51:21', NULL),
(2, 'TIF02', 'Sistem Informasi', '2021-07-31 09:42:22', '2021-07-31 09:42:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seleksi`
--

CREATE TABLE `seleksi` (
  `id` bigint(20) NOT NULL,
  `kd_seleksi` varchar(10) DEFAULT NULL,
  `thn_akademik` varchar(4) DEFAULT NULL,
  `id_beasiswa` bigint(20) DEFAULT NULL,
  `id_mahasiswa` bigint(20) DEFAULT NULL,
  `status_terima` enum('Y','N') DEFAULT NULL,
  `tgl_seleksi` date DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `seleksi`
--

INSERT INTO `seleksi` (`id`, `kd_seleksi`, `thn_akademik`, `id_beasiswa`, `id_mahasiswa`, `status_terima`, `tgl_seleksi`, `id_prodi`, `nilai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'S21001', '2021', 1, 1, NULL, '2021-07-28', 1, 0.00750009, '2021-07-28 00:48:32', '2021-07-28 00:49:31', NULL),
(6, 'S21002', '2021', 1, 3, NULL, '2021-07-31', 2, 0.00100001, '2021-07-31 09:44:47', '2021-07-31 09:44:47', NULL),
(7, 'S21003', '2021', 1, 4, NULL, '2021-07-31', 1, 0.00750007, '2021-07-31 10:11:25', '2021-07-31 10:11:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `kd_user` varchar(20) DEFAULT NULL,
  `nama` varchar(191) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `level` enum('tu','prodiTi','prodiSi') DEFAULT NULL,
  `jabatan` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `kd_user`, `nama`, `username`, `password`, `level`, `jabatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'U-001', 'Bagian TU', 'bagiantu', '$2y$10$BNhFQsSVrbqyC06c1gtv6uKeZH5dnby0SaYG24VQq9fXsRnL8I37m', 'tu', 'Staff', NULL, NULL, NULL),
(6, 'U-002', 'Prodi Teknik Informatika', 'prodiTi', '$2y$10$nkVstqqqnC.4WyOwFNrJHO86suyAIpBzXTqsNdxDgkdNfJnutSthO', 'prodiTi', 'Staff', '2021-07-31 10:40:22', '2021-07-31 10:40:22', NULL),
(7, 'U-003', 'Prodi Sistem Informasi', 'prodiSi', '$2y$10$wqsaIPIf8un6IndEIbP5ROpvd11X0UlinuPaX38WDQNsB6DSVfcby', 'prodiSi', 'Staff', '2021-07-31 10:40:22', '2021-07-31 10:40:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `bobot`
--
ALTER TABLE `bobot`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `detail_seleksi`
--
ALTER TABLE `detail_seleksi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `kouta`
--
ALTER TABLE `kouta`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `seleksi`
--
ALTER TABLE `seleksi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bobot`
--
ALTER TABLE `bobot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detail_seleksi`
--
ALTER TABLE `detail_seleksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `kouta`
--
ALTER TABLE `kouta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `persyaratan`
--
ALTER TABLE `persyaratan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seleksi`
--
ALTER TABLE `seleksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
