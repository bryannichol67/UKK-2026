-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Nov 2026 pada 05.10
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
-- Database: `db_ukk_sql_2026`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'KP01', 'Wawan Kurniawan, S.Pd.I', 'guru01@sekolah.test', 1, 2, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(2, 'KP02', 'Ai Nuryaidah, S.Pd', 'guru02@sekolah.test', 1, 3, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(3, 'KP03', 'Maya Permata Endah,S. Pd', 'guru03@sekolah.test', 1, 4, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(4, 'KP04', 'Dody Jaenudin,S.Pd.', 'guru04@sekolah.test', 1, 5, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(5, 'KP05', 'Dedi Kardiman, S. Pd', 'guru05@sekolah.test', 1, 6, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(6, 'KP06', 'Uca Musa Yusenda, S.Pd', 'guru06@sekolah.test', 1, 7, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(7, 'KP07', 'Drs. Ahmad Nur Mukhlis', 'guru07@sekolah.test', 1, 8, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(8, 'KP08', 'Drs. Heri', 'guru08@sekolah.test', 1, 9, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(9, 'KP09', 'Asep Bastaman', 'guru09@sekolah.test', 1, 10, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(10, 'KP10', 'H. Encep Maemun, S.T.,M.Pd', 'guru10@sekolah.test', 1, 11, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(11, 'KP11', 'Opik', 'guru11@sekolah.test', 1, 12, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(12, 'KP12', 'Ida Farida, S. Pd', 'guru12@sekolah.test', 1, 13, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(13, 'KP13', 'Idah Mahmudah, S.Pd', 'guru13@sekolah.test', 1, 14, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(14, 'KP14', 'Drs. Muhamad Ali', 'guru14@sekolah.test', 1, 15, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(15, 'KP15', 'Helmi Ali Akbar, S.Pd.I', 'guru15@sekolah.test', 1, 16, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(16, 'KP16', 'Syeni Suswarini, S.Pd', 'guru16@sekolah.test', 1, 17, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(17, 'KP17', 'Wiwid Yulianti, S.Pd', 'guru17@sekolah.test', 1, 18, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(18, 'KP18', 'Ansor Muhajir, S.T', 'guru18@sekolah.test', 1, 19, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(19, 'KP19', 'Ogi Gaosun Gias, S.Pd.I', 'guru19@sekolah.test', 1, 20, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(20, 'KP20', 'Sandi Mulyana, S.Pd', 'guru20@sekolah.test', 1, 21, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(21, 'KP21', 'Erna Suryani, S.Pd', 'guru21@sekolah.test', 1, 22, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(22, 'KP22', 'Ai Wahidah, S.Ag', 'guru22@sekolah.test', 1, 23, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(23, 'KP23', 'Chandra Aditya Yusup, S.Pd', 'guru23@sekolah.test', 1, 24, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(24, 'KP24', 'Arif Kusmawan, S.Pd', 'guru24@sekolah.test', 1, 25, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(25, 'KP25', 'Asep Taufiq Hidayat, S.Kom', 'guru25@sekolah.test', 1, 26, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(26, 'KP26', 'Rendy Ichsan Kusumah, S.T', 'guru26@sekolah.test', 1, 27, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(27, 'KP27', 'Feri Rahmawan, S.Pd', 'guru27@sekolah.test', 1, 28, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(28, 'KP28', 'Ari Sandriana, S.Kom', 'guru28@sekolah.test', 1, 29, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(29, 'KP29', 'Yaneu Nurdian, S.Pd, M.Pd', 'guru29@sekolah.test', 1, 30, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(30, 'KP30', 'Ucu Muhammad Khoer N, S.Pd', 'guru30@sekolah.test', 1, 31, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(31, 'KP31', 'Mira Dwi Rahmawati, S.Ag', 'guru31@sekolah.test', 1, 32, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(32, 'KP32', 'Aldi Maulana, S.Pd', 'guru32@sekolah.test', 1, 33, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(33, 'KP33', 'Eli Rosliah, S.Pd', 'guru33@sekolah.test', 1, 34, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(34, 'KP34', 'Isni Nur Fitriani, S.Pd', 'guru34@sekolah.test', 1, 35, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(35, 'KP35', 'Aanisah Putri Nur Aini, S.Pd', 'guru35@sekolah.test', 1, 36, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(36, 'KP36', 'Yusi Luthfiani, S.Sos.I', 'guru36@sekolah.test', 1, 37, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(37, 'KP37', 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'guru37@sekolah.test', 1, 38, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(38, 'KP38', 'Yusrin Noer Sabrina, S.Pd', 'guru38@sekolah.test', 1, 39, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(39, 'KP39', 'Senny Indayani, S.Pd', 'guru39@sekolah.test', 1, 40, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(40, 'KP40', 'Ilma Amalia, S.Pd', 'guru40@sekolah.test', 1, 41, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(41, 'KP41', 'Alvira Sofwatunnisa, S.Pd', 'guru41@sekolah.test', 1, 42, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(42, 'KP42', 'Risna Andriyani, S.Pd', 'guru42@sekolah.test', 1, 43, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(43, 'KP43', 'Dra. Tintin Noerhayati', 'guru43@sekolah.test', 1, 44, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(44, 'KP44', 'Rizkia Fahira, S.Pd', 'guru44@sekolah.test', 1, 45, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(45, 'KP45', 'Frasetio', 'guru45@sekolah.test', 1, 46, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(46, 'KP46', 'Ratnaningsih Hatil Aeni, S.Pd.', 'guru46@sekolah.test', 1, 47, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(47, 'KP47', 'Dheny Darajatul Hasani, S.Pd.', 'guru47@sekolah.test', 1, 48, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(48, 'KP48', 'Fahrullah, S.Pd', 'guru48@sekolah.test', 1, 49, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(49, 'KP49', 'Aan Andriana, S.T', 'guru49@sekolah.test', 1, 50, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(50, 'KP50', 'Fitri Fauziah, S.T', 'guru50@sekolah.test', 1, 51, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(51, 'KP51', 'Nida Aulia, S.Pd', 'guru51@sekolah.test', 1, 52, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(52, 'KP52', 'Sri Nurrizki Putri Krisnadi, S.Pd', 'guru52@sekolah.test', 1, 53, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(53, 'KP53', 'Riesy Putri Navia, S.Kom', 'guru53@sekolah.test', 1, 54, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(54, 'KP54', 'Rurry Febriani Maryadi, S.Pd', 'guru54@sekolah.test', 1, 55, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(55, 'KP55', 'Irvan Rizal, S.Pd', 'guru55@sekolah.test', 1, 56, '2026-11-07 03:00:00', '2026-11-07 03:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'RPL 1', 'XII', 'RPL', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(2, 'RPL 2', 'XII', 'RPL', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(2, 2, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(3, 3, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(4, 4, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(5, 5, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(6, 6, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(7, 7, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(8, 8, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(9, 9, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(10, 10, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(11, 11, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(12, 12, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(13, 13, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(14, 14, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(15, 15, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(16, 16, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(17, 17, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(18, 18, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(19, 19, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(20, 20, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(21, 21, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(22, 22, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(23, 23, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(24, 24, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(25, 25, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(26, 26, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(27, 27, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(28, 28, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(29, 29, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(30, 30, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(31, 31, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(32, 32, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(33, 33, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(34, 34, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(35, 35, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(36, 36, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(37, 37, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(38, 38, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(39, 39, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(40, 40, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(41, 41, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(42, 42, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(43, 43, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(44, 44, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(45, 45, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(46, 46, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(47, 47, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(48, 48, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(49, 49, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(50, 50, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `kode` varchar(30) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'PG-001', 'Terlambat datang ke sekolah #001', 2, 'Deskripsi pelanggaran nomor 1.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 2, 'PG-002', 'Tidak memakai atribut lengkap #002', 3, 'Deskripsi pelanggaran nomor 2.', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(3, 3, 'PG-003', 'Tidak memakai seragam sesuai ketentuan #003', 4, 'Deskripsi pelanggaran nomor 3.', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(4, 4, 'PG-004', 'Meninggalkan kelas tanpa izin #004', 5, 'Deskripsi pelanggaran nomor 4.', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(5, 5, 'PG-005', 'Tidak mengerjakan tugas #005', 6, 'Deskripsi pelanggaran nomor 5.', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(6, 6, 'PG-006', 'Rambut tidak sesuai aturan #006', 7, 'Deskripsi pelanggaran nomor 6.', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(7, 7, 'PG-007', 'Membawa barang terlarang #007', 8, 'Deskripsi pelanggaran nomor 7.', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 8, 'PG-008', 'Berkata tidak sopan #008', 9, 'Deskripsi pelanggaran nomor 8.', 1, '2026-07-08 01:00:00', '2026-07-08 01:00:00'),
(9, 9, 'PG-009', 'Membuang sampah sembarangan #009', 10, 'Deskripsi pelanggaran nomor 9.', 1, '2026-07-09 01:00:00', '2026-07-09 01:00:00'),
(10, 10, 'PG-010', 'Tidak mengikuti upacara #010', 1, 'Deskripsi pelanggaran nomor 10.', 1, '2026-07-10 01:00:00', '2026-07-10 01:00:00'),
(11, 11, 'PG-011', 'Terlambat datang ke sekolah #011', 2, 'Deskripsi pelanggaran nomor 11.', 1, '2026-07-11 01:00:00', '2026-07-11 01:00:00'),
(12, 12, 'PG-012', 'Tidak memakai atribut lengkap #012', 3, 'Deskripsi pelanggaran nomor 12.', 1, '2026-07-12 01:00:00', '2026-07-12 01:00:00'),
(13, 13, 'PG-013', 'Tidak memakai seragam sesuai ketentuan #013', 4, 'Deskripsi pelanggaran nomor 13.', 1, '2026-07-13 01:00:00', '2026-07-13 01:00:00'),
(14, 14, 'PG-014', 'Meninggalkan kelas tanpa izin #014', 5, 'Deskripsi pelanggaran nomor 14.', 1, '2026-07-14 01:00:00', '2026-07-14 01:00:00'),
(15, 15, 'PG-015', 'Tidak mengerjakan tugas #015', 6, 'Deskripsi pelanggaran nomor 15.', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(16, 16, 'PG-016', 'Rambut tidak sesuai aturan #016', 7, 'Deskripsi pelanggaran nomor 16.', 1, '2026-07-16 01:00:00', '2026-07-16 01:00:00'),
(17, 17, 'PG-017', 'Membawa barang terlarang #017', 8, 'Deskripsi pelanggaran nomor 17.', 1, '2026-07-17 01:00:00', '2026-07-17 01:00:00'),
(18, 18, 'PG-018', 'Berkata tidak sopan #018', 9, 'Deskripsi pelanggaran nomor 18.', 1, '2026-07-18 01:00:00', '2026-07-18 01:00:00'),
(19, 19, 'PG-019', 'Membuang sampah sembarangan #019', 10, 'Deskripsi pelanggaran nomor 19.', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 20, 'PG-020', 'Tidak mengikuti upacara #020', 1, 'Deskripsi pelanggaran nomor 20.', 1, '2026-07-20 01:00:00', '2026-07-20 01:00:00'),
(21, 21, 'PG-021', 'Terlambat datang ke sekolah #021', 2, 'Deskripsi pelanggaran nomor 21.', 1, '2026-07-21 01:00:00', '2026-07-21 01:00:00'),
(22, 22, 'PG-022', 'Tidak memakai atribut lengkap #022', 3, 'Deskripsi pelanggaran nomor 22.', 1, '2026-07-22 01:00:00', '2026-07-22 01:00:00'),
(23, 23, 'PG-023', 'Tidak memakai seragam sesuai ketentuan #023', 4, 'Deskripsi pelanggaran nomor 23.', 1, '2026-07-23 01:00:00', '2026-07-23 01:00:00'),
(24, 24, 'PG-024', 'Meninggalkan kelas tanpa izin #024', 5, 'Deskripsi pelanggaran nomor 24.', 1, '2026-07-24 01:00:00', '2026-07-24 01:00:00'),
(25, 25, 'PG-025', 'Tidak mengerjakan tugas #025', 6, 'Deskripsi pelanggaran nomor 25.', 1, '2026-07-25 01:00:00', '2026-07-25 01:00:00'),
(26, 26, 'PG-026', 'Rambut tidak sesuai aturan #026', 7, 'Deskripsi pelanggaran nomor 26.', 1, '2026-07-26 01:00:00', '2026-07-26 01:00:00'),
(27, 27, 'PG-027', 'Membawa barang terlarang #027', 8, 'Deskripsi pelanggaran nomor 27.', 1, '2026-07-27 01:00:00', '2026-07-27 01:00:00'),
(28, 28, 'PG-028', 'Berkata tidak sopan #028', 9, 'Deskripsi pelanggaran nomor 28.', 1, '2026-07-28 01:00:00', '2026-07-28 01:00:00'),
(29, 29, 'PG-029', 'Membuang sampah sembarangan #029', 10, 'Deskripsi pelanggaran nomor 29.', 1, '2026-07-29 01:00:00', '2026-07-29 01:00:00'),
(30, 30, 'PG-030', 'Tidak mengikuti upacara #030', 1, 'Deskripsi pelanggaran nomor 30.', 1, '2026-07-30 01:00:00', '2026-07-30 01:00:00'),
(31, 31, 'PG-031', 'Terlambat datang ke sekolah #031', 2, 'Deskripsi pelanggaran nomor 31.', 1, '2026-07-31 01:00:00', '2026-07-31 01:00:00'),
(32, 32, 'PG-032', 'Tidak memakai atribut lengkap #032', 3, 'Deskripsi pelanggaran nomor 32.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(33, 33, 'PG-033', 'Tidak memakai seragam sesuai ketentuan #033', 4, 'Deskripsi pelanggaran nomor 33.', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(34, 34, 'PG-034', 'Meninggalkan kelas tanpa izin #034', 5, 'Deskripsi pelanggaran nomor 34.', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(35, 35, 'PG-035', 'Tidak mengerjakan tugas #035', 6, 'Deskripsi pelanggaran nomor 35.', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(36, 36, 'PG-036', 'Rambut tidak sesuai aturan #036', 7, 'Deskripsi pelanggaran nomor 36.', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(37, 37, 'PG-037', 'Membawa barang terlarang #037', 8, 'Deskripsi pelanggaran nomor 37.', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(38, 38, 'PG-038', 'Berkata tidak sopan #038', 9, 'Deskripsi pelanggaran nomor 38.', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(39, 39, 'PG-039', 'Membuang sampah sembarangan #039', 10, 'Deskripsi pelanggaran nomor 39.', 1, '2026-07-08 01:00:00', '2026-07-08 01:00:00'),
(40, 40, 'PG-040', 'Tidak mengikuti upacara #040', 1, 'Deskripsi pelanggaran nomor 40.', 1, '2026-07-09 01:00:00', '2026-07-09 01:00:00'),
(41, 41, 'PG-041', 'Terlambat datang ke sekolah #041', 2, 'Deskripsi pelanggaran nomor 41.', 1, '2026-07-10 01:00:00', '2026-07-10 01:00:00'),
(42, 42, 'PG-042', 'Tidak memakai atribut lengkap #042', 3, 'Deskripsi pelanggaran nomor 42.', 1, '2026-07-11 01:00:00', '2026-07-11 01:00:00'),
(43, 43, 'PG-043', 'Tidak memakai seragam sesuai ketentuan #043', 4, 'Deskripsi pelanggaran nomor 43.', 1, '2026-07-12 01:00:00', '2026-07-12 01:00:00'),
(44, 44, 'PG-044', 'Meninggalkan kelas tanpa izin #044', 5, 'Deskripsi pelanggaran nomor 44.', 1, '2026-07-13 01:00:00', '2026-07-13 01:00:00'),
(45, 45, 'PG-045', 'Tidak mengerjakan tugas #045', 6, 'Deskripsi pelanggaran nomor 45.', 1, '2026-07-14 01:00:00', '2026-07-14 01:00:00'),
(46, 46, 'PG-046', 'Rambut tidak sesuai aturan #046', 7, 'Deskripsi pelanggaran nomor 46.', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(47, 47, 'PG-047', 'Membawa barang terlarang #047', 8, 'Deskripsi pelanggaran nomor 47.', 1, '2026-07-16 01:00:00', '2026-07-16 01:00:00'),
(48, 48, 'PG-048', 'Berkata tidak sopan #048', 9, 'Deskripsi pelanggaran nomor 48.', 1, '2026-07-17 01:00:00', '2026-07-17 01:00:00'),
(49, 49, 'PG-049', 'Membuang sampah sembarangan #049', 10, 'Deskripsi pelanggaran nomor 49.', 1, '2026-07-18 01:00:00', '2026-07-18 01:00:00'),
(50, 50, 'PG-050', 'Tidak mengikuti upacara #050', 1, 'Deskripsi pelanggaran nomor 50.', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(51, 51, 'PG-051', 'Terlambat datang ke sekolah #051', 2, 'Deskripsi pelanggaran nomor 51.', 1, '2026-07-20 01:00:00', '2026-07-20 01:00:00'),
(52, 52, 'PG-052', 'Tidak memakai atribut lengkap #052', 3, 'Deskripsi pelanggaran nomor 52.', 1, '2026-07-21 01:00:00', '2026-07-21 01:00:00'),
(53, 53, 'PG-053', 'Tidak memakai seragam sesuai ketentuan #053', 4, 'Deskripsi pelanggaran nomor 53.', 1, '2026-07-22 01:00:00', '2026-07-22 01:00:00'),
(54, 54, 'PG-054', 'Meninggalkan kelas tanpa izin #054', 5, 'Deskripsi pelanggaran nomor 54.', 1, '2026-07-23 01:00:00', '2026-07-23 01:00:00'),
(55, 55, 'PG-055', 'Tidak mengerjakan tugas #055', 6, 'Deskripsi pelanggaran nomor 55.', 1, '2026-07-24 01:00:00', '2026-07-24 01:00:00'),
(56, 56, 'PG-056', 'Rambut tidak sesuai aturan #056', 7, 'Deskripsi pelanggaran nomor 56.', 1, '2026-07-25 01:00:00', '2026-07-25 01:00:00'),
(57, 57, 'PG-057', 'Membawa barang terlarang #057', 8, 'Deskripsi pelanggaran nomor 57.', 1, '2026-07-26 01:00:00', '2026-07-26 01:00:00'),
(58, 58, 'PG-058', 'Berkata tidak sopan #058', 9, 'Deskripsi pelanggaran nomor 58.', 1, '2026-07-27 01:00:00', '2026-07-27 01:00:00'),
(59, 59, 'PG-059', 'Membuang sampah sembarangan #059', 10, 'Deskripsi pelanggaran nomor 59.', 1, '2026-07-28 01:00:00', '2026-07-28 01:00:00'),
(60, 60, 'PG-060', 'Tidak mengikuti upacara #060', 1, 'Deskripsi pelanggaran nomor 60.', 1, '2026-07-29 01:00:00', '2026-07-29 01:00:00'),
(61, 61, 'PG-061', 'Terlambat datang ke sekolah #061', 2, 'Deskripsi pelanggaran nomor 61.', 1, '2026-07-30 01:00:00', '2026-07-30 01:00:00'),
(62, 62, 'PG-062', 'Tidak memakai atribut lengkap #062', 3, 'Deskripsi pelanggaran nomor 62.', 1, '2026-07-31 01:00:00', '2026-07-31 01:00:00'),
(63, 63, 'PG-063', 'Tidak memakai seragam sesuai ketentuan #063', 4, 'Deskripsi pelanggaran nomor 63.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(64, 64, 'PG-064', 'Meninggalkan kelas tanpa izin #064', 5, 'Deskripsi pelanggaran nomor 64.', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(65, 65, 'PG-065', 'Tidak mengerjakan tugas #065', 6, 'Deskripsi pelanggaran nomor 65.', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(66, 66, 'PG-066', 'Rambut tidak sesuai aturan #066', 7, 'Deskripsi pelanggaran nomor 66.', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(67, 67, 'PG-067', 'Membawa barang terlarang #067', 8, 'Deskripsi pelanggaran nomor 67.', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(68, 68, 'PG-068', 'Berkata tidak sopan #068', 9, 'Deskripsi pelanggaran nomor 68.', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(69, 69, 'PG-069', 'Membuang sampah sembarangan #069', 10, 'Deskripsi pelanggaran nomor 69.', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(70, 70, 'PG-070', 'Tidak mengikuti upacara #070', 1, 'Deskripsi pelanggaran nomor 70.', 1, '2026-07-08 01:00:00', '2026-07-08 01:00:00'),
(71, 71, 'PG-071', 'Terlambat datang ke sekolah #071', 2, 'Deskripsi pelanggaran nomor 71.', 1, '2026-07-09 01:00:00', '2026-07-09 01:00:00'),
(72, 72, 'PG-072', 'Tidak memakai atribut lengkap #072', 3, 'Deskripsi pelanggaran nomor 72.', 1, '2026-07-10 01:00:00', '2026-07-10 01:00:00'),
(73, 73, 'PG-073', 'Tidak memakai seragam sesuai ketentuan #073', 4, 'Deskripsi pelanggaran nomor 73.', 1, '2026-07-11 01:00:00', '2026-07-11 01:00:00'),
(74, 74, 'PG-074', 'Meninggalkan kelas tanpa izin #074', 5, 'Deskripsi pelanggaran nomor 74.', 1, '2026-07-12 01:00:00', '2026-07-12 01:00:00'),
(75, 75, 'PG-075', 'Tidak mengerjakan tugas #075', 6, 'Deskripsi pelanggaran nomor 75.', 1, '2026-07-13 01:00:00', '2026-07-13 01:00:00'),
(76, 76, 'PG-076', 'Rambut tidak sesuai aturan #076', 7, 'Deskripsi pelanggaran nomor 76.', 1, '2026-07-14 01:00:00', '2026-07-14 01:00:00'),
(77, 77, 'PG-077', 'Membawa barang terlarang #077', 8, 'Deskripsi pelanggaran nomor 77.', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(78, 78, 'PG-078', 'Berkata tidak sopan #078', 9, 'Deskripsi pelanggaran nomor 78.', 1, '2026-07-16 01:00:00', '2026-07-16 01:00:00'),
(79, 79, 'PG-079', 'Membuang sampah sembarangan #079', 10, 'Deskripsi pelanggaran nomor 79.', 1, '2026-07-17 01:00:00', '2026-07-17 01:00:00'),
(80, 80, 'PG-080', 'Tidak mengikuti upacara #080', 1, 'Deskripsi pelanggaran nomor 80.', 1, '2026-07-18 01:00:00', '2026-07-18 01:00:00'),
(81, 81, 'PG-081', 'Terlambat datang ke sekolah #081', 2, 'Deskripsi pelanggaran nomor 81.', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(82, 82, 'PG-082', 'Tidak memakai atribut lengkap #082', 3, 'Deskripsi pelanggaran nomor 82.', 1, '2026-07-20 01:00:00', '2026-07-20 01:00:00'),
(83, 83, 'PG-083', 'Tidak memakai seragam sesuai ketentuan #083', 4, 'Deskripsi pelanggaran nomor 83.', 1, '2026-07-21 01:00:00', '2026-07-21 01:00:00'),
(84, 84, 'PG-084', 'Meninggalkan kelas tanpa izin #084', 5, 'Deskripsi pelanggaran nomor 84.', 1, '2026-07-22 01:00:00', '2026-07-22 01:00:00'),
(85, 85, 'PG-085', 'Tidak mengerjakan tugas #085', 6, 'Deskripsi pelanggaran nomor 85.', 1, '2026-07-23 01:00:00', '2026-07-23 01:00:00'),
(86, 86, 'PG-086', 'Rambut tidak sesuai aturan #086', 7, 'Deskripsi pelanggaran nomor 86.', 1, '2026-07-24 01:00:00', '2026-07-24 01:00:00'),
(87, 87, 'PG-087', 'Membawa barang terlarang #087', 8, 'Deskripsi pelanggaran nomor 87.', 1, '2026-07-25 01:00:00', '2026-07-25 01:00:00'),
(88, 88, 'PG-088', 'Berkata tidak sopan #088', 9, 'Deskripsi pelanggaran nomor 88.', 1, '2026-07-26 01:00:00', '2026-07-26 01:00:00'),
(89, 89, 'PG-089', 'Membuang sampah sembarangan #089', 10, 'Deskripsi pelanggaran nomor 89.', 1, '2026-07-27 01:00:00', '2026-07-27 01:00:00'),
(90, 90, 'PG-090', 'Tidak mengikuti upacara #090', 1, 'Deskripsi pelanggaran nomor 90.', 1, '2026-07-28 01:00:00', '2026-07-28 01:00:00'),
(91, 91, 'PG-091', 'Terlambat datang ke sekolah #091', 2, 'Deskripsi pelanggaran nomor 91.', 1, '2026-07-29 01:00:00', '2026-07-29 01:00:00'),
(92, 92, 'PG-092', 'Tidak memakai atribut lengkap #092', 3, 'Deskripsi pelanggaran nomor 92.', 1, '2026-07-30 01:00:00', '2026-07-30 01:00:00'),
(93, 93, 'PG-093', 'Tidak memakai seragam sesuai ketentuan #093', 4, 'Deskripsi pelanggaran nomor 93.', 1, '2026-07-31 01:00:00', '2026-07-31 01:00:00'),
(94, 94, 'PG-094', 'Meninggalkan kelas tanpa izin #094', 5, 'Deskripsi pelanggaran nomor 94.', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(95, 95, 'PG-095', 'Tidak mengerjakan tugas #095', 6, 'Deskripsi pelanggaran nomor 95.', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(96, 96, 'PG-096', 'Rambut tidak sesuai aturan #096', 7, 'Deskripsi pelanggaran nomor 96.', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(97, 97, 'PG-097', 'Membawa barang terlarang #097', 8, 'Deskripsi pelanggaran nomor 97.', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(98, 98, 'PG-098', 'Berkata tidak sopan #098', 9, 'Deskripsi pelanggaran nomor 98.', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(99, 99, 'PG-099', 'Membuang sampah sembarangan #099', 10, 'Deskripsi pelanggaran nomor 99.', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(100, 100, 'PG-100', 'Tidak mengikuti upacara #100', 1, 'Deskripsi pelanggaran nomor 100.', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan 1', 'Kategori pelanggaran nomor 1', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 'Kerapian 1', 'Kategori pelanggaran nomor 2', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(3, 'Kehadiran 1', 'Kategori pelanggaran nomor 3', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(4, 'Ketertiban 1', 'Kategori pelanggaran nomor 4', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(5, 'Perlengkapan 1', 'Kategori pelanggaran nomor 5', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(6, 'Sikap 1', 'Kategori pelanggaran nomor 6', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(7, 'Kebersihan 1', 'Kategori pelanggaran nomor 7', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(8, 'Keamanan 1', 'Kategori pelanggaran nomor 8', 1, '2026-07-08 01:00:00', '2026-07-08 01:00:00'),
(9, 'Akademik 1', 'Kategori pelanggaran nomor 9', 1, '2026-07-09 01:00:00', '2026-07-09 01:00:00'),
(10, 'Lingkungan 1', 'Kategori pelanggaran nomor 10', 1, '2026-07-10 01:00:00', '2026-07-10 01:00:00'),
(11, 'Kedisiplinan 2', 'Kategori pelanggaran nomor 11', 1, '2026-07-11 01:00:00', '2026-07-11 01:00:00'),
(12, 'Kerapian 2', 'Kategori pelanggaran nomor 12', 1, '2026-07-12 01:00:00', '2026-07-12 01:00:00'),
(13, 'Kehadiran 2', 'Kategori pelanggaran nomor 13', 1, '2026-07-13 01:00:00', '2026-07-13 01:00:00'),
(14, 'Ketertiban 2', 'Kategori pelanggaran nomor 14', 1, '2026-07-14 01:00:00', '2026-07-14 01:00:00'),
(15, 'Perlengkapan 2', 'Kategori pelanggaran nomor 15', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(16, 'Sikap 2', 'Kategori pelanggaran nomor 16', 1, '2026-07-16 01:00:00', '2026-07-16 01:00:00'),
(17, 'Kebersihan 2', 'Kategori pelanggaran nomor 17', 1, '2026-07-17 01:00:00', '2026-07-17 01:00:00'),
(18, 'Keamanan 2', 'Kategori pelanggaran nomor 18', 1, '2026-07-18 01:00:00', '2026-07-18 01:00:00'),
(19, 'Akademik 2', 'Kategori pelanggaran nomor 19', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(20, 'Lingkungan 2', 'Kategori pelanggaran nomor 20', 1, '2026-07-20 01:00:00', '2026-07-20 01:00:00'),
(21, 'Kedisiplinan 3', 'Kategori pelanggaran nomor 21', 1, '2026-07-21 01:00:00', '2026-07-21 01:00:00'),
(22, 'Kerapian 3', 'Kategori pelanggaran nomor 22', 1, '2026-07-22 01:00:00', '2026-07-22 01:00:00'),
(23, 'Kehadiran 3', 'Kategori pelanggaran nomor 23', 1, '2026-07-23 01:00:00', '2026-07-23 01:00:00'),
(24, 'Ketertiban 3', 'Kategori pelanggaran nomor 24', 1, '2026-07-24 01:00:00', '2026-07-24 01:00:00'),
(25, 'Perlengkapan 3', 'Kategori pelanggaran nomor 25', 1, '2026-07-25 01:00:00', '2026-07-25 01:00:00'),
(26, 'Sikap 3', 'Kategori pelanggaran nomor 26', 1, '2026-07-26 01:00:00', '2026-07-26 01:00:00'),
(27, 'Kebersihan 3', 'Kategori pelanggaran nomor 27', 1, '2026-07-27 01:00:00', '2026-07-27 01:00:00'),
(28, 'Keamanan 3', 'Kategori pelanggaran nomor 28', 1, '2026-07-28 01:00:00', '2026-07-28 01:00:00'),
(29, 'Akademik 3', 'Kategori pelanggaran nomor 29', 1, '2026-07-29 01:00:00', '2026-07-29 01:00:00'),
(30, 'Lingkungan 3', 'Kategori pelanggaran nomor 30', 1, '2026-07-30 01:00:00', '2026-07-30 01:00:00'),
(31, 'Kedisiplinan 4', 'Kategori pelanggaran nomor 31', 1, '2026-07-31 01:00:00', '2026-07-31 01:00:00'),
(32, 'Kerapian 4', 'Kategori pelanggaran nomor 32', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(33, 'Kehadiran 4', 'Kategori pelanggaran nomor 33', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(34, 'Ketertiban 4', 'Kategori pelanggaran nomor 34', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(35, 'Perlengkapan 4', 'Kategori pelanggaran nomor 35', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(36, 'Sikap 4', 'Kategori pelanggaran nomor 36', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(37, 'Kebersihan 4', 'Kategori pelanggaran nomor 37', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(38, 'Keamanan 4', 'Kategori pelanggaran nomor 38', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(39, 'Akademik 4', 'Kategori pelanggaran nomor 39', 1, '2026-07-08 01:00:00', '2026-07-08 01:00:00'),
(40, 'Lingkungan 4', 'Kategori pelanggaran nomor 40', 1, '2026-07-09 01:00:00', '2026-07-09 01:00:00'),
(41, 'Kedisiplinan 5', 'Kategori pelanggaran nomor 41', 1, '2026-07-10 01:00:00', '2026-07-10 01:00:00'),
(42, 'Kerapian 5', 'Kategori pelanggaran nomor 42', 1, '2026-07-11 01:00:00', '2026-07-11 01:00:00'),
(43, 'Kehadiran 5', 'Kategori pelanggaran nomor 43', 1, '2026-07-12 01:00:00', '2026-07-12 01:00:00'),
(44, 'Ketertiban 5', 'Kategori pelanggaran nomor 44', 1, '2026-07-13 01:00:00', '2026-07-13 01:00:00'),
(45, 'Perlengkapan 5', 'Kategori pelanggaran nomor 45', 1, '2026-07-14 01:00:00', '2026-07-14 01:00:00'),
(46, 'Sikap 5', 'Kategori pelanggaran nomor 46', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(47, 'Kebersihan 5', 'Kategori pelanggaran nomor 47', 1, '2026-07-16 01:00:00', '2026-07-16 01:00:00'),
(48, 'Keamanan 5', 'Kategori pelanggaran nomor 48', 1, '2026-07-17 01:00:00', '2026-07-17 01:00:00'),
(49, 'Akademik 5', 'Kategori pelanggaran nomor 49', 1, '2026-07-18 01:00:00', '2026-07-18 01:00:00'),
(50, 'Lingkungan 5', 'Kategori pelanggaran nomor 50', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(51, 'Kedisiplinan 6', 'Kategori pelanggaran nomor 51', 1, '2026-07-20 01:00:00', '2026-07-20 01:00:00'),
(52, 'Kerapian 6', 'Kategori pelanggaran nomor 52', 1, '2026-07-21 01:00:00', '2026-07-21 01:00:00'),
(53, 'Kehadiran 6', 'Kategori pelanggaran nomor 53', 1, '2026-07-22 01:00:00', '2026-07-22 01:00:00'),
(54, 'Ketertiban 6', 'Kategori pelanggaran nomor 54', 1, '2026-07-23 01:00:00', '2026-07-23 01:00:00'),
(55, 'Perlengkapan 6', 'Kategori pelanggaran nomor 55', 1, '2026-07-24 01:00:00', '2026-07-24 01:00:00'),
(56, 'Sikap 6', 'Kategori pelanggaran nomor 56', 1, '2026-07-25 01:00:00', '2026-07-25 01:00:00'),
(57, 'Kebersihan 6', 'Kategori pelanggaran nomor 57', 1, '2026-07-26 01:00:00', '2026-07-26 01:00:00'),
(58, 'Keamanan 6', 'Kategori pelanggaran nomor 58', 1, '2026-07-27 01:00:00', '2026-07-27 01:00:00'),
(59, 'Akademik 6', 'Kategori pelanggaran nomor 59', 1, '2026-07-28 01:00:00', '2026-07-28 01:00:00'),
(60, 'Lingkungan 6', 'Kategori pelanggaran nomor 60', 1, '2026-07-29 01:00:00', '2026-07-29 01:00:00'),
(61, 'Kedisiplinan 7', 'Kategori pelanggaran nomor 61', 1, '2026-07-30 01:00:00', '2026-07-30 01:00:00'),
(62, 'Kerapian 7', 'Kategori pelanggaran nomor 62', 1, '2026-07-31 01:00:00', '2026-07-31 01:00:00'),
(63, 'Kehadiran 7', 'Kategori pelanggaran nomor 63', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(64, 'Ketertiban 7', 'Kategori pelanggaran nomor 64', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(65, 'Perlengkapan 7', 'Kategori pelanggaran nomor 65', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(66, 'Sikap 7', 'Kategori pelanggaran nomor 66', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(67, 'Kebersihan 7', 'Kategori pelanggaran nomor 67', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(68, 'Keamanan 7', 'Kategori pelanggaran nomor 68', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(69, 'Akademik 7', 'Kategori pelanggaran nomor 69', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00'),
(70, 'Lingkungan 7', 'Kategori pelanggaran nomor 70', 1, '2026-07-08 01:00:00', '2026-07-08 01:00:00'),
(71, 'Kedisiplinan 8', 'Kategori pelanggaran nomor 71', 1, '2026-07-09 01:00:00', '2026-07-09 01:00:00'),
(72, 'Kerapian 8', 'Kategori pelanggaran nomor 72', 1, '2026-07-10 01:00:00', '2026-07-10 01:00:00'),
(73, 'Kehadiran 8', 'Kategori pelanggaran nomor 73', 1, '2026-07-11 01:00:00', '2026-07-11 01:00:00'),
(74, 'Ketertiban 8', 'Kategori pelanggaran nomor 74', 1, '2026-07-12 01:00:00', '2026-07-12 01:00:00'),
(75, 'Perlengkapan 8', 'Kategori pelanggaran nomor 75', 1, '2026-07-13 01:00:00', '2026-07-13 01:00:00'),
(76, 'Sikap 8', 'Kategori pelanggaran nomor 76', 1, '2026-07-14 01:00:00', '2026-07-14 01:00:00'),
(77, 'Kebersihan 8', 'Kategori pelanggaran nomor 77', 1, '2026-07-15 01:00:00', '2026-07-15 01:00:00'),
(78, 'Keamanan 8', 'Kategori pelanggaran nomor 78', 1, '2026-07-16 01:00:00', '2026-07-16 01:00:00'),
(79, 'Akademik 8', 'Kategori pelanggaran nomor 79', 1, '2026-07-17 01:00:00', '2026-07-17 01:00:00'),
(80, 'Lingkungan 8', 'Kategori pelanggaran nomor 80', 1, '2026-07-18 01:00:00', '2026-07-18 01:00:00'),
(81, 'Kedisiplinan 9', 'Kategori pelanggaran nomor 81', 1, '2026-07-19 01:00:00', '2026-07-19 01:00:00'),
(82, 'Kerapian 9', 'Kategori pelanggaran nomor 82', 1, '2026-07-20 01:00:00', '2026-07-20 01:00:00'),
(83, 'Kehadiran 9', 'Kategori pelanggaran nomor 83', 1, '2026-07-21 01:00:00', '2026-07-21 01:00:00'),
(84, 'Ketertiban 9', 'Kategori pelanggaran nomor 84', 1, '2026-07-22 01:00:00', '2026-07-22 01:00:00'),
(85, 'Perlengkapan 9', 'Kategori pelanggaran nomor 85', 1, '2026-07-23 01:00:00', '2026-07-23 01:00:00'),
(86, 'Sikap 9', 'Kategori pelanggaran nomor 86', 1, '2026-07-24 01:00:00', '2026-07-24 01:00:00'),
(87, 'Kebersihan 9', 'Kategori pelanggaran nomor 87', 1, '2026-07-25 01:00:00', '2026-07-25 01:00:00'),
(88, 'Keamanan 9', 'Kategori pelanggaran nomor 88', 1, '2026-07-26 01:00:00', '2026-07-26 01:00:00'),
(89, 'Akademik 9', 'Kategori pelanggaran nomor 89', 1, '2026-07-27 01:00:00', '2026-07-27 01:00:00'),
(90, 'Lingkungan 9', 'Kategori pelanggaran nomor 90', 1, '2026-07-28 01:00:00', '2026-07-28 01:00:00'),
(91, 'Kedisiplinan 10', 'Kategori pelanggaran nomor 91', 1, '2026-07-29 01:00:00', '2026-07-29 01:00:00'),
(92, 'Kerapian 10', 'Kategori pelanggaran nomor 92', 1, '2026-07-30 01:00:00', '2026-07-30 01:00:00'),
(93, 'Kehadiran 10', 'Kategori pelanggaran nomor 93', 1, '2026-07-31 01:00:00', '2026-07-31 01:00:00'),
(94, 'Ketertiban 10', 'Kategori pelanggaran nomor 94', 1, '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(95, 'Perlengkapan 10', 'Kategori pelanggaran nomor 95', 1, '2026-07-02 01:00:00', '2026-07-02 01:00:00'),
(96, 'Sikap 10', 'Kategori pelanggaran nomor 96', 1, '2026-07-03 01:00:00', '2026-07-03 01:00:00'),
(97, 'Kebersihan 10', 'Kategori pelanggaran nomor 97', 1, '2026-07-04 01:00:00', '2026-07-04 01:00:00'),
(98, 'Keamanan 10', 'Kategori pelanggaran nomor 98', 1, '2026-07-05 01:00:00', '2026-07-05 01:00:00'),
(99, 'Akademik 10', 'Kategori pelanggaran nomor 99', 1, '2026-07-06 01:00:00', '2026-07-06 01:00:00'),
(100, 'Lingkungan 10', 'Kategori pelanggaran nomor 100', 1, '2026-07-07 01:00:00', '2026-07-07 01:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `nama_siswa` varchar(150) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `pelanggaran_id` int(11) DEFAULT NULL,
  `nama_pelanggaran` varchar(150) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text NOT NULL,
  `poin` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(30) DEFAULT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2026001', '9900000001', 'ALFIN RAHADIAN', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(2, '2026002', '9900000002', 'ALISA RAMADHANI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(3, '2026003', '9900000003', 'AMA AURA LIVIA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(4, '2026004', '9900000004', 'ANIS KHOERUNNISA NUR RAMADANI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(5, '2026005', '9900000005', 'AZMIL AMIRA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(6, '2026006', '9900000006', 'AZRIL AKBAR FAWZI ABDILLAH', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(7, '2026007', '9900000007', 'ERLANGGA SAPUTRA HIDAYAT', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(8, '2026008', '9900000008', 'HILMIA HUMMA TUNNUNJAH', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(9, '2026009', '9900000009', 'ILMA NAJYA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(10, '2026010', '9900000010', 'JULIANA DHARMA PANGESTU', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(11, '2026011', '9900000011', 'KAYLA NUR FADILAH', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(12, '2026012', '9900000012', 'MOZA DINA NABILLAH', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(13, '2026013', '9900000013', 'MUHAMAD ALFARIZI', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(14, '2026014', '9900000014', 'MUHAMAD FAHRIN ADAM', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(15, '2026015', '9900000015', 'MUHAMAD ZIDAN MAULIDAN', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(16, '2026016', '9900000016', 'MUHAMAD ZULFAN NURFALANSYAH', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(17, '2026017', '9900000017', 'NATIYA NUR AZKIYA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(18, '2026018', '9900000018', 'NOVITA PUSPITASARI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(19, '2026019', '9900000019', 'NUCKY ANDREAS FEBRIAN', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(20, '2026020', '9900000020', 'RADITYA JETI PRASETYA', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(21, '2026021', '9900000021', 'RANGGA RAMADIYANTO NURHAKIM', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(22, '2026022', '9900000022', 'RISQI MUHAMAD IHWANI', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(23, '2026023', '9900000023', 'SALWA SABILATUL BARAKAH', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(24, '2026024', '9900000024', 'TAZKIA ZAHRA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(25, '2026025', '9900000025', 'ADITTIA NUR LANTIP', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(26, '2026026', '9900000026', 'AGNIA ROSYA NOERILLAH', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(27, '2026027', '9900000027', 'ANISA AMIRULLA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(28, '2026028', '9900000028', 'APADEA KANDI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(29, '2026029', '9900000029', 'ARFA DIESA OKMAELIZA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(30, '2026030', '9900000030', 'FITRI NUR SYIAMI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(31, '2026031', '9900000031', 'JUNITA PUTRI NUR RAHMAN', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(32, '2026032', '9900000032', 'MOHAMMAD ATALARIK ALI SYAHBANA', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(33, '2026033', '9900000033', 'MUHAMAD FAHRIL FAHRUROZI', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(34, '2026034', '9900000034', 'MUHAMMAD ADNAN SYAEFUL ISLAMI', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(35, '2026035', '9900000035', 'MUHAMMAD ZAHRU AQILA FIKRI', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(36, '2026036', '9900000036', 'NADIA ZULFA SORAYA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(37, '2026037', '9900000037', 'NAZRIL ILHAM', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(38, '2026038', '9900000038', 'PUSPITA DEWI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(39, '2026039', '9900000039', 'RAKHA MUHAMMAD HAYKAL', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(40, '2026040', '9900000040', 'RANI MEILANI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(41, '2026041', '9900000041', 'REIHAN MUZAKI', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(42, '2026042', '9900000042', 'RESA JULIANSAH', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(43, '2026043', '9900000043', 'RIZKI PERMATA SUGIANTO', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(44, '2026044', '9900000044', 'SAHIRA FIRAJ', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(45, '2026045', '9900000045', 'SENDI MARDIAN', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(46, '2026046', '9900000046', 'SHAHAIDAN NIZZAR', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(47, '2026047', '9900000047', 'SHERLY SATRIANI', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(48, '2026048', '9900000048', 'SOFI NURJANAH', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(49, '2026049', '9900000049', 'SURAIYA SALSABILA AZZAHRA', 'P', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(50, '2026050', '9900000050', 'TONI ANTONIO', 'L', '2008-01-01', '-', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2026/2027', '2026-07-01', '2027-06-30', 1, '2026-11-07 03:00:00', '2026-11-07 03:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'user001@sekolah.test', '2026-07-01 01:00:00', '$2y$10$dl48Y6nzKH541PUq45vYouC4dy54yrt52yXNXs3IsBzyvbzqtqn/u', '', 'admin', '2026-07-01 01:00:00', '2026-07-01 01:00:00'),
(2, 'Wawan Kurniawan, S.Pd.I', 'guru01@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(3, 'Ai Nuryaidah, S.Pd', 'guru02@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(4, 'Maya Permata Endah,S. Pd', 'guru03@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(5, 'Dody Jaenudin,S.Pd.', 'guru04@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(6, 'Dedi Kardiman, S. Pd', 'guru05@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(7, 'Uca Musa Yusenda, S.Pd', 'guru06@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(8, 'Drs. Ahmad Nur Mukhlis', 'guru07@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(9, 'Drs. Heri', 'guru08@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(10, 'Asep Bastaman', 'guru09@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(11, 'H. Encep Maemun, S.T.,M.Pd', 'guru10@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(12, 'Opik', 'guru11@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(13, 'Ida Farida, S. Pd', 'guru12@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(14, 'Idah Mahmudah, S.Pd', 'guru13@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(15, 'Drs. Muhamad Ali', 'guru14@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(16, 'Helmi Ali Akbar, S.Pd.I', 'guru15@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(17, 'Syeni Suswarini, S.Pd', 'guru16@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(18, 'Wiwid Yulianti, S.Pd', 'guru17@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(19, 'Ansor Muhajir, S.T', 'guru18@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(20, 'Ogi Gaosun Gias, S.Pd.I', 'guru19@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(21, 'Sandi Mulyana, S.Pd', 'guru20@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(22, 'Erna Suryani, S.Pd', 'guru21@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(23, 'Ai Wahidah, S.Ag', 'guru22@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(24, 'Chandra Aditya Yusup, S.Pd', 'guru23@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(25, 'Arif Kusmawan, S.Pd', 'guru24@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(26, 'Asep Taufiq Hidayat, S.Kom', 'guru25@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(27, 'Rendy Ichsan Kusumah, S.T', 'guru26@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(28, 'Feri Rahmawan, S.Pd', 'guru27@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(29, 'Ari Sandriana, S.Kom', 'guru28@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(30, 'Yaneu Nurdian, S.Pd, M.Pd', 'guru29@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(31, 'Ucu Muhammad Khoer N, S.Pd', 'guru30@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(32, 'Mira Dwi Rahmawati, S.Ag', 'guru31@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(33, 'Aldi Maulana, S.Pd', 'guru32@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(34, 'Eli Rosliah, S.Pd', 'guru33@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(35, 'Isni Nur Fitriani, S.Pd', 'guru34@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(36, 'Aanisah Putri Nur Aini, S.Pd', 'guru35@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(37, 'Yusi Luthfiani, S.Sos.I', 'guru36@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(38, 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'guru37@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(39, 'Yusrin Noer Sabrina, S.Pd', 'guru38@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(40, 'Senny Indayani, S.Pd', 'guru39@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(41, 'Ilma Amalia, S.Pd', 'guru40@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(42, 'Alvira Sofwatunnisa, S.Pd', 'guru41@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(43, 'Risna Andriyani, S.Pd', 'guru42@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(44, 'Dra. Tintin Noerhayati', 'guru43@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(45, 'Rizkia Fahira, S.Pd', 'guru44@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(46, 'Frasetio', 'guru45@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(47, 'Ratnaningsih Hatil Aeni, S.Pd.', 'guru46@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(48, 'Dheny Darajatul Hasani, S.Pd.', 'guru47@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(49, 'Fahrullah, S.Pd', 'guru48@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(50, 'Aan Andriana, S.T', 'guru49@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(51, 'Fitri Fauziah, S.T', 'guru50@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(52, 'Nida Aulia, S.Pd', 'guru51@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(53, 'Sri Nurrizki Putri Krisnadi, S.Pd', 'guru52@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(54, 'Riesy Putri Navia, S.Kom', 'guru53@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(55, 'Rurry Febriani Maryadi, S.Pd', 'guru54@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00'),
(56, 'Irvan Rizal, S.Pd', 'guru55@sekolah.test', '2026-11-07 03:00:00', '$2y$10$2YFOzyGtUgF6c4aA93vX4OLExwJCSGxAwURM6j0uIZkiil7d4h.9O', '', 'guru', '2026-11-07 03:00:00', '2026-11-07 03:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 28, '2026-11-07', '2026-11-07', 1, '2026-11-07 03:58:11', '2026-11-07 03:58:11');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indeks untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indeks untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD CONSTRAINT `t_guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `t_kelas_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_3` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD CONSTRAINT `t_pelanggaran_ibfk_1` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`),
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_2` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_4` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_5` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_6` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD CONSTRAINT `t_wali_kelas_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
