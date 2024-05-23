-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 08:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loansystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `BillingID` int(11) NOT NULL,
  `DateGenerated` date NOT NULL,
  `BorrowerID` int(11) NOT NULL,
  `AccountType` varchar(50) NOT NULL,
  `LoanedAmount` decimal(10,2) NOT NULL,
  `ReceivedAmount` decimal(10,2) DEFAULT NULL,
  `AmountToPay` decimal(10,2) NOT NULL,
  `Interest` decimal(5,2) NOT NULL,
  `Penalty` decimal(5,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `BillingStatus` enum('Completed','Overdue') NOT NULL,
  `DueDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loanid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `loan_amount` decimal(10,2) NOT NULL,
  `payable_months` int(11) NOT NULL,
  `status` enum('Pending','Rejected','Approved') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loanid`, `user_id`, `loan_amount`, `payable_months`, `status`, `created_at`) VALUES
(10, 3, 4704.50, 1, 'Pending', '2024-05-22 07:32:41'),
(11, 3, 4704.50, 1, 'Pending', '2024-05-22 07:33:11'),
(12, 3, 4704.50, 1, 'Pending', '2024-05-22 07:34:52'),
(13, 3, 4704.50, 1, 'Pending', '2024-05-22 07:35:09'),
(14, 3, 4704.50, 1, 'Pending', '2024-05-22 07:35:10'),
(15, 3, 4704.50, 1, 'Pending', '2024-05-22 07:38:21'),
(16, 3, 4704.50, 1, 'Pending', '2024-05-22 07:38:22'),
(17, 3, 4704.50, 1, 'Pending', '2024-05-22 07:38:32'),
(18, 3, 4704.50, 1, 'Pending', '2024-05-22 07:38:32'),
(19, 3, 4704.50, 1, 'Pending', '2024-05-22 07:46:20'),
(20, 3, 4704.50, 1, 'Pending', '2024-05-22 07:46:20'),
(21, 3, 4704.50, 1, 'Pending', '2024-05-22 07:46:26'),
(22, 3, 4704.50, 1, 'Pending', '2024-05-22 07:46:27'),
(23, 3, 4704.50, 1, 'Pending', '2024-05-22 07:51:58'),
(24, 3, 4704.50, 1, 'Pending', '2024-05-22 07:51:58'),
(25, 3, 4704.50, 1, 'Pending', '2024-05-22 07:53:10'),
(26, 3, 4704.50, 1, 'Pending', '2024-05-22 07:53:10'),
(27, 3, 4704.50, 1, 'Pending', '2024-05-22 08:19:03'),
(28, 3, 5645.40, 1, 'Pending', '2024-05-22 08:19:24'),
(29, 3, 9409.00, 1, 'Pending', '2024-05-22 08:24:26'),
(30, 3, 8.73, 1, 'Pending', '2024-05-22 08:39:37'),
(31, 3, 9.00, 1, 'Pending', '2024-05-22 08:42:24'),
(32, 3, 3.88, 1, 'Pending', '2024-05-22 08:45:13'),
(33, 3, 9.00, 1, 'Pending', '2024-05-22 09:03:27'),
(34, 3, 9409.00, 1, 'Pending', '2024-05-22 09:38:46'),
(35, 3, 4704.50, 1, 'Pending', '2024-05-22 12:31:43'),
(36, 3, 4704.50, 1, 'Pending', '2024-05-22 12:33:47'),
(37, 5, 4704.50, 1, 'Pending', '2024-05-22 12:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `loan_transactions`
--

CREATE TABLE `loan_transactions` (
  `lntranid` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `transaction_type` enum('Increase') NOT NULL,
  `amount_increase` decimal(10,2) NOT NULL,
  `payable_months_increase` int(11) NOT NULL,
  `admin_remarks` varchar(255) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_transactions`
--

INSERT INTO `loan_transactions` (`lntranid`, `loan_id`, `transaction_type`, `amount_increase`, `payable_months_increase`, `admin_remarks`, `transaction_date`) VALUES
(10, 10, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:32:41'),
(11, 11, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:33:11'),
(12, 12, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:34:53'),
(13, 13, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:35:10'),
(14, 14, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:35:10'),
(15, 15, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:38:21'),
(16, 16, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:38:23'),
(17, 17, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:38:32'),
(18, 18, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:38:32'),
(19, 19, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:46:20'),
(20, 20, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:46:20'),
(21, 21, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:46:27'),
(22, 22, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:46:27'),
(23, 23, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:51:58'),
(24, 24, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:51:58'),
(25, 25, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:53:10'),
(26, 26, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 01:53:10'),
(27, 27, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 02:19:04'),
(28, 28, '', 5645.40, 1, 'Loan application submitted', '2024-05-22 02:19:24'),
(29, 29, '', 9409.00, 1, 'Loan application submitted', '2024-05-22 02:24:26'),
(30, 30, '', 8.73, 1, 'Loan application submitted', '2024-05-22 02:39:37'),
(31, 31, '', 9.00, 1, 'Loan application submitted', '2024-05-22 02:42:24'),
(32, 32, '', 3.88, 1, 'Loan application submitted', '2024-05-22 02:45:13'),
(33, 33, '', 9.00, 1, 'Loan application submitted', '2024-05-22 03:03:28'),
(34, 34, '', 9409.00, 1, 'Loan application submitted', '2024-05-22 03:38:47'),
(35, 35, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 06:31:43'),
(36, 36, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 06:33:47'),
(37, 37, '', 4704.50, 1, 'Loan application submitted', '2024-05-22 06:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `savingdatabase`
--

CREATE TABLE `savingdatabase` (
  `savings_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `savings_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `last_activity_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savingdatabase`
--

INSERT INTO `savingdatabase` (`savings_id`, `user_id`, `savings_amount`, `last_activity_date`) VALUES
(1, 9, 806.00, '2024-05-21'),
(2, 3, 600.00, '2024-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `savingstransaction`
--

CREATE TABLE `savingstransaction` (
  `transaction_id` varchar(11) NOT NULL,
  `savings_id` int(11) NOT NULL,
  `transaction_type` enum('Deposit','Withdrawal') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `last_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Failed','Rejected','Completed') NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savingstransaction`
--

INSERT INTO `savingstransaction` (`transaction_id`, `savings_id`, `transaction_type`, `amount`, `last_amount`, `status`, `date_time`) VALUES
('DP664d5fa09', 2, 'Deposit', 100.00, 200.00, 'Completed', '2024-05-22'),
('DP664d5fb07', 2, 'Deposit', 300.00, 500.00, 'Completed', '2024-05-22'),
('DP664de5467', 2, 'Deposit', 100.00, 600.00, 'Completed', '2024-05-22'),
('WT664d5fb5', 2, 'Withdrawal', 500.00, 500.00, 'Pending', '2024-05-22'),
('WT664de53a', 2, 'Withdrawal', 500.00, 500.00, 'Pending', '2024-05-22'),
('WT664de549', 2, 'Withdrawal', 501.00, 600.00, 'Pending', '2024-05-22'),
('WT664de550', 2, 'Withdrawal', 502.00, 600.00, 'Pending', '2024-05-22'),
('WT664de557', 2, 'Withdrawal', 503.00, 600.00, 'Pending', '2024-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `birthday` date NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_account_number` varchar(50) NOT NULL,
  `card_holder_name` varchar(100) NOT NULL,
  `tin_number` varchar(50) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_phone_number` varchar(20) NOT NULL,
  `position` varchar(100) NOT NULL,
  `monthly_earnings` decimal(10,2) NOT NULL,
  `proof_of_billing` varchar(255) NOT NULL,
  `valid_id_primary` varchar(255) NOT NULL,
  `coe` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','active','disabled') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `account_type`, `name`, `address`, `gender`, `birthday`, `age`, `email`, `contact_number`, `bank_name`, `bank_account_number`, `card_holder_name`, `tin_number`, `company_name`, `company_address`, `company_phone_number`, `position`, `monthly_earnings`, `proof_of_billing`, `valid_id_primary`, `coe`, `username`, `password`, `status`) VALUES
(3, 'Premium', 'shen416', 'minglanilla', 'Male', '2000-10-12', 23, 'sherwintorrejas24@gmail.com', '09981994340', 'gcash', '464151515135', 'dawad', '1254984', 'none', 'none', '181961', 'dwawd', 18199.00, 'C:\\xampp1\\htdocs\\loanss\\control/../view/pof/Use case diagram.png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/vid/USE CASE 1.png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/coe/erd.png', 'testadmin', '$2y$10$dOr.g/1MLhQK9TWM14J2PeMy9M.Xq4gKh8XMEjwO9EDtCBv6roVbm', 'active'),
(5, 'Basic', 'shen', 'minglanilla', 'Male', '2000-10-12', 23, 'kpowyrbgegeg@gmail.com', '09981994340', 'gcash', '464151515135', 'dawad', '1254984', 'none', 'none', '181961', 'dwawd', 18199.00, 'C:\\xampp1\\htdocs\\loanss\\control/../view/pof/1716172273_icons8-3-dots-32.png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/vid/1716172273_photo (1).png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/coe/1716172273_recycle-bin.png', 'admintest', '$2y$10$4SVEjTgcIG2W/vi/HHc8CeWzJk4fkvauMMeLQbAGhtbFrQf5DWbBC', 'active'),
(8, 'Admin', 'admin', 'admin', 'Male', '2000-12-12', 23, 'sherwin_torrejas@yahoo.com', '09981994340', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 99999999.99, 'C:\\xampp1\\htdocs\\loanss\\control/../view/pof/image-removebg-preview.png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/vid/429102754_3812552732309475_3534995835571299191_n.png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/coe/RAD.png', 'adminadmin', '$2y$10$dRNu/Q.iWBzLYoTeht1yU.J2KDXx2kfzaJl1B6PXyHxLMdOaEZq72', 'active'),
(9, 'Premium', 'sampl', 'sampl', 'Male', '2000-02-12', 24, 'hl997678@gmail.com', '09981994340', 'sampl', 'sampl', 'sampl', 'sampl', 'sampl', 'sampl', 'sampl', 'sampl', 979107.00, 'C:\\xampp1\\htdocs\\loanss\\control/../view/pof/Blank board (2).png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/vid/placeholder.png', 'C:\\xampp1\\htdocs\\loanss\\control/../view/coe/0', 'sample', '$2y$10$1rXyaUBWWbiw3kgEHImUV.r6d2xOIzUOvJDpIM2.IS6piZShGoE3.', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`BillingID`),
  ADD KEY `BorrowerID` (`BorrowerID`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loanid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  ADD PRIMARY KEY (`lntranid`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `savingdatabase`
--
ALTER TABLE `savingdatabase`
  ADD PRIMARY KEY (`savings_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `savingstransaction`
--
ALTER TABLE `savingstransaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `savings_id` (`savings_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `BillingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  MODIFY `lntranid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `savingdatabase`
--
ALTER TABLE `savingdatabase`
  MODIFY `savings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`BorrowerID`) REFERENCES `users` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  ADD CONSTRAINT `loan_transactions_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`loanid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `savingdatabase`
--
ALTER TABLE `savingdatabase`
  ADD CONSTRAINT `savingdatabase_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `savingstransaction`
--
ALTER TABLE `savingstransaction`
  ADD CONSTRAINT `savingstransaction_ibfk_1` FOREIGN KEY (`savings_id`) REFERENCES `savingdatabase` (`savings_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
