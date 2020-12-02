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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.grup_dinilai: ~10 rows (approximately)
/*!40000 ALTER TABLE `grup_dinilai` DISABLE KEYS */;
INSERT INTO `grup_dinilai` (`id_grup`, `id_penilai`, `id_kar`) VALUES
	(57, 27, 'kar01'),
	(58, 27, 'karya123'),
	(59, 28, 'kar03'),
	(60, 28, 'kar02'),
	(67, 29, 'kar04'),
	(68, 29, 'kar05'),
	(69, 29, 'kar08'),
	(70, 30, 'kar06'),
	(71, 30, 'kar07'),
	(72, 30, 'adhit123');
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.penilai: ~4 rows (approximately)
/*!40000 ALTER TABLE `penilai` DISABLE KEYS */;
INSERT INTO `penilai` (`id_penilai`, `id_periode`, `id_toko`, `grup`, `sts`) VALUES
	(27, 3, 1, 'grup131', '0'),
	(28, 3, 1, 'grup132', '0'),
	(29, 3, 3, 'grup331', '0'),
	(30, 3, 3, 'grup332', '0');
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
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.penilaian: ~108 rows (approximately)
/*!40000 ALTER TABLE `penilaian` DISABLE KEYS */;
INSERT INTO `penilaian` (`id_penilaian`, `id_penilai_detail`, `id_sub_kriteria`, `hasil_nilai`) VALUES
	(37, 70, 1, 4),
	(38, 70, 2, 4),
	(39, 70, 3, 4),
	(40, 70, 4, 4),
	(41, 70, 5, 4),
	(42, 70, 6, 4),
	(43, 70, 7, 4),
	(44, 70, 8, 4),
	(45, 70, 9, 4),
	(46, 70, 10, 4),
	(47, 70, 11, 4),
	(48, 70, 12, 4),
	(49, 70, 13, 4),
	(50, 70, 14, 4),
	(51, 70, 15, 4),
	(52, 70, 16, 4),
	(53, 70, 17, 4),
	(54, 70, 18, 4),
	(55, 72, 1, 4),
	(56, 72, 2, 4),
	(57, 72, 3, 4),
	(58, 72, 4, 4),
	(59, 72, 5, 4),
	(60, 72, 6, 4),
	(61, 72, 7, 4),
	(62, 72, 8, 4),
	(63, 72, 9, 4),
	(64, 72, 10, 4),
	(65, 72, 11, 4),
	(66, 72, 12, 4),
	(67, 72, 13, 4),
	(68, 72, 14, 4),
	(69, 72, 15, 4),
	(70, 72, 16, 4),
	(71, 72, 17, 4),
	(72, 72, 18, 4),
	(73, 69, 1, 4),
	(74, 69, 2, 4),
	(75, 69, 3, 4),
	(76, 69, 4, 4),
	(77, 69, 5, 4),
	(78, 69, 6, 4),
	(79, 69, 7, 4),
	(80, 69, 8, 4),
	(81, 69, 9, 4),
	(82, 69, 10, 4),
	(83, 69, 11, 4),
	(84, 69, 12, 4),
	(85, 69, 13, 4),
	(86, 69, 14, 4),
	(87, 69, 15, 4),
	(88, 69, 16, 4),
	(89, 69, 17, 4),
	(90, 69, 18, 4),
	(91, 71, 1, 4),
	(92, 71, 2, 4),
	(93, 71, 3, 4),
	(94, 71, 4, 4),
	(95, 71, 5, 4),
	(96, 71, 6, 4),
	(97, 71, 7, 4),
	(98, 71, 8, 4),
	(99, 71, 9, 4),
	(100, 71, 10, 4),
	(101, 71, 11, 4),
	(102, 71, 12, 4),
	(103, 71, 13, 4),
	(104, 71, 14, 4),
	(105, 71, 15, 4),
	(106, 71, 16, 4),
	(107, 71, 17, 4),
	(108, 71, 18, 4),
	(109, 73, 1, 3),
	(110, 73, 2, 4),
	(111, 73, 3, 3),
	(112, 73, 4, 3),
	(113, 73, 5, 3),
	(114, 73, 6, 3),
	(115, 73, 7, 3),
	(116, 73, 8, 2),
	(117, 73, 9, 2),
	(118, 73, 10, 2),
	(119, 73, 11, 2),
	(120, 73, 12, 2),
	(121, 73, 13, 2),
	(122, 73, 14, 2),
	(123, 73, 15, 2),
	(124, 73, 16, 3),
	(125, 73, 17, 3),
	(126, 73, 18, 2),
	(127, 74, 1, 3),
	(128, 74, 2, 1),
	(129, 74, 3, 1),
	(130, 74, 4, 1),
	(131, 74, 5, 1),
	(132, 74, 6, 1),
	(133, 74, 7, 1),
	(134, 74, 8, 1),
	(135, 74, 9, 1),
	(136, 74, 10, 1),
	(137, 74, 11, 1),
	(138, 74, 12, 1),
	(139, 74, 13, 1),
	(140, 74, 14, 1),
	(141, 74, 15, 1),
	(142, 74, 16, 2),
	(143, 74, 17, 2),
	(144, 74, 18, 1);
/*!40000 ALTER TABLE `penilaian` ENABLE KEYS */;

-- Dumping structure for table dbtbrk.penilai_detail
DROP TABLE IF EXISTS `penilai_detail`;
CREATE TABLE IF NOT EXISTS `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_grup` int(11) NOT NULL,
  `id_kar` varchar(12) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_penilai_detail`),
  KEY `id_kar` (`id_kar`),
  KEY `id_grup` (`id_grup`),
  CONSTRAINT `FK_penilai_detail_grup_dinilai` FOREIGN KEY (`id_grup`) REFERENCES `grup_dinilai` (`id_grup`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_penilai_detail_karyawan` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dbtbrk.penilai_detail: ~20 rows (approximately)
/*!40000 ALTER TABLE `penilai_detail` DISABLE KEYS */;
INSERT INTO `penilai_detail` (`id_penilai_detail`, `id_grup`, `id_kar`) VALUES
	(69, 57, 'suptbrk'),
	(70, 57, 'ownertbrk'),
	(71, 58, 'suptbrk'),
	(72, 58, 'ownertbrk'),
	(73, 59, 'suptbrk'),
	(74, 59, 'ownertbrk'),
	(75, 60, 'suptbrk'),
	(76, 60, 'ownertbrk'),
	(89, 67, 'suptbrk'),
	(90, 67, 'ownertbrk'),
	(91, 68, 'suptbrk'),
	(92, 68, 'ownertbrk'),
	(93, 69, 'suptbrk'),
	(94, 69, 'ownertbrk'),
	(95, 70, 'suptbrk'),
	(96, 70, 'ownertbrk'),
	(97, 71, 'suptbrk'),
	(98, 71, 'ownertbrk'),
	(99, 72, 'suptbrk'),
	(100, 72, 'ownertbrk');
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
	(2, '2020', '11', '4', 0),
	(3, '2020', '12', '2', 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table dbtbrk.presensi: ~13 rows (approximately)
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
	(22, 2, 'kar03', 12),
	(23, 3, 'kar01', 12),
	(24, 3, 'kar02', 12),
	(25, 3, 'kar03', 12),
	(26, 3, 'karya123', 12);
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
