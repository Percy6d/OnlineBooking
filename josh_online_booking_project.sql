-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2023 at 01:39 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `josh_online_booking_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `timeCreated` datetime NOT NULL,
  `timeUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commodities`
--

CREATE TABLE `commodities` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `typeID` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `timeCreated` datetime NOT NULL,
  `timeUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commodities_images`
--

CREATE TABLE `commodities_images` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `commodityID` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `timeAdded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `name` varchar(15) NOT NULL,
  `timeCreated` datetime NOT NULL,
  `timeUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `uid`, `name`, `timeCreated`, `timeUpdated`) VALUES
(1, 'XntTaq4g735IHx2WlSGe', 'product', '2023-04-21 17:54:14', '2023-04-21 17:54:14'),
(5, 'oJunOKArd9HUL8wbis5t', 'service', '2023-04-22 11:04:19', '2023-04-22 11:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `mobileNumber` varchar(15) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `isVerified` tinyint(1) NOT NULL DEFAULT 0,
  `timeCreated` datetime NOT NULL,
  `timeUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `firstname`, `lastname`, `emailAddress`, `mobileNumber`, `password`, `isVerified`, `timeCreated`, `timeUpdated`) VALUES
(1, 'psKhb0iAHGQ3MDolmu9e', NULL, NULL, 'gigirichardofficial@gmail.com', NULL, '$2y$10$rT2SEINqJazvVvKwoNiZU.mwrNfS3DetkVu8y5rc/6dCfcTz7LnsK', 0, '2023-04-21 00:27:38', '2023-04-21 00:27:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `commodities`
--
ALTER TABLE `commodities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `typeID` (`typeID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `commodities_images`
--
ALTER TABLE `commodities_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commodities`
--
ALTER TABLE `commodities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commodities_images`
--
ALTER TABLE `commodities_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commodities`
--
ALTER TABLE `commodities`
  ADD CONSTRAINT `commodities_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `commodities_ibfk_2` FOREIGN KEY (`typeID`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `commodities_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
