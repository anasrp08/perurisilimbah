-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2020 at 06:51 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simbah`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `md_jenislimbah`
--

CREATE TABLE `md_jenislimbah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenislimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `md_jenislimbah`
--

INSERT INTO `md_jenislimbah` (`id`, `jenislimbah`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Limbah B3', '', NULL, NULL),
(2, 'Limbah Non B3', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `md_namalimbah`
--

CREATE TABLE `md_namalimbah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namalimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipelimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenislimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fisik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `md_namalimbah`
--

INSERT INTO `md_namalimbah` (`id`, `namalimbah`, `satuan`, `tipelimbah`, `jenislimbah`, `fisik`, `saldo`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Limbah Cair B3 Aqua Save', 'Liter', '-', 'Limbah B3', 'Cair', 12000, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(2, 'Limbah Cair B3 WTG', 'Liter', '-', 'Limbah B3', 'Cair', 3767, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(3, 'Limbah Cair B3 (Tasganu, Lab, Cemor,Persiapan, Tandiesdll)', 'Liter', '-', 'Limbah B3', 'Cair', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(4, 'Limbah Sludge Tinta Aquasave', 'Karung', '-', 'Limbah B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(5, 'Limbah Medis (Poliklinik)', 'Kantong', '-', 'Limbah B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(6, 'Tinta Ex Cetak Dalam Kemasan Kaleng @ 25 Kg', 'Kaleng', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(7, 'Kaleng Bekas Tinta Cetak, Kemesan Kaleng @ 5 Kg', 'Kaleng', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(8, 'Kaleng Bekas Tinta Cetak, Kemesan Kaleng @ 2.5 & 1 Kg', 'Kaleng', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(9, 'Tinta Ex Cetak Dalam Kemesan Drum @ 200 Liter', 'Drum', '-', 'Limbah B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(10, 'Limbah Sisiran LKU (Potongan Karung)', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(11, 'Limbah Pounch Bintang', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(12, 'Limbah Rajangan Hasil Cetakan Sementara (HCS)', 'Bal', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(13, 'Limbah Ex Kemesan Kimia', 'Buah', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(14, 'Ex Sample Laboratorium', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(15, 'Cetakan Gagal/Rusak', 'Lembar', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(16, 'Sampah B3 (Majun, Plastik, Kertas, Pallet,dll)', 'Karung', '-', 'Limbah B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(17, 'Oli Bekas ', 'Drum', '-', 'Limbah B3', 'Cair', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(18, 'Karet Blanket', 'Lembar', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(19, 'Limbah Lampu TL', 'Buah', '-', 'Limbah B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(20, 'Tinta Printer', 'Buah', '-', 'Limbah B3', 'Cair', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(21, 'Plastik Laminasi Bekas', 'Palet', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(22, 'Kemasan Bekas Kimia (drum)', 'Buah', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(23, 'Kemasan Bekas Kimia (Jerigen)', 'Buah', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(24, 'Elektronik (Ac, Aki, Duering)', 'Buah', '-', 'Limbah B3', 'Padat ', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(25, 'Careen Bekas', 'Buah', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(26, 'Brikyet Utas Tidak Sempurna (Bank Indonesia) & Nepal', 'Lembar', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(27, 'Silica', 'Kantong', '-', 'Limbah B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(28, 'Sampah Domestik', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(29, 'Peti Kayu,Lemari Kayu, meja kayu, dll', 'Buah', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(30, 'LKS', 'Lembar', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(31, 'Varnish', 'Drum', '-', 'Limbah B3', 'Cair', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(32, 'Sisiran Kertas', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(33, 'Kemasan Bekas Kimia ( Kempu )', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(34, 'Rajangan Plat', 'Kg', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(35, 'Mikro Filter', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(36, 'Sisiran Rol', 'Karung', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(37, 'Sampah Ekonomis (Besi)', 'Palet', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00'),
(38, 'Palet Feeder Bekas', 'Buah', '-', 'Limbah Non B3', 'Padat', 0, '-', '2020-02-04 17:00:00', '2020-02-04 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `md_penghasillimbah`
--

CREATE TABLE `md_penghasillimbah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direktorat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `md_penghasillimbah`
--

INSERT INTO `md_penghasillimbah` (`id`, `seksi`, `departemen`, `direktorat`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Seksi Desain', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(2, 'Seksi  Proof', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(3, 'Departemen Laboratorium', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(4, 'Departemen Perencanaan dan Rekayasa Teknologi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(5, 'Departemen Pengelolaan Limbah dan Utilitas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(6, 'Departemen Pelayanan Bank Indonesia', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(7, 'Departemen Production Planning and Inventory Control (PPIC) Uang RI', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(8, 'Departemen Persiapan Cetak Uang RI', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(9, 'Departemen Cetak Uang Kertas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(10, 'Departemen Khazanah dan Verifikasi Uang Kertas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(11, 'Departemen Produksi Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(12, 'Departemen Pemeliharaan Teknik SBU Uang RI', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(13, 'Departemen Penjualan Pelanggan Pemerintah Non BI', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(14, 'Departemen Perencanaan, Evaluasi, Monitoring dan Pengiriman Produk Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(15, 'Departemen Persiapan,Cetak dan Pemeliharaan Produk Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(16, 'Departemen Khazanah dan Verifikasi Produk Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(17, 'Departemen Pengadaan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(18, 'Departemen Kebijakan Pengadaan dan Pergudangan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(19, 'Departemen Fasilitas Umum', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(20, 'Departemen Human Resources Operations', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(21, 'Departemen Human Resources Business Partner and Industrial Relation', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(22, 'Departemen Strategic Human Resources Management', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(23, 'Departemen Pengamanan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(24, 'Departemen Pengamanan Elektronik dan K3', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(25, 'Departemen Pendidikan dan Pelatihan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(26, 'Departemen Penelitian dan Pengembangan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(27, 'Departemen Operasional Teknologi Informasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(28, 'Departemen Pengembangan Teknologi Informasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(29, 'Departemen Tata Kelola dan Kebijakan Teknologi Informasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(30, 'Departemen Keuangan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(31, 'Departemen Akuntansi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(32, 'Seksi Penjualan Uang Luar Negeri dan Logam Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(33, 'Seksi Penjualan Websheet dan Paspor Buku', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(34, 'Anak Perusahaan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(35, 'Seksi  Analisa Bahan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(36, 'Seksi  Validasi dan Standarisasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(37, 'Seksi  Jaminan Produk', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(38, 'Seksi  Fisik Investasi Mesin dan Kalibrasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(39, 'Seksi  Rekayasa Teknik', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(40, 'Seksi  Riset dan Pengembangan Operasional', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(41, 'Seksi  Operasional Limbah Produksi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(42, 'Seksi  Tata Kelola Utilitas Pabrik dan Limbah Produksi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(43, 'Seksi  Utilitas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(44, 'Seksi  Pelayanan Order Bank Indonesia', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(45, 'Unit  Pengelola Bahan Penunjang Utama', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(46, 'Seksi  Production Planning and Inventory Control (PPIC) Produk Uang Kertas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(47, 'Seksi Production Planning and Inventory Control (PPIC) Produk Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(48, 'Seksi  Penataan Hasil Verifikasi Produk Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(49, 'Seksi  Pengendalian Kualitas Produk', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(50, 'Seksi  Pembuatan Pelat dan Rol', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(51, 'Seksi  Pembuatan Acuan Cetak Logam dan Peralatan Penunjang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(52, 'Seksi  Sarana Penyedia Bahan dan Perangkat Penunjang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(53, 'Seksi  Cetak Rata', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(54, 'Seksi  Cetak Dalam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(55, 'Seksi  Cetak Nomor', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(56, 'Seksi Khazanah Cetak Uang Kertas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(57, 'Seksi  Khazanah Penyelesaian', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(58, 'Seksi  Verifikasi Lembar Besar', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(59, 'Seksi  Penyelesaian Lembar Kertas Uang Parsial dan Hasil Cetak Tidak Sempurna', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(60, 'Seksi  Penyelesaian Masinal', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(61, 'Seksi Khazanah Produk Akhir Uang Kertas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(62, 'Seksi  Cetak dan Sortir Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(63, 'Seksi  Khazanah Produksi Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(64, 'Seksi  Penyelesaian Produksi Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(65, 'Unit  Perencanaan dan Pemeliharaan Mesin Produksi Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(66, 'Seksi  Mekanikal Produksi Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(67, 'Seksi  Elektrikal Produksi Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(68, 'Seksi  Penjualan Produk Imigrasi dan BPN', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(69, 'Seksi  Penjualan Produk Bea Cukai dan Pajak', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(70, 'Seksi  Production Planning and Inventory Control (PPIC) Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(71, 'Seksi Evaluasi dan Monitoring', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(72, 'Seksi  Pengiriman', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(73, 'Seksi Pemeliharaan Teknik Produksi Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(74, 'Seksi  Persiapan Cetak', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(75, 'Seksi  Cetak Pita Cukai', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(76, 'Seksi  Cetak Paspor dan Buku', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(77, 'Seksi  Cetak Materai dan Dokumen Sekuriti', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(78, 'Seksi  Cetak Logam Non Uang dan Uang Luar Negri', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(79, 'Seksi  Verifikasi Produk Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(80, 'Seksi  Khazanah Pdks Awl', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(81, 'Seksi  Khazanah Pdks Akr', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(82, 'Seksi  Khazanah dan Finishing Produk Logam Non Uang dan Uang Luar Negri', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(83, 'Seksi  Pengadaan Barang Investasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(84, 'Seksi  Pengadaan Jasa dan Barang Umum', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(85, 'Seksi  Pengadaan Barang Non Investasi (Lokal)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(86, 'Seksi Pengadaan Barang Non Investasi (Impor) dan Administrasi Ekspor- Impor', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(87, 'Seksi Persiapan Pengadaan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(88, 'Seksi  Pergudangan dan Administrasi Jasa', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(89, 'Seksi Monitoring, Kebijakan Pengadaan dan Manajemen Pemasok', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(90, 'Seksi  Pemeliharaan Bangunan dan Penataan Lingkungan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(91, 'Seksi  Pelayanan Umum', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(92, 'Seksi  Remunerasi dan HRIS', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(93, 'Seksi  Pelayanan Karyawan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(94, 'Seksi  Hubungan Industrial', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(95, 'Seksi  Human Resources Business Partner', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(96, 'Seksi  Perencanaan SDM dan Manajemen Performa', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(97, 'Seksi  Pengembangan Sistem Manajemen SDM', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(98, 'Seksi  Pengembangan Talent dan Perencanaan Suksesi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(99, 'Seksi Hubungan Karyawan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(100, 'Seksi  Pengamanan Fisik, Personil dan Material', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(101, 'Seksi  Pengamanan Elektronik', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(102, 'Seksi  Keselamatan Kesehatan Kerja dan Damkar', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(103, 'Seksi  Pengelola Layanan User', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(104, 'Seksi  Infrastruktur Teknologi Informasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(105, 'Seksi  Pemeliharaan Sistem TeknoIogi Informasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(106, 'Seksi  Pengembangan Aplikasi Internal', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(107, 'Seksi  Pengembangan Aplikasi Enterprise', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(108, 'Seksi  Pengembangan Infrastruktur Teknologi Informasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(109, 'Seksi  Anggaran', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(110, 'Seksi  Perbendaharaan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(111, 'Seksi  Dana dan Piutang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(112, 'Seksi  Akuntansi Umum', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(113, 'Seksi  Akuntansi Biaya', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(114, 'Seksi  Perpajakan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(115, 'Unit  Analisa Bahan Baku', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(116, 'Unit  Analisa Bahan Penolong', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(117, 'Unit  Validasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(118, 'Unit  Standarisasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(119, 'Unit  Data Produk', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(120, 'Unit  Pemeriksaan Keaslian Produk', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(121, 'Unit  Perencanaan Fisik Investasi dan Kalibrasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(122, 'Unit  Pemasangan Fisik Investasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(123, 'Unit  Rekayasa Teknik Mekanikal', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(124, 'Unit  Rekayasa Teknik Bangunan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(125, 'Unit  Opersl dan Pemeliharaan Jaringan Induk Listrik', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(126, 'Unit  Opersl dan Pemeliharaan Tata Udara', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(127, 'Unit  Opersl dan Pemeliharaan Pengolahan Air Bersih', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(128, 'Unit  Pemeliharaan Mknkal dan Elektrikal Gedung', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(129, 'Unit  Pengendalian Kualitas Produk Uang Kertas Lini A', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(130, 'Unit  Pengendalian Kualitas Produk Uang Kertas Lini B', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(131, 'Unit  Pengendalian Kualitas Produk Ugam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(132, 'Unit  Pembuatan Pelat Cetak ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(133, 'Unit  Pembuatan Rol ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(134, 'Unit  Pembuatan Relief', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(135, 'Unit  Pembuatan Stempel', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(136, 'Unit  Sepuh dan Press', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(137, 'Unit  Persiapan Bahan dan Peralatan Penunjang Cetak Uang Kertas Lini A', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(138, 'Unit  Persiapan Bahan dan Peralatan Penunjang Cetak Uang Kertas Lini B', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(139, 'Unit  WSRT Cetak Uang Kertas Lini A', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(140, 'Unit  WSRT Cetak Uang Kertas Lini B', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(141, 'Unit  Cetak Rata Lini A ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(142, 'Unit  Cetak Rata Lini B ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(143, 'Unit  Cetak Dalam Lini A ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(144, 'Unit  Cetak Dalam Lini B ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(145, 'Unit  Cetak Nomor Lini A ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(146, 'Unit  Cetak Nomor Lini B ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(147, 'Unit Penerimaan dan Penyediaan Bahan Baku Uang Kertas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(148, 'Unit  Penghitungan Cetak Rata dan Cetak Dalam ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(149, 'Unit Penghitungan Penyelesaian Cetak (Shift ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(150, 'Unit Khazanah Cetak Lini B  (Shift – 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(151, 'Unit Pengelolaan LKUTU dan LKS Lini A dan B', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(152, 'Unit Penyediaan Lembar Kertas Uang Berseri Nomor (Shift – 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(153, 'Unit Penyediaan Cetak Nomor dan Finishing Lini A (Shift – 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(154, 'Unit Penyediaan Lembar Kertas Uang Belum Berseri Nomor (Shift – 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(155, 'Unit Penyediaan Cetak Nomor dan Finishing Lini B (Shift – 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(156, 'Unit  Verifikasi Lembar Kertas Uang Blanko', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(157, 'Unit  Verifikasi Lembar Kertas Uang Masinal', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(158, 'Unit  Verifikasi Lembar Kertas Uang Manual', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(159, 'Unit  Penyelesaian Lembar Kertas Uang (Lembar Kertas Uang) Parsial Lini A', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(160, 'Unit  Pengelolaan Hasil Cetak Tidak Sempurna  ( - 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(161, 'Unit Penyelesaian Lembar Kertas Uang (LKU) Parsial Lini B (Shift – 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(162, 'Unit  Penyelesaian Masinal Lini A ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(163, 'Unit  Penyelesaian Masinal Lini B  ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(164, 'Unit  Penyortiran Lini A ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(165, 'Unit Pengemasan dan Penyerahan Lini A', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(166, 'Unit Penyortiran, Pengemasan dan Penyerahan Lini B (Shift - 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(167, 'Unit  Pembuatan Sisi Uang Logam  ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(168, 'Unit  Cetak Uang Logam ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(169, 'Unit  Sortir Uang Logam ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(170, 'Unit  Khazanah Bahan Baku Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(171, 'Unit  Khazanah Cetak dan Penyerahan Ugam ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(172, 'Unit  Pembungkusan Uang Logam ( - 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(173, 'Unit  Pengemasan Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(174, 'Unit  Mekanikal Produksi Uang Kertas Lini A', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(175, 'Unit  Mekanikal Produksi Uang Kertas Lini B', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(176, 'Unit  Mekanikal Produksi Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(177, 'Unit  Elektrikal Produksi Uang Kertas Lini A', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(178, 'Unit  Elektrikal Produksi Uang Kertas Lini B', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(179, 'Unit  Elektrikal Produksi Uang Logam', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(180, 'Unit Korektor', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(181, 'Unit  Pengendalian Kualitas Produk', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(182, 'Unit Penataan Hasil', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(183, 'Unit Mekanikal Mesin Produksi Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(184, 'Unit Elektrikal Mesin Produksi Non Uang', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(185, 'Unit  Pembuatan Acuan Cetak ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(186, 'Unit  Cetak Pita Cukai HT ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(187, 'Unit  Cetak Pita Cukai MMEA', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(188, 'Unit  Cetak Paspor dan Buku ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(189, 'Unit  Penjilidan Masinal ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(190, 'Unit  Cetak Materai ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(191, 'Unit Cetak Dokumen Sekuriti', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(192, 'Unit  Awal Cetak Logam Non Uang dan Uang Luar Negri', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(193, 'Unit  Cetak Logam Non Uang dan Ugam Luar Negeri', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(194, 'Unit  Cetak Uang Kertas Luar Negeri ( 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(195, 'Unit Verifikasi Produk Pita Cukai HT', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(196, 'Unit  Verifikasi Produk Paspor dan Buku ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(197, 'Unit Verifikasi Produk Meterai dan Dokumen Sekuriti (Shift –1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(198, 'Unit Verifikasi Produk Pita Cukai MMEA', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(199, 'Unit  Khazanah Pdks Awl Pita Cukai ( ? 1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(200, 'Unit  Khazanah Produksi  Awal Paspor dan Buku ( ?1,2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(201, 'Unit Khazanah Produksi Awal Meterai dan Dokumen Sekuriti (Shift –1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(202, 'Unit Pengemasan Pita Cukai HT', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(203, 'Unit  Khazanah Produksi  Akhir Paspor dan Buku', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(204, 'Unit Khazanah Produksi Akhir Produk Meterai dan Dokumen Sekuriti (Shift –1, 2)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(205, 'Unit Pengelolaan Hasil Cetak Tidak Sempurna (HCTS) dan MMEA', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(206, 'Unit  Khazanah Produk Logam Non Uang dan Uang Luar Negri', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(207, 'Unit Verifikasi dan Finishing Produk Logam Non Uang dan Uang Luar Negeri', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(208, 'Unit  Gudang Area 1', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(209, 'Unit  Gudang Area 2', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(210, 'Unit  Gudang Area 3', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(211, 'Unit  Pengelolaan Data Inventory dan Jasa', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(212, 'Unit  Pemeliharaan dan Penataan Lingkungan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(213, 'Unit  Pemeliharaan Bangunan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(214, 'Unit  Remunerasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(215, 'Unit  HRIS', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(216, 'Unit  Pengelolaan Fasilitas', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(217, 'Unit  Pelayanan Kesehatan', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(218, 'Unit  Pelayanan Administrasi', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(219, 'Unit  Pengamanan Fisik ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(220, 'Unit  Pengamanan Personil dan Material', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(221, 'Unit  Opersl Pengamanan Elektronik ( ? 1, 2, 3)', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(222, 'Unit  Pemeliharaan Pengamanan Elektronik', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(223, 'Unit  Keselamatan Kesehatan Kerja', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(224, 'Unit  Pemadam Kebakaran', '-', '-', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `md_satuan`
--

CREATE TABLE `md_satuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `md_satuan`
--

INSERT INTO `md_satuan` (`id`, `satuan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Liter', '', NULL, NULL),
(2, 'M3', '', NULL, NULL),
(3, 'Kg', '', NULL, NULL),
(4, 'Ton', '', NULL, NULL),
(5, 'Lembar', '', NULL, NULL),
(6, 'Bilyet', '', NULL, NULL),
(7, 'Kaleng', '', NULL, NULL),
(8, 'Drum', '', NULL, NULL),
(9, 'Bal', '', NULL, NULL),
(10, 'Buah', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `md_tipelimbah`
--

CREATE TABLE `md_tipelimbah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipelimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fisik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenislimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `md_tipelimbah`
--

INSERT INTO `md_tipelimbah` (`id`, `tipelimbah`, `fisik`, `jenislimbah`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Sludge', 'Cair', 'B3', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `md_tps`
--

CREATE TABLE `md_tps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namatps` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenislimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipelimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitasarea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitasjumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fisik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `md_tps`
--

INSERT INTO `md_tps` (`id`, `namatps`, `jenislimbah`, `tipelimbah`, `kapasitasarea`, `satuan1`, `kapasitasjumlah`, `satuan2`, `fisik`, `created_at`, `updated_at`) VALUES
(1, 'TPS B3 I', 'Limbah B3', 'Abu ', '75', 'm2', '150', 'm3', 'Padat', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(2, 'TPS B3 II', 'Limbah B3', 'Sludge', '144', 'm2', '125', 'JB', 'Padat', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(3, 'TPS B3 III', 'Limbah B3', 'Sampah Kontaminasi', '144', 'm2', '125', 'JB', 'Padat', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(4, 'TPS B3 IV', 'Limbah B3', 'Kaleng', '180', 'm2', '50955', 'Buah', 'Padat', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(5, 'Kolam Limbah Cair', 'Limbah B3', 'Limbah Cair', '250', 'm3', '250', 'm3', 'Cair', '2020-02-03 17:00:00', '2020-02-03 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `md_vendorlimbah`
--

CREATE TABLE `md_vendorlimbah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namavendor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenislimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipelimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fisik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `md_vendorlimbah`
--

INSERT INTO `md_vendorlimbah` (`id`, `namavendor`, `jenislimbah`, `tipelimbah`, `fisik`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'PT Multihana Kreasindo', '1', 'Sludge', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(2, 'PT Nasional Hijau Lestari', '1', 'Sludge', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(3, 'PT Multihana Kreasindo', '1', 'Sampah Kontaminasi', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(4, 'PT Nasional Hijau Lestari', '1', 'Sampah Kontaminasi', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(5, 'PT Multihana Kreasindo', '1', 'Tinta Netralisasi', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(6, 'PT Nasional Hijau Lestari', '1', 'Tinta Netralisasi', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(7, 'PT Wastec Internasional', '1', 'Limbah Cair B3', 'Cair', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(8, 'PT PPLI', '1', 'Limbah Cair B3', 'Cair', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(9, 'PT PPLI', '1', 'Abu Pembakaran', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00'),
(10, 'PT Garuda Logistik', '2', 'Sisiran LKU', 'Padat', '-', '2020-02-03 17:00:00', '2020-02-03 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '2014_10_12_000000_create_users_table', 1),
(16, '2014_10_12_100000_create_password_resets_table', 1),
(17, '2019_08_19_000000_create_failed_jobs_table', 1),
(18, '2020_01_30_054846_laratrust_setup_tables', 1),
(19, '2020_01_31_011800_create_md_jenislimbah', 1),
(21, '2020_01_31_012916_create_md_tipelimbah', 1),
(22, '2020_01_31_013023_create_md_vendorlimbah', 1),
(24, '2020_01_31_013208_create_md_penghasillimbah', 1),
(26, '2020_01_31_023757_create_tr_proseslimbah', 1),
(27, '2020_01_31_025952_create_md_satuan', 1),
(28, '2020_01_31_015623_create_tr_mutasilimbah', 1),
(29, '2020_01_31_012600_create_md_namalimbah', 1),
(30, '2020_01_31_013124_create_md_tps', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', NULL, '2020-02-02 21:50:52', '2020-02-02 21:50:52'),
(2, 'operator', 'Operator', NULL, '2020-02-02 21:50:53', '2020-02-02 21:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\User'),
(2, 2, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `tr_mutasilimbah`
--

CREATE TABLE `tr_mutasilimbah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namalimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl` date NOT NULL,
  `asallimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenislimbah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fisik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mutasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tps` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limbah3r` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tr_mutasilimbah`
--

INSERT INTO `tr_mutasilimbah` (`id`, `namalimbah`, `tgl`, `asallimbah`, `jenislimbah`, `fisik`, `mutasi`, `jumlah`, `satuan`, `tps`, `limbah3r`, `created_at`, `updated_at`) VALUES
(1, 'Limbah Cair B3 Aqua Save', '2020-02-08', 'Departemen Perencanaan dan Rekayasa Teknologi', 'Limbah B3', 'Cair', 'Input', 2000, 'Liter', 'TPS B3 II', '-', '2020-02-05 17:00:00', NULL),
(2, 'Limbah Cair B3 WTG', '2020-02-06', 'Seksi  Proof', 'Limbah B3', 'Cair', 'Input', 5000, 'Liter', 'TPS B3 III', NULL, '2020-02-05 17:00:00', NULL),
(3, 'asdas', '2020-02-06', 'teknologi informasi', 'Limbah B3', 'Sludge', 'Input', 21, 'karung', 'TPS B3 1', '-', '2020-02-05 17:00:00', NULL),
(4, 'Limbah Cair B3 WTG', '2020-02-06', 'Seksi Desain', 'Limbah B3', 'Cair', 'Input', 10000, 'Liter', 'Kolam Limbah Cair', '-', NULL, NULL),
(5, 'Limbah Cair B3 WTG', '2020-02-06', 'Departemen Laboratorium', 'Limbah Non B3', 'Cair', 'Input', 10000, 'M3', 'TPS B3 III', 'y', NULL, NULL),
(6, 'Limbah Cair B3 WTG', '2020-02-06', 'Seksi  Proof', 'Limbah Non B3', 'Padat', 'Input', 1233, 'M3', 'TPS B3 III', 'y', NULL, NULL),
(7, 'Limbah Cair B3 WTG', '2020-02-07', 'Departemen Perencanaan dan Rekayasa Teknologi', 'Limbah Non B3', 'Padat', 'Input', 21, 'Ton', 'TPS B3 II', 't', NULL, NULL),
(8, 'Tinta Ex Cetak Dalam Kemasan Kaleng @ 25 Kg', '2020-02-13', 'Departemen Laboratorium', 'Limbah Non B3', 'Cair', 'Input', 12, 'Kg', 'TPS B3 III', 't', NULL, NULL),
(9, 'Limbah Cair B3 Aqua Save', '2020-02-05', 'Departemen Perencanaan dan Rekayasa Teknologi', 'Limbah B3', 'Cair', 'Input', 10000, 'Liter', 'TPS B3 II', '-', NULL, NULL),
(10, 'Limbah Cair B3 Aqua Save', '2020-02-07', 'Departemen Perencanaan dan Rekayasa Teknologi', 'Limbah B3', 'Cair', 'Input', 10000, 'Liter', 'TPS B3 II', '-', NULL, NULL),
(11, 'Limbah Cair B3 Aqua Save', '2020-02-08', 'Departemen Perencanaan dan Rekayasa Teknologi', 'Limbah B3', 'Cair', 'Input', 1233, 'Liter', 'TPS B3 II', '-', NULL, NULL),
(12, 'Oli Bekas', '2020-02-08', 'Departemen Perencanaan dan Rekayasa Teknologi', 'Limbah B3', 'Cair', 'Input', 5000, 'Drum', 'TPS B3 II', '-', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tr_proseslimbah`
--

CREATE TABLE `tr_proseslimbah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idlimbah` int(11) NOT NULL,
  `proses` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mutasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `is_verified`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Limbah', 'admin@limbahperuri', 'admin_avatar.jpg', NULL, '$2y$10$EN6bKMvmXY0bT0Txoej6b.bEzJit0o5p9OfQ2w8Vk3.oQ2tzwluiy', 1, NULL, '2020-02-02 21:50:53', '2020-02-02 21:50:53'),
(2, 'Operator', 'operator@limbahperuri', 'operator_avatar.png', NULL, '$2y$10$rnQiZQBKo.deqbEWdXiZbesVLABiOp4KVjkX3hHWjnMQF/Kqtae6q', 1, NULL, '2020-02-02 21:50:53', '2020-02-02 21:50:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_jenislimbah`
--
ALTER TABLE `md_jenislimbah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_namalimbah`
--
ALTER TABLE `md_namalimbah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_penghasillimbah`
--
ALTER TABLE `md_penghasillimbah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_satuan`
--
ALTER TABLE `md_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_tipelimbah`
--
ALTER TABLE `md_tipelimbah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_tps`
--
ALTER TABLE `md_tps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_vendorlimbah`
--
ALTER TABLE `md_vendorlimbah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `tr_mutasilimbah`
--
ALTER TABLE `tr_mutasilimbah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tr_proseslimbah`
--
ALTER TABLE `tr_proseslimbah`
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `md_jenislimbah`
--
ALTER TABLE `md_jenislimbah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `md_namalimbah`
--
ALTER TABLE `md_namalimbah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `md_penghasillimbah`
--
ALTER TABLE `md_penghasillimbah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `md_satuan`
--
ALTER TABLE `md_satuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `md_tipelimbah`
--
ALTER TABLE `md_tipelimbah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `md_tps`
--
ALTER TABLE `md_tps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `md_vendorlimbah`
--
ALTER TABLE `md_vendorlimbah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tr_mutasilimbah`
--
ALTER TABLE `tr_mutasilimbah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tr_proseslimbah`
--
ALTER TABLE `tr_proseslimbah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
