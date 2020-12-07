-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 05 Des 2020 pada 10.33
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
(73, 31, 'kar01'),
(74, 31, 'kar02'),
(75, 32, 'kar03'),
(76, 32, 'karya123'),
(77, 33, 'adhit123'),
(78, 33, 'kar04'),
(79, 33, 'kar05'),
(80, 34, 'kar06'),
(81, 34, 'kar07'),
(82, 34, 'kar08');

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
('suptbrk', 2, 1, 'tbrksup', 'Sup manukan', 'Jl. Banyu Urip', '081987654321'),
('suptbrk2', 2, 3, 'tbrksup2', 'Sup wonorejo', 'Jl. Gayungan', '0821212457');

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
(31, 3, 1, 'grup131', '1'),
(32, 3, 1, 'grup132', '1'),
(33, 3, 3, 'grup331', '1'),
(34, 3, 3, 'grup332', '1');

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
(307, 101, 1, 3),
(308, 101, 2, 2),
(309, 101, 3, 2),
(310, 101, 4, 3),
(311, 101, 5, 3),
(312, 101, 6, 3),
(313, 101, 7, 3),
(314, 101, 8, 3),
(315, 101, 9, 3),
(316, 101, 10, 3),
(317, 101, 11, 3),
(318, 101, 12, 3),
(319, 101, 13, 2),
(320, 101, 14, 3),
(321, 101, 15, 3),
(322, 101, 16, 3),
(323, 101, 17, 3),
(324, 101, 18, 2),
(325, 102, 1, 2),
(326, 102, 2, 2),
(327, 102, 3, 2),
(328, 102, 4, 2),
(329, 102, 5, 2),
(330, 102, 6, 2),
(331, 102, 7, 2),
(332, 102, 8, 2),
(333, 102, 9, 2),
(334, 102, 10, 2),
(335, 102, 11, 2),
(336, 102, 12, 2),
(337, 102, 13, 2),
(338, 102, 14, 2),
(339, 102, 15, 3),
(340, 102, 16, 3),
(341, 102, 17, 3),
(342, 102, 18, 2),
(343, 103, 1, 2),
(344, 103, 2, 2),
(345, 103, 3, 2),
(346, 103, 4, 2),
(347, 103, 5, 2),
(348, 103, 6, 2),
(349, 103, 7, 2),
(350, 103, 8, 2),
(351, 103, 9, 2),
(352, 103, 10, 3),
(353, 103, 11, 2),
(354, 103, 12, 4),
(355, 103, 13, 3),
(356, 103, 14, 3),
(357, 103, 15, 3),
(358, 103, 16, 3),
(359, 103, 17, 2),
(360, 103, 18, 4),
(361, 104, 1, 4),
(362, 104, 2, 4),
(363, 104, 3, 4),
(364, 104, 4, 4),
(365, 104, 5, 4),
(366, 104, 6, 4),
(367, 104, 7, 4),
(368, 104, 8, 4),
(369, 104, 9, 4),
(370, 104, 10, 4),
(371, 104, 11, 4),
(372, 104, 12, 4),
(373, 104, 13, 4),
(374, 104, 14, 4),
(375, 104, 15, 4),
(376, 104, 16, 4),
(377, 104, 17, 4),
(378, 104, 18, 4),
(379, 105, 1, 4),
(380, 105, 2, 4),
(381, 105, 3, 4),
(382, 105, 4, 4),
(383, 105, 5, 4),
(384, 105, 6, 4),
(385, 105, 7, 4),
(386, 105, 8, 4),
(387, 105, 9, 4),
(388, 105, 10, 4),
(389, 105, 11, 4),
(390, 105, 12, 4),
(391, 105, 13, 4),
(392, 105, 14, 4),
(393, 105, 15, 4),
(394, 105, 16, 4),
(395, 105, 17, 4),
(396, 105, 18, 4),
(397, 106, 1, 1),
(398, 106, 2, 1),
(399, 106, 3, 1),
(400, 106, 4, 1),
(401, 106, 5, 1),
(402, 106, 6, 1),
(403, 106, 7, 1),
(404, 106, 8, 1),
(405, 106, 9, 1),
(406, 106, 10, 1),
(407, 106, 11, 1),
(408, 106, 12, 1),
(409, 106, 13, 1),
(410, 106, 14, 1),
(411, 106, 15, 1),
(412, 106, 16, 1),
(413, 106, 17, 1),
(414, 106, 18, 1),
(415, 107, 1, 3),
(416, 107, 2, 3),
(417, 107, 3, 3),
(418, 107, 4, 2),
(419, 107, 5, 3),
(420, 107, 6, 2),
(421, 107, 7, 3),
(422, 107, 8, 3),
(423, 107, 9, 2),
(424, 107, 10, 3),
(425, 107, 11, 2),
(426, 107, 12, 3),
(427, 107, 13, 3),
(428, 107, 14, 2),
(429, 107, 15, 2),
(430, 107, 16, 2),
(431, 107, 17, 2),
(432, 107, 18, 3),
(433, 108, 1, 1),
(434, 108, 2, 1),
(435, 108, 3, 2),
(436, 108, 4, 2),
(437, 108, 5, 2),
(438, 108, 6, 2),
(439, 108, 7, 2),
(440, 108, 8, 2),
(441, 108, 9, 2),
(442, 108, 10, 2),
(443, 108, 11, 2),
(444, 108, 12, 2),
(445, 108, 13, 2),
(446, 108, 14, 2),
(447, 108, 15, 2),
(448, 108, 16, 2),
(449, 108, 17, 2),
(450, 108, 18, 2),
(451, 109, 1, 2),
(452, 109, 2, 2),
(453, 109, 3, 2),
(454, 109, 4, 2),
(455, 109, 5, 2),
(456, 109, 6, 2),
(457, 109, 7, 2),
(458, 109, 8, 2),
(459, 109, 9, 2),
(460, 109, 10, 2),
(461, 109, 11, 2),
(462, 109, 12, 2),
(463, 109, 13, 2),
(464, 109, 14, 2),
(465, 109, 15, 2),
(466, 109, 16, 2),
(467, 109, 17, 2),
(468, 109, 18, 2),
(469, 110, 1, 2),
(470, 110, 2, 2),
(471, 110, 3, 2),
(472, 110, 4, 2),
(473, 110, 5, 2),
(474, 110, 6, 2),
(475, 110, 7, 2),
(476, 110, 8, 2),
(477, 110, 9, 2),
(478, 110, 10, 2),
(479, 110, 11, 2),
(480, 110, 12, 2),
(481, 110, 13, 2),
(482, 110, 14, 2),
(483, 110, 15, 2),
(484, 110, 16, 2),
(485, 110, 17, 2),
(486, 110, 18, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai_detail`
--

CREATE TABLE `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL,
  `id_grup` int(11) NOT NULL,
  `id_kar` varchar(12) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penilai_detail`
--

INSERT INTO `penilai_detail` (`id_penilai_detail`, `id_grup`, `id_kar`) VALUES
(101, 73, 'suptbrk'),
(102, 74, 'suptbrk'),
(103, 75, 'suptbrk'),
(104, 76, 'suptbrk'),
(105, 77, 'suptbrk2'),
(106, 78, 'suptbrk2'),
(107, 79, 'suptbrk2'),
(108, 80, 'suptbrk2'),
(109, 81, 'suptbrk2'),
(110, 82, 'suptbrk2');

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
(2, '2020', '11', '4', 0),
(3, '2020', '12', '2', 1);

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
(22, 2, 'kar03', 12),
(23, 3, 'kar01', 12),
(24, 3, 'kar02', 12),
(25, 3, 'kar03', 12),
(26, 3, 'karya123', 12),
(27, 3, 'kar04', 12),
(28, 3, 'adhit123', 12),
(29, 3, 'kar05', 12),
(30, 3, 'kar06', 12),
(31, 3, 'kar07', 12),
(32, 3, 'kar08', 12);

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
  ADD KEY `id_kar` (`id_kar`),
  ADD KEY `id_grup` (`id_grup`);

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
  MODIFY `id_grup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
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
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;
--
-- AUTO_INCREMENT for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  MODIFY `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_pres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  ADD CONSTRAINT `FK_penilai_detail_grup_dinilai` FOREIGN KEY (`id_grup`) REFERENCES `grup_dinilai` (`id_grup`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilai_detail_karyawan` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `FK_presensi_periode` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kar2` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
