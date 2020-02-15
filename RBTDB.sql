-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.35-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for rulebasetopsis
DROP DATABASE IF EXISTS `rulebasetopsis`;
CREATE DATABASE IF NOT EXISTS `rulebasetopsis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `rulebasetopsis`;

-- Dumping structure for table rulebasetopsis.master_aturan
DROP TABLE IF EXISTS `master_aturan`;
CREATE TABLE IF NOT EXISTS `master_aturan` (
  `id_aturan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) DEFAULT NULL,
  `kode_aturan` varchar(30) DEFAULT NULL,
  `hasil` enum('Memenuhi Syarat','Tidak Memenuhi Syarat') DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_aturan`),
  KEY `id_kriteria` (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.master_aturan: ~5 rows (approximately)
/*!40000 ALTER TABLE `master_aturan` DISABLE KEYS */;
REPLACE INTO `master_aturan` (`id_aturan`, `id_kriteria`, `kode_aturan`, `hasil`, `dibuat_oleh`, `waktu_dibuat`) VALUES
	(14, 1, 'RULE 1', 'Memenuhi Syarat', 1, '2019-10-26 14:47:30'),
	(15, 2, 'RULE 2', 'Memenuhi Syarat', 1, '2019-10-26 14:48:55'),
	(16, 3, 'RULE 3', 'Memenuhi Syarat', 1, '2019-10-26 14:49:30'),
	(17, 4, 'RULE 4', 'Memenuhi Syarat', 1, '2019-10-26 14:50:46'),
	(18, 5, 'RULE 5', 'Memenuhi Syarat', 1, '2019-10-26 14:51:48');
/*!40000 ALTER TABLE `master_aturan` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.master_aturancustume
DROP TABLE IF EXISTS `master_aturancustume`;
CREATE TABLE IF NOT EXISTS `master_aturancustume` (
  `id_aturancustume` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` text,
  `paramMax` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_aturancustume`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.master_aturancustume: ~1 rows (approximately)
/*!40000 ALTER TABLE `master_aturancustume` DISABLE KEYS */;
REPLACE INTO `master_aturancustume` (`id_aturancustume`, `keterangan`, `paramMax`) VALUES
	(1, 'IF jumlah poin Tidak memenuhi syarat lebih besar sama dengan 4 THEN proses penilaian tidak dilanjutkan ELSE proses penilaian dilanjutkan', 4);
/*!40000 ALTER TABLE `master_aturancustume` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.master_aturandetail
DROP TABLE IF EXISTS `master_aturandetail`;
CREATE TABLE IF NOT EXISTS `master_aturandetail` (
  `id_aturandetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_aturan` int(11) DEFAULT NULL,
  `id_subkriteria` int(11) DEFAULT NULL,
  `kondisi` char(3) DEFAULT NULL COMMENT '<,=,>,<=,>=,!=',
  `nilai` float DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_aturandetail`),
  KEY `id_aturan` (`id_aturan`),
  KEY `id_subkriteria` (`id_subkriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.master_aturandetail: ~9 rows (approximately)
/*!40000 ALTER TABLE `master_aturandetail` DISABLE KEYS */;
REPLACE INTO `master_aturandetail` (`id_aturandetail`, `id_aturan`, `id_subkriteria`, `kondisi`, `nilai`, `dibuat_oleh`, `waktu_dibuat`) VALUES
	(13, 14, 11, 'MIN', 2, 1, NULL),
	(14, 14, 12, 'MIN', 20, 1, NULL),
	(15, 15, 13, 'MIN', 3, 1, NULL),
	(16, 15, 14, 'MAX', 10, 1, NULL),
	(17, 16, 21, 'MIN', 2, 1, NULL),
	(18, 17, 22, 'MIN', 30, 1, NULL),
	(19, 17, 23, 'MIN', 50, 1, NULL),
	(20, 18, 25, 'MIN', 1, 1, NULL),
	(21, 18, 26, 'MIN', 1, 1, NULL);
/*!40000 ALTER TABLE `master_aturandetail` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.master_divisi
DROP TABLE IF EXISTS `master_divisi`;
CREATE TABLE IF NOT EXISTS `master_divisi` (
  `id_divisi` int(11) NOT NULL AUTO_INCREMENT,
  `kode_divisi` char(10) DEFAULT NULL,
  `nama_divisi` varchar(50) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_divisi`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.master_divisi: ~25 rows (approximately)
/*!40000 ALTER TABLE `master_divisi` DISABLE KEYS */;
REPLACE INTO `master_divisi` (`id_divisi`, `kode_divisi`, `nama_divisi`, `dibuat_oleh`, `waktu_dibuat`) VALUES
	(1, 'EXP', 'EXPORT (GROUP 1-2)', 1, '2019-10-25 21:44:30'),
	(2, 'BI-MST', 'BUSINESS IMPROVEMENT & MST (GROUP)', NULL, '2019-10-25 20:25:52'),
	(3, 'INT`L REG', 'INTERNATIONAL REGISTRATION', NULL, '2019-10-25 20:25:47'),
	(4, 'TRAINING', 'MARKETING ETHICAL TRAINING DIVISION', NULL, '2019-10-25 20:25:41'),
	(5, 'PCH', 'PURCHASING', NULL, '2019-10-25 20:25:35'),
	(6, 'PD', 'PRODUCT DEVELOPMENT', NULL, '2019-10-25 20:25:28'),
	(7, 'CHC2', 'MARKETING HEALTHCARE 2', NULL, '2019-10-25 20:25:15'),
	(8, 'OMEGA', 'MARKETING OMEGA', NULL, '2019-10-25 20:25:14'),
	(9, 'GASTRO', 'MARKETING ALPHA PEDIATRIC (GASTRO)', NULL, '2019-10-25 20:25:09'),
	(10, 'RESPI', 'MARKETING ALPHA PEDIATRIC (RESPIRO)', NULL, '2019-10-25 20:25:04'),
	(11, 'SIGMA', 'MARKETING SIGMA', NULL, '2019-10-25 20:24:58'),
	(12, 'GA', 'GENERAL AFFAIR', NULL, '2019-10-25 20:24:52'),
	(13, 'IC', 'INTERNAL CONTROL', NULL, '2019-10-25 20:24:45'),
	(14, 'OGB', 'MARKETING GENERIC (OGB)', NULL, '2019-10-25 20:24:38'),
	(15, 'HRD', 'HUMAN RESOURCE & DEVELOPMENT', NULL, '2019-10-25 20:24:28'),
	(16, 'MARS', 'MARKETING MARS', NULL, '2019-10-25 20:24:21'),
	(17, 'FA', 'FINANCE & ACCOUNTING + PAYROLL', NULL, '2019-10-25 20:24:15'),
	(18, 'BUSDEV', 'BUSINESS DEVELOPMENT', NULL, '2019-10-25 20:24:10'),
	(19, 'MED', 'MEDICASTORE', NULL, '2019-10-25 20:24:04'),
	(20, 'MA', 'MARKETING ANALYST', NULL, '2019-10-25 20:23:59'),
	(21, 'MK9', 'MARKETING BPJS', NULL, '2019-10-25 20:23:51'),
	(22, 'CHC3', 'MARKETING HEALTHCARE 3', NULL, '2019-10-25 20:23:45'),
	(23, 'THI', 'MARKETING THAILAND', NULL, '2019-10-25 20:23:37'),
	(24, 'SHO', 'MARKETING SIGMA HOSPITAL', NULL, '2019-10-25 20:23:32');
/*!40000 ALTER TABLE `master_divisi` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.master_kriteria
DROP TABLE IF EXISTS `master_kriteria`;
CREATE TABLE IF NOT EXISTS `master_kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kriteria` char(4) DEFAULT NULL,
  `nama_kriteria` varchar(50) DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `tipe_kriteria` enum('Benefit','Cost') DEFAULT NULL COMMENT '1 Benefit , 2 Cost',
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tahun_penilaian` year(4) DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.master_kriteria: ~5 rows (approximately)
/*!40000 ALTER TABLE `master_kriteria` DISABLE KEYS */;
REPLACE INTO `master_kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `bobot`, `tipe_kriteria`, `dibuat_oleh`, `waktu_dibuat`, `tahun_penilaian`) VALUES
	(1, 'KU', 'Kualitas', 20, 'Benefit', 1, '2019-11-01 21:16:23', '2018'),
	(2, 'PR', 'Profesional', 25, 'Benefit', 1, '2019-11-01 21:16:26', '2018'),
	(3, 'IN', 'Inovasi', 15, 'Benefit', 1, '2019-11-01 21:16:30', '2018'),
	(4, 'AN', 'Angka', 25, 'Benefit', 1, '2019-11-01 21:16:33', '2018'),
	(5, 'KO', 'Kolaborasi', 15, 'Benefit', 1, '2019-11-01 21:16:37', '2018');
/*!40000 ALTER TABLE `master_kriteria` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.master_subkriteria
DROP TABLE IF EXISTS `master_subkriteria`;
CREATE TABLE IF NOT EXISTS `master_subkriteria` (
  `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT,
  `kode_subkriteria` char(4) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `keterangan` text,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipe_subkriteria` enum('Manual','Otomatis') DEFAULT NULL,
  PRIMARY KEY (`id_subkriteria`),
  KEY `id_kriteria` (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.master_subkriteria: ~9 rows (approximately)
/*!40000 ALTER TABLE `master_subkriteria` DISABLE KEYS */;
REPLACE INTO `master_subkriteria` (`id_subkriteria`, `kode_subkriteria`, `id_kriteria`, `keterangan`, `dibuat_oleh`, `waktu_dibuat`, `tipe_subkriteria`) VALUES
	(11, 'KU1', 1, 'Jumlah aspek kualitas kinerja yang membaik', 1, '2019-10-26 12:56:18', 'Manual'),
	(12, 'KU2', 1, 'Persentase anggota divisi mendapatkan PK dengan nilai baik', 1, '2019-10-26 23:11:10', 'Manual'),
	(13, 'PR1', 2, 'Aspek yang diubah dalam team sehingga menjadi team Profesional sesuai definisi APIKK Profesional', 1, '2019-10-26 23:12:34', 'Manual'),
	(14, 'PR2', 2, 'Total anggota Team yang sedang dalam masa evalusai SP atau mendapatkan SP', 1, '2019-10-26 23:25:00', 'Manual'),
	(21, 'IN', 3, 'Inovasi Yang dilakukan dalam upaya menyelamatkan divisi sehingga terjadi perbaikan Angka', 1, '2019-10-26 23:25:59', 'Manual'),
	(22, 'AN1', 4, 'Jumlah Karyawan dengan Growth PK ', 1, '2019-10-26 23:27:49', 'Manual'),
	(23, 'AN2', 4, 'Jumlah Karyawan dengan nilai PK Cukup / Baik ', 1, '2019-10-26 23:28:31', 'Manual'),
	(25, 'KO1', 5, 'Membuktikan langkah perbaikan proses kerja yang dilakukan melalui kolaborasi internal team ', 1, '2019-10-26 14:21:45', 'Manual'),
	(26, 'KO2', 5, 'Membuktikan langkah perbaikan proses kerja yang dilakukan melalui kolaborasi External team ', 1, '2019-10-26 14:23:37', 'Manual');
/*!40000 ALTER TABLE `master_subkriteria` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.master_subkriteriadetail
DROP TABLE IF EXISTS `master_subkriteriadetail`;
CREATE TABLE IF NOT EXISTS `master_subkriteriadetail` (
  `id_subkriteriadetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_subkriteria` int(11) DEFAULT NULL,
  `keterangan` text,
  `nilai_akhir` float DEFAULT NULL,
  `nilai_awal` float DEFAULT NULL,
  `nilai_aktual` float DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `urutan_penilaian` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_subkriteriadetail`),
  KEY `id_subkriteria` (`id_subkriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.master_subkriteriadetail: ~45 rows (approximately)
/*!40000 ALTER TABLE `master_subkriteriadetail` DISABLE KEYS */;
REPLACE INTO `master_subkriteriadetail` (`id_subkriteriadetail`, `id_subkriteria`, `keterangan`, `nilai_akhir`, `nilai_awal`, `nilai_aktual`, `dibuat_oleh`, `waktu_dibuat`, `urutan_penilaian`) VALUES
	(101, 11, 'Lebih dari 10 Aspek dalam 1 Tahun', 9999, 11, 100, 1, '2019-10-26 23:22:45', 0),
	(102, 11, '8 - 10 Aspek dalam 1 Tahun', 10, 8, 80, 1, '2019-10-26 23:22:45', 1),
	(103, 11, '5 - 7 Aspek dalam 1 Tahun', 7, 5, 60, 1, '2019-10-26 23:22:45', 2),
	(104, 11, '2 - 4 Aspek dalam 1 Tahun', 4, 2, 40, 1, '2019-10-26 23:22:45', 3),
	(105, 11, 'Kurang dari 2 Aspek dalam 1 Tahun', 1, 0, 20, 1, '2019-10-26 23:22:45', 4),
	(121, 14, 'Tidak SP dalam 1 Tahun', 0, 0, 100, 1, '2019-10-26 23:25:00', 0),
	(122, 14, 'SP 1%-2%', 2, 1, 80, 1, '2019-10-26 23:25:00', 1),
	(123, 14, 'SP 3%-6%', 6, 3, 60, 1, '2019-10-26 23:25:00', 2),
	(124, 14, 'SP 7%-10%', 10, 7, 40, 1, '2019-10-26 23:25:00', 3),
	(125, 14, 'SP Lebih dari 10%', 9999, 11, 20, 1, '2019-10-26 23:25:00', 4),
	(126, 21, 'Lebih dari 10 Inovasi dalam 1 Tahun', 9999, 11, 100, 1, '2019-10-26 23:25:59', 0),
	(127, 21, '8 - 10 Inovasi dalam 1 Tahun', 10, 8, 80, 1, '2019-10-26 23:25:59', 1),
	(128, 21, '5 - 7 Inovasi dalam 1 Tahun', 7, 5, 60, 1, '2019-10-26 23:25:59', 2),
	(129, 21, '2 - 4 Inovasi dalam 1 Tahun', 4, 2, 40, 1, '2019-10-26 23:25:59', 3),
	(130, 21, 'Kurang dari 2 Inovasi dalam 1 Tahun', 1, 0, 20, 1, '2019-10-26 23:25:59', 4),
	(141, 25, 'Lebih dari 10 Langkah', 9999, 10, 100, 1, '2019-10-26 23:29:10', 0),
	(142, 25, '7 - 9 Langkah', 9, 7, 80, 1, '2019-10-26 23:29:10', 1),
	(143, 25, '4 - 6 Langkah', 6, 4, 60, 1, '2019-10-26 23:29:10', 2),
	(144, 25, '1 - 3 Langkah', 3, 1, 40, 1, '2019-10-26 23:29:10', 3),
	(145, 25, 'Tidak Ada', 0, 0, 20, 1, '2019-10-26 23:29:10', 4),
	(146, 26, 'Lebih dari 10 Langkah', 9999, 10, 100, 1, '2019-10-26 23:29:45', 0),
	(147, 26, '7 - 9 Langkah', 9, 7, 80, 1, '2019-10-26 23:29:45', 1),
	(148, 26, '4 - 6 Langkah', 6, 4, 60, 1, '2019-10-26 23:29:45', 2),
	(149, 26, '1 - 3 Langkah', 3, 1, 40, 1, '2019-10-26 23:29:45', 3),
	(150, 26, 'Tidak Ada', 0, 0, 20, 1, '2019-10-26 23:29:45', 4),
	(151, 12, 'Nilai PK Cukup / Baik Lebih dari 80%', 9999, 81, 100, 1, '2019-10-27 00:19:16', 0),
	(152, 12, 'Nilai PK Cukup / Baik antara 60%-80%', 80, 60, 80, 1, '2019-10-27 00:19:16', 1),
	(153, 12, 'Nilai PK Cukup / Baik antara 40%-59%', 59, 40, 60, 1, '2019-10-27 00:19:16', 2),
	(154, 12, 'Nilai PK Nilai Baik antara 20%-39%', 39, 20, 40, 1, '2019-10-27 00:19:16', 3),
	(155, 12, 'Nilai PK Nilai Baik Kurang dari 20%', 19, 0, 20, 1, '2019-10-27 00:19:16', 4),
	(156, 22, 'Growth PK Lebih dari 90%', 9999, 90, 100, 1, '2019-10-27 00:21:06', 0),
	(157, 22, 'Growth PK 80%-89%', 89, 80, 80, 1, '2019-10-27 00:21:06', 1),
	(158, 22, 'Growth PK 60%-79%', 79, 60, 60, 1, '2019-10-27 00:21:06', 2),
	(159, 22, 'Growth PK 30%-59%', 59, 30, 40, 1, '2019-10-27 00:21:06', 3),
	(160, 22, 'Growth PK Kurang dari 30%', 29, 0, 20, 1, '2019-10-27 00:21:06', 4),
	(161, 23, 'Nilai PK Cukup / Baik Lebih dari 90%', 9999, 90, 100, 1, '2019-10-27 00:22:58', 0),
	(162, 23, 'Nilai PK Cukup / Baik antara 70%-89%', 89, 70, 80, 1, '2019-10-27 00:22:58', 1),
	(163, 23, 'Nilai PK Cukup / Baik antara 50%-69%', 69, 50, 60, 1, '2019-10-27 00:22:58', 2),
	(164, 23, 'Nilai PK Cukup / Baik antara 40%-49%', 49, 40, 40, 1, '2019-10-27 00:22:58', 3),
	(165, 23, 'Nilai PK Cukup / Baik Kurang dari 40%', 39, 0, 20, 1, '2019-10-27 00:22:58', 4),
	(166, 13, 'Lebih dari 10 Aspek dalam 1 Tahun', 9999, 11, 100, 1, '2019-10-27 20:59:21', 0),
	(167, 13, '8 - 10 Aspek dalam 1 Tahun', 10, 8, 80, 1, '2019-10-27 20:59:21', 1),
	(168, 13, '6 - 7 Aspek dalam 1 Tahun', 7, 6, 60, 1, '2019-10-27 20:59:21', 2),
	(169, 13, '3 - 5 Aspek dalam 1 Tahun', 5, 3, 40, 1, '2019-10-27 20:59:21', 3),
	(170, 13, 'Kurang dari 3 Aspek dalam 1 Tahun', 2, 0, 20, 1, '2019-10-27 20:59:21', 4);
/*!40000 ALTER TABLE `master_subkriteriadetail` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.param_matrik
DROP TABLE IF EXISTS `param_matrik`;
CREATE TABLE IF NOT EXISTS `param_matrik` (
  `id_param_matrik` int(11) NOT NULL AUTO_INCREMENT,
  `id_seleksi` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `idealnegatif` float DEFAULT NULL,
  `idealpositif` float DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_param_matrik`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.param_matrik: ~5 rows (approximately)
/*!40000 ALTER TABLE `param_matrik` DISABLE KEYS */;
REPLACE INTO `param_matrik` (`id_param_matrik`, `id_seleksi`, `id_kriteria`, `nilai`, `idealnegatif`, `idealpositif`, `dibuat_oleh`, `waktu_dibuat`) VALUES
	(6, 5, 1, 265.518, 2.26, 6.78, 6, '2019-11-01 22:54:56'),
	(7, 5, 2, 324.191, 2.3125, 7.7125, 6, '2019-11-01 22:54:56'),
	(8, 5, 3, 295.297, 1.0155, 5.079, 6, '2019-11-01 22:54:56'),
	(9, 5, 4, 282.843, 1.7675, 8.84, 6, '2019-11-01 22:54:56'),
	(10, 5, 5, 305.614, 0.981, 4.4175, 6, '2019-11-01 22:54:56');
/*!40000 ALTER TABLE `param_matrik` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.pengguna
DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id_pengguna` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(50) DEFAULT NULL,
  `id_divisi` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `rule` tinyint(4) DEFAULT NULL COMMENT '1 HC, 2 HEAD, 3 KAR, 4 DIR, 5 ADM',
  PRIMARY KEY (`id_pengguna`),
  KEY `id_divisi` (`id_divisi`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.pengguna: ~3 rows (approximately)
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
REPLACE INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `id_divisi`, `username`, `password`, `rule`) VALUES
	(2, 'USER RULE 4', 18, 'userrule2', '1234', 4),
	(3, 'USER RULE 5', 18, 'userrule5', '1234', 5),
	(6, 'Direksi OKEoce', 1, 'dirOKoce123', '81dc9bdb52d04dc20036dbd8313ed055', 1);
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.penilaian
DROP TABLE IF EXISTS `penilaian`;
CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `id_divisi` int(11) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tahun_penilaian` year(4) DEFAULT NULL,
  `status` enum('Draft','Waiting Review','Finish') DEFAULT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `id_divisi` (`id_divisi`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.penilaian: ~24 rows (approximately)
/*!40000 ALTER TABLE `penilaian` DISABLE KEYS */;
REPLACE INTO `penilaian` (`id_penilaian`, `id_divisi`, `dibuat_oleh`, `waktu_dibuat`, `tahun_penilaian`, `status`) VALUES
	(73, 1, 6, '2019-11-01 21:17:23', '2018', 'Finish'),
	(74, 2, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(75, 3, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(76, 4, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(77, 5, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(78, 6, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(79, 7, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(80, 8, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(81, 9, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(82, 10, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(83, 11, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(84, 12, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(85, 13, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(86, 14, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(87, 15, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(88, 16, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(89, 17, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(90, 18, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(91, 19, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(92, 20, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(93, 21, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(94, 22, 6, '2019-11-01 21:17:24', '2018', 'Finish'),
	(95, 23, 6, '2019-11-01 21:17:25', '2018', 'Finish'),
	(96, 24, 6, '2019-11-01 21:17:25', '2018', 'Finish');
/*!40000 ALTER TABLE `penilaian` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.penilaian_detail
DROP TABLE IF EXISTS `penilaian_detail`;
CREATE TABLE IF NOT EXISTS `penilaian_detail` (
  `id_penilaian_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_penilaian` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `id_subkriteria` int(11) DEFAULT NULL,
  `id_subkriteriadetail` int(11) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hasil` enum('MS','TMS') DEFAULT NULL,
  PRIMARY KEY (`id_penilaian_detail`),
  KEY `id_subkriteriadetail` (`id_subkriteriadetail`)
) ENGINE=InnoDB AUTO_INCREMENT=745 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.penilaian_detail: ~216 rows (approximately)
/*!40000 ALTER TABLE `penilaian_detail` DISABLE KEYS */;
REPLACE INTO `penilaian_detail` (`id_penilaian_detail`, `id_penilaian`, `id_kriteria`, `id_subkriteria`, `id_subkriteriadetail`, `dibuat_oleh`, `waktu_dibuat`, `hasil`) VALUES
	(529, 73, 1, 11, 105, NULL, '2019-11-01 21:18:38', 'TMS'),
	(530, 73, 1, 12, 152, NULL, '2019-11-01 21:18:39', 'MS'),
	(531, 73, 2, 13, 170, NULL, '2019-11-01 21:18:41', 'TMS'),
	(532, 73, 2, 14, 121, NULL, '2019-11-01 21:18:41', 'MS'),
	(533, 73, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(534, 73, 4, 22, 157, NULL, '2019-11-01 21:18:43', 'MS'),
	(535, 73, 4, 23, 164, NULL, '2019-11-01 21:18:45', 'TMS'),
	(536, 73, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(537, 73, 5, 26, 149, NULL, '2019-11-01 21:18:47', 'MS'),
	(538, 74, 1, 11, 102, NULL, '2019-11-01 21:18:38', 'MS'),
	(539, 74, 1, 12, 154, NULL, '2019-11-01 21:18:39', 'MS'),
	(540, 74, 2, 13, 166, NULL, '2019-11-01 21:18:40', 'MS'),
	(541, 74, 2, 14, 125, NULL, '2019-11-01 21:18:42', 'TMS'),
	(542, 74, 3, 21, 127, NULL, '2019-11-01 21:18:42', 'MS'),
	(543, 74, 4, 22, 160, NULL, '2019-11-01 21:18:44', 'TMS'),
	(544, 74, 4, 23, 161, NULL, '2019-11-01 21:18:44', 'MS'),
	(545, 74, 5, 25, 142, NULL, '2019-11-01 21:18:45', 'MS'),
	(546, 74, 5, 26, 146, NULL, '2019-11-01 21:18:46', 'MS'),
	(547, 75, 1, 11, 105, NULL, '2019-11-01 21:18:38', 'TMS'),
	(548, 75, 1, 12, 153, NULL, '2019-11-01 21:18:39', 'MS'),
	(549, 75, 2, 13, 170, NULL, '2019-11-01 21:18:41', 'TMS'),
	(550, 75, 2, 14, 124, NULL, '2019-11-01 21:18:42', 'MS'),
	(551, 75, 3, 21, 128, NULL, '2019-11-01 21:18:42', 'MS'),
	(552, 75, 4, 22, 156, NULL, '2019-11-01 21:18:43', 'MS'),
	(553, 75, 4, 23, 161, NULL, '2019-11-01 21:18:44', 'MS'),
	(554, 75, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(555, 75, 5, 26, 148, NULL, '2019-11-01 21:18:47', 'MS'),
	(556, 76, 1, 11, 104, NULL, '2019-11-01 21:18:38', 'MS'),
	(557, 76, 1, 12, 152, NULL, '2019-11-01 21:18:39', 'MS'),
	(558, 76, 2, 13, 166, NULL, '2019-11-01 21:18:40', 'MS'),
	(559, 76, 2, 14, 121, NULL, '2019-11-01 21:18:41', 'MS'),
	(560, 76, 3, 21, 126, NULL, '2019-11-01 21:18:42', 'MS'),
	(561, 76, 4, 22, 159, NULL, '2019-11-01 21:18:44', 'MS'),
	(562, 76, 4, 23, 163, NULL, '2019-11-01 21:18:44', 'MS'),
	(563, 76, 5, 25, 143, NULL, '2019-11-01 21:18:45', 'MS'),
	(564, 76, 5, 26, 149, NULL, '2019-11-01 21:18:47', 'MS'),
	(565, 77, 1, 11, 103, NULL, '2019-11-01 21:18:38', 'MS'),
	(566, 77, 1, 12, 154, NULL, '2019-11-01 21:18:39', 'MS'),
	(567, 77, 2, 13, 167, NULL, '2019-11-01 21:18:40', 'MS'),
	(568, 77, 2, 14, 122, NULL, '2019-11-01 21:18:41', 'MS'),
	(569, 77, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(570, 77, 4, 22, 158, NULL, '2019-11-01 21:18:43', 'MS'),
	(571, 77, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(572, 77, 5, 25, 143, NULL, '2019-11-01 21:18:45', 'MS'),
	(573, 77, 5, 26, 146, NULL, '2019-11-01 21:18:46', 'MS'),
	(574, 78, 1, 11, 105, NULL, '2019-11-01 21:18:38', 'TMS'),
	(575, 78, 1, 12, 154, NULL, '2019-11-01 21:18:39', 'MS'),
	(576, 78, 2, 13, 169, NULL, '2019-11-01 21:18:41', 'MS'),
	(577, 78, 2, 14, 122, NULL, '2019-11-01 21:18:41', 'MS'),
	(578, 78, 3, 21, 129, NULL, '2019-11-01 21:18:43', 'MS'),
	(579, 78, 4, 22, 160, NULL, '2019-11-01 21:18:44', 'TMS'),
	(580, 78, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(581, 78, 5, 25, 143, NULL, '2019-11-01 21:18:46', 'MS'),
	(582, 78, 5, 26, 146, NULL, '2019-11-01 21:18:46', 'MS'),
	(583, 79, 1, 11, 104, NULL, '2019-11-01 21:18:38', 'MS'),
	(584, 79, 1, 12, 152, NULL, '2019-11-01 21:18:39', 'MS'),
	(585, 79, 2, 13, 169, NULL, '2019-11-01 21:18:41', 'MS'),
	(586, 79, 2, 14, 122, NULL, '2019-11-01 21:18:41', 'MS'),
	(587, 79, 3, 21, 129, NULL, '2019-11-01 21:18:43', 'MS'),
	(588, 79, 4, 22, 157, NULL, '2019-11-01 21:18:43', 'MS'),
	(589, 79, 4, 23, 162, NULL, '2019-11-01 21:18:44', 'MS'),
	(590, 79, 5, 25, 143, NULL, '2019-11-01 21:18:46', 'MS'),
	(591, 79, 5, 26, 149, NULL, '2019-11-01 21:18:47', 'MS'),
	(592, 80, 1, 11, 103, NULL, '2019-11-01 21:18:38', 'MS'),
	(593, 80, 1, 12, 154, NULL, '2019-11-01 21:18:39', 'MS'),
	(594, 80, 2, 13, 166, NULL, '2019-11-01 21:18:40', 'MS'),
	(595, 80, 2, 14, 121, NULL, '2019-11-01 21:18:41', 'MS'),
	(596, 80, 3, 21, 129, NULL, '2019-11-01 21:18:43', 'MS'),
	(597, 80, 4, 22, 158, NULL, '2019-11-01 21:18:43', 'MS'),
	(598, 80, 4, 23, 163, NULL, '2019-11-01 21:18:45', 'MS'),
	(599, 80, 5, 25, 143, NULL, '2019-11-01 21:18:46', 'MS'),
	(600, 80, 5, 26, 149, NULL, '2019-11-01 21:18:47', 'MS'),
	(601, 81, 1, 11, 104, NULL, '2019-11-01 21:18:38', 'MS'),
	(602, 81, 1, 12, 153, NULL, '2019-11-01 21:18:39', 'MS'),
	(603, 81, 2, 13, 170, NULL, '2019-11-01 21:18:41', 'TMS'),
	(604, 81, 2, 14, 124, NULL, '2019-11-01 21:18:42', 'MS'),
	(605, 81, 3, 21, 128, NULL, '2019-11-01 21:18:43', 'MS'),
	(606, 81, 4, 22, 157, NULL, '2019-11-01 21:18:43', 'MS'),
	(607, 81, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(608, 81, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(609, 81, 5, 26, 146, NULL, '2019-11-01 21:18:46', 'MS'),
	(610, 82, 1, 11, 105, NULL, '2019-11-01 21:18:39', 'TMS'),
	(611, 82, 1, 12, 153, NULL, '2019-11-01 21:18:39', 'MS'),
	(612, 82, 2, 13, 167, NULL, '2019-11-01 21:18:40', 'MS'),
	(613, 82, 2, 14, 123, NULL, '2019-11-01 21:18:42', 'MS'),
	(614, 82, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(615, 82, 4, 22, 156, NULL, '2019-11-01 21:18:43', 'MS'),
	(616, 82, 4, 23, 164, NULL, '2019-11-01 21:18:45', 'TMS'),
	(617, 82, 5, 25, 142, NULL, '2019-11-01 21:18:45', 'MS'),
	(618, 82, 5, 26, 147, NULL, '2019-11-01 21:18:47', 'MS'),
	(619, 83, 1, 11, 101, NULL, '2019-11-01 21:18:38', 'MS'),
	(620, 83, 1, 12, 152, NULL, '2019-11-01 21:18:39', 'MS'),
	(621, 83, 2, 13, 169, NULL, '2019-11-01 21:18:41', 'MS'),
	(622, 83, 2, 14, 124, NULL, '2019-11-01 21:18:42', 'MS'),
	(623, 83, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(624, 83, 4, 22, 158, NULL, '2019-11-01 21:18:43', 'MS'),
	(625, 83, 4, 23, 161, NULL, '2019-11-01 21:18:44', 'MS'),
	(626, 83, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(627, 83, 5, 26, 150, NULL, '2019-11-01 21:18:47', 'TMS'),
	(628, 84, 1, 11, 104, NULL, '2019-11-01 21:18:38', 'MS'),
	(629, 84, 1, 12, 154, NULL, '2019-11-01 21:18:40', 'MS'),
	(630, 84, 2, 13, 168, NULL, '2019-11-01 21:18:40', 'MS'),
	(631, 84, 2, 14, 123, NULL, '2019-11-01 21:18:42', 'MS'),
	(632, 84, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(633, 84, 4, 22, 159, NULL, '2019-11-01 21:18:44', 'MS'),
	(634, 84, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(635, 84, 5, 25, 144, NULL, '2019-11-01 21:18:46', 'MS'),
	(636, 84, 5, 26, 149, NULL, '2019-11-01 21:18:47', 'MS'),
	(637, 85, 1, 11, 104, NULL, '2019-11-01 21:18:38', 'MS'),
	(638, 85, 1, 12, 154, NULL, '2019-11-01 21:18:40', 'MS'),
	(639, 85, 2, 13, 168, NULL, '2019-11-01 21:18:40', 'MS'),
	(640, 85, 2, 14, 124, NULL, '2019-11-01 21:18:42', 'MS'),
	(641, 85, 3, 21, 129, NULL, '2019-11-01 21:18:43', 'MS'),
	(642, 85, 4, 22, 158, NULL, '2019-11-01 21:18:44', 'MS'),
	(643, 85, 4, 23, 161, NULL, '2019-11-01 21:18:44', 'MS'),
	(644, 85, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(645, 85, 5, 26, 150, NULL, '2019-11-01 21:18:47', 'TMS'),
	(646, 86, 1, 11, 102, NULL, '2019-11-01 21:18:38', 'MS'),
	(647, 86, 1, 12, 151, NULL, '2019-11-01 21:18:39', 'MS'),
	(648, 86, 2, 13, 170, NULL, '2019-11-01 21:18:41', 'TMS'),
	(649, 86, 2, 14, 122, NULL, '2019-11-01 21:18:42', 'MS'),
	(650, 86, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(651, 86, 4, 22, 159, NULL, '2019-11-01 21:18:44', 'MS'),
	(652, 86, 4, 23, 161, NULL, '2019-11-01 21:18:44', 'MS'),
	(653, 86, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(654, 86, 5, 26, 146, NULL, '2019-11-01 21:18:46', 'MS'),
	(655, 87, 1, 11, 104, NULL, '2019-11-01 21:18:38', 'MS'),
	(656, 87, 1, 12, 154, NULL, '2019-11-01 21:18:40', 'MS'),
	(657, 87, 2, 13, 166, NULL, '2019-11-01 21:18:40', 'MS'),
	(658, 87, 2, 14, 121, NULL, '2019-11-01 21:18:41', 'MS'),
	(659, 87, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(660, 87, 4, 22, 158, NULL, '2019-11-01 21:18:44', 'MS'),
	(661, 87, 4, 23, 163, NULL, '2019-11-01 21:18:45', 'MS'),
	(662, 87, 5, 25, 143, NULL, '2019-11-01 21:18:46', 'MS'),
	(663, 87, 5, 26, 146, NULL, '2019-11-01 21:18:47', 'MS'),
	(664, 88, 1, 11, 102, NULL, '2019-11-01 21:18:38', 'MS'),
	(665, 88, 1, 12, 155, NULL, '2019-11-01 21:18:40', 'TMS'),
	(666, 88, 2, 13, 168, NULL, '2019-11-01 21:18:41', 'MS'),
	(667, 88, 2, 14, 122, NULL, '2019-11-01 21:18:42', 'MS'),
	(668, 88, 3, 21, 126, NULL, '2019-11-01 21:18:42', 'MS'),
	(669, 88, 4, 22, 158, NULL, '2019-11-01 21:18:44', 'MS'),
	(670, 88, 4, 23, 164, NULL, '2019-11-01 21:18:45', 'TMS'),
	(671, 88, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(672, 88, 5, 26, 150, NULL, '2019-11-01 21:18:47', 'TMS'),
	(673, 89, 1, 11, 104, NULL, '2019-11-01 21:18:38', 'MS'),
	(674, 89, 1, 12, 155, NULL, '2019-11-01 21:18:40', 'TMS'),
	(675, 89, 2, 13, 166, NULL, '2019-11-01 21:18:40', 'MS'),
	(676, 89, 2, 14, 125, NULL, '2019-11-01 21:18:42', 'TMS'),
	(677, 89, 3, 21, 130, NULL, '2019-11-01 21:18:43', 'TMS'),
	(678, 89, 4, 22, 158, NULL, '2019-11-01 21:18:44', 'MS'),
	(679, 89, 4, 23, 161, NULL, '2019-11-01 21:18:44', 'MS'),
	(680, 89, 5, 25, 141, NULL, '2019-11-01 21:18:45', 'MS'),
	(681, 89, 5, 26, 148, NULL, '2019-11-01 21:18:47', 'MS'),
	(682, 90, 1, 11, 101, NULL, '2019-11-01 21:18:38', 'MS'),
	(683, 90, 1, 12, 152, NULL, '2019-11-01 21:18:39', 'MS'),
	(684, 90, 2, 13, 166, NULL, '2019-11-01 21:18:40', 'MS'),
	(685, 90, 2, 14, 125, NULL, '2019-11-01 21:18:42', 'TMS'),
	(686, 90, 3, 21, 126, NULL, '2019-11-01 21:18:42', 'MS'),
	(687, 90, 4, 22, 160, NULL, '2019-11-01 21:18:44', 'TMS'),
	(688, 90, 4, 23, 163, NULL, '2019-11-01 21:18:45', 'MS'),
	(689, 90, 5, 25, 142, NULL, '2019-11-01 21:18:45', 'MS'),
	(690, 90, 5, 26, 146, NULL, '2019-11-01 21:18:47', 'MS'),
	(691, 91, 1, 11, 103, NULL, '2019-11-01 21:18:38', 'MS'),
	(692, 91, 1, 12, 154, NULL, '2019-11-01 21:18:40', 'MS'),
	(693, 91, 2, 13, 167, NULL, '2019-11-01 21:18:40', 'MS'),
	(694, 91, 2, 14, 122, NULL, '2019-11-01 21:18:42', 'MS'),
	(695, 91, 3, 21, 127, NULL, '2019-11-01 21:18:42', 'MS'),
	(696, 91, 4, 22, 159, NULL, '2019-11-01 21:18:44', 'MS'),
	(697, 91, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(698, 91, 5, 25, 145, NULL, '2019-11-01 21:18:46', 'TMS'),
	(699, 91, 5, 26, 147, NULL, '2019-11-01 21:18:47', 'MS'),
	(700, 92, 1, 11, 105, NULL, '2019-11-01 21:18:39', 'TMS'),
	(701, 92, 1, 12, 152, NULL, '2019-11-01 21:18:39', 'MS'),
	(702, 92, 2, 13, 168, NULL, '2019-11-01 21:18:41', 'MS'),
	(703, 92, 2, 14, 121, NULL, '2019-11-01 21:18:41', 'MS'),
	(704, 92, 3, 21, 129, NULL, '2019-11-01 21:18:43', 'MS'),
	(705, 92, 4, 22, 156, NULL, '2019-11-01 21:18:43', 'MS'),
	(706, 92, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(707, 92, 5, 25, 142, NULL, '2019-11-01 21:18:45', 'MS'),
	(708, 92, 5, 26, 150, NULL, '2019-11-01 21:18:47', 'TMS'),
	(709, 93, 1, 11, 105, NULL, '2019-11-01 21:18:39', 'TMS'),
	(710, 93, 1, 12, 151, NULL, '2019-11-01 21:18:39', 'MS'),
	(711, 93, 2, 13, 167, NULL, '2019-11-01 21:18:40', 'MS'),
	(712, 93, 2, 14, 125, NULL, '2019-11-01 21:18:42', 'TMS'),
	(713, 93, 3, 21, 127, NULL, '2019-11-01 21:18:42', 'MS'),
	(714, 93, 4, 22, 160, NULL, '2019-11-01 21:18:44', 'TMS'),
	(715, 93, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(716, 93, 5, 25, 141, NULL, '2019-11-01 21:18:45', 'MS'),
	(717, 93, 5, 26, 149, NULL, '2019-11-01 21:18:47', 'MS'),
	(718, 94, 1, 11, 103, NULL, '2019-11-01 21:18:38', 'MS'),
	(719, 94, 1, 12, 153, NULL, '2019-11-01 21:18:39', 'MS'),
	(720, 94, 2, 13, 166, NULL, '2019-11-01 21:18:40', 'MS'),
	(721, 94, 2, 14, 123, NULL, '2019-11-01 21:18:42', 'MS'),
	(722, 94, 3, 21, 126, NULL, '2019-11-01 21:18:42', 'MS'),
	(723, 94, 4, 22, 159, NULL, '2019-11-01 21:18:44', 'MS'),
	(724, 94, 4, 23, 161, NULL, '2019-11-01 21:18:44', 'MS'),
	(725, 94, 5, 25, 142, NULL, '2019-11-01 21:18:45', 'MS'),
	(726, 94, 5, 26, 147, NULL, '2019-11-01 21:18:47', 'MS'),
	(727, 95, 1, 11, 105, NULL, '2019-11-01 21:18:39', 'TMS'),
	(728, 95, 1, 12, 154, NULL, '2019-11-01 21:18:40', 'MS'),
	(729, 95, 2, 13, 169, NULL, '2019-11-01 21:18:41', 'MS'),
	(730, 95, 2, 14, 122, NULL, '2019-11-01 21:18:42', 'MS'),
	(731, 95, 3, 21, 128, NULL, '2019-11-01 21:18:43', 'MS'),
	(732, 95, 4, 22, 160, NULL, '2019-11-01 21:18:44', 'TMS'),
	(733, 95, 4, 23, 163, NULL, '2019-11-01 21:18:45', 'MS'),
	(734, 95, 5, 25, 144, NULL, '2019-11-01 21:18:46', 'MS'),
	(735, 95, 5, 26, 146, NULL, '2019-11-01 21:18:47', 'MS'),
	(736, 96, 1, 11, 105, NULL, '2019-11-01 21:18:39', 'TMS'),
	(737, 96, 1, 12, 152, NULL, '2019-11-01 21:18:39', 'MS'),
	(738, 96, 2, 13, 169, NULL, '2019-11-01 21:18:41', 'MS'),
	(739, 96, 2, 14, 122, NULL, '2019-11-01 21:18:42', 'MS'),
	(740, 96, 3, 21, 127, NULL, '2019-11-01 21:18:42', 'MS'),
	(741, 96, 4, 22, 160, NULL, '2019-11-01 21:18:44', 'TMS'),
	(742, 96, 4, 23, 165, NULL, '2019-11-01 21:18:45', 'TMS'),
	(743, 96, 5, 25, 142, NULL, '2019-11-01 21:18:45', 'MS'),
	(744, 96, 5, 26, 148, NULL, '2019-11-01 21:18:47', 'MS');
/*!40000 ALTER TABLE `penilaian_detail` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.seleksi
DROP TABLE IF EXISTS `seleksi`;
CREATE TABLE IF NOT EXISTS `seleksi` (
  `id_seleksi` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` text,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tahun_penilaian` year(4) DEFAULT NULL,
  `status_seleksi` enum('Sudah diproses','Belum diproses seleksi','Belum diproses pemeringkatan') DEFAULT NULL,
  `status_keputusan` enum('Menunggu Keputusan','Selesai') DEFAULT NULL,
  PRIMARY KEY (`id_seleksi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.seleksi: ~1 rows (approximately)
/*!40000 ALTER TABLE `seleksi` DISABLE KEYS */;
REPLACE INTO `seleksi` (`id_seleksi`, `keterangan`, `dibuat_oleh`, `waktu_dibuat`, `tahun_penilaian`, `status_seleksi`, `status_keputusan`) VALUES
	(5, 'Seleksi dan Rangking Divisi', 6, '2019-11-01 22:54:56', '2018', 'Sudah diproses', 'Menunggu Keputusan');
/*!40000 ALTER TABLE `seleksi` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.seleksi_hasil
DROP TABLE IF EXISTS `seleksi_hasil`;
CREATE TABLE IF NOT EXISTS `seleksi_hasil` (
  `id_seleksi_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_seleksi` int(11) DEFAULT NULL,
  `id_divisi` int(11) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hasil` enum('Dilanjutkan','Tidak Dilanjutkan') DEFAULT NULL,
  `apositif` float DEFAULT NULL,
  `anegatif` float DEFAULT NULL,
  `prefrensi` float DEFAULT NULL,
  `peringkat` int(11) DEFAULT NULL,
  `ikeputusan` tinyint(4) DEFAULT NULL COMMENT '1 : Dipilih, 2 : Tidak dipilih',
  PRIMARY KEY (`id_seleksi_hasil`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.seleksi_hasil: ~24 rows (approximately)
/*!40000 ALTER TABLE `seleksi_hasil` DISABLE KEYS */;
REPLACE INTO `seleksi_hasil` (`id_seleksi_hasil`, `id_seleksi`, `id_divisi`, `dibuat_oleh`, `waktu_dibuat`, `hasil`, `apositif`, `anegatif`, `prefrensi`, `peringkat`, `ikeputusan`) VALUES
	(1, 5, 1, 6, '2019-11-01 22:45:28', 'Tidak Dilanjutkan', NULL, NULL, NULL, NULL, NULL),
	(2, 5, 2, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 6.1483, 8.5046, 0.5804, 4, NULL),
	(3, 5, 3, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.2566, 5.9435, 0.4503, 13, NULL),
	(4, 5, 4, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 5.007, 8.6853, 0.6343, 3, NULL),
	(5, 5, 5, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.9975, 6.2371, 0.4382, 14, NULL),
	(6, 5, 6, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 8.9876, 4.2464, 0.3209, 22, NULL),
	(7, 5, 7, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.7368, 7.5497, 0.4939, 8, NULL),
	(8, 5, 8, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 6.7636, 7.6533, 0.5309, 5, NULL),
	(9, 5, 9, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 8.8011, 5.6827, 0.3923, 20, NULL),
	(10, 5, 10, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.8075, 6.4424, 0.4521, 12, NULL),
	(11, 5, 11, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.3512, 5.3077, 0.4193, 17, NULL),
	(12, 5, 12, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 9.7674, 4.3206, 0.3067, 23, NULL),
	(13, 5, 13, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 8.8348, 5.4203, 0.3802, 21, NULL),
	(14, 5, 14, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 6.8222, 6.8716, 0.5018, 7, NULL),
	(15, 5, 15, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 6.5381, 6.7875, 0.5094, 6, NULL),
	(16, 5, 16, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.2138, 6.6281, 0.4788, 9, NULL),
	(17, 5, 17, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.929, 5.5406, 0.4113, 18, NULL),
	(18, 5, 18, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 4.0597, 8.8466, 0.6854, 1, NULL),
	(19, 5, 19, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 7.8745, 7.0915, 0.4738, 11, NULL),
	(20, 5, 20, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 8.0056, 7.2935, 0.4767, 10, NULL),
	(21, 5, 21, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 8.1257, 6.0577, 0.4271, 15, NULL),
	(22, 5, 22, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 5.0743, 9.302, 0.647, 2, NULL),
	(23, 5, 23, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 8.602, 5.8432, 0.4045, 19, NULL),
	(24, 5, 24, 6, '2019-11-01 22:45:53', 'Dilanjutkan', 8.1509, 6.0611, 0.4265, 16, NULL);
/*!40000 ALTER TABLE `seleksi_hasil` ENABLE KEYS */;

-- Dumping structure for table rulebasetopsis.seleksi_hasildetail
DROP TABLE IF EXISTS `seleksi_hasildetail`;
CREATE TABLE IF NOT EXISTS `seleksi_hasildetail` (
  `id_seleksi_hasildetail` int(11) NOT NULL AUTO_INCREMENT,
  `id_seleksi_hasil` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nilai_awal` float DEFAULT NULL,
  `nilai_normalisasi` float DEFAULT NULL,
  `nilai_terbobot` float DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hasil` enum('MS','TMS') DEFAULT NULL,
  PRIMARY KEY (`id_seleksi_hasildetail`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

-- Dumping data for table rulebasetopsis.seleksi_hasildetail: ~120 rows (approximately)
/*!40000 ALTER TABLE `seleksi_hasildetail` DISABLE KEYS */;
REPLACE INTO `seleksi_hasildetail` (`id_seleksi_hasildetail`, `id_seleksi_hasil`, `id_kriteria`, `nilai_awal`, `nilai_normalisasi`, `nilai_terbobot`, `dibuat_oleh`, `waktu_dibuat`, `hasil`) VALUES
	(1, 1, 1, 50, NULL, NULL, 6, '2019-11-01 22:45:28', 'TMS'),
	(2, 1, 2, 60, NULL, NULL, 6, '2019-11-01 22:45:28', 'TMS'),
	(3, 1, 3, 20, NULL, NULL, 6, '2019-11-01 22:45:28', 'TMS'),
	(4, 1, 4, 60, NULL, NULL, 6, '2019-11-01 22:45:28', 'TMS'),
	(5, 1, 5, 30, NULL, NULL, 6, '2019-11-01 22:45:28', 'TMS'),
	(6, 2, 1, 60, 0.226, 4.52, 6, '2019-11-01 22:45:48', 'MS'),
	(7, 2, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:49', 'TMS'),
	(8, 2, 3, 80, 0.2709, 4.0635, 6, '2019-11-01 22:45:49', 'MS'),
	(9, 2, 4, 60, 0.2121, 5.3025, 6, '2019-11-01 22:45:51', 'TMS'),
	(10, 2, 5, 90, 0.2945, 4.4175, 6, '2019-11-01 22:45:51', 'MS'),
	(11, 3, 1, 40, 0.1506, 3.012, 6, '2019-11-01 22:45:48', 'TMS'),
	(12, 3, 2, 30, 0.0925, 2.3125, 6, '2019-11-01 22:45:49', 'TMS'),
	(13, 3, 3, 60, 0.2032, 3.048, 6, '2019-11-01 22:45:50', 'MS'),
	(14, 3, 4, 100, 0.3536, 8.84, 6, '2019-11-01 22:45:50', 'MS'),
	(15, 3, 5, 40, 0.1309, 1.9635, 6, '2019-11-01 22:45:51', 'TMS'),
	(16, 4, 1, 60, 0.226, 4.52, 6, '2019-11-01 22:45:48', 'MS'),
	(17, 4, 2, 100, 0.3085, 7.7125, 6, '2019-11-01 22:45:49', 'MS'),
	(18, 4, 3, 100, 0.3386, 5.079, 6, '2019-11-01 22:45:50', 'MS'),
	(19, 4, 4, 50, 0.1768, 4.42, 6, '2019-11-01 22:45:50', 'MS'),
	(20, 4, 5, 50, 0.1636, 2.454, 6, '2019-11-01 22:45:51', 'MS'),
	(21, 5, 1, 50, 0.1883, 3.766, 6, '2019-11-01 22:45:48', 'MS'),
	(22, 5, 2, 80, 0.2468, 6.17, 6, '2019-11-01 22:45:49', 'MS'),
	(23, 5, 3, 20, 0.0677, 1.0155, 6, '2019-11-01 22:45:50', 'TMS'),
	(24, 5, 4, 40, 0.1414, 3.535, 6, '2019-11-01 22:45:50', 'TMS'),
	(25, 5, 5, 80, 0.2618, 3.927, 6, '2019-11-01 22:45:51', 'MS'),
	(26, 6, 1, 30, 0.113, 2.26, 6, '2019-11-01 22:45:48', 'TMS'),
	(27, 6, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:49', 'MS'),
	(28, 6, 3, 40, 0.1355, 2.0325, 6, '2019-11-01 22:45:50', 'MS'),
	(29, 6, 4, 20, 0.0707, 1.7675, 6, '2019-11-01 22:45:50', 'TMS'),
	(30, 6, 5, 80, 0.2618, 3.927, 6, '2019-11-01 22:45:51', 'MS'),
	(31, 7, 1, 60, 0.226, 4.52, 6, '2019-11-01 22:45:48', 'MS'),
	(32, 7, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:49', 'MS'),
	(33, 7, 3, 40, 0.1355, 2.0325, 6, '2019-11-01 22:45:50', 'MS'),
	(34, 7, 4, 80, 0.2828, 7.07, 6, '2019-11-01 22:45:50', 'MS'),
	(35, 7, 5, 50, 0.1636, 2.454, 6, '2019-11-01 22:45:51', 'MS'),
	(36, 8, 1, 50, 0.1883, 3.766, 6, '2019-11-01 22:45:48', 'MS'),
	(37, 8, 2, 100, 0.3085, 7.7125, 6, '2019-11-01 22:45:49', 'MS'),
	(38, 8, 3, 40, 0.1355, 2.0325, 6, '2019-11-01 22:45:50', 'MS'),
	(39, 8, 4, 60, 0.2121, 5.3025, 6, '2019-11-01 22:45:51', 'MS'),
	(40, 8, 5, 50, 0.1636, 2.454, 6, '2019-11-01 22:45:51', 'MS'),
	(41, 9, 1, 50, 0.1883, 3.766, 6, '2019-11-01 22:45:48', 'MS'),
	(42, 9, 2, 30, 0.0925, 2.3125, 6, '2019-11-01 22:45:48', 'TMS'),
	(43, 9, 3, 60, 0.2032, 3.048, 6, '2019-11-01 22:45:50', 'MS'),
	(44, 9, 4, 50, 0.1768, 4.42, 6, '2019-11-01 22:45:51', 'TMS'),
	(45, 9, 5, 60, 0.1963, 2.9445, 6, '2019-11-01 22:45:51', 'TMS'),
	(46, 10, 1, 40, 0.1506, 3.012, 6, '2019-11-01 22:45:48', 'TMS'),
	(47, 10, 2, 70, 0.2159, 5.3975, 6, '2019-11-01 22:45:48', 'MS'),
	(48, 10, 3, 20, 0.0677, 1.0155, 6, '2019-11-01 22:45:50', 'TMS'),
	(49, 10, 4, 70, 0.2475, 6.1875, 6, '2019-11-01 22:45:50', 'TMS'),
	(50, 10, 5, 80, 0.2618, 3.927, 6, '2019-11-01 22:45:51', 'MS'),
	(51, 11, 1, 90, 0.339, 6.78, 6, '2019-11-01 22:45:47', 'MS'),
	(52, 11, 2, 40, 0.1234, 3.085, 6, '2019-11-01 22:45:49', 'MS'),
	(53, 11, 3, 20, 0.0677, 1.0155, 6, '2019-11-01 22:45:50', 'TMS'),
	(54, 11, 4, 80, 0.2828, 7.07, 6, '2019-11-01 22:45:50', 'MS'),
	(55, 11, 5, 20, 0.0654, 0.981, 6, '2019-11-01 22:45:51', 'TMS'),
	(56, 12, 1, 40, 0.1506, 3.012, 6, '2019-11-01 22:45:47', 'MS'),
	(57, 12, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:49', 'MS'),
	(58, 12, 3, 20, 0.0677, 1.0155, 6, '2019-11-01 22:45:50', 'TMS'),
	(59, 12, 4, 30, 0.1061, 2.6525, 6, '2019-11-01 22:45:50', 'TMS'),
	(60, 12, 5, 40, 0.1309, 1.9635, 6, '2019-11-01 22:45:51', 'MS'),
	(61, 13, 1, 40, 0.1506, 3.012, 6, '2019-11-01 22:45:47', 'MS'),
	(62, 13, 2, 50, 0.1542, 3.855, 6, '2019-11-01 22:45:49', 'MS'),
	(63, 13, 3, 40, 0.1355, 2.0325, 6, '2019-11-01 22:45:49', 'MS'),
	(64, 13, 4, 80, 0.2828, 7.07, 6, '2019-11-01 22:45:50', 'MS'),
	(65, 13, 5, 20, 0.0654, 0.981, 6, '2019-11-01 22:45:51', 'TMS'),
	(66, 14, 1, 90, 0.339, 6.78, 6, '2019-11-01 22:45:48', 'MS'),
	(67, 14, 2, 50, 0.1542, 3.855, 6, '2019-11-01 22:45:49', 'TMS'),
	(68, 14, 3, 20, 0.0677, 1.0155, 6, '2019-11-01 22:45:50', 'TMS'),
	(69, 14, 4, 70, 0.2475, 6.1875, 6, '2019-11-01 22:45:51', 'MS'),
	(70, 14, 5, 60, 0.1963, 2.9445, 6, '2019-11-01 22:45:51', 'TMS'),
	(71, 15, 1, 40, 0.1506, 3.012, 6, '2019-11-01 22:45:48', 'MS'),
	(72, 15, 2, 100, 0.3085, 7.7125, 6, '2019-11-01 22:45:49', 'MS'),
	(73, 15, 3, 20, 0.0677, 1.0155, 6, '2019-11-01 22:45:49', 'TMS'),
	(74, 15, 4, 60, 0.2121, 5.3025, 6, '2019-11-01 22:45:50', 'MS'),
	(75, 15, 5, 80, 0.2618, 3.927, 6, '2019-11-01 22:45:51', 'MS'),
	(76, 16, 1, 50, 0.1883, 3.766, 6, '2019-11-01 22:45:48', 'TMS'),
	(77, 16, 2, 70, 0.2159, 5.3975, 6, '2019-11-01 22:45:48', 'MS'),
	(78, 16, 3, 100, 0.3386, 5.079, 6, '2019-11-01 22:45:49', 'MS'),
	(79, 16, 4, 50, 0.1768, 4.42, 6, '2019-11-01 22:45:51', 'TMS'),
	(80, 16, 5, 20, 0.0654, 0.981, 6, '2019-11-01 22:45:51', 'TMS'),
	(81, 17, 1, 30, 0.113, 2.26, 6, '2019-11-01 22:45:48', 'TMS'),
	(82, 17, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:49', 'TMS'),
	(83, 17, 3, 20, 0.0677, 1.0155, 6, '2019-11-01 22:45:50', 'TMS'),
	(84, 17, 4, 80, 0.2828, 7.07, 6, '2019-11-01 22:45:51', 'MS'),
	(85, 17, 5, 80, 0.2618, 3.927, 6, '2019-11-01 22:45:51', 'MS'),
	(86, 18, 1, 90, 0.339, 6.78, 6, '2019-11-01 22:45:48', 'MS'),
	(87, 18, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:49', 'TMS'),
	(88, 18, 3, 100, 0.3386, 5.079, 6, '2019-11-01 22:45:49', 'MS'),
	(89, 18, 4, 40, 0.1414, 3.535, 6, '2019-11-01 22:45:50', 'TMS'),
	(90, 18, 5, 90, 0.2945, 4.4175, 6, '2019-11-01 22:45:51', 'MS'),
	(91, 19, 1, 50, 0.1883, 3.766, 6, '2019-11-01 22:45:48', 'MS'),
	(92, 19, 2, 80, 0.2468, 6.17, 6, '2019-11-01 22:45:49', 'MS'),
	(93, 19, 3, 80, 0.2709, 4.0635, 6, '2019-11-01 22:45:49', 'MS'),
	(94, 19, 4, 30, 0.1061, 2.6525, 6, '2019-11-01 22:45:50', 'TMS'),
	(95, 19, 5, 50, 0.1636, 2.454, 6, '2019-11-01 22:45:51', 'TMS'),
	(96, 20, 1, 50, 0.1883, 3.766, 6, '2019-11-01 22:45:48', 'TMS'),
	(97, 20, 2, 80, 0.2468, 6.17, 6, '2019-11-01 22:45:49', 'MS'),
	(98, 20, 3, 40, 0.1355, 2.0325, 6, '2019-11-01 22:45:49', 'MS'),
	(99, 20, 4, 60, 0.2121, 5.3025, 6, '2019-11-01 22:45:50', 'TMS'),
	(100, 20, 5, 50, 0.1636, 2.454, 6, '2019-11-01 22:45:51', 'TMS'),
	(101, 21, 1, 60, 0.226, 4.52, 6, '2019-11-01 22:45:48', 'TMS'),
	(102, 21, 2, 50, 0.1542, 3.855, 6, '2019-11-01 22:45:49', 'TMS'),
	(103, 21, 3, 80, 0.2709, 4.0635, 6, '2019-11-01 22:45:49', 'MS'),
	(104, 21, 4, 20, 0.0707, 1.7675, 6, '2019-11-01 22:45:50', 'TMS'),
	(105, 21, 5, 70, 0.229, 3.435, 6, '2019-11-01 22:45:51', 'MS'),
	(106, 22, 1, 60, 0.226, 4.52, 6, '2019-11-01 22:45:48', 'MS'),
	(107, 22, 2, 80, 0.2468, 6.17, 6, '2019-11-01 22:45:48', 'MS'),
	(108, 22, 3, 100, 0.3386, 5.079, 6, '2019-11-01 22:45:49', 'MS'),
	(109, 22, 4, 70, 0.2475, 6.1875, 6, '2019-11-01 22:45:50', 'MS'),
	(110, 22, 5, 80, 0.2618, 3.927, 6, '2019-11-01 22:45:51', 'MS'),
	(111, 23, 1, 30, 0.113, 2.26, 6, '2019-11-01 22:45:48', 'TMS'),
	(112, 23, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:49', 'MS'),
	(113, 23, 3, 60, 0.2032, 3.048, 6, '2019-11-01 22:45:50', 'MS'),
	(114, 23, 4, 40, 0.1414, 3.535, 6, '2019-11-01 22:45:50', 'TMS'),
	(115, 23, 5, 70, 0.229, 3.435, 6, '2019-11-01 22:45:51', 'MS'),
	(116, 24, 1, 50, 0.1883, 3.766, 6, '2019-11-01 22:45:47', 'TMS'),
	(117, 24, 2, 60, 0.1851, 4.6275, 6, '2019-11-01 22:45:48', 'MS'),
	(118, 24, 3, 80, 0.2709, 4.0635, 6, '2019-11-01 22:45:50', 'MS'),
	(119, 24, 4, 20, 0.0707, 1.7675, 6, '2019-11-01 22:45:50', 'TMS'),
	(120, 24, 5, 70, 0.229, 3.435, 6, '2019-11-01 22:45:51', 'MS');
/*!40000 ALTER TABLE `seleksi_hasildetail` ENABLE KEYS */;

-- Dumping structure for trigger rulebasetopsis.hasildetail_clear
DROP TRIGGER IF EXISTS `hasildetail_clear`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `hasildetail_clear` AFTER DELETE ON `seleksi_hasil` FOR EACH ROW BEGIN
    DELETE FROM `seleksi_hasildetail`
	WHERE seleksi_hasildetail.id_seleksi_hasil = old.id_seleksi_hasil; 
    END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger rulebasetopsis.subkriteriadetail_clear
DROP TRIGGER IF EXISTS `subkriteriadetail_clear`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `subkriteriadetail_clear` AFTER DELETE ON `master_subkriteria` FOR EACH ROW BEGIN
    DELETE FROM `master_subkriteriadetail`
	WHERE master_subkriteriadetail.id_subkriteria = old.id_subkriteria; 
    END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
