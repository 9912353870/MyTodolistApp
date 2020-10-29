-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 29, 2020 at 10:45 AM
-- Server version: 5.7.30-0ubuntu0.16.04.1
-- PHP Version: 5.6.40-15+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `personal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_details`
--

CREATE TABLE `todo_details` (
  `sno` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `assignee` varchar(30) DEFAULT NULL,
  `estimated` varchar(30) DEFAULT NULL,
  `completed` varchar(30) DEFAULT NULL,
  `categories` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `cdate` varchar(30) DEFAULT NULL,
  `udate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo_details`
--

INSERT INTO `todo_details` (`sno`, `title`, `assignee`, `estimated`, `completed`, `categories`, `status`, `cdate`, `udate`) VALUES
(3, 'something edited here', '6', '04:00:00', '10:15:00', '10', '1', '28-10-2020 11:20:00pm', '28-10-2020 11:46:59pm'),
(4, 'todo1:check  this imp', '6', '10:00:00', '15:30:00', '11', '1', '29-10-2020 08:58:25am', NULL),
(5, 'todo2:check  this imp', '7', '09:25:00', '13:20:00', '7', '2', '29-10-2020 09:30:49am', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `mail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `mail`) VALUES
(6, 'Bhanu prakash Mallepoola', '$2y$10$rrBz5XZfaXWigHkz3K.WleQLipOrj5KNziypK1fnbmKTYqckGWOum', '2020-10-28 16:07:41', 'sravan8147@gmail.com'),
(7, 'sravan kumar', '$2y$10$gIPO31XPOUTMxvI7M.CY1eJCVTpUSpq6FH0zC8pLj57khOx36o1.i', '2020-10-28 20:14:28', 'fakemail@gmail.com'),
(8, 'prasad mallepoola', '$2y$10$sqzl7IdKwZOFeBjbY28odudd5s32KaVODUsxI7qjOyXG3L3JsjJdC', '2020-10-28 20:15:44', 'fakemail2@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_details`
--
ALTER TABLE `todo_details`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_details`
--
ALTER TABLE `todo_details`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
