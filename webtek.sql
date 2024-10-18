-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 15, 2024 at 11:23 AM
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
DROP DATABASE IF EXISTS `webtek`;
CREATE DATABASE IF NOT EXISTS `webtek` DEFAULT CHARACTER SET utf8mb4;
USE `webtek`;

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

DROP TABLE IF EXISTS `alumni`;
CREATE TABLE IF NOT EXISTS `alumni` (
  `userID` int NOT NULL,
  `year_graduated` year DEFAULT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `isEmployed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`userID`, `year_graduated`, `degree`, `isEmployed`) VALUES
(1, '2012', 'BS Engineering', 1),
(2, '2007', 'BS Biology', 0),
(4, '2015', 'BS Mathematics', 1),
(5, '2023', 'BS Computer Science', 0),
(7, '2005', 'BS Physics', 0),
(11, '2011', 'BS Business Administration', 0),
(12, '2022', 'BS Information Technology', 1),
(13, '2025', 'BS Biology', 0),
(15, '2009', 'BS Physics', 1),
(16, '2004', 'BS Nursing', 1),
(17, '2006', 'BS Mathematics', 1),
(20, '2006', 'BS Engineering', 1),
(22, '2012', 'BS Chemistry', 1),
(23, '2012', 'BS Engineering', 1),
(25, '2007', 'BS Information Technology', 1),
(27, '2007', 'BS Information Technology', 1),
(28, '2008', 'BS Business Administration', 0),
(30, '2012', 'BS Mathematics', 0),
(31, '2023', 'BS Business Administration', 0),
(32, '2017', 'BS Business Administration', 1),
(33, '2013', 'BS Environmental Science', 1),
(34, '2008', 'BS Physics', 0),
(38, '2004', 'BS Information Technology', 1),
(39, '2025', 'BS Computer Science', 0),
(40, '2010', 'BS Business Administration', 0),
(41, '2008', 'BS Chemistry', 0),
(42, '2015', 'BS Physics', 0),
(43, '2005', 'BS Physics', 1),
(47, '2014', 'BS Biology', 1),
(48, '2003', 'BS Mathematics', 1),
(50, '2010', 'BS Chemistry', 0);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE IF NOT EXISTS `application` (
  `appID` int NOT NULL,
  `diplomaURL` varchar(255) DEFAULT NULL,
  `schoolIdURL` varchar(255) DEFAULT NULL,
  `isVerified` tinyint(1) DEFAULT NULL,
  `userID` int DEFAULT NULL,
  PRIMARY KEY (`appID`),
  KEY `FK_Application_User` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `commentID` int NOT NULL,
  `content` text,
  `createdAt` datetime DEFAULT NULL,
  `postID` int DEFAULT NULL,
  `userID` int DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `FK_Comment_Post` (`postID`),
  KEY `FK_Comment_User` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `eventID` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `eventDate` date DEFAULT NULL,
  `eventTime` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `eventType` varchar(50) DEFAULT NULL,
  `createdOn` datetime DEFAULT NULL,
  `createdBy` int DEFAULT NULL,
  PRIMARY KEY (`eventID`),
  KEY `FK_Event_User` (`createdBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `createdBy`, `title`, `description`, `eventDate`, `eventTime`, `location`, `eventType`, `createdOn`) VALUES
