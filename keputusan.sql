-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2021 at 08:26 AM
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
(1, '13411', 'Icank', 'Laki-Laki', 27, 'SMA 1 Sentani', 'IPS', '2012', 1, '2021-07-31 15:08:27', '2021-07-31 15:08:27', NULL),
(2, 'Eman', '16411012', 'Laki-Laki', 32, 'SMA N2 Biak', 'IPA', '2007', 1, '2021-07-31 15:09:14', '2021-07-31 15:09:14', NULL),
(3, '14411', 'Hendrik', 'Laki-Laki', 27, 'SMA N2 APO', 'IPS', '2013', 1, '2021-07-31 15:10:15', '2021-07-31 15:10:15', NULL),
(4, '13410', 'Yahya Deo', 'Laki-Laki', 28, 'Sma Organda', 'IPS', '2013', 2, '2021-07-31 15:11:03', '2021-07-31 15:11:03', NULL),
(5, '13410', 'Billy Bonai', 'Laki-Laki', 30, 'Sma Timika', 'IPA', '2010', 2, '2021-07-31 15:11:53', '2021-07-31 15:11:53', NULL),
(6, '14410', 'Juan Mambrasar', 'Laki-Laki', 29, 'Sma N1 Biak', 'IPS', '2014', 2, '2021-07-31 15:12:54', '2021-07-31 15:12:54', NULL),
(7, '001', 'Charien Natalia Pei', 'Perempuan', 19, 'SMA Negeri 1 Wamena', 'IPA', '2020', 2, '2021-08-01 00:10:48', '2021-08-01 00:10:48', NULL),
(8, '002', 'Newius Maling', 'Laki-Laki', 22, 'SMK N 1 Sentani', 'Teknik Komputer', '2018', 2, '2021-08-01 00:11:31', '2021-08-01 00:11:31', NULL),
(9, '003', 'Elzy M Boingera', 'Perempuan', 19, 'SMK N 1 Sentani', 'Teknik Komputer', '2020', 1, '2021-08-01 00:12:15', '2021-08-01 00:12:15', NULL),
(10, '004', 'Maria Dolorosa', 'Perempuan', 20, 'SMA Khatolik Yos Sudarso', 'IPA', '2018', 2, '2021-08-01 00:13:00', '2021-08-01 00:13:00', NULL),
(11, '005', 'Zulfitra Surya', 'Laki-Laki', 20, 'SMK N 3 Jayapura', 'Teknik Komputer', '2020', 1, '2021-08-01 00:13:58', '2021-08-01 00:13:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `persyaratan`
--

CREATE TABLE `persyaratan` (
  `id` int(11) NOT NULL,
  `kd_persyaratan` varchar(5) DEFAULT NULL,
  `nm_persyaratan` varchar(191) DEFAULT NULL,
  `id_beasiswa` bigint(20) DEFAULT NULL,
  `type_persyaratan` enum('jawaban','pilihan') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pilihan_persyaratan`
--

CREATE TABLE `pilihan_persyaratan` (
  `id` int(11) NOT NULL,
  `id_persyaratan` int(11) NOT NULL,
  `pilihan` varchar(255) NOT NULL,
  `nilai_pilihan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pilihan_persyaratan`
--

INSERT INTO `pilihan_persyaratan` (`id`, `id_persyaratan`, `pilihan`, `nilai_pilihan`) VALUES
(6, 1, 'Buruh', 5),
(7, 1, 'Petani', 4),
(8, 1, 'swasta', 3),
(9, 1, 'Polisi', 2),
(10, 1, 'TNI', 1),
(16, 3, 'Petani', 3),
(17, 3, 'Nelayan', 2);

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
(1, '411', 'Teknik Informatika', '2021-07-27 11:50:55', '2021-07-27 11:51:21', NULL),
(2, '421', 'Sistem Informasi', '2021-07-31 09:42:22', '2021-07-31 16:35:16', NULL);

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
  `status_terima` enum('Layak','Tidak Layak') DEFAULT NULL,
  `tgl_seleksi` date DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `id_kouta` int(11) NOT NULL,
  `nilai` double(12,12) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `seleksi`
--

INSERT INTO `seleksi` (`id`, `kd_seleksi`, `thn_akademik`, `id_beasiswa`, `id_mahasiswa`, `status_terima`, `tgl_seleksi`, `id_prodi`, `id_kouta`, `nilai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'S0001', '2021', 1, 7, 'Layak', '2021-08-03', 2, 2, 0.400002200000, '2021-08-03 02:27:15', '2021-08-03 02:27:15', NULL),
(2, 'S0002', '2021', 1, 4, 'Layak', '2021-08-03', 2, 2, 0.400001800000, '2021-08-03 02:38:30', '2021-08-03 02:38:30', NULL),
(3, 'S0003', '2021', 1, 8, 'Tidak Layak', '2021-08-03', 2, 2, 0.200000180000, '2021-08-03 02:39:58', '2021-08-03 02:39:58', NULL),
(4, 'S21002', '2021', 1, 5, 'Layak', '2021-08-03', 2, 2, 0.384001200000, '2021-08-03 02:42:35', '2021-08-03 02:42:35', NULL),
(5, 'S21002', '2021', 1, 6, 'Layak', '2021-08-03', 2, 2, 0.600001400000, '2021-08-03 02:43:41', '2021-08-03 02:43:41', NULL);

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
-- Indexes for table `pilihan_persyaratan`
--
ALTER TABLE `pilihan_persyaratan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_persyaratan` (`id_persyaratan`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `seleksi`
--
ALTER TABLE `seleksi`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_kouta` (`id_kouta`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_seleksi`
--
ALTER TABLE `detail_seleksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kouta`
--
ALTER TABLE `kouta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `persyaratan`
--
ALTER TABLE `persyaratan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pilihan_persyaratan`
--
ALTER TABLE `pilihan_persyaratan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seleksi`
--
ALTER TABLE `seleksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
