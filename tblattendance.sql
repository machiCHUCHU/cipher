-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 06:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbattendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblattendance`
--

CREATE TABLE `tblattendance` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `in_AM` time DEFAULT NULL,
  `out_AM` time DEFAULT NULL,
  `in_PM` time DEFAULT NULL,
  `out_PM` time DEFAULT NULL,
  `dated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblattendance`
--

INSERT INTO `tblattendance` (`id`, `userid`, `in_AM`, `out_AM`, `in_PM`, `out_PM`, `dated`) VALUES
(21, 1, '11:31:48', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(22, 1, '11:33:13', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(23, 1, '11:35:10', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(24, 1, '11:35:46', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(25, 1, '11:37:38', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(26, 1, '11:38:30', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(27, 1, '11:38:33', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(28, 1, '11:40:58', '11:45:04', '11:44:30', NULL, '2024-04-17'),
(29, 1, '12:14:06', NULL, NULL, NULL, '2024-04-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblattendance`
--
ALTER TABLE `tblattendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD CONSTRAINT `tblattendance_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `tblstudents` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
