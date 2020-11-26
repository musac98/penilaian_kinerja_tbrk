-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table dbtbrk.data_penilaian_kinerja
DROP TABLE IF EXISTS `data_penilaian_kinerja`;
CREATE TABLE IF NOT EXISTS `data_penilaian_kinerja` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `kriteria` varchar(50) NOT NULL,
  `sub_kriteria` varchar(100) NOT NULL,
  `bobot` int(11) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.data_penilaian_kinerja: ~18 rows (approximately)
/*!40000 ALTER TABLE `data_penilaian_kinerja` DISABLE KEYS */;
INSERT INTO `data_penilaian_kinerja` (`id_kriteria`, `kriteria`, `sub_kriteria`, `bobot`) VALUES
	(1, 'Efisiensi', 'Penguasaan tentang sistem dan prosedur sesuai bidang masing-masing', 5),
	(2, 'Efisiensi', 'Hasil pekerjaan yang bermutu dan sesuai dengan peraturan yang ada', 5),
	(3, 'Kepedulian', 'Membantu pekerja lain jika mengalami kesulitan', 10),
	(4, 'Keantusiasan', 'Kemampuan semangat kerja tinggi dalam mempelajari ilmu baru dalam pekerjaan', 10),
	(5, 'Salam (Greeting)', 'Menyapa sesama karyawan', 5),
	(6, 'Salam (Greeting)', 'Mengucapkan salam ketika ada customer datang', 5),
	(7, 'Etika (Attitude)', 'Memeberikan sikap yang professional pada saat melayani  customer', 3),
	(8, 'Etika (Attitude)', 'Tingkah laku yang baik terhadap sesama karyawan', 3),
	(9, 'Etika (Attitude)', 'Tingkah laku yang baik terhadap atasan', 3),
	(10, 'Estimasi', 'Ketepatan waktu', 5),
	(11, 'Estimasi', 'Kehadiran karyawan', 5),
	(12, 'Kejujuran', 'Jujur dalam bekerja  dan saling terbuka dalam hal informasi demi kepentingan bersama', 10),
	(13, 'Kelengkapan  (Uniform)', 'Kelengkapan seragam', 5),
	(14, 'Kelengkapan  (Uniform)', 'Kerapian penampilan', 5),
	(15, 'Kerja sama', 'Kemampuan bekerja sama dengan karyawan lain', 5),
	(16, 'Kerja sama', 'Kemampuan bekerja sesuai dengan instruksi atasan', 5),
	(17, 'Passion', 'Bekerja dengan tulus dan ceria', 5),
	(18, 'Passion', 'Menunjukan gaya/style yang sejalan dengan pekerjaan', 5);
/*!40000 ALTER TABLE `data_penilaian_kinerja` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.grup_dinilai
DROP TABLE IF EXISTS `grup_dinilai`;
CREATE TABLE IF NOT EXISTS `grup_dinilai` (
  `id_grup` int(11) NOT NULL AUTO_INCREMENT,
  `id_penilai` int(11) NOT NULL,
  `id_kar` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id_grup`),
  KEY `id_penilai` (`id_penilai`),
  KEY `id_kar` (`id_kar`),
  CONSTRAINT `FK_grup_dinilai_karyawan` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grup_penilai_penilai` FOREIGN KEY (`id_penilai`) REFERENCES `penilai` (`id_penilai`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.grup_dinilai: ~10 rows (approximately)
/*!40000 ALTER TABLE `grup_dinilai` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `grup_dinilai` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.jabatan
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE IF NOT EXISTS `jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(12) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.jabatan: ~3 rows (approximately)
/*!40000 ALTER TABLE `jabatan` DISABLE KEYS */;
INSERT INTO `jabatan` (`id_jabatan`, `jabatan`, `level`) VALUES
	(1, 'Owner', 2),
	(2, 'Supervisor', 1),
	(3, 'Karyawan', 4);
