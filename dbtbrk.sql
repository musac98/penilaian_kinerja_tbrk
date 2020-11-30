-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30 Nov 2020 pada 04.23
-- Versi Server: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbtbrk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_penilaian_kinerja`
--

CREATE TABLE `data_penilaian_kinerja` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL DEFAULT '0',
  `sub_kriteria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_penilaian_kinerja`
--

INSERT INTO `data_penilaian_kinerja` (`id_sub_kriteria`, `id_kriteria`, `sub_kriteria`) VALUES
(1, 1, 'Penguasaan tentang sistem dan prosedur sesuai bidang masing-masing'),
(2, 1, 'Hasil pekerjaan yang bermutu dan sesuai dengan peraturan yang ada'),
(3, 2, 'Membantu pekerja lain jika mengalami kesulitan'),
(4, 3, 'Kemampuan semangat kerja tinggi dalam mempelajari ilmu baru dalam pekerjaan'),
(5, 4, 'Menyapa sesama karyawan'),
(6, 4, 'Mengucapkan salam ketika ada customer datang'),
(7, 5, 'Memeberikan sikap yang professional pada saat melayani  customer'),
(8, 5, 'Tingkah laku yang baik terhadap sesama karyawan'),
(9, 5, 'Tingkah laku yang baik terhadap atasan'),
(10, 6, 'Ketepatan waktu'),
(11, 6, 'Kehadiran karyawan'),
(12, 7, 'Jujur dalam bekerja  dan saling terbuka dalam hal informasi demi kepentingan bersama'),
(13, 8, 'Kelengkapan seragam'),
(14, 8, 'Kerapian penampilan'),
(15, 9, 'Kemampuan bekerja sama dengan karyawan lain'),
(16, 9, 'Kemampuan bekerja sesuai dengan instruksi atasan'),
(17, 10, 'Bekerja dengan tulus dan ceria'),
(18, 10, 'Menunjukan gaya/style yang sejalan dengan pekerjaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grup_dinilai`
--

