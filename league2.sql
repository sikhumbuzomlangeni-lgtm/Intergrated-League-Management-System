-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 05:48 PM
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
-- Database: `league2`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `match_id` int(11) NOT NULL,
  `home_team_id` int(11) NOT NULL,
  `away_team_id` int(11) NOT NULL,
  `match_date` date NOT NULL,
  `home_score` int(11) DEFAULT NULL,
  `away_score` int(11) DEFAULT NULL,
  `status` enum('Scheduled','Played') DEFAULT 'Scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`match_id`, `home_team_id`, `away_team_id`, `match_date`, `home_score`, `away_score`, `status`) VALUES
(1, 39, 44, '2025-11-15', 2, 1, 'Played'),
(2, 43, 40, '2025-11-15', 0, 0, 'Played'),
(3, 37, 38, '2025-11-15', 2, 2, 'Played'),
(4, 41, 42, '2025-11-15', 4, 1, 'Played'),
(5, 45, 47, '2025-11-15', 1, 3, 'Played'),
(6, 41, 42, '2025-11-15', 2, 5, 'Played');

-- --------------------------------------------------------

--
-- Table structure for table `standings`
--

CREATE TABLE `standings` (
  `team_id` int(11) NOT NULL,
  `played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `draws` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `goals_for` int(11) DEFAULT 0,
  `goals_against` int(11) DEFAULT 0,
  `points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standings`
--

INSERT INTO `standings` (`team_id`, `played`, `wins`, `draws`, `losses`, `goals_for`, `goals_against`, `points`) VALUES
(37, 1, 0, 1, 0, 2, 2, 1),
(38, 1, 0, 1, 0, 2, 2, 1),
(39, 1, 1, 0, 0, 2, 1, 3),
(40, 1, 0, 1, 0, 0, 0, 1),
(41, 2, 1, 0, 1, 6, 6, 3),
(42, 2, 1, 0, 1, 6, 6, 3),
(43, 1, 0, 1, 0, 0, 0, 1),
(44, 1, 0, 0, 1, 1, 2, 0),
(45, 1, 0, 0, 1, 1, 3, 0),
(46, 0, 0, 0, 0, 0, 0, 0),
(47, 1, 1, 0, 0, 3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `manager_id`, `logo`, `created_at`) VALUES
(37, 'Manzini Warriors', 1, NULL, '2025-11-14 17:01:31'),
(38, 'Mbabane Titans', 3, NULL, '2025-11-14 17:14:59'),
(39, 'Lobamba Lions', 4, NULL, '2025-11-14 17:14:59'),
(40, 'Siteki Strikers', 5, NULL, '2025-11-14 17:14:59'),
(41, 'Nhlangano Knights', 6, NULL, '2025-11-14 17:14:59'),
(42, 'Piggs Peak Panthers', 7, NULL, '2025-11-14 17:14:59'),
(43, 'Malkerns Meteors', 8, NULL, '2025-11-14 17:14:59'),
(44, 'Big Bend Blazers', 9, NULL, '2025-11-14 17:14:59'),
(45, 'Simunye Spartans', 10, NULL, '2025-11-14 17:14:59'),
(46, 'Matsapha Mariners', 11, NULL, '2025-11-14 17:14:59'),
(47, 'Ngwenya Nomads', 12, NULL, '2025-11-14 17:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('Admin','Manager') NOT NULL DEFAULT 'Manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'sikhumbuzo', 'qwerty', 'Manager'),
(2, 'siphosethu', 'qwerty', 'Admin'),
(3, 'muheti', 'qwerty', 'Manager'),
(4, 'tino', 'qwerty', 'Manager'),
(5, 'sengeto', 'qwerty', 'Manager'),
(6, 'swakhile', 'qwerty', 'Manager'),
(7, 'nkosingivile', 'qwerty', 'Manager'),
(8, 'phumlani', 'qwerty', 'Manager'),
(9, 'ntokozo', 'qwerty', 'Manager'),
(10, 'nkosinamandla', 'qwerty', 'Manager'),
(11, 'joey', 'qwerty', 'Manager'),
(12, 'lethu', 'qwerty', 'Manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `home_team_id` (`home_team_id`),
  ADD KEY `away_team_id` (`away_team_id`);

--
-- Indexes for table `standings`
--
ALTER TABLE `standings`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`),
  ADD UNIQUE KEY `team_name` (`team_name`),
  ADD KEY `teams_ibfk_1` (`manager_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`team_id`),
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`team_id`);

--
-- Constraints for table `standings`
--
ALTER TABLE `standings`
  ADD CONSTRAINT `standings_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
