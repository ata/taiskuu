-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2009 at 08:31 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sia_payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `Gaji`
--

CREATE TABLE IF NOT EXISTS `Gaji` (
  `id` bigint(20) NOT NULL auto_increment,
  `karyawan_id` bigint(20) NOT NULL,
  `periode_id` bigint(20) NOT NULL,
  `gaji_pokok` bigint(20) NOT NULL,
  `jumlah_kehadiran` int(11) NOT NULL,
  `jumlah_sakit` int(11) NOT NULL,
  `jumlah_izin` int(11) NOT NULL,
  `jumlah_jam_lembur_biasa` int(11) NOT NULL,
  `jumlah_jam_lembur_libur` int(11) NOT NULL,
  `jumlah_jam_lembur_minggu` int(11) NOT NULL,
  `tunjangan_jabatan` bigint(20) NOT NULL,
  `tunjangan_keluarga` bigint(20) NOT NULL,
  `tunjangan_lain` bigint(20) NOT NULL,
  `uang_lembur` bigint(20) NOT NULL,
  `uang_transport` bigint(20) NOT NULL,
  `uang_makan` bigint(20) NOT NULL,
  `bonus` bigint(20) NOT NULL,
  `potongan` bigint(20) NOT NULL,
  `total_gaji` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Gaji`
--

INSERT INTO `Gaji` (`id`, `karyawan_id`, `periode_id`, `gaji_pokok`, `jumlah_kehadiran`, `jumlah_sakit`, `jumlah_izin`, `jumlah_jam_lembur_biasa`, `jumlah_jam_lembur_libur`, `jumlah_jam_lembur_minggu`, `tunjangan_jabatan`, `tunjangan_keluarga`, `tunjangan_lain`, `uang_lembur`, `uang_transport`, `uang_makan`, `bonus`, `potongan`, `total_gaji`) VALUES
(1, 1, 1, 1000000, 24, 2, 1, 3, 5, 6, 500000, 200000, 10000, 383721, 144000, 360000, 500000, 34884, 3062837);

-- --------------------------------------------------------

--
-- Table structure for table `JamLembur`
--

CREATE TABLE IF NOT EXISTS `JamLembur` (
  `id` bigint(20) NOT NULL auto_increment,
  `hari` enum('normal','libur','minggu') NOT NULL,
  `jumlah_jam` int(11) NOT NULL,
  `karyawan_id` bigint(20) NOT NULL,
  `periode_id` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `JamLembur`
--


-- --------------------------------------------------------

--
-- Table structure for table `Karyawan`
--

CREATE TABLE IF NOT EXISTS `Karyawan` (
  `id` bigint(20) NOT NULL auto_increment,
  `nik` varchar(16) NOT NULL,
  `nama_lengkap` varchar(128) NOT NULL,
  `tempat_lahir` varchar(128) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `golongan` varchar(128) NOT NULL,
  `gaji_pokok` bigint(20) NOT NULL,
  `tunjangan_jabatan` bigint(20) NOT NULL,
  `tunjangan_keluarga` bigint(20) NOT NULL,
  `tunjangan_lain` bigint(20) NOT NULL,
  `transport_per_hari` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `Karyawan`
--

INSERT INTO `Karyawan` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `golongan`, `gaji_pokok`, `tunjangan_jabatan`, `tunjangan_keluarga`, `tunjangan_lain`, `transport_per_hari`) VALUES
(1, '0023', 'Ahmad Tanwir', 'Tunjang', '1987-11-20', 'S', 1000000, 500000, 200000, 10000, 6000),
(6, '0001', 'Didin', 'Tunjang', '1987-11-20', 'A', 1000000, 500000, 200000, 10000, 6000),
(12, '0001', 'Siapa Aja', 'B', '2009-06-05', 'A', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Periode`
--

CREATE TABLE IF NOT EXISTS `Periode` (
  `id` bigint(20) NOT NULL auto_increment,
  `periode` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Periode`
--

INSERT INTO `Periode` (`id`, `periode`) VALUES
(1, '2009-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `Presensi`
--

CREATE TABLE IF NOT EXISTS `Presensi` (
  `id` bigint(20) NOT NULL auto_increment,
  `karyawan_id` bigint(20) NOT NULL,
  `periode_id` bigint(20) NOT NULL,
  `kehadiran` int(11) NOT NULL,
  `sakit` int(11) NOT NULL,
  `izin` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Presensi`
--

INSERT INTO `Presensi` (`id`, `karyawan_id`, `periode_id`, `kehadiran`, `sakit`, `izin`) VALUES
(1, 1, 1, 20, 2, 1),
(2, 1, 2, 20, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Setting`
--

CREATE TABLE IF NOT EXISTS `Setting` (
  `id` bigint(20) NOT NULL auto_increment,
  `upah_lembur_hari_biasa` float(10,0) NOT NULL,
  `upah_lembur_hari_minggu` float(10,0) NOT NULL,
  `upah_lembur_hari_libur` float(10,0) NOT NULL,
  `uang_makan_harian` bigint(20) NOT NULL,
  `potongan_per_ketidakhadiran_sakit` float(10,0) NOT NULL,
  `potongan_per_ketidakhadiran_izin` float(10,0) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Setting`
--

INSERT INTO `Setting` (`id`, `upah_lembur_hari_biasa`, `upah_lembur_hari_minggu`, `upah_lembur_hari_libur`, `uang_makan_harian`, `potongan_per_ketidakhadiran_sakit`, `potongan_per_ketidakhadiran_izin`) VALUES
(1, 1, 1, 6, 15000, 2, 2);
