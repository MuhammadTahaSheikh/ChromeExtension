-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2023 at 07:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `updated_podio_extension`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) NOT NULL,
  `au_id` bigint(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `au_id`, `title`, `date`, `status`, `company_id`, `created_at`) VALUES
(1, 2, 'Completed', '2023-05-02', 'Completed', 2, '2023-05-15 17:42:01'),
(2, 2, 'Completed', '2023-05-02', 'Completed', 2, '2023-05-15 17:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_success`
--

CREATE TABLE `campaign_success` (
  `id` bigint(20) NOT NULL,
  `csu_id` bigint(20) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `campaign_leads` int(11) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaign_success`
--

INSERT INTO `campaign_success` (`id`, `csu_id`, `campaign_name`, `campaign_leads`, `company_id`, `created_at`) VALUES
(8, 89, '[04.13.23 SAN ANTONIO TX 20+ YEARS OWNED OWNER OCC 15K - TM1', 0, 2, '2023-05-22 10:29:50'),
(9, 99, 'test9', 0, 2, '2023-05-22 10:29:50'),
(325, 0, 'test campaign 5', 0, 2, '2023-06-14 16:24:25'),
(326, 0, 'testing campaign', 2, 2, '2023-06-14 16:40:34'),
(328, 0, 'testing campaign 3', 0, 2, '2023-06-11 16:41:45'),
(329, 0, 'testing campaign 7', 1500, 2, '2023-06-14 13:41:45'),
(330, 0, 'testing campaign', 150, 2, '2023-06-14 14:33:22'),
(331, 0, 'testing campaign', 1234, 2, '2023-06-14 14:33:22'),
(332, 0, 'testing campaign', 150, 2, '2023-06-14 14:33:22'),
(333, 0, 'testing campaign', 1234, 2, '2023-06-14 14:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) NOT NULL,
  `client_id` varchar(256) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `phone_num` varchar(14) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_id`, `first_name`, `last_name`, `phone_num`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, '111', 'Muhammad', 'Taha', '03114315611', 'tahasheikh682@gmail.com', '', '2023-05-11 13:59:59', '2023-05-11 13:59:59'),
(9, '999', '', '', '', '', '', '2023-05-12 12:00:57', '2023-05-12 12:00:57'),
(10, '222', '', '', '', '', '', '2023-05-12 13:36:50', '2023-05-12 13:36:50'),
(18, '19', 'thd', 'crm', '112233', 'thdcrm@gmail.com', '', '2023-05-18 13:28:33', '2023-05-18 10:28:33'),
(123, '123', '360', 'test', '', '', '', '2023-05-17 22:16:45', '2023-05-17 19:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `client_companies`
--

CREATE TABLE `client_companies` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_companies`
--

INSERT INTO `client_companies` (`id`, `client_id`, `company_id`, `created_at`) VALUES
(1, 1, 2, '2023-05-11 14:04:26'),
(11, 9, 3, '2023-05-08 15:01:39'),
(12, 9, 2, '2023-05-12 12:28:24'),
(13, 10, 2, '2023-05-12 13:37:17'),
(123, 123, 123, '2023-05-17 19:18:19'),
(124, 18, 17, '2023-05-09 13:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) NOT NULL,
  `title` varchar(45) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `title`, `url`, `created_at`, `updated_at`) VALUES
(2, '', 'https://podio.com/sellyourhomes/syh-crm', '2023-05-11 14:04:06', '2023-05-11 14:04:06'),
(3, 'syh', 'https://podio.com/quickofferhomescom/operations-reivolution', '2023-05-11 16:44:32', '2023-05-11 16:44:32'),
(4, '360Synergytech', 'https://podio.com/sellyourhomes/sy/h-crm/deleted', '2023-05-12 14:46:40', '2023-05-12 14:46:40'),
(17, 'thd', 'https://podio.com/thehomedealcom/thd-crm', '2023-05-18 10:31:05', '2023-05-18 10:31:05'),
(123, '', 'https://podio.com/quickofferhomescom/operations-reivolution', '2023-05-17 22:17:57', '2023-05-17 19:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) NOT NULL,
  `status` varchar(100) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `lead_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `escrow`
--

CREATE TABLE `escrow` (
  `id` bigint(20) NOT NULL,
  `escrow_money` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL,
  `compnay_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `escrow`
--

INSERT INTO `escrow` (`id`, `escrow_money`, `deal_id`, `compnay_id`, `created_at`) VALUES
(1, 1000, 0, 2, '2023-05-12 14:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) NOT NULL,
  `lu_id` bigint(20) NOT NULL,
  `type` varchar(45) NOT NULL,
  `temperature` varchar(45) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `leads_under_drip` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `lu_id`, `type`, `temperature`, `company_id`, `leads_under_drip`, `created_at`) VALUES
(12, 0, 'text', 'warm', 2, 1, '2023-05-10 22:09:50'),
(13, 0, 'ppc', 'warm', 2, 1, '2023-03-02 14:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `marketing_expense`
--

CREATE TABLE `marketing_expense` (
  `id` int(11) NOT NULL,
  `campaign_id` bigint(20) NOT NULL,
  `amount` double NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marketing_expense`
--

INSERT INTO `marketing_expense` (`id`, `campaign_id`, `amount`, `company_id`, `created_at`) VALUES
(1, 1, 900, 3, '2022-12-08 00:00:00'),
(2, 1, 1000, 2, '2023-05-08 00:00:00'),
(3, 0, 500, 2, '2023-01-08 13:59:22'),
(4, 2, 650, 2, '2023-03-08 17:25:40'),
(10, 2, 650, 2, '2022-11-02 17:34:17'),
(63, 2, 450, 2, '2023-02-06 19:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `profit_chart`
--

CREATE TABLE `profit_chart` (
  `id` bigint(20) NOT NULL,
  `deal_id` bigint(20) NOT NULL,
  `profit` varchar(255) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profit_chart`
--

INSERT INTO `profit_chart` (`id`, `deal_id`, `profit`, `company_id`, `created_at`) VALUES
(1, 2, '1500', 2, '2023-02-08 18:27:59'),
(2, 2, '500', 2, '2023-02-08 18:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `telemarketing`
--

CREATE TABLE `telemarketing` (
  `id` bigint(20) NOT NULL,
  `comm_id` bigint(20) NOT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `company_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telemarketing`
--

INSERT INTO `telemarketing` (`id`, `comm_id`, `type_id`, `company_id`, `created_at`) VALUES
(1, 2, 1, 2, '2022-11-05 21:49:31'),
(2, 2, 2, 2, '2023-01-12 21:50:22'),
(3, 2, 3, 2, '2023-03-22 21:51:18'),
(4, 2, 4, 2, '2023-01-14 21:02:51'),
(5, 2, 5, 2, '2023-04-05 16:15:07'),
(6, 2, 6, 2, '2023-02-02 17:50:50'),
(7, 2, 7, 2, '2023-05-07 18:57:08'),
(8, 2, 8, 2, '2023-04-07 21:09:34'),
(9, 2, 2, 2, '2023-01-12 13:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `title`, `description`) VALUES
(1, 'sms-in', NULL),
(2, 'sms-in', NULL),
(3, 'sms-in', NULL),
(4, 'call-out', NULL),
(5, 'sms-out', 'test_smsout'),
(6, 'call-in', 'test_callin'),
(7, 'call-out', 'te'),
(8, 'sms-out', 'retest');

-- --------------------------------------------------------

--
-- Table structure for table `va_hours`
--

CREATE TABLE `va_hours` (
  `id` bigint(20) NOT NULL,
  `report_id` bigint(20) NOT NULL,
  `name` varchar(45) NOT NULL,
  `time-in` time NOT NULL,
  `time-out` time NOT NULL,
  `working_hours` int(11) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `va_hours`
--

INSERT INTO `va_hours` (`id`, `report_id`, `name`, `time-in`, `time-out`, `working_hours`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'taha', '07:06:05', '09:06:05', 9, 2, '2023-05-01 20:12:26', NULL),
(27, 0, 'test 360', '00:00:00', '00:00:00', 12, 2, '2023-06-14 14:03:28', NULL),
(29, 0, 'moughees', '00:00:00', '00:00:00', 14, 2, '2023-06-14 16:46:38', NULL),
(31, 0, 'moughees', '00:00:00', '00:00:00', 14, 2, '2023-06-14 16:46:38', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_company_appointments_id` (`company_id`);

--
-- Indexes for table `campaign_success`
--
ALTER TABLE `campaign_success`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_company_campaing_success_fk` (`company_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `client_companies`
--
ALTER TABLE `client_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_contracts_id` (`company_id`);

--
-- Indexes for table `escrow`
--
ALTER TABLE `escrow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_escrow_idx` (`compnay_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_company_leads_id` (`company_id`);

--
-- Indexes for table `marketing_expense`
--
ALTER TABLE `marketing_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_marketing_expense_id` (`company_id`),
  ADD KEY `fk_campaign_marketing_expense_id` (`campaign_id`);

--
-- Indexes for table `profit_chart`
--
ALTER TABLE `profit_chart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_profit_id` (`company_id`);

--
-- Indexes for table `telemarketing`
--
ALTER TABLE `telemarketing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_telemarketing_type_id` (`type_id`),
  ADD KEY `fk_company_telemarketing_id` (`company_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `va_hours`
--
ALTER TABLE `va_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compnay_va_hours_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `campaign_success`
--
ALTER TABLE `campaign_success`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `client_companies`
--
ALTER TABLE `client_companies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `escrow`
--
ALTER TABLE `escrow`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `marketing_expense`
--
ALTER TABLE `marketing_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `profit_chart`
--
ALTER TABLE `profit_chart`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `telemarketing`
--
ALTER TABLE `telemarketing`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `va_hours`
--
ALTER TABLE `va_hours`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_company_appointments_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `campaign_success`
--
ALTER TABLE `campaign_success`
  ADD CONSTRAINT `fk_company_campaing_success_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `client_companies`
--
ALTER TABLE `client_companies`
  ADD CONSTRAINT `fk_client_company_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_company_client_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `fk_company_contracts_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `escrow`
--
ALTER TABLE `escrow`
  ADD CONSTRAINT `fk_company_escrow_idx` FOREIGN KEY (`compnay_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `fk_company_leads_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `marketing_expense`
--
ALTER TABLE `marketing_expense`
  ADD CONSTRAINT `fk_company_marketing_expense_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `profit_chart`
--
ALTER TABLE `profit_chart`
  ADD CONSTRAINT `fk_company_profit_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `telemarketing`
--
ALTER TABLE `telemarketing`
  ADD CONSTRAINT `fk_company_telemarketing_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_telemarketing_type_id` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `va_hours`
--
ALTER TABLE `va_hours`
  ADD CONSTRAINT `fk_compnay_va_hours_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
