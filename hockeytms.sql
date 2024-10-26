-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 03:14 PM
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
-- Database: `hockeytms`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `cal_id` int(15) NOT NULL,
  `title` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `category` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `seen` varchar(500) NOT NULL,
  `date_in` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setup`
--

CREATE TABLE `setup` (
  `setup_id` int(15) NOT NULL,
  `home` varchar(500) NOT NULL,
  `site_title` varchar(500) NOT NULL,
  `site_url` varchar(500) NOT NULL,
  `site_logo` varchar(250) NOT NULL,
  `meta_keywords` varchar(1000) NOT NULL,
  `meta_desc` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`setup_id`, `home`, `site_title`, `site_url`, `site_logo`, `meta_keywords`, `meta_desc`) VALUES
(1, 'http://localhost/hockeyplayertms/', 'Nigerian Hockey Federation', 'http://localhost/hockeyplayertms/', 'assets/images/logo-light.png', 'hockey', 'task management system for hockey players');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(15) NOT NULL,
  `task` varchar(50) NOT NULL,
  `assigned` varchar(50) NOT NULL,
  `comments` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `status` int(15) NOT NULL,
  `date_in` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(15) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `age` int(15) NOT NULL,
  `role` varchar(500) NOT NULL,
  `speed` int(15) NOT NULL,
  `endurance_level` int(15) NOT NULL,
  `games_played` int(15) NOT NULL,
  `goals` int(15) NOT NULL,
  `assists` int(15) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `image` varchar(500) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `admin` tinyint(1) NOT NULL,
  `date_in` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `age`, `role`, `speed`, `endurance_level`, `games_played`, `goals`, `assists`, `state`, `country`, `gender`, `password`, `image`, `active`, `admin`, `date_in`) VALUES
(1, 'Coach', 'Admin', 'admin@gmail.com', 0, '', 0, 0, 0, 0, 0, '', '', 'Male', '$2y$10$Apt6SdaFw5eA1oRiVgwNkeMcGN4Nf5yOu0cCUU2h8n/IMR06glYDu', 'uploads/bosslady.jpg', 1, 1, '2024-07-03 07:24:46'),
(19, 'Adaeze', 'Bosslady', 'bosslady@gmail.com', 22, 'Forward', 50, 70, 15, 7, 5, 'Rivers State', 'Nigeria', 'Female', '$2y$10$BiOLe34umig0V.UhB6xa6e96ojNJUtvZih53qmer4aNU8TB3/sj7S', 'uploads/bosslady.jpg', 1, 0, '2024-07-15 14:04:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`cal_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`setup_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `cal_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `setup_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