(1, 3, 'utilize end-to-end content', 'matrix customized markets', '2024-12-26', '07:35:00', '0022 Cassandra Trace Apt. 277\nWendyfurt, MA 97512', 'seminars', '2024-10-15 18:36:35'),
(2, 6, 'aggregate ubiquitous relationships', 'facilitate intuitive initiatives', '2024-12-27', '07:35:00', '21704 Joanna Station Suite 843\nJohnland, IA 79135', 'alumni awards', '2024-10-15 18:47:35'),
(3, 8, 'matrix end-to-end experiences', 'orchestrate synergistic markets', '2024-12-06', '07:35:00', '9417 Huffman Forks\nNew Benjamin, CT 57121', 'sports fest', '2024-10-15 02:55:35'),
(4, 9, 'enhance killer infrastructures', 'transition e-business infrastructures', '2025-01-15', '07:35:00', '79404 Wilkins Trace Apt. 168\nLake Crystalhaven, NC 02322', 'webinars', '2024-10-15 14:22:35'),
(5, 10, 'cultivate cross-platform web services', 'productize seamless partnerships', '2025-01-12', '07:35:00', '0720 Eric Burg Suite 022\nEricborough, NH 52318', 'sports fest', '2024-10-15 03:08:35'),
(6, 14, 'mesh bleeding-edge ROI', 'extend viral supply-chains', '2024-11-10', '07:35:00', '28312 Guerra Manors Apt. 494\nSouth David, MP 57338', 'alumni awards', '2024-10-15 06:46:35'),
(7, 18, 'maximize magnetic initiatives', 'architect synergistic e-business', '2024-12-12', '07:35:00', '97930 Ashley Bridge Apt. 341\nDanielside, ME 31216', 'conventions', '2024-10-15 12:54:35'),
(8, 19, 'utilize sticky niches', 'disintermediate best-of-breed initiatives', '2024-11-15', '07:35:00', '6733 Cunningham Track Suite 167\nBrownmouth, HI 50183', 'community outreach', '2024-10-15 19:01:35'),
(9, 21, 'innovate web-enabled e-commerce', 'productize dot-com architectures', '2024-11-26', '07:35:00', 'PSC 5338, Box 9517\nAPO AP 38767', 'fundraiser', '2024-10-15 14:57:35'),
(10, 24, 'syndicate synergistic e-services', 'visualize scalable web services', '2024-11-16', '07:35:00', '94797 Greg Radial\nLake Katherinemouth, TN 20262', 'conventions', '2024-10-15 13:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE IF NOT EXISTS `follows` (
  `followerID` int NOT NULL,
  `followedID` int NOT NULL,
  `followedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`followerID`,`followedID`),
  KEY `FK_Follow_Followed` (`followedID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `postID` int NOT NULL,
  `userID` int NOT NULL,
  `likedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`postID`, `userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `mediaID` int NOT NULL,
  `mediaType` varchar(50) DEFAULT NULL,
  `mediaURL` varchar(255) DEFAULT NULL,
  `uploadedAt` datetime DEFAULT NULL,
  `postID` int DEFAULT NULL,
  PRIMARY KEY (`mediaID`),
  KEY `FK_Media_Post` (`postID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `postID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `caption` text,
  `createdAt` datetime DEFAULT NULL,
  `lastInteraction` datetime DEFAULT NULL,
  PRIMARY KEY (`postID`),
  KEY `FK_Post_User` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL,
  `role` enum('Alumni','Manager') DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `middleName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `profilePicture` varchar(255) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `isOnline` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `role`, `username`, `password`, `firstName`, `middleName`, `lastName`, `email`, `profilePicture`, `company`, `isOnline`) VALUES
(1, 'Alumni', 'clarkejamie', 'YMn8xgQ0NH', 'Mitchell', 'Elizabeth', 'Carr', 'rebeccamoore@example.net', '', 'company', 0),
(2, 'Alumni', 'klinelauren', '5CkiHc5zZI', 'Elizabeth', 'Pamela', 'Reynolds', 'brian79@example.org', '', 'company', 0),
(3, 'Manager', 'nicholas11', '43BkNudtOD', 'Jason', 'Brooke', 'Jackson', 'hillchelsea@example.com', '', 'company', 0),
(4, 'Alumni', 'bradykenneth', 'wy23h3enhM', 'Amanda', 'Ronald', 'Cooper', 'caitlin84@example.com', '', 'company', 0),
(5, 'Alumni', 'sampsonwilliam', 'Gdr0NUvNJd', 'Steve', 'Kristin', 'Peters', 'hhoover@example.org', '', 'company', 0),
(6, 'Manager', 'zlittle', 'TI1BevmLtM', 'Steven', 'Taylor', 'Garcia', 'sonya93@example.net', '', 'company', 0),
(7, 'Alumni', 'ajohnston', 'ItFf8xGdDe', 'Christine', 'Steven', 'Jordan', 'harrislindsey@example.com', '', 'company', 0),
(8, 'Manager', 'lopezchad', 'JW7D0NHm3F', 'Chris', 'Priscilla', 'Anderson', 'hwright@example.org', '', 'company', 0),
(9, 'Manager', 'aliciarodriguez', 'sDvgEr8zKm', 'Jeffrey', 'Nicole', 'Parker', 'ctorres@example.com', '', 'company', 0),
(10, 'Manager', 'lrice', 'KHANSDMBAP', 'Kenneth', 'Elizabeth', 'Smith', 'adrianasloan@example.net', '', 'company', 0),
(11, 'Alumni', 'garnerlori', 'muZPxYelBe', 'Lauren', 'Joseph', 'Willis', 'robertmorgan@example.com', '', 'company', 0),
(12, 'Alumni', 'ycarroll', 'i53i4Xzp5h', 'Jill', 'Matthew', 'White', 'billy10@example.com', '', 'company', 0),
(13, 'Alumni', 'tracey30', 'nHJgFo4htD', 'Melissa', 'Gregory', 'Harris', 'austinstephanie@example.org', '', 'company', 0),
(14, 'Manager', 'whamilton', 't0CzSzHXlt', 'Joseph', 'Jennifer', 'Thompson', 'ricky82@example.net', '', 'company', 0),
(15, 'Alumni', 'gabrielaustin', 'QYaZkHo6KO', 'Cody', 'Joshua', 'Thomas', 'brian69@example.net', '', 'company', 0),
(16, 'Alumni', 'mstevens', 'V205ZgrmL4', 'Rachel', 'Jocelyn', 'Cruz', 'laurenfranklin@example.org', '', 'company', 0),
(17, 'Alumni', 'benjamin68', 'Aov6FyK6yV', 'Shannon', 'Danielle', 'Chen', 'qgomez@example.org', '', 'company', 0),
(18, 'Manager', 'colerachel', 'El1RRrchga', 'Philip', 'Tara', 'Walker', 'patricia89@example.net', '', 'company', 0),
(19, 'Manager', 'yyoung', 'uD6mb2Clkn', 'Sheila', 'Ann', 'Wong', 'salascarrie@example.org', '', 'company', 0),
(20, 'Alumni', 'megan27', 'bNF99jTFBT', 'Katie', 'Tracy', 'Jones', 'caitlin59@example.net', '', 'company', 0),
(21, 'Manager', 'coreycarroll', 'xTTlR1vAoI', 'Craig', 'Edward', 'Hamilton', 'henryjordan@example.net', '', 'company', 0),
(22, 'Alumni', 'xking', 'MlkbNsg6rU', 'Victoria', 'Jennifer', 'Soto', 'odean@example.com', '', 'company', 0),
(23, 'Alumni', 'kristennelson', 'Tvd1BW7MUB', 'Joel', 'Julie', 'Gordon', 'wilsonkelly@example.com', '', 'company', 0),
(24, 'Manager', 'melissajohnson', '8M5dVxyDpZ', 'Kristin', 'Katherine', 'Ortiz', 'melanierussell@example.com', '', 'company', 0),
(25, 'Alumni', 'jlee', 'bOvczA7RQR', 'Michael', 'Jonathan', 'Freeman', 'kimberly28@example.net', '', 'company', 0),
(26, 'Manager', 'williamschristine', '8OyOqJBwrQ', 'Sean', 'Courtney', 'Keith', 'travisjones@example.com', '', 'company', 0),
(27, 'Alumni', 'woodselizabeth', 'YhCz54zAHo', 'Deborah', 'Diane', 'Smith', 'boydrose@example.com', '', 'company', 0),
(28, 'Alumni', 'rburns', 'u51YHLZVzp', 'Michelle', 'Kimberly', 'Grant', 'jgraves@example.org', '', 'company', 0),
(29, 'Manager', 'shepherdtaylor', '8eJPP6f3QM', 'Bradley', 'Sean', 'Dorsey', 'briangeorge@example.com', '', 'company', 0),
(30, 'Alumni', 'moraashley', 'x18kDX7F3e', 'Jacob', 'Matthew', 'Wood', 'leondiamond@example.net', '', 'company', 0),
(31, 'Alumni', 'patricia13', '25vM6vKLng', 'Christine', 'Robert', 'Reyes', 'jefferyhicks@example.org', '', 'company', 0),
(32, 'Alumni', 'jacqueline11', 'KYg0jcBLPm', 'Todd', 'Rachel', 'Myers', 'lmorton@example.net', '', 'company', 0),
(33, 'Alumni', 'matthewhull', 'ABEVCqS07X', 'Jasmine', 'Laura', 'Hughes', 'ashley49@example.org', '', 'company', 0),
(34, 'Alumni', 'brandon78', 'yNRo29zmYV', 'Mark', 'Jillian', 'Jones', 'frank35@example.org', '', 'company', 0),
(35, 'Manager', 'cannonantonio', 'Ep5VhGRfhO', 'Amanda', 'Lisa', 'Peterson', 'kelly76@example.org', '', 'company', 0),
(36, 'Manager', 'thomasclark', 'VCl2QcOYmW', 'Samuel', 'James', 'Dominguez', 'yhiggins@example.net', '', 'company', 0),
(37, 'Manager', 'bgreen', 'TRl2oAPFFm', 'Pamela', 'Andrew', 'Moses', 'joseph42@example.org', '', 'company', 0),
(38, 'Alumni', 'ogentry', '3Jx4qlFdvX', 'Valerie', 'Zachary', 'Booker', 'cathyfloyd@example.org', '', 'company', 0),
(39, 'Alumni', 'andrew94', 'JIddpNdCIO', 'Jay', 'Shawn', 'Moody', 'josefrancis@example.org', '', 'company', 0),
(40, 'Alumni', 'wmclean', 'FGeHYq5ZfE', 'Daniel', 'Anthony', 'Stewart', 'ambercain@example.net', '', 'company', 0),
(41, 'Alumni', 'johnorr', 'PMQIbTgHS6', 'Traci', 'Mason', 'Ellis', 'terri75@example.com', '', 'company', 0),
(42, 'Alumni', 'molly87', '5ZtAFX6R3n', 'Linda', 'Stephanie', 'Griffith', 'hendersonjohn@example.net', '', 'company', 0),
(43, 'Alumni', 'stephen15', 'JSDS7JWhYd', 'Kevin', 'Erik', 'Collins', 'jonesstephanie@example.org', '', 'company', 0),
(44, 'Manager', 'andre04', '8cZCK6PidM', 'Wendy', 'Natalie', 'Walker', 'williamseric@example.com', '', 'company', 0),
(45, 'Manager', 'lauren69', '1d63KKlzvU', 'Adrian', 'Jonathan', 'Smith', 'xmendoza@example.org', '', 'company', 0),
(46, 'Manager', 'colton10', 'ZeYXPS5V0t', 'Jodi', 'Timothy', 'Andrews', 'scott23@example.org', '', 'company', 0),
(47, 'Alumni', 'gonzalezangela', 'oNjALynRVk', 'Brent', 'Jeremy', 'Dawson', 'darrellmoore@example.net', '', 'company', 0),
(48, 'Alumni', 'robertgarrison', 'AGB2XiZZLt', 'Steve', 'Alexander', 'Davis', 'nancy19@example.net', '', 'company', 0),
(49, 'Manager', 'ilove', 'geFi54zhyZ', 'Robert', 'Richard', 'Perez', 'stewartmichael@example.org', '', 'company', 0),
(50, 'Alumni', 'ewingaaron', 'QZovz6gTVY', 'Blake', 'Gary', 'Wade', 'ccline@example.com', '', 'company', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `FK_Alumni_User` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `FK_Application_User` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_Comment_Post` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Comment_User` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `FK_Event_User` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `FK_Follow_Followed` FOREIGN KEY (`followedID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Follow_Follower` FOREIGN KEY (`followerID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FK_Like_Post` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Like_User` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_Media_Post` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_Post_User` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
