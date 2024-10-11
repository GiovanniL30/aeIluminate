-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2024 at 04:10 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtek`
--
CREATE DATABASE IF NOT EXISTS `webtek` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `webtek`;

-- --------------------------------------------------------

--
-- Table structure for table `activitylog`
--

DROP TABLE IF EXISTS `activitylog`;
CREATE TABLE IF NOT EXISTS `activitylog` (
  `activityID` int NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activityTime` timestamp NULL DEFAULT NULL,
  `ipAddress` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deviceInfo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userID` int NOT NULL,
  PRIMARY KEY (`activityID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

DROP TABLE IF EXISTS `alumni`;
CREATE TABLE IF NOT EXISTS `alumni` (
  `userID` int NOT NULL,
  `year_graduated` year DEFAULT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isEmployed` tinyint(1) DEFAULT NULL,
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`userID`, `year_graduated`, `program`, `isEmployed`) VALUES
(2, '2020', 'IT', 1),
(3, '2021', 'IT', 0);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `userID` int NOT NULL,
  `work_for` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`userID`, `work_for`) VALUES
(4, 'Company A'),
(5, 'Company B');

-- --------------------------------------------------------

--
-- Table structure for table `systemlog`
--

DROP TABLE IF EXISTS `systemlog`;
CREATE TABLE IF NOT EXISTS `systemlog` (
  `syslogID` int NOT NULL,
  `logType` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `errorCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `errorMessage` text COLLATE utf8mb4_unicode_ci,
  `stackTrace` text COLLATE utf8mb4_unicode_ci,
  `resolveStatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`syslogID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middleName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isOnline` tinyint(1) DEFAULT NULL,
  `profilePicture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `role`, `username`, `password`, `firstName`, `middleName`, `lastName`, `email`, `isOnline`, `profilePicture`) VALUES
