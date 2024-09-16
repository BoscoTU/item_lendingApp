-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 06:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `item-lending-app_v1.7`
--

-- --------------------------------------------------------

--
-- Table structure for table `black_list`
--

CREATE TABLE `black_list` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `class_number` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_input`
--

CREATE TABLE `item_input` (
  `item` varchar(255) NOT NULL,
  `have_additional_info` tinyint(1) NOT NULL,
  `additional_info_type` varchar(255) DEFAULT NULL,
  `input_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_input`
--

INSERT INTO `item_input` (`item`, `have_additional_info`, `additional_info_type`, `input_description`) VALUES
('basketball', 1, 'number', 'basketball no.:'),
('portable battery', 1, 'boolean', 'have_plug?');

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

CREATE TABLE `user_history` (
  `timestamp` datetime NOT NULL,
  `action` varchar(255) NOT NULL,
  `id` int(20) NOT NULL,
  `can_borrow` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `class_number` int(11) NOT NULL,
  `date` date NOT NULL,
  `period` varchar(255) DEFAULT NULL,
  `item_dealt_with` varchar(255) DEFAULT NULL,
  `additional_information` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Complete user history';

--
-- Dumping data for table `user_history`
--

INSERT INTO `user_history` (`timestamp`, `action`, `id`, `can_borrow`, `name`, `class`, `class_number`, `date`, `period`, `item_dealt_with`, `additional_information`) VALUES
('2024-08-16 03:21:17', 'borrow', 12, 0, 'Lau', '3D', 11, '2024-08-16', 'recess', 'portable battery', 'have_plug?: true'),
('2024-08-16 23:29:28', 'return', 12, 1, 'Lau', '3D', 11, '2024-08-16', 'recess', 'portable battery', 'have_plug?: true');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `black_list`
--
ALTER TABLE `black_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_input`
--
ALTER TABLE `item_input`
  ADD PRIMARY KEY (`item`),
  ADD UNIQUE KEY `item` (`item`);

--
-- Indexes for table `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`timestamp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
