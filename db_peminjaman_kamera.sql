-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.infinityfree.com
-- Generation Time: Apr 13, 2026 at 10:10 AM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41635470_db_peminjaman_kamera`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id` int(11) NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `kondisi` enum('baik','rusak') NOT NULL DEFAULT 'baik',
  `harga_sewa` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `nama_alat`, `id_kategori`, `stok`, `kondisi`, `harga_sewa`, `foto`) VALUES
(5, 'Sony A7 III', 2, 2, 'baik', 250000, '1776089395_69dcf93370d7f.jpg'),
(6, 'Fujifilm X-T4', 2, 2, 'baik', 180000, '1776088874_69dcf72a573bd.jpg'),
(7, 'Canon EOS R6', 2, 1, 'baik', 300000, NULL),
(8, 'Canon EF 50mm f/1.8', 3, 5, 'baik', 50000, NULL),
(9, 'Nikon AF-S 35mm f/1.8G', 3, 4, 'baik', 55000, NULL),
(10, 'Sony FE 85mm f/1.8', 3, 2, 'baik', 80000, NULL),
(11, 'Canon EF 24-70mm f/2.8L', 3, 2, 'baik', 120000, NULL),
(12, 'Manfrotto MT055XPRO3', 4, 5, 'baik', 30000, NULL),
(13, 'Benro A2883FS4', 4, 4, 'baik', 35000, NULL),
(14, 'Gitzo GT2542', 4, 2, 'baik', 50000, NULL),
(15, 'Godox SL-60W', 5, 4, 'baik', 40000, NULL),
(16, 'Aputure 120D Mark II', 5, 3, 'baik', 60000, NULL),
(17, 'Softbox 60x90cm', 5, 6, 'baik', 20000, NULL),
(18, 'Memory Card 64GB', 6, 10, 'baik', 15000, NULL),
(19, 'Battery Grip Canon', 6, 5, 'baik', 25000, NULL),
(20, 'Camera Bag', 6, 8, 'baik', 20000, NULL),
(21, 'Lens Filter UV 77mm', 6, 12, 'baik', 10000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(2, 'lensa'),
(3, 'tripod'),
(4, 'Kamera DSLR'),
(5, 'Kamera Mirrorless'),
(6, 'Lensa'),
(7, 'Tripod'),
(8, 'Lighting'),
(9, 'Aksesoris'),
(12, 'kamera');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `role` enum('admin','petugas','peminjam') NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `id_user`, `nama_user`, `role`, `aktivitas`, `keterangan`, `created_at`) VALUES
(1, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-20 14:48:34'),
(2, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-20 14:52:02'),
(3, 1, 'Administrator', 'admin', 'Tambah Alat', 'Menambahkan alat: kamera', '2026-02-20 14:55:46'),
(4, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-02-20 14:56:13'),
(5, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 15:00:05'),
(6, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 15:00:36'),
(7, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-02-20 15:01:08'),
(8, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-02-20 15:13:18'),
(9, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-20 15:13:38'),
(10, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-20 15:55:28'),
(11, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-02-20 15:55:48'),
(12, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 15:56:08'),
(13, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 15:56:34'),
(14, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-02-20 15:56:57'),
(15, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-02-20 15:57:17'),
(16, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 16:04:32'),
(17, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 16:04:46'),
(18, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 16:09:54'),
(19, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Gitzo GT2542 (Total: Rp 50.000, DP: Rp 50.000)', '2026-02-20 16:12:38'),
(20, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 16:13:53'),
(21, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-02-20 16:14:10'),
(22, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Gitzo GT2542', '2026-02-20 16:14:22'),
(23, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-02-20 16:14:36'),
(24, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 16:14:45'),
(25, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 16:15:05'),
(26, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 16:15:13'),
(27, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 16:15:29'),
(28, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-02-20 16:15:34'),
(29, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-02-20 19:12:21'),
(30, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 19:12:27'),
(31, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Fujifilm X-T4 (Total: Rp 360.000, DP: Rp 60.000)', '2026-02-20 19:13:56'),
(32, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 19:14:04'),
(33, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-02-20 19:14:08'),
(34, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Fujifilm X-T4', '2026-02-20 19:14:13'),
(35, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-02-20 19:14:18'),
(36, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 19:15:29'),
(37, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 19:15:45'),
(38, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-02-20 19:15:58'),
(39, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-02-20 19:17:01'),
(40, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 19:17:06'),
(41, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-20 19:26:14'),
(42, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-20 19:26:24'),
(43, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-23 07:45:45'),
(44, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-02-23 08:15:33'),
(45, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-23 08:16:30'),
(46, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-02-23 08:16:50'),
(47, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-02-23 08:17:02'),
(48, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-02-23 08:18:56'),
(49, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-23 08:19:10'),
(50, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-23 08:19:48'),
(51, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-02-23 12:22:57'),
(52, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-02-23 12:23:12'),
(53, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-11 03:39:37'),
(54, 1, 'Administrator', 'admin', 'Edit Alat', 'Mengubah data alat: kamera', '2026-04-11 03:40:05'),
(55, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-11 03:42:45'),
(56, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-11 03:43:16'),
(57, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-11 03:50:57'),
(58, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-11 03:51:09'),
(59, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-11 03:58:59'),
(60, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-11 03:59:11'),
(61, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:26:14'),
(62, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:43:13'),
(63, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-11 04:45:42'),
(64, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:46:27'),
(65, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:47:50'),
(66, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-11 04:49:00'),
(67, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:49:15'),
(68, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-11 04:52:18'),
(69, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:52:31'),
(70, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:54:35'),
(71, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-11 04:54:38'),
(72, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:54:59'),
(73, 1, 'Administrator', 'admin', 'Tambah Alat', 'Menambahkan alat: uput', '2026-04-11 04:56:01'),
(74, 1, 'Administrator', 'admin', 'Hapus Alat', 'Menghapus alat: uput', '2026-04-11 04:56:10'),
(75, 1, 'Administrator', 'admin', 'Edit User', 'Mengubah data user: Peminjam1', '2026-04-11 04:56:28'),
(76, 1, 'Administrator', 'admin', 'Edit User', 'Mengubah data user: Peminjam', '2026-04-11 04:56:36'),
(77, 1, 'Administrator', 'admin', 'Tambah User', 'Menambahkan user: uput (peminjam)', '2026-04-11 04:57:07'),
(78, 1, 'Administrator', 'admin', 'Hapus User', 'Menghapus user: uput', '2026-04-11 04:57:14'),
(79, 1, 'Administrator', 'admin', 'Hapus Kategori', 'Menghapus kategori ID: 10', '2026-04-11 04:57:37'),
(80, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-11 04:57:56'),
(81, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-11 04:58:43'),
(82, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Canon EOS R6 (Total: Rp 300.000)', '2026-04-11 05:07:56'),
(83, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-11 05:08:10'),
(84, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-11 05:09:00'),
(85, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Canon EOS R6', '2026-04-11 05:10:24'),
(86, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 06:39:09'),
(87, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 06:39:12'),
(88, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 06:39:48'),
(89, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Sony A7 III (Total: Rp 500.000)', '2026-04-12 06:40:34'),
(90, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 06:42:54'),
(91, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Sony A7 III', '2026-04-12 06:45:08'),
(92, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Memory Card 64GB (Total: Rp 30.000)', '2026-04-12 06:53:03'),
(93, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 07:18:47'),
(94, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:19:03'),
(95, 1, 'Administrator', 'admin', 'Tambah Alat', 'Menambahkan alat: alat', '2026-04-12 07:19:42'),
(96, 1, 'Administrator', 'admin', 'Hapus Alat', 'Menghapus alat: alat', '2026-04-12 07:19:52'),
(97, 1, 'Administrator', 'admin', 'Edit Alat', 'Mengubah data alat: kamera', '2026-04-12 07:20:10'),
(98, 1, 'Administrator', 'admin', 'Hapus Kategori', 'Menghapus kategori ID: 11', '2026-04-12 07:21:55'),
(99, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-12 07:22:07'),
(100, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:22:12'),
(101, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Memory Card 64GB', '2026-04-12 07:22:25'),
(102, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 07:22:56'),
(103, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:23:14'),
(104, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-12 07:23:51'),
(105, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-12 07:23:51'),
(106, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:23:58'),
(107, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 07:24:20'),
(108, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:24:25'),
(109, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:26:56'),
(110, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 07:27:38'),
(111, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:27:57'),
(112, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Canon EF 24-70mm f/2.8L (Total: Rp 120.000)', '2026-04-12 07:28:23'),
(113, 3, 'Peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-12 07:28:30'),
(114, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:28:39'),
(115, 2, 'Petugas', 'petugas', 'Reject Peminjaman', 'Menolak peminjaman alat: Canon EF 24-70mm f/2.8L - Alasan: bukti gajelas', '2026-04-12 07:30:42'),
(116, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Canon EOS 6D Mark II (Total: Rp 200.000)', '2026-04-12 07:31:53'),
(117, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-12 07:32:13'),
(118, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 07:32:19'),
(119, 2, 'Petugas', 'petugas', 'Reject Peminjaman', 'Menolak peminjaman alat: Canon EOS 6D Mark II - Alasan: barang diperbaiki', '2026-04-12 07:32:33'),
(120, 3, 'Peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 16:13:42'),
(121, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 16:14:29'),
(122, 3, 'Peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: kamera (Total: Rp 200.000)', '2026-04-12 16:14:29'),
(123, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: kamera', '2026-04-12 16:14:37'),
(124, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 17:31:33'),
(125, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:23:01'),
(126, 1, 'Administrator', 'admin', 'Edit Alat', 'Mengubah data alat: kamera', '2026-04-12 18:23:42'),
(127, 1, 'Administrator', 'admin', 'Edit Alat', 'Mengubah data alat: kamera', '2026-04-12 18:24:09'),
(128, 1, 'Administrator', 'admin', 'Hapus Alat', 'Menghapus alat: kamera', '2026-04-12 18:24:15'),
(129, 1, 'Administrator', 'admin', 'Hapus Kategori', 'Menghapus kategori ID: 1', '2026-04-12 18:26:14'),
(130, 1, 'Administrator', 'admin', 'Edit User', 'Mengubah data user: Peminjam1', '2026-04-12 18:26:54'),
(131, 1, 'Administrator', 'admin', 'Hapus User', 'Menghapus user: Peminjam1', '2026-04-12 18:27:03'),
(132, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-12 18:27:51'),
(133, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:27:57'),
(134, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 18:28:51'),
(135, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:29:26'),
(136, 1, 'Administrator', 'admin', 'Tambah User', 'Menambahkan user: peminjam (peminjam)', '2026-04-12 18:30:09'),
(137, 1, 'Administrator', 'admin', 'Edit User', 'Mengubah data user: peminjam', '2026-04-12 18:30:29'),
(138, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-12 18:30:37'),
(139, 5, 'peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:30:42'),
(140, 5, 'peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Canon EOS R6 (Total: Rp 300.000)', '2026-04-12 18:31:29'),
(141, 5, 'peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Canon EF 50mm f/1.8 (Total: Rp 50.000)', '2026-04-12 18:32:02'),
(142, 5, 'peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-12 18:32:17'),
(143, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:32:23'),
(144, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Canon EF 50mm f/1.8', '2026-04-12 18:32:33'),
(145, 2, 'Petugas', 'petugas', 'Reject Peminjaman', 'Menolak peminjaman alat: Canon EOS R6 - Alasan: barang rusak', '2026-04-12 18:32:42'),
(146, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 18:32:50'),
(147, 5, 'peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:32:55'),
(148, 5, 'peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-12 18:42:13'),
(149, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:42:25'),
(150, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 18:43:11'),
(151, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 18:45:33'),
(152, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 18:45:38'),
(153, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 19:01:43'),
(154, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 19:02:09'),
(155, 5, 'peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 19:02:24'),
(156, 5, 'peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Sony FE 85mm f/1.8 (Total: Rp 80.000)', '2026-04-12 19:03:25'),
(157, 5, 'peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-12 19:03:32'),
(158, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-12 19:03:40'),
(159, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Sony FE 85mm f/1.8', '2026-04-12 19:03:47'),
(160, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-12 19:04:09'),
(161, 5, 'peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-12 19:04:22'),
(162, 5, 'peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-13 00:15:43'),
(163, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-13 00:17:55'),
(164, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:15:26'),
(165, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-13 06:15:41'),
(166, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:15:49'),
(167, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-13 06:16:56'),
(168, 5, 'peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:17:03'),
(169, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:17:30'),
(170, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-13 06:18:08'),
(171, 5, 'peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:18:29'),
(172, 5, 'peminjam', 'peminjam', 'Ajukan Peminjaman', 'Mengajukan peminjaman alat: Gitzo GT2542 (Total: Rp 100.000)', '2026-04-13 06:18:53'),
(173, 5, 'peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-13 06:19:00'),
(174, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:19:06'),
(175, 2, 'Petugas', 'petugas', 'Approve Peminjaman', 'Menyetujui peminjaman alat: Gitzo GT2542', '2026-04-13 06:19:51'),
(176, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-13 06:19:58'),
(177, 5, 'peminjam', 'peminjam', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:20:19'),
(178, 5, 'peminjam', 'peminjam', 'Logout', 'User keluar dari sistem', '2026-04-13 06:20:39'),
(179, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:20:46'),
(180, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-13 06:21:17'),
(181, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-13 06:34:45'),
(182, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-13 07:00:14'),
(183, 1, 'Administrator', 'admin', 'Edit Alat', 'Mengubah data alat: Fujifilm X-T4', '2026-04-13 07:01:14'),
(184, 1, 'Administrator', 'admin', 'Logout', 'User keluar dari sistem', '2026-04-13 07:01:28'),
(185, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-13 07:01:35'),
(186, 2, 'Petugas', 'petugas', 'Login', 'User berhasil login ke sistem', '2026-04-13 07:08:41'),
(187, 2, 'Petugas', 'petugas', 'Logout', 'User keluar dari sistem', '2026-04-13 07:09:20'),
(188, 1, 'Administrator', 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-13 07:09:28'),
(189, 1, 'Administrator', 'admin', 'Edit Alat', 'Mengubah data alat: Sony A7 III', '2026-04-13 07:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_peminjam` varchar(100) DEFAULT NULL,
  `id_alat` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `total_harga` int(11) NOT NULL DEFAULT 0,
  `dp` int(11) NOT NULL DEFAULT 0,
  `bukti_dp` varchar(255) DEFAULT NULL,
  `sisa_bayar` int(11) NOT NULL DEFAULT 0,
  `pelunasan` int(11) NOT NULL DEFAULT 0,
  `bukti_pelunasan` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('belum_dp','dp_dibayar','lunas') NOT NULL DEFAULT 'belum_dp',
  `status` enum('pending','disetujui','ditolak','dipinjam','menunggu_pengembalian','dikembalikan') NOT NULL DEFAULT 'pending',
  `alasan_tolak` varchar(100) DEFAULT NULL,
  `kerusakan` text DEFAULT NULL,
  `denda_telat` int(11) NOT NULL DEFAULT 0,
  `denda_kerusakan` int(11) NOT NULL DEFAULT 0,
  `total_denda` int(11) NOT NULL DEFAULT 0,
  `status_bayar` enum('belum_bayar','lunas') NOT NULL DEFAULT 'belum_bayar',
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `bukti_tf` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_user`, `nama_peminjam`, `id_alat`, `tgl_pinjam`, `tgl_kembali`, `total_harga`, `dp`, `bukti_dp`, `sisa_bayar`, `pelunasan`, `bukti_pelunasan`, `status_pembayaran`, `status`, `alasan_tolak`, `kerusakan`, `denda_telat`, `denda_kerusakan`, `total_denda`, `status_bayar`, `bukti_bayar`, `bukti_tf`, `created_at`) VALUES
(9, 5, NULL, 7, '2026-04-13', '2026-04-14', 300000, 0, NULL, 0, 0, NULL, 'belum_dp', 'ditolak', 'barang rusak', NULL, 0, 0, 0, 'belum_bayar', NULL, '1776043884_Screenshot (7).png', '2026-04-12 18:31:29'),
(10, 5, NULL, 8, '2026-04-13', '2026-04-14', 50000, 0, NULL, 0, 50000, '1776044569_pelunasan_Screenshot (7).png', 'lunas', 'dikembalikan', NULL, NULL, 0, 0, 0, 'lunas', NULL, '1776043922_Screenshot (7).png', '2026-04-12 18:32:02'),
(11, 5, NULL, 10, '2026-04-13', '2026-04-14', 80000, 0, NULL, 0, 79999, '1776086185_pelunasan_Screenshot 2026-04-05 102755.png', 'dp_dibayar', '', NULL, NULL, 0, 0, 0, 'belum_bayar', NULL, '1776045804_Screenshot (7).png', '2026-04-12 19:03:25'),
(12, 5, NULL, 14, '2026-04-13', '2026-04-15', 100000, 0, NULL, 0, 100000, '1776086467_pelunasan_Screenshot 2026-04-05 135101.png', 'lunas', 'dikembalikan', NULL, NULL, 0, 0, 0, 'lunas', NULL, '1776086333_Screenshot 2026-03-11 165549.png', '2026-04-13 06:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','peminjam') NOT NULL DEFAULT 'peminjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$DErgQv4oxmku.QYLTmHu..ifpi68MBkoSJvnVt0ztKR8aorK5mBy6', 'admin'),
(2, 'Petugas', 'petugas@gmail.com', '$2y$10$K1VR7AlBTZj1vu1gZ8LzY.Hpht2Rtvq6o9HdHooUsBEINHQX6N0Ei', 'petugas'),
(5, 'peminjam', 'peminjam@gmail.com', '$2y$10$DNyb2bKZSICDyjAet2D.jOm5HH1DmXnxVPsDZ5cDROOE6fDgvKeUO', 'peminjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_alat` (`id_alat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alat`
--
ALTER TABLE `alat`
  ADD CONSTRAINT `alat_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
