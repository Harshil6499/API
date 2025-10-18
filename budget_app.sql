-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2025 at 05:28 PM
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
-- Database: `budget_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `harshil_accounts` (
  `account_id` int(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_type` enum('bank','wallet','cash') DEFAULT 'bank',
  `balance` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `user_id`, `account_name`, `account_type`, `balance`, `created_at`, `updated_at`) VALUES
(1, 3, 'harshil', 'cash', 1000.00, '2025-10-06 11:49:12', '2025-10-17 11:49:12'),
(10, 1, 'HDFC Bank', 'bank', 15000.00, '2025-10-13 12:02:50', '2025-10-13 12:02:50'),
(11, 1, 'HDFC Bank', 'bank', 15000.00, '2025-10-13 12:03:02', '2025-10-13 12:03:02'),
(12, 1, 'HDFC Bank', 'bank', 15000.00, '2025-10-13 12:03:36', '2025-10-13 12:03:36'),
(13, 3, 'HDFC Bank', 'bank', 15000.00, '2025-10-13 12:04:13', '2025-10-13 12:04:13'),
(14, 10, 'My Business Wallet', 'wallet', 3200.50, '2025-10-13 12:05:20', '2025-10-13 14:38:09'),
(15, 3, 'HDFC Bank', 'bank', 15000.00, '2025-10-13 13:20:38', '2025-10-13 13:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `harshil_categories` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `user_id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(2, 3, 'Updated Category Name', 'expense', '2025-10-14 16:28:38', '2025-10-14 16:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `harshil_expenses` (
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text DEFAULT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `user_id`, `account_id`, `category`, `amount`, `note`, `expense_date`, `created_at`, `updated_at`) VALUES
(5, 3, 10, 'Transport', 2500.00, 'Cab ride to office', '2025-10-13', '2025-10-15 11:42:44', '2025-10-15 11:43:15'),
(7, 3, 10, 'Food', 250.00, 'Lunch at cafe', '2025-10-13', '2025-10-15 11:47:53', '2025-10-15 11:47:53'),
(8, 3, 10, 'Food', 250.00, 'Lunch at cafe', '2025-10-13', '2025-10-15 11:47:55', '2025-10-15 11:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `harshil_income` (
  `income_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text DEFAULT NULL,
  `income_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `user_id`, `account_id`, `category`, `amount`, `note`, `income_date`, `created_at`, `updated_at`) VALUES
(2, 3, 10, 'Salary', 5000.00, 'October salary', '2025-10-15', '2025-10-15 12:27:49', '2025-10-15 12:27:49'),
(3, 3, 10, 'Freelance', 1500.00, 'Updated project payment', '2025-10-15', '2025-10-15 12:27:51', '2025-10-15 12:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `harshil_transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `account_id`, `type`, `category`, `amount`, `note`, `date`, `created_at`, `updated_at`) VALUES
(2, 1, 10, 'expense', 'Food', 250.75, 'Lunch at restaurant', '2025-10-13', '2025-10-14 11:01:00', '2025-10-14 11:05:37'),
(3, 1, 10, 'expense', 'Food', 250.75, 'Lunch at restaurant', '2025-10-13', '2025-10-14 12:27:18', '2025-10-14 12:27:18'),
(4, 1, 10, 'expense', 'Food', 250.75, 'Lunch at restaurant', '2025-10-13', '2025-10-14 14:33:44', '2025-10-14 14:33:44'),
(5, 1, 10, 'expense', 'Food', 250.75, 'Lunch at restaurant', '2025-10-13', '2025-10-14 14:33:47', '2025-10-14 14:33:47'),
(6, 1, 10, 'expense', 'Shopping', 200.00, 'Bought clothes', '2025-10-13', '2025-10-14 14:33:48', '2025-10-14 14:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `harshil_users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `DOB` date DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `confirm_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `phone`, `password`, `DOB`, `profile_image`, `role`, `created_at`, `updated_at`, `confirm_password`) VALUES
(1, 'Harshil Updated1', 'Shishangiya1', 'admin@gmail.com', '9876543210', '1234', '2000-10-12', 'profile_updated.png', 'admin', '2025-10-12 12:02:56', '2025-10-13 15:26:39', ''),
(3, 'admin', 'admin', 'admin123@gmail.com', '1234567890', '123', '2025-10-09', NULL, 'admin', '2025-10-12 12:03:27', '2025-10-12 12:03:27', ''),
(10, 'Harshil', 'Shishangiya', 'harshil@gmail.com', '9876543210', '1234', '2000-10-10', 'profile1.png', 'user', '2025-10-12 12:50:20', '2025-10-12 12:50:20', '1234'),
(15, 'Harshil', 'Shishangiya', 'harshil7777@gmail.com', '9876543210', '1234', '2000-10-10', 'profile1.png', 'user', '2025-10-13 10:40:16', '2025-10-13 10:40:16', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `income_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
