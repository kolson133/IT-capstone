-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2016 at 02:22 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dwbh`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` int(5) NOT NULL,
  `description` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `id` int(6) NOT NULL,
  `yelpID` varchar(64) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`id`, `yelpID`, `phone`, `name`) VALUES
(1, 'the-joynt-eau-claire', '7158356959', 'The Joynt'),
(2, 'the-eau-claire-fire-house-eau-claire', '7155140406', 'Firehouse');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(5) NOT NULL,
  `daysOccuringOn` varchar(450) NOT NULL,
  `description` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `happyhour`
--

CREATE TABLE `happyhour` (
  `id` int(5) NOT NULL,
  `dayOfTheWeek` int(1) NOT NULL,
  `timeStart` varchar(5) NOT NULL,
  `timeEnd` varchar(5) NOT NULL,
  `description` varchar(128) NOT NULL,
  `barID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `happyhour`
--

INSERT INTO `happyhour` (`id`, `dayOfTheWeek`, `timeStart`, `timeEnd`, `description`, `barID`) VALUES
(1, 0, '08:00', '20:00', 'Free Beer', 1),
(2, 1, '10:00', '14:00', 'Free Water', 2),
(9, 2, '08:00', '20:00', 'test addition', 1);

-- --------------------------------------------------------

--
-- Table structure for table `submissiontypes`
--

CREATE TABLE `submissiontypes` (
  `id` int(2) NOT NULL,
  `typeDesc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submissiontypes`
--

INSERT INTO `submissiontypes` (`id`, `typeDesc`) VALUES
(1, 'happyhour');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `email` varchar(90) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usersubmissions`
--

CREATE TABLE `usersubmissions` (
  `id` int(6) NOT NULL,
  `userID` int(6) NOT NULL,
  `submissionType` int(2) NOT NULL,
  `submissionID` int(5) NOT NULL,
  `submittedOn` datetime NOT NULL,
  `businessID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersubmissions`
--

INSERT INTO `usersubmissions` (`id`, `userID`, `submissionType`, `submissionID`, `submittedOn`, `businessID`) VALUES
(1, 0, 1, 1, '2016-12-07 00:00:00', 1),
(2, 0, 1, 2, '2016-12-07 00:00:00', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `happyhour`
--
ALTER TABLE `happyhour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissiontypes`
--
ALTER TABLE `submissiontypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usersubmissions`
--
ALTER TABLE `usersubmissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `happyhour`
--
ALTER TABLE `happyhour`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `submissiontypes`
--
ALTER TABLE `submissiontypes`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usersubmissions`
--
ALTER TABLE `usersubmissions`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