/*!40000 ALTER TABLE `jabatan` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.karyawan
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE IF NOT EXISTS `karyawan` (
  `id_kar` varchar(12) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `password` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kar`),
  KEY `id_jabatan` (`id_jabatan`),
  KEY `id_toko` (`id_toko`),
  CONSTRAINT `fk_jab1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_toko1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.karyawan: ~13 rows (approximately)
/*!40000 ALTER TABLE `karyawan` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `karyawan` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.penilai
DROP TABLE IF EXISTS `penilai`;
CREATE TABLE IF NOT EXISTS `penilai` (
  `id_penilai` int(11) NOT NULL AUTO_INCREMENT,
  `id_periode` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `grup` varchar(50) NOT NULL DEFAULT '',
  `sts` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_penilai`),
  KEY `id_periode` (`id_periode`),
  KEY `id_toko` (`id_toko`),
  CONSTRAINT `FK_penilai_toko` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_per1` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.penilai: ~4 rows (approximately)
/*!40000 ALTER TABLE `penilai` DISABLE KEYS */;
INSERT INTO `penilai` (`id_penilai`, `id_periode`, `id_toko`, `grup`, `sts`) VALUES
	(11, 2, 3, 'grup321', '0'),
	(12, 2, 3, 'grup322', '0'),
	(13, 2, 1, 'grup121', '1'),
	(14, 2, 1, 'grup122', '0');
