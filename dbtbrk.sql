-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 24 Nov 2020 pada 15.31
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
  `id_kriteria` int(11) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `sub_kriteria` varchar(100) NOT NULL,
  `bobot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_penilaian_kinerja`
--

INSERT INTO `data_penilaian_kinerja` (`id_kriteria`, `kriteria`, `sub_kriteria`, `bobot`) VALUES
(1, 'Efisiensi', 'Penguasaan tentang sistem dan prosedur sesuai bidang masing-masing', 5),
(2, 'Efisiensi', 'Hasil pekerjaan yang bermutu dan sesuai dengan peraturan yang ada', 5),
(3, 'Kepedulian', 'Membantu pekerja lain jika mengalami kesulitan', 10),
(4, 'Keantusiasan', 'Kemampuan semangat kerja tinggi dalam mempelajari ilmu baru dalam pekerjaan', 10),
(5, 'Salam (Greeting)', 'Menyapa sesama karyawan', 5),
(6, 'Salam (Greeting)', 'Mengucapkan salam ketika ada customer datang', 5),
(7, 'Etika (Attitude)', 'Memeberikan sikap yang professional pada saat melayani  customer', 4),
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `grup_penilai`
--

CREATE TABLE `grup_penilai` (
  `id_grup` int(11) NOT NULL,
  `id_penilai` int(11) NOT NULL,
  `id_kar` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('adhit123', 3, 3, 'adhit321', 'Adhitya', 'Jl.', '123456'),
('karya123', 3, 1, '321karya', 'Karyawan', 'Jl. Pandegiling', '08189912376'),
('ownertbrk', 1, 1, 'tbrkowner', 'Owner', 'Jl. Babatan Pilang', '08112345678'),
('suptbrk', 2, 1, 'tbrksup', 'Supervisor', 'Jl. Banyu Urip', '081987654321'),
('suptbrk2', 2, 3, 'tbrksup2', 'Sup2', 'Jl. Gayungan', '0821212457');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai`
--

CREATE TABLE `penilai` (
  `id_penilai` int(11) NOT NULL,
  `id_kar` varchar(12) NOT NULL,
  `id_periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_penilai_detail` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `hasil_nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai_detail`
--

CREATE TABLE `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL,
  `id_kar` varchar(12) NOT NULL,
  `id_penilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `id_kar` varchar(12) NOT NULL,
  `jml_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id_pres`, `id_kar`, `jml_masuk`) VALUES
(2, 'karya123', 1),
(7, 'adhit123', 0);

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
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `grup_penilai`
--
ALTER TABLE `grup_penilai`
  ADD PRIMARY KEY (`id_grup`);

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
-- Indexes for table `penilai`
--
ALTER TABLE `penilai`
  ADD PRIMARY KEY (`id_penilai`),
  ADD KEY `id_kar` (`id_kar`),
  ADD KEY `id_periode` (`id_periode`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_penilai_detail` (`id_penilai_detail`,`id_kriteria`),
  ADD KEY `fk_krit1` (`id_kriteria`);

--
-- Indexes for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD PRIMARY KEY (`id_penilai_detail`),
  ADD KEY `id_kar` (`id_kar`,`id_penilai`),
  ADD KEY `fk_pen1` (`id_penilai`);

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
  ADD KEY `id_kar` (`id_kar`);

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
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `grup_penilai`
--
ALTER TABLE `grup_penilai`
  MODIFY `id_grup` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  MODIFY `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_pres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

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
  ADD CONSTRAINT `fk_kar1` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_per1` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_krit1` FOREIGN KEY (`id_kriteria`) REFERENCES `data_penilaian_kinerja` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pendet` FOREIGN KEY (`id_penilai_detail`) REFERENCES `penilai_detail` (`id_penilai_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD CONSTRAINT `fk_kar3` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pen1` FOREIGN KEY (`id_penilai`) REFERENCES `penilai` (`id_penilai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `fk_kar2` FOREIGN KEY (`id_kar`) REFERENCES `karyawan` (`id_kar`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
