-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Apr 2026 pada 14.34
-- Versi server: 11.4.9-MariaDB-cll-lve
-- Versi PHP: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mitra432_scopus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_tersimpan`
--

CREATE TABLE `jurnal_tersimpan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doi` varchar(150) NOT NULL COMMENT 'Digital Object Identifier - Unik',
  `judul` text NOT NULL COMMENT 'Judul Artikel / Jurnal',
  `penulis` text DEFAULT NULL COMMENT 'Daftar Penulis (dc:creator)',
  `nama_publikasi` varchar(255) DEFAULT NULL COMMENT 'Nama Jurnal (prism:publicationName)',
  `tahun_terbit` int(4) DEFAULT NULL COMMENT 'Tahun Publikasi',
  `kata_kunci` text DEFAULT NULL COMMENT 'Author Keywords dari Scopus',
  `abstrak` longtext DEFAULT NULL COMMENT 'Teks Abstrak (jika diekstrak)',
  `url_sumber` varchar(500) DEFAULT NULL COMMENT 'Link URL asli dokumen',
  `status_baca` enum('Belum Dibaca','Sedang Dibaca','Selesai','Relevan','Tidak Relevan') DEFAULT 'Belum Dibaca' COMMENT 'Label untuk pemetaan literatur',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu data disimpan ke sistem lokal',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_pencarian`
--

CREATE TABLE `riwayat_pencarian` (
  `id` int(11) NOT NULL,
  `kueri` varchar(255) NOT NULL COMMENT 'Kata kunci pencarian yang digunakan',
  `jumlah_hasil` int(11) DEFAULT 0 COMMENT 'Jumlah dokumen yang ditemukan',
  `waktu_pencarian` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jurnal_tersimpan`
--
ALTER TABLE `jurnal_tersimpan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_doi_unik` (`doi`),
  ADD KEY `idx_tahun` (`tahun_terbit`),
  ADD KEY `idx_status` (`status_baca`);

--
-- Indeks untuk tabel `riwayat_pencarian`
--
ALTER TABLE `riwayat_pencarian`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jurnal_tersimpan`
--
ALTER TABLE `jurnal_tersimpan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_pencarian`
--
ALTER TABLE `riwayat_pencarian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