/*!40000 ALTER TABLE `penilai` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.penilaian
DROP TABLE IF EXISTS `penilaian`;
CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `id_penilai_detail` int(11) NOT NULL DEFAULT 0,
  `id_kriteria` int(11) NOT NULL,
  `hasil_nilai` int(11) NOT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `fk_krit1` (`id_kriteria`),
  KEY `id_penilai_detail` (`id_penilai_detail`),
  CONSTRAINT `FK_penilaian_penilai_detail` FOREIGN KEY (`id_penilai_detail`) REFERENCES `penilai_detail` (`id_penilai_detail`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_krit1` FOREIGN KEY (`id_kriteria`) REFERENCES `data_penilaian_kinerja` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.penilaian: ~288 rows (approximately)
/*!40000 ALTER TABLE `penilaian` DISABLE KEYS */;
INSERT INTO `penilaian` (`id_penilaian`, `id_penilai_detail`, `id_kriteria`, `hasil_nilai`) VALUES
	(1, 5, 1, 2),
	(2, 5, 2, 2),
	(3, 5, 3, 4),
	(4, 5, 4, 2),
	(5, 5, 5, 3),
	(6, 5, 6, 1),
	(7, 5, 7, 4),
	(8, 5, 8, 3),
	(9, 5, 9, 4),
	(10, 5, 10, 1),
	(11, 5, 11, 4),
	(12, 5, 12, 1),
	(13, 5, 13, 3),
	(14, 5, 14, 2),
	(15, 5, 15, 2),
	(16, 5, 16, 3),
	(17, 5, 17, 3),
	(18, 5, 18, 1),
	(19, 6, 1, 2),
	(20, 6, 2, 2),
	(21, 6, 3, 4),
	(22, 6, 4, 3),
	(23, 6, 5, 3),
	(24, 6, 6, 4),
	(25, 6, 7, 1),
	(26, 6, 8, 3),
	(27, 6, 9, 3),
	(28, 6, 10, 3),
	(29, 6, 11, 3),
	(30, 6, 12, 4),
	(31, 6, 13, 2),
	(32, 6, 14, 4),
	(33, 6, 15, 1),
	(34, 6, 16, 3),
	(35, 6, 17, 1),
	(36, 6, 18, 1),
	(37, 7, 1, 4),
	(38, 7, 2, 2),
	(39, 7, 3, 4),
	(40, 7, 4, 2),
	(41, 7, 5, 2),
	(42, 7, 6, 1),
	(43, 7, 7, 3),
	(44, 7, 8, 2),
	(45, 7, 9, 1),
	(46, 7, 10, 1),
	(47, 7, 11, 2),
	(48, 7, 12, 4),
	(49, 7, 13, 2),
	(50, 7, 14, 3),
	(51, 7, 15, 3),
	(52, 7, 16, 1),
	(53, 7, 17, 4),
	(54, 7, 18, 1),
	(55, 8, 1, 1),
	(56, 8, 2, 3),
	(57, 8, 3, 1),
	(58, 8, 4, 3),
	(59, 8, 5, 2),
	(60, 8, 6, 1),
	(61, 8, 7, 1),
	(62, 8, 8, 3),
	(63, 8, 9, 4),
	(64, 8, 10, 3),
	(65, 8, 11, 3),
	(66, 8, 12, 4),
	(67, 8, 13, 4),
	(68, 8, 14, 1),
	(69, 8, 15, 1),
	(70, 8, 16, 3),
	(71, 8, 17, 3),
	(72, 8, 18, 3),
	(73, 9, 1, 3),
	(74, 9, 2, 1),
	(75, 9, 3, 1),
	(76, 9, 4, 1),
	(77, 9, 5, 3),
	(78, 9, 6, 4),
	(79, 9, 7, 4),
	(80, 9, 8, 3),
	(81, 9, 9, 1),
	(82, 9, 10, 4),
	(83, 9, 11, 1),
	(84, 9, 12, 1),
	(85, 9, 13, 2),
	(86, 9, 14, 4),
	(87, 9, 15, 3),
	(88, 9, 16, 2),
	(89, 9, 17, 4),
	(90, 9, 18, 4),
	(91, 10, 1, 3),
	(92, 10, 2, 3),
	(93, 10, 3, 4),
	(94, 10, 4, 2),
	(95, 10, 5, 3),
	(96, 10, 6, 1),
	(97, 10, 7, 4),
	(98, 10, 8, 1),
	(99, 10, 9, 4),
	(100, 10, 10, 1),
	(101, 10, 11, 1),
	(102, 10, 12, 1),
	(103, 10, 13, 3),
	(104, 10, 14, 2),
	(105, 10, 15, 4),
	(106, 10, 16, 4),
	(107, 10, 17, 1),
	(108, 10, 18, 3),
	(109, 11, 1, 1),
	(110, 11, 2, 3),
	(111, 11, 3, 3),
	(112, 11, 4, 1),
	(113, 11, 5, 3),
	(114, 11, 6, 1),
	(115, 11, 7, 3),
	(116, 11, 8, 1),
	(117, 11, 9, 4),
	(118, 11, 10, 3),
	(119, 11, 11, 3),
	(120, 11, 12, 3),
	(121, 11, 13, 2),
	(122, 11, 14, 1),
	(123, 11, 15, 3),
	(124, 11, 16, 3),
	(125, 11, 17, 2),
	(126, 11, 18, 3),
	(127, 12, 1, 4),
	(128, 12, 2, 4),
	(129, 12, 3, 1),
	(130, 12, 4, 2),
	(131, 12, 5, 2),
	(132, 12, 6, 3),
	(133, 12, 7, 3),
	(134, 12, 8, 3),
	(135, 12, 9, 2),
	(136, 12, 10, 4),
	(137, 12, 11, 1),
	(138, 12, 12, 3),
	(139, 12, 13, 2),
	(140, 12, 14, 1),
	(141, 12, 15, 2),
	(142, 12, 16, 1),
	(143, 12, 17, 3),
	(144, 12, 18, 1),
	(145, 5, 1, 3),
	(146, 5, 2, 3),
	(147, 5, 3, 1),
	(148, 5, 4, 1),
	(149, 5, 5, 3),
	(150, 5, 6, 1),
	(151, 5, 7, 2),
	(152, 5, 8, 1),
	(153, 5, 9, 3),
	(154, 5, 10, 3),
	(155, 5, 11, 3),
	(156, 5, 12, 2),
	(157, 5, 13, 1),
	(158, 5, 14, 2),
	(159, 5, 15, 3),
	(160, 5, 16, 4),
	(161, 5, 17, 3),
	(162, 5, 18, 4),
	(163, 6, 1, 4),
	(164, 6, 2, 3),
	(165, 6, 3, 4),
	(166, 6, 4, 2),
	(167, 6, 5, 1),
	(168, 6, 6, 3),
	(169, 6, 7, 2),
	(170, 6, 8, 3),
	(171, 6, 9, 3),
	(172, 6, 10, 3),
	(173, 6, 11, 1),
	(174, 6, 12, 2),
	(175, 6, 13, 2),
	(176, 6, 14, 1),
	(177, 6, 15, 4),
	(178, 6, 16, 2),
	(179, 6, 17, 1),
	(180, 6, 18, 1),
	(181, 7, 1, 2),
	(182, 7, 2, 4),
	(183, 7, 3, 2),
	(184, 7, 4, 2),
	(185, 7, 5, 3),
	(186, 7, 6, 3),
	(187, 7, 7, 1),
	(188, 7, 8, 1),
	(189, 7, 9, 1),
	(190, 7, 10, 3),
	(191, 7, 11, 4),
	(192, 7, 12, 1),
	(193, 7, 13, 4),
	(194, 7, 14, 3),
	(195, 7, 15, 1),
	(196, 7, 16, 1),
	(197, 7, 17, 4),
	(198, 7, 18, 2),
	(199, 8, 1, 2),
	(200, 8, 2, 1),
	(201, 8, 3, 3),
	(202, 8, 4, 2),
	(203, 8, 5, 4),
	(204, 8, 6, 1),
	(205, 8, 7, 3),
	(206, 8, 8, 2),
	(207, 8, 9, 1),
	(208, 8, 10, 1),
	(209, 8, 11, 4),
	(210, 8, 12, 2),
	(211, 8, 13, 4),
	(212, 8, 14, 3),
	(213, 8, 15, 3),
	(214, 8, 16, 1),
	(215, 8, 17, 3),
	(216, 8, 18, 3),
	(217, 9, 1, 1),
	(218, 9, 2, 2),
	(219, 9, 3, 4),
	(220, 9, 4, 1),
	(221, 9, 5, 4),
	(222, 9, 6, 3),
	(223, 9, 7, 2),
	(224, 9, 8, 2),
	(225, 9, 9, 1),
	(226, 9, 10, 1),
	(227, 9, 11, 4),
	(228, 9, 12, 1),
	(229, 9, 13, 3),
	(230, 9, 14, 1),
	(231, 9, 15, 2),
	(232, 9, 16, 1),
	(233, 9, 17, 3),
	(234, 9, 18, 1),
	(235, 10, 1, 1),
	(236, 10, 2, 2),
	(237, 10, 3, 3),
	(238, 10, 4, 2),
	(239, 10, 5, 3),
	(240, 10, 6, 1),
	(241, 10, 7, 4),
	(242, 10, 8, 3),
	(243, 10, 9, 1),
	(244, 10, 10, 1),
	(245, 10, 11, 2),
	(246, 10, 12, 4),
	(247, 10, 13, 2),
	(248, 10, 14, 1),
	(249, 10, 15, 3),
	(250, 10, 16, 3),
	(251, 10, 17, 1),
	(252, 10, 18, 4),
	(253, 11, 1, 2),
	(254, 11, 2, 3),
	(255, 11, 3, 4),
	(256, 11, 4, 1),
	(257, 11, 5, 3),
	(258, 11, 6, 4),
	(259, 11, 7, 3),
	(260, 11, 8, 4),
	(261, 11, 9, 4),
	(262, 11, 10, 3),
	(263, 11, 11, 4),
	(264, 11, 12, 3),
	(265, 11, 13, 3),
	(266, 11, 14, 4),
	(267, 11, 15, 3),
	(268, 11, 16, 3),
	(269, 11, 17, 4),
	(270, 11, 18, 2),
	(271, 12, 1, 4),
	(272, 12, 2, 4),
	(273, 12, 3, 4),
	(274, 12, 4, 2),
	(275, 12, 5, 2),
	(276, 12, 6, 3),
	(277, 12, 7, 1),
	(278, 12, 8, 2),
	(279, 12, 9, 3),
	(280, 12, 10, 2),
	(281, 12, 11, 1),
	(282, 12, 12, 2),
	(283, 12, 13, 4),
	(284, 12, 14, 3),
	(285, 12, 15, 4),
	(286, 12, 16, 1),
	(287, 12, 17, 3),
	(288, 12, 18, 2);