(1, 'Super Admin', 'admin', 'admin', 'John', 'A', 'Doe', 'superadmin@example.com', 0, ''),
(2, 'Alumni', 'alumni1', 'hashedpassword2', 'Jane', 'B', 'Smith', 'alumni1@example.com', 0, ''),
(3, 'Alumni', 'alumni2', 'hashedpassword3', 'Alice', 'C', 'Johnson', 'alumni2@example.com', 0, ''),
(4, 'Manager', 'manager1', 'hashedpassword4', 'Bob', 'D', 'Lee', 'manager1@example.com', 0, ''),
(5, 'Manager', 'manager2', 'hashedpassword5', 'Charlie', 'E', 'Brown', 'manager2@example.com', 0, ''),
(6, 'Alumni', 'alumni6', 'hashedpassword6', 'Juan', 'Santos', 'De la Cruz', 'alumni6@example.com', 0, NULL),
(7, 'Alumni', 'alumni7', 'hashedpassword7', 'Maria', 'Garcia', 'Reyes', 'alumni7@example.com', 0, NULL),
(8, 'Alumni', 'alumni8', 'hashedpassword8', 'Jose', 'Mendoza', 'Bautista', 'alumni8@example.com', 0, NULL),
(9, 'Alumni', 'alumni9', 'hashedpassword9', 'Ana', 'Flores', 'Torres', 'alumni9@example.com', 0, NULL),
(10, 'Alumni', 'alumni10', 'hashedpassword10', 'Pedro', 'Cruz', 'Lazaro', 'alumni10@example.com', 0, NULL),
(11, 'Alumni', 'alumni11', 'hashedpassword11', 'Isabel', 'Rivera', 'Santos', 'alumni11@example.com', 0, NULL),
(12, 'Alumni', 'alumni12', 'hashedpassword12', 'Ramon', 'Villanueva', 'Del Rosario', 'alumni12@example.com', 0, NULL),
(13, 'Alumni', 'alumni13', 'hashedpassword13', 'Carmen', 'Diaz', 'Lopez', 'alumni13@example.com', 0, NULL),
(14, 'Alumni', 'alumni14', 'hashedpassword14', 'Enrique', 'Morales', 'Santiago', 'alumni14@example.com', 0, NULL),
(15, 'Alumni', 'alumni15', 'hashedpassword15', 'Lucia', 'Cruz', 'Fernandez', 'alumni15@example.com', 0, NULL),
(16, 'Alumni', 'alumni16', 'hashedpassword16', 'Alfredo', 'Torres', 'Diaz', 'alumni16@example.com', 0, NULL),
(17, 'Alumni', 'alumni17', 'hashedpassword17', 'Gloria', 'Navarro', 'Garcia', 'alumni17@example.com', 0, NULL),
(18, 'Alumni', 'alumni18', 'hashedpassword18', 'Roberto', 'Dela Cruz', 'Martinez', 'alumni18@example.com', 0, NULL),
(19, 'Alumni', 'alumni19', 'hashedpassword19', 'Victoria', 'Flores', 'Salvador', 'alumni19@example.com', 0, NULL),
(20, 'Alumni', 'alumni20', 'hashedpassword20', 'Daniel', 'Reyes', 'Moreno', 'alumni20@example.com', 0, NULL),
(21, 'Alumni', 'alumni21', 'hashedpassword21', 'Patricia', 'Fernandez', 'Delos Santos', 'alumni21@example.com', 0, NULL),
(22, 'Alumni', 'alumni22', 'hashedpassword22', 'Luis', 'Lopez', 'Mendoza', 'alumni22@example.com', 0, NULL),
(23, 'Alumni', 'alumni23', 'hashedpassword23', 'Cecilia', 'Ramos', 'Reyes', 'alumni23@example.com', 0, NULL),
(24, 'Alumni', 'alumni24', 'hashedpassword24', 'Manuel', 'Santos', 'Torres', 'alumni24@example.com', 0, NULL),
(25, 'Alumni', 'alumni25', 'hashedpassword25', 'Rosa', 'Villanueva', 'Flores', 'alumni25@example.com', 0, NULL),
(26, 'Alumni', 'alumni26', 'hashedpassword26', 'Carlos', 'Del Rosario', 'Garcia', 'alumni26@example.com', 0, NULL),
(27, 'Alumni', 'alumni27', 'hashedpassword27', 'Teresa', 'Diaz', 'Martinez', 'alumni27@example.com', 0, NULL),
(28, 'Alumni', 'alumni28', 'hashedpassword28', 'Francisco', 'Morales', 'Lopez', 'alumni28@example.com', 0, NULL),
(29, 'Alumni', 'alumni29', 'hashedpassword29', 'Alicia', 'Cruz', 'Reyes', 'alumni29@example.com', 0, NULL),
(30, 'Alumni', 'alumni30', 'hashedpassword30', 'Miguel', 'Santiago', 'Mendoza', 'alumni30@example.com', 0, NULL),
(31, 'Alumni', 'alumni31', 'hashedpassword31', 'Beatriz', 'Rivera', 'Dela Cruz', 'alumni31@example.com', 0, NULL),
(32, 'Alumni', 'alumni32', 'hashedpassword32', 'Julio', 'Fernandez', 'Delos Santos', 'alumni32@example.com', 0, NULL),
(33, 'Alumni', 'alumni33', 'hashedpassword33', 'Nina', 'Reyes', 'Garcia', 'alumni33@example.com', 0, NULL),
(34, 'Alumni', 'alumni34', 'hashedpassword34', 'Andres', 'Flores', 'Santos', 'alumni34@example.com', 0, NULL),
(35, 'Alumni', 'alumni35', 'hashedpassword35', 'Elena', 'Morales', 'Bautista', 'alumni35@example.com', 0, NULL),
(36, 'Alumni', 'alumni36', 'hashedpassword36', 'Oscar', 'Garcia', 'Santiago', 'alumni36@example.com', 0, NULL),
(37, 'Alumni', 'alumni37', 'hashedpassword37', 'Salvador', 'Lopez', 'Torres', 'alumni37@example.com', 0, NULL),
(38, 'Alumni', 'alumni38', 'hashedpassword38', 'Luz', 'Navarro', 'Delos Santos', 'alumni38@example.com', 0, NULL),
(39, 'Alumni', 'alumni39', 'hashedpassword39', 'Benito', 'Torres', 'Morales', 'alumni39@example.com', 0, NULL),
(40, 'Alumni', 'alumni40', 'hashedpassword40', 'Estrella', 'Santos', 'Garcia', 'alumni40@example.com', 0, NULL),
(41, 'Manager', 'manager11', 'hashedpassword41', 'Marco', 'Reyes', 'Cruz', 'manager11@example.com', 0, NULL),
(42, 'Manager', 'manager12', 'hashedpassword42', 'Gina', 'Villanueva', 'Santos', 'manager12@example.com', 0, NULL),
(43, 'Manager', 'manager3', 'hashedpassword43', 'Felipe', 'Diaz', 'Martinez', 'manager3@example.com', 0, NULL),
(44, 'Manager', 'manager4', 'hashedpassword44', 'Sandra', 'Delos Reyes', 'Garcia', 'manager4@example.com', 0, NULL),
(45, 'Manager', 'manager5', 'hashedpassword45', 'Victor', 'Cruz', 'Lopez', 'manager5@example.com', 0, NULL),
(46, 'Manager', 'manager6', 'hashedpassword46', 'Alma', 'Fernandez', 'Santiago', 'manager6@example.com', 0, NULL),
(47, 'Manager', 'manager7', 'hashedpassword47', 'Ricardo', 'Morales', 'Bautista', 'manager7@example.com', 0, NULL),
(48, 'Manager', 'manager8', 'hashedpassword48', 'Monica', 'Dela Cruz', 'Santos', 'manager8@example.com', 0, NULL),
(49, 'Manager', 'manager9', 'hashedpassword49', 'Tomas', 'Navarro', 'Garcia', 'manager9@example.com', 0, NULL),
(50, 'Manager', 'manager10', 'hashedpassword50', 'Silvia', 'Torres', 'Lopez', 'manager10@example.com', 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
