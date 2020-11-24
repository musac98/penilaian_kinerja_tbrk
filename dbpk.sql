-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table dbpk.periode
CREATE TABLE IF NOT EXISTS `periode` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_ajar` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `status_periode` int(11) NOT NULL,
  `setting` varchar(50) NOT NULL,
  `setting_jml` varchar(50) NOT NULL,
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table dbpk.periode: ~4 rows (approximately)
/*!40000 ALTER TABLE `periode` DISABLE KEYS */;
INSERT INTO `periode` (`id_periode`, `tahun_ajar`, `semester`, `status_periode`, `setting`, `setting_jml`) VALUES
	(1, '2018', 'Ganjil', 0, '50;25;15;10', '3;10'),
	(2, '2018', 'Genap', 0, '50;30;10;10', '3;10'),
	(3, '2019', 'Ganjil', 0, '50;30;10;10', '3;10'),
	(5, '2020', 'Ganjil', 1, '40;30;20;10', '5;5');
/*!40000 ALTER TABLE `periode` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
