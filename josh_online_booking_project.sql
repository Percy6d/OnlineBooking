-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2023 at 10:20 PM
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
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `commodityID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `timeCreated` datetime NOT NULL,
  `timeUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `imageURL` varchar(255) DEFAULT NULL,
  `timeCreated` datetime NOT NULL,
  `timeUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `uid`, `name`, `imageURL`, `timeCreated`, `timeUpdated`) VALUES
(2, '5yc8dqaGiRZDwjztU1Tl', 'Artisan', 'https://images.pexels.com/photos/1675993/pexels-photo-1675993.jpeg?auto=compress&cs=tinysrgb&w=600', '2023-04-22 18:05:48', '2023-04-22 18:05:48'),
(4, 'bk4pu8sgNfmJG1aCIer0', 'Housing', 'https://images.pexels.com/photos/144632/pexels-photo-144632.jpeg?auto=compress&cs=tinysrgb&w=600', '2023-04-22 18:06:36', '2023-04-22 18:06:36');

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

--
-- Dumping data for table `commodities`
--

INSERT INTO `commodities` (`id`, `uid`, `name`, `userID`, `categoryID`, `typeID`, `status`, `timeCreated`, `timeUpdated`) VALUES
(2, 'z5SimX0j6MZufYIwD9Cn', 'Random laptops', 1, 2, 1, 0, '2023-04-23 00:25:20', '2023-04-23 00:25:20');

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

--
-- Dumping data for table `commodities_images`
--

INSERT INTO `commodities_images` (`id`, `uid`, `commodityID`, `url`, `timeAdded`) VALUES
(1, 'JQeK4y59S0sCuztFiLxq', 2, 'https://images.pexels.com/photos/11129922/pexels-photo-11129922.jpeg?auto=compress&cs=tinysrgb&w=600', '2023-04-23 00:25:20'),
(2, 'y1eHZRLYnjGf0Q87XOUK', 2, 'https://images.pexels.com/photos/16254610/pexels-photo-16254610.jpeg?auto=compress&cs=tinysrgb&w=600', '2023-04-23 00:25:20'),
(3, 'kTZ8ugQnRjYvecmBxzWP', 2, 'https://images.pexels.com/photos/13791390/pexels-photo-13791390.jpeg?auto=compress&cs=tinysrgb&w=600', '2023-04-23 00:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `amount` float NOT NULL,
  `timePaid` datetime NOT NULL
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
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD KEY `commodityID` (`commodityID`),
  ADD KEY `userID` (`userID`);

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
  ADD UNIQUE KEY `uid` (`uid`),
  ADD KEY `commodityID` (`commodityID`);

--
-- Indexes for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `bookingID` (`bookingID`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `commodities`
--
ALTER TABLE `commodities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commodities_images`
--
ALTER TABLE `commodities_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`commodityID`) REFERENCES `commodities` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `commodities`
--
ALTER TABLE `commodities`
  ADD CONSTRAINT `commodities_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `commodities_ibfk_2` FOREIGN KEY (`typeID`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `commodities_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `commodities_images`
--
ALTER TABLE `commodities_images`
  ADD CONSTRAINT `commodities_images_ibfk_1` FOREIGN KEY (`commodityID`) REFERENCES `commodities` (`id`);

--
-- Constraints for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD CONSTRAINT `payment_histories_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `bookings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
