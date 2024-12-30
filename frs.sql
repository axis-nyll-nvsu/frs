-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 05:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frs`
--

-- --------------------------------------------------------

--
-- Table structure for table `frs_audittrail`
--

CREATE TABLE `frs_audittrail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frs_cashflow`
--

CREATE TABLE `frs_cashflow` (
  `id` int(11) NOT NULL,
  `year` char(4) NOT NULL,
  `balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frs_categories`
--

CREATE TABLE `frs_categories` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frs_categories`
--

INSERT INTO `frs_categories` (`id`, `description`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 'Booking Fee - Bagabag', b'0', 1, NULL),
(2, 'Booking Fee - Bambang', b'0', 1, NULL),
(3, 'Booking Fee - Bayombong', b'0', 1, NULL),
(4, 'Booking Fee - Cordon', b'0', 1, NULL),
(5, 'Booking Fee - Santiago', b'0', 1, NULL),
(6, 'Booking Fee - Solano', b'0', 1, NULL),
(7, '5% MUVE/TUVE - Bagabag', b'0', 1, NULL),
(8, '5% MUVE/TUVE - Bambang', b'0', 1, NULL),
(9, '5% MUVE/TUVE - Bayombong', b'0', 1, NULL),
(10, '5% MUVE/TUVE - Cordon', b'0', 1, NULL),
(11, '5% MUVE/TUVE - Santiago', b'0', 1, NULL),
(12, '5% MUVE/TUVE - Solano', b'0', 1, NULL),
(13, 'Mgmt. Fee - EJEEP', b'0', 1, NULL),
(14, 'Mgmt. Fee - TTS', b'0', 1, NULL),
(15, 'Charging Fee', b'0', 1, NULL),
(16, 'Membership Fee', b'0', 1, NULL),
(17, 'Parking Fee', b'0', 1, NULL),
(18, 'Processing Fee', b'0', 1, NULL),
(19, 'Share Capital', b'0', 1, NULL),
(20, 'Trip Ticket', b'0', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `frs_collections`
--

CREATE TABLE `frs_collections` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `receipt` varchar(25) NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frs_drivers`
--

CREATE TABLE `frs_drivers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frs_ecategories`
--

CREATE TABLE `frs_ecategories` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frs_ecategories`
--

INSERT INTO `frs_ecategories` (`id`, `description`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 'Salaries', b'0', 1, NULL),
(2, 'Incentives', b'0', 1, NULL),
(3, 'Employee Benefits', b'0', 1, NULL),
(4, 'Utilities', b'0', 1, NULL),
(5, 'Office Supplies', b'0', 1, NULL),
(6, 'Equipment', b'0', 1, NULL),
(7, 'Meals and Snacks', b'0', 1, NULL),
(8, 'Maintenance Fees', b'0', 1, NULL),
(9, 'Legal Fees', b'0', 1, NULL),
(10, 'Other Expenses', b'0', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `frs_expenses`
--

CREATE TABLE `frs_expenses` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frs_fares`
--

CREATE TABLE `frs_fares` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` double(10,0) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frs_salaries`
--

CREATE TABLE `frs_salaries` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `collection` double NOT NULL,
  `amount` double NOT NULL,
  `paid` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frs_users`
--

CREATE TABLE `frs_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `type` int(1) NOT NULL,
  `image` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frs_users`
--

INSERT INTO `frs_users` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `type`, `image`, `address`, `contact`, `deleted`) VALUES
(1, 'Charlene', 'Bumanghat', 'Dela Cruz', 'admin@admin.com', '202cb962ac59075b964b07152d234b70', 0, 'default.png', 'Bayombong, Nueva Vizcaya', '09170202020', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `frs_audittrail`
--
ALTER TABLE `frs_audittrail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audittrail_userid` (`user_id`);

--
-- Indexes for table `frs_cashflow`
--
ALTER TABLE `frs_cashflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frs_categories`
--
ALTER TABLE `frs_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_createdby` (`created_by`),
  ADD KEY `fk_categories_updatedby` (`updated_by`);

--
-- Indexes for table `frs_collections`
--
ALTER TABLE `frs_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_collections_categoryid` (`category_id`),
  ADD KEY `fk_collections_createdby` (`created_by`),
  ADD KEY `fk_collections_updatedby` (`updated_by`);

--
-- Indexes for table `frs_drivers`
--
ALTER TABLE `frs_drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_drivers_createdby` (`created_by`),
  ADD KEY `fk_drivers_updatedby` (`updated_by`);

--
-- Indexes for table `frs_ecategories`
--
ALTER TABLE `frs_ecategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ecategories_createdby` (`created_by`),
  ADD KEY `fk_ecategories_updatedby` (`updated_by`);

--
-- Indexes for table `frs_expenses`
--
ALTER TABLE `frs_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expenses_createdby` (`created_by`),
  ADD KEY `fk_expenses_updatedby` (`updated_by`),
  ADD KEY `fk_expenses_categoryid` (`category_id`);

--
-- Indexes for table `frs_fares`
--
ALTER TABLE `frs_fares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fcollections_createdby` (`created_by`),
  ADD KEY `fk_fcollections_updatedby` (`updated_by`);

--
-- Indexes for table `frs_salaries`
--
ALTER TABLE `frs_salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_salaries_createdby` (`created_by`),
  ADD KEY `fk_salaries_updateby` (`updated_by`),
  ADD KEY `fk_salaries_driverid` (`driver_id`);

--
-- Indexes for table `frs_users`
--
ALTER TABLE `frs_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `frs_audittrail`
--
ALTER TABLE `frs_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frs_cashflow`
--
ALTER TABLE `frs_cashflow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frs_categories`
--
ALTER TABLE `frs_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `frs_collections`
--
ALTER TABLE `frs_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frs_drivers`
--
ALTER TABLE `frs_drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frs_ecategories`
--
ALTER TABLE `frs_ecategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `frs_expenses`
--
ALTER TABLE `frs_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frs_fares`
--
ALTER TABLE `frs_fares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frs_salaries`
--
ALTER TABLE `frs_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frs_users`
--
ALTER TABLE `frs_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `frs_audittrail`
--
ALTER TABLE `frs_audittrail`
  ADD CONSTRAINT `fk_audittrail_userid` FOREIGN KEY (`user_id`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `frs_categories`
--
ALTER TABLE `frs_categories`
  ADD CONSTRAINT `fk_categories_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_categories_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `frs_collections`
--
ALTER TABLE `frs_collections`
  ADD CONSTRAINT `fk_collections_categoryid` FOREIGN KEY (`category_id`) REFERENCES `frs_categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_collections_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_collections_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `frs_drivers`
--
ALTER TABLE `frs_drivers`
  ADD CONSTRAINT `fk_drivers_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_drivers_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `frs_ecategories`
--
ALTER TABLE `frs_ecategories`
  ADD CONSTRAINT `fk_ecategories_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ecategories_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `frs_expenses`
--
ALTER TABLE `frs_expenses`
  ADD CONSTRAINT `fk_expenses_categoryid` FOREIGN KEY (`category_id`) REFERENCES `frs_ecategories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expenses_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expenses_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `frs_fares`
--
ALTER TABLE `frs_fares`
  ADD CONSTRAINT `fk_fcollections_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fcollections_driverid` FOREIGN KEY (`driver_id`) REFERENCES `frs_drivers` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fcollections_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `frs_salaries`
--
ALTER TABLE `frs_salaries`
  ADD CONSTRAINT `fk_salaries_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_salaries_driverid` FOREIGN KEY (`driver_id`) REFERENCES `frs_drivers` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_salaries_updateby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
