-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2021 at 08:16 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `todolist`
--

CREATE TABLE `todolist` (
  `id` int(11) NOT NULL,
  `task` varchar(128) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `completed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todolist`
--

INSERT INTO `todolist` (`id`, `task`, `due_date`, `created_date`, `is_completed`, `completed_date`) VALUES
(1, 'Call Maria', '2021-03-08 00:28:00', '2021-03-07 19:58:56', 1, '2021-03-07 20:01:53'),
(2, 'Meeting with the clients', '2021-03-08 10:30:00', '2021-03-07 20:00:27', 0, NULL),
(3, 'Discus the project with the team', '2021-03-09 00:30:00', '2021-03-07 20:01:30', 0, NULL),
(4, 'Dentist appointment', '2021-03-09 09:45:00', '2021-03-07 20:03:17', 0, NULL),
(5, 'Check with Sarah about the documentation', '2021-03-10 15:30:00', '2021-03-07 20:04:59', 0, NULL),
(6, 'Meeting with Frank', '2021-03-08 16:30:00', '2021-03-07 20:05:56', 0, NULL),
(7, 'Wish Joey birthday', '2021-03-09 00:00:00', '2021-03-07 20:07:37', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todolist`
--
ALTER TABLE `todolist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todolist`
--
ALTER TABLE `todolist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