/*!40000 ALTER TABLE `penilaian` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.penilai_detail
DROP TABLE IF EXISTS `penilai_detail`;
CREATE TABLE IF NOT EXISTS `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_penilai` int(11) NOT NULL,
  `id_kar` varchar(12) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_penilai_detail`),
  KEY `id_penilai` (`id_penilai`),
  KEY `id_kar` (`id_kar`),
  CONSTRAINT `FK_penilai_detail_karyawan` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_penilai_detail_penilai` FOREIGN KEY (`id_penilai`) REFERENCES `penilai` (`id_penilai`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbtbrk.penilai_detail: ~8 rows (approximately)
/*!40000 ALTER TABLE `penilai_detail` DISABLE KEYS */;
INSERT INTO `penilai_detail` (`id_penilai_detail`, `id_penilai`, `id_kar`) VALUES
	(5, 11, 'suptbrk'),
	(6, 11, 'ownertbrk'),
	(7, 12, 'suptbrk'),
	(8, 12, 'ownertbrk'),
	(9, 13, 'suptbrk2'),
	(10, 13, 'ownertbrk'),
	(11, 14, 'suptbrk2'),
	(12, 14, 'ownertbrk');
/*!40000 ALTER TABLE `penilai_detail` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.periode
DROP TABLE IF EXISTS `periode`;
CREATE TABLE IF NOT EXISTS `periode` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` varchar(50) NOT NULL,
  `bulan` varchar(50) NOT NULL,
  `pekan` varchar(50) NOT NULL,
  `status_periode` int(11) NOT NULL,
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.periode: ~3 rows (approximately)
/*!40000 ALTER TABLE `periode` DISABLE KEYS */;
INSERT INTO `periode` (`id_periode`, `tahun`, `bulan`, `pekan`, `status_periode`) VALUES
	(1, '2020', '11', '2', 0),
	(2, '2020', '11', '4', 1),
	(3, '2020', '12', '2', 0);
