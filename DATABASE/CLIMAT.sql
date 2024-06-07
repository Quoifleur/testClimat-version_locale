-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2024 at 04:00 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testclimat`
--

-- --------------------------------------------------------

--
-- Table structure for table `CLIMAT`
--

CREATE TABLE `CLIMAT` (
  `id` int(10) UNSIGNED NOT NULL,
  `COMPTEclef` varchar(64) DEFAULT NULL,
  `COMPTEvisibilite` tinyint(1) DEFAULT '0',
  `AC` varchar(32) DEFAULT NULL,
  `SAVE` int(1) DEFAULT NULL,
  `RAM` int(16) DEFAULT NULL,
  `DATEcollecte` date DEFAULT NULL,
  `DATEentre` date DEFAULT NULL,
  `TEMPORALITEperiode` varchar(9) DEFAULT NULL,
  `TEMPORALITEmois` varchar(128) DEFAULT NULL,
  `TEMPORALITEsaison` varchar(24) DEFAULT NULL,
  `NOMlocalisation` varchar(32) DEFAULT NULL,
  `NOMgenerique` varchar(32) DEFAULT NULL,
  `POSITIONhemisphere` varchar(8) DEFAULT NULL,
  `POSITIONx` decimal(20,20) DEFAULT NULL,
  `POSITIONy` decimal(20,20) DEFAULT NULL,
  `POSITIONz` decimal(20,20) DEFAULT NULL,
  `NORMALEte` varchar(256) DEFAULT NULL,
  `NORMALEpr` varchar(256) DEFAULT NULL,
  `NORMALE2` varchar(256) DEFAULT NULL,
  `NORMALE3` varchar(256) DEFAULT NULL,
  `NORMALE4` varchar(256) DEFAULT NULL,
  `RESULTATkoge` varchar(256) DEFAULT NULL,
  `RESULTATgaus` varchar(256) DEFAULT NULL,
  `RESULTATmart` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CLIMAT`
--
--
-- Indexes for dumped tables
--

--
-- Indexes for table `CLIMAT`
--
ALTER TABLE `CLIMAT`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CLIMAT`
--
ALTER TABLE `CLIMAT`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