CREATE TABLE `grup_dinilai` (
  `id_grup` int(11) NOT NULL,
  `id_penilai` int(11) NOT NULL,
  `id_kar` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `grup_dinilai`
--

INSERT INTO `grup_dinilai` (`id_grup`, `id_penilai`, `id_kar`) VALUES
(5, 11, 'adhit123'),
(6, 11, 'kar04'),
(7, 11, 'kar05'),
(8, 12, 'kar06'),
(9, 12, 'kar07'),
(10, 12, 'kar08'),
(15, 13, 'kar01'),
(16, 13, 'kar02'),
(17, 14, 'kar03'),
(18, 14, 'karya123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `jabatan` varchar(12) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `jabatan`, `level`) VALUES
(1, 'Owner', 2),
(2, 'Supervisor', 1),
(3, 'Karyawan', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_kar` varchar(12) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `password` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_kar`, `id_jabatan`, `id_toko`, `password`, `nama`, `alamat`, `no_telp`) VALUES
('adhit123', 3, 3, 'adhit321', 'Adhitya', 'Jl. a', '123456'),
('kar01', 3, 1, '1234', 'Karyawan Toko 1.1', 'Jl. ini no 1', '87776765652'),
('kar02', 3, 1, '1234', 'Karyawan Toko 1.2', 'Jl. ini no 2', '88276355652'),
('kar03', 3, 1, '1234', 'Karyawan Toko 1.3', 'Jl. ini no 3', '87791882736'),
('kar04', 3, 3, '1234', 'Karyawan Toko 2.1', 'Jl. itu no 1', '83847765652'),
('kar05', 3, 3, '1234', 'Karyawan Toko 2.2', 'Jl. itu no 2', '87928375652'),
('kar06', 3, 3, '1234', 'Karyawan Toko 2.3', 'Jl. itu no 3', '88278295652'),
('kar07', 3, 3, '1234', 'Karyawan Toko 2.4', 'Jl. itu no 4', '12972825652'),
('kar08', 3, 3, '1234', 'Karyawan Toko 2.5', 'Jl. itu no 5', '82982728922'),
('karya123', 3, 1, '321karya', 'Karyawan', 'Jl. Pandegiling', '08189912376'),
('ownertbrk', 1, 1, 'tbrkowner', 'Owner', 'Jl. Babatan Pilang', '08112345678'),
('suptbrk', 2, 1, 'tbrksup', 'Supervisor', 'Jl. Banyu Urip', '081987654321'),
('suptbrk2', 2, 3, 'tbrksup2', 'Sup2', 'Jl. Gayungan', '0821212457');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kriteria` varchar(200) DEFAULT NULL,
  `bobot` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `bobot`) VALUES
(1, 'Efisiensi', 10),
(2, 'Kepedulian', 10),
(3, 'Keantusiasan', 10),
(4, 'Salam (Greeting)', 10),
(5, 'Etika (Attitude)', 10),
(6, 'Estimasi', 10),
(7, 'Kejujuran', 10),
(8, 'Kelengkapan  (Uniform)', 10),
(9, 'Kerja sama', 10),
(10, 'Passion', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai`
--

CREATE TABLE `penilai` (
  `id_penilai` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `grup` varchar(50) NOT NULL DEFAULT '',
  `sts` char(1) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilai`
--

INSERT INTO `penilai` (`id_penilai`, `id_periode`, `id_toko`, `grup`, `sts`) VALUES
(11, 2, 3, 'grup321', '1'),
(12, 2, 3, 'grup322', '0'),
(13, 2, 1, 'grup121', '1'),
(14, 2, 1, 'grup122', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_penilai_detail` int(11) NOT NULL DEFAULT '0',
  `id_sub_kriteria` int(11) NOT NULL,
  `hasil_nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_penilai_detail`, `id_sub_kriteria`, `hasil_nilai`) VALUES
(37, 7, 1, 4),
(38, 7, 2, 3),
(39, 7, 3, 2),
(40, 7, 4, 1),
(41, 7, 5, 3),
(42, 7, 6, 4),
(43, 7, 7, 1),
(44, 7, 8, 4),
(45, 7, 9, 2),
(46, 7, 10, 1),
(47, 7, 11, 4),
(48, 7, 12, 2),
(49, 7, 13, 2),
(50, 7, 14, 3),
(51, 7, 15, 1),
(52, 7, 16, 4),
(53, 7, 17, 1),
(54, 7, 18, 3),
(55, 8, 1, 2),
(56, 8, 2, 2),
(57, 8, 3, 1),
(58, 8, 4, 3),
(59, 8, 5, 3),
(60, 8, 6, 3),
(61, 8, 7, 3),
(62, 8, 8, 3),
(63, 8, 9, 1),
(64, 8, 10, 3),
(65, 8, 11, 2),
(66, 8, 12, 4),
(67, 8, 13, 2),
(68, 8, 14, 2),
(69, 8, 15, 2),
(70, 8, 16, 3),
(71, 8, 17, 3),
(72, 8, 18, 1),
(73, 9, 1, 4),
(74, 9, 2, 2),
(75, 9, 3, 1),
(76, 9, 4, 3),
(77, 9, 5, 2),
(78, 9, 6, 4),
(79, 9, 7, 4),
(80, 9, 8, 1),
(81, 9, 9, 2),
(82, 9, 10, 4),
(83, 9, 11, 2),
(84, 9, 12, 3),
(85, 9, 13, 3),
(86, 9, 14, 1),
(87, 9, 15, 4),
(88, 9, 16, 2),
(89, 9, 17, 2),
(90, 9, 18, 4),
(91, 10, 1, 2),
(92, 10, 2, 3),
(93, 10, 3, 1),
(94, 10, 4, 1),
(95, 10, 5, 2),
(96, 10, 6, 1),
(97, 10, 7, 1),
(98, 10, 8, 3),
(99, 10, 9, 2),
(100, 10, 10, 4),
(101, 10, 11, 4),
(102, 10, 12, 4),
(103, 10, 13, 2),
(104, 10, 14, 4),
(105, 10, 15, 1),
(106, 10, 16, 3),
(107, 10, 17, 1),
(108, 10, 18, 2),
(109, 11, 1, 4),
(110, 11, 2, 1),
(111, 11, 3, 1),
(112, 11, 4, 1),
(113, 11, 5, 1),
(114, 11, 6, 4),
(115, 11, 7, 2),
(116, 11, 8, 1),
(117, 11, 9, 2),
(118, 11, 10, 2),
(119, 11, 11, 4),
(120, 11, 12, 2),
(121, 11, 13, 1),
(122, 11, 14, 4),
(123, 11, 15, 3),
(124, 11, 16, 4),
(125, 11, 17, 2),
(126, 11, 18, 2),
(127, 12, 1, 4),
(128, 12, 2, 4),
(129, 12, 3, 1),
(130, 12, 4, 1),
(131, 12, 5, 4),
(132, 12, 6, 4),
(133, 12, 7, 2),
(134, 12, 8, 1),
(135, 12, 9, 3),
(136, 12, 10, 1),
(137, 12, 11, 2),
(138, 12, 12, 1),
(139, 12, 13, 3),
(140, 12, 14, 2),
(141, 12, 15, 1),
(142, 12, 16, 4),
(143, 12, 17, 4),
(144, 12, 18, 3),
(145, 6, 1, 4),
(146, 6, 2, 4),
(147, 6, 3, 4),
(148, 6, 4, 4),
(149, 6, 5, 4),
(150, 6, 6, 4),
(151, 6, 7, 4),
(152, 6, 8, 4),
(153, 6, 9, 4),
(154, 6, 10, 4),
(155, 6, 11, 4),
(156, 6, 12, 4),
(157, 6, 13, 4),
(158, 6, 14, 4),
(159, 6, 15, 4),
(160, 6, 16, 4),
(161, 6, 17, 4),
(162, 6, 18, 4),
(163, 5, 1, 4),
(164, 5, 2, 4),
(165, 5, 3, 4),
(166, 5, 4, 4),
(167, 5, 5, 4),
(168, 5, 6, 4),
(169, 5, 7, 4),
(170, 5, 8, 4),
(171, 5, 9, 4),
(172, 5, 10, 4),
(173, 5, 11, 4),
(174, 5, 12, 4),
(175, 5, 13, 4),
(176, 5, 14, 4),
(177, 5, 15, 4),
(178, 5, 16, 4),
(179, 5, 17, 4),
(180, 5, 18, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai_detail`
--

CREATE TABLE `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL,
  `id_penilai` int(11) NOT NULL,
  `id_kar` varchar(12) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penilai_detail`
--

INSERT INTO `penilai_detail` (`id_penilai_detail`, `id_penilai`, `id_kar`) VALUES
(5, 11, 'suptbrk'),
(6, 11, 'ownertbrk'),
(7, 12, 'suptbrk'),
(8, 12, 'ownertbrk'),
(9, 13, 'suptbrk2'),
(10, 13, 'ownertbrk'),
(11, 14, 'suptbrk2'),
(12, 14, 'ownertbrk');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE `periode` (
  `id_periode` int(11) NOT NULL,
  `tahun` varchar(50) NOT NULL,
  `bulan` varchar(50) NOT NULL,
  `pekan` varchar(50) NOT NULL,
  `status_periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`id_periode`, `tahun`, `bulan`, `pekan`, `status_periode`) VALUES
(1, '2020', '11', '2', 0),
(2, '2020', '11', '4', 1),
(3, '2020', '12', '2', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id_pres` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL DEFAULT '0',
  `id_kar` varchar(12) NOT NULL,
  `jml_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id_pres`, `id_periode`, `id_kar`, `jml_masuk`) VALUES
(2, 2, 'karya123', 12),
(7, 2, 'adhit123', 12),
(12, 2, 'kar01', 12),
(13, 2, 'kar02', 12),
(17, 2, 'kar04', 12),
(18, 2, 'kar05', 12),
(19, 2, 'kar06', 12),
(20, 2, 'kar07', 12),
(21, 2, 'kar08', 12),
(22, 2, 'kar03', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `setting_jml` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `toko`
--

INSERT INTO `toko` (`id_toko`, `lokasi`, `setting_jml`) VALUES
(1, 'Jl. Manukan Dalam No.12', '2'),
(3, 'Jl. Wonorejo IV', '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_penilaian_kinerja`
--
ALTER TABLE `data_penilaian_kinerja`
  ADD PRIMARY KEY (`id_sub_kriteria`) USING BTREE,
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `grup_dinilai`
--
ALTER TABLE `grup_dinilai`
  ADD PRIMARY KEY (`id_grup`),
  ADD KEY `id_penilai` (`id_penilai`),
  ADD KEY `id_kar` (`id_kar`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_kar`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_toko` (`id_toko`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilai`
--
ALTER TABLE `penilai`
  ADD PRIMARY KEY (`id_penilai`),
  ADD KEY `id_periode` (`id_periode`),
  ADD KEY `id_toko` (`id_toko`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_penilai_detail` (`id_penilai_detail`),
  ADD KEY `id_sub_kriteria` (`id_sub_kriteria`);

--
-- Indexes for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD PRIMARY KEY (`id_penilai_detail`),
  ADD KEY `id_penilai` (`id_penilai`),
  ADD KEY `id_kar` (`id_kar`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_pres`),
  ADD KEY `id_kar` (`id_kar`),
  ADD KEY `id_periode` (`id_periode`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_penilaian_kinerja`
--
ALTER TABLE `data_penilaian_kinerja`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `grup_dinilai`
--
ALTER TABLE `grup_dinilai`
  MODIFY `id_grup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  MODIFY `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_pres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_penilaian_kinerja`
--
ALTER TABLE `data_penilaian_kinerja`
  ADD CONSTRAINT `FK_data_penilaian_kinerja_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `grup_dinilai`
--
ALTER TABLE `grup_dinilai`
  ADD CONSTRAINT `FK_grup_dinilai_karyawan` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_grup_penilai_penilai` FOREIGN KEY (`id_penilai`) REFERENCES `penilai` (`id_penilai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `fk_jab1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_toko1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilai`
--
ALTER TABLE `penilai`
  ADD CONSTRAINT `FK_penilai_toko` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_per1` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `FK_penilaian_data_penilaian_kinerja` FOREIGN KEY (`id_sub_kriteria`) REFERENCES `data_penilaian_kinerja` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilaian_penilai_detail` FOREIGN KEY (`id_penilai_detail`) REFERENCES `penilai_detail` (`id_penilai_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD CONSTRAINT `FK_penilai_detail_karyawan` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilai_detail_penilai` FOREIGN KEY (`id_penilai`) REFERENCES `penilai` (`id_penilai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `FK_presensi_periode` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kar2` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