/*!40000 ALTER TABLE `periode` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.presensi
DROP TABLE IF EXISTS `presensi`;
CREATE TABLE IF NOT EXISTS `presensi` (
  `id_pres` int(11) NOT NULL AUTO_INCREMENT,
  `id_periode` int(11) NOT NULL DEFAULT 0,
  `id_kar` varchar(12) NOT NULL,
  `jml_masuk` int(11) NOT NULL,
  PRIMARY KEY (`id_pres`),
  KEY `id_kar` (`id_kar`),
  KEY `id_periode` (`id_periode`),
  CONSTRAINT `FK_presensi_periode` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kar2` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.presensi: ~9 rows (approximately)
/*!40000 ALTER TABLE `presensi` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `presensi` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.toko
DROP TABLE IF EXISTS `toko`;
CREATE TABLE IF NOT EXISTS `toko` (
  `id_toko` int(11) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(50) NOT NULL,
  `setting_jml` varchar(50) NOT NULL,
  PRIMARY KEY (`id_toko`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.toko: ~2 rows (approximately)
/*!40000 ALTER TABLE `toko` DISABLE KEYS */;
INSERT INTO `toko` (`id_toko`, `lokasi`, `setting_jml`) VALUES
	(1, 'Jl. Manukan Dalam No.12', '2'),
	(3, 'Jl. Wonorejo IV', '3');
/*!40000 ALTER TABLE `toko` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
