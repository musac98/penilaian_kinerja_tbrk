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
  `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL DEFAULT 0,
  `sub_kriteria` varchar(100) NOT NULL,
  PRIMARY KEY (`id_sub_kriteria`) USING BTREE,
  KEY `id_kriteria` (`id_kriteria`),
  CONSTRAINT `FK_data_penilaian_kinerja_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.data_penilaian_kinerja: ~18 rows (approximately)
/*!40000 ALTER TABLE `data_penilaian_kinerja` DISABLE KEYS */;
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

-- Dumping structure for table dbtbrk.kriteria
DROP TABLE IF EXISTS `kriteria`;
CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(200) DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbtbrk.kriteria: ~10 rows (approximately)
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;

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
	(11, 2, 3, 'grup321', '1'),
	(12, 2, 3, 'grup322', '0'),
	(13, 2, 1, 'grup121', '1'),
	(14, 2, 1, 'grup122', '0');
/*!40000 ALTER TABLE `penilai` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.penilaian
DROP TABLE IF EXISTS `penilaian`;
CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `id_penilai_detail` int(11) NOT NULL DEFAULT 0,
  `id_sub_kriteria` int(11) NOT NULL,
  `hasil_nilai` int(11) NOT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `id_penilai_detail` (`id_penilai_detail`),
  KEY `id_sub_kriteria` (`id_sub_kriteria`),
  CONSTRAINT `FK_penilaian_data_penilaian_kinerja` FOREIGN KEY (`id_sub_kriteria`) REFERENCES `data_penilaian_kinerja` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_penilaian_penilai_detail` FOREIGN KEY (`id_penilai_detail`) REFERENCES `penilai_detail` (`id_penilai_detail`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.penilaian: ~144 rows (approximately)
/*!40000 ALTER TABLE `penilaian` DISABLE KEYS */;
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

-- Dumping data for table dbtbrk.presensi: ~10 rows (approximately)
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
