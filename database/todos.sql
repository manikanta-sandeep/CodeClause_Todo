-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 30, 2023 at 04:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todos`
--

-- --------------------------------------------------------

--
-- Table structure for table `Todo`
--

CREATE TABLE `Todo` (
  `todo_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(25) NOT NULL,
  `deadline` varchar(25) NOT NULL,
  `last_updated` varchar(25) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Todo`
--

INSERT INTO `Todo` (`todo_id`, `creator_id`, `title`, `description`, `status`, `date_created`, `deadline`, `last_updated`, `priority`) VALUES
(17, 22, 'Hai', 'This is new priority todo', 0, '30-06-2023 05:20:54 PM', '', '30-06-2023 05:27:11 PM', 5),
(18, 22, 'Sandeep', '', 0, '30-06-2023 05:46:04 PM', '', '30-06-2023 05:46:04 PM', 4),
(19, 22, 'Sandy', '', 0, '30-06-2023 05:46:16 PM', '', '30-06-2023 05:46:16 PM', 5),
(20, 22, 'Hai I am sandeep', '', 0, '30-06-2023 06:39:03 PM', '', '30-06-2023 06:39:03 PM', 3),
(21, 22, 'This is completed', '', 1, '30-06-2023 06:39:46 PM', '', '30-06-2023 06:39:46 PM', 0),
(22, 22, 'Hello', '', 1, '30-06-2023 06:46:45 PM', '', '30-06-2023 06:46:45 PM', 2);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_joined` varchar(25) DEFAULT NULL,
  `last_updated` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `username`, `password`, `dob`, `email`, `date_joined`, `last_updated`) VALUES
(22, 'Manikanta Sandeep', '$2y$10$3xNRpXYoxd5qhFAHRzZMNOIpA8O1c3rR1yWuCN5zpXZTjI33HyOxO', '2003-02-05', 'saimanikanta2496@gmail.com', '29-06-2023 10:09:33 PM', '30-06-2023 04:34:18 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Todo`
--
ALTER TABLE `Todo`
  ADD PRIMARY KEY (`todo_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Todo`
--
ALTER TABLE `Todo`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
