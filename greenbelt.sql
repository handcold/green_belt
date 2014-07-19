-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 19, 2014 at 01:45 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `greenbelt`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_incidents_users_idx` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `name`, `created_at`, `updated_at`, `users_id`) VALUES
(2, 'Selling meth', '2014-07-18 12:56:50', '2014-07-18 12:56:50', 2),
(5, 'Being black', '2014-07-15 00:00:00', '2014-07-18 13:06:36', 2),
(6, 'Littering', '2014-06-20 00:00:00', '2014-07-18 13:08:57', 3),
(8, 'Feeding beef to cows', '0000-00-00 00:00:00', '2014-07-18 13:41:53', 4),
(9, 'Communism', '2014-07-04 00:00:00', '2014-07-18 13:59:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Curtis', 'Chin', 'curtteh@gmail.com', 'curtis', '2014-07-18 12:37:11', '2014-07-18 12:37:11'),
(2, 'Sterling', 'Archer', 'sterlingarcher@isis.gov', 'lana', '2014-07-18 12:53:00', '2014-07-18 12:53:00'),
(3, 'Captain', 'Underpants', 'underpants@gmail.com', 'lol', '2014-07-18 13:08:33', '2014-07-18 13:08:33'),
(4, 'Clifford', 'Bigreddog', 'clifford@reddog.com', 'red', '2014-07-18 13:41:28', '2014-07-18 13:41:28'),
(5, 'Harry', 'Potter', 'harry@potter.com', 'yes', '2014-07-18 14:17:26', '2014-07-18 14:17:26'),
(6, 'Tony', 'Stark', 'ironman@yahoo.com', 'fuck', '2014-07-18 15:00:22', '2014-07-18 15:00:22'),
(7, 'Shooter', 'McGavin', 'shooter@aol.com', 'fuck', '2014-07-18 15:59:02', '2014-07-18 15:59:02'),
(8, 'Curtis', 'Chin', 'hello@goodbye.com', 'hello', '2014-07-18 16:30:27', '2014-07-18 16:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `users_has_incidents`
--

CREATE TABLE `users_has_incidents` (
  `users_id` int(11) NOT NULL,
  `incidents_id` int(11) NOT NULL,
  PRIMARY KEY (`users_id`,`incidents_id`),
  KEY `fk_users_has_incidents_incidents1_idx` (`incidents_id`),
  KEY `fk_users_has_incidents_users1_idx` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_has_incidents`
--

INSERT INTO `users_has_incidents` (`users_id`, `incidents_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(6, 1),
(1, 2),
(2, 2),
(1, 5),
(2, 5),
(4, 5),
(2, 6),
(7, 6),
(2, 7),
(2, 8),
(1, 9),
(4, 9),
(5, 9),
(7, 9),
(7, 13),
(8, 17);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
