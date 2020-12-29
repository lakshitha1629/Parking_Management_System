-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 29, 2020 at 06:18 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_parking`
--

DROP TABLE IF EXISTS `booking_parking`;
CREATE TABLE IF NOT EXISTS `booking_parking` (
  `booking_no` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `space_no` int(10) NOT NULL,
  `vehicle_entering` time NOT NULL,
  `status` varchar(20) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `book_status` varchar(20) NOT NULL,
  PRIMARY KEY (`booking_no`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parking_details`
--

DROP TABLE IF EXISTS `parking_details`;
CREATE TABLE IF NOT EXISTS `parking_details` (
  `p_no` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(11) NOT NULL,
  `vehicle_categorie` varchar(25) NOT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `parking_slot` int(10) NOT NULL,
  `vehicle_in` datetime NOT NULL,
  `vehicle_out` datetime DEFAULT NULL,
  PRIMARY KEY (`p_no`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parking_slots`
--

DROP TABLE IF EXISTS `parking_slots`;
CREATE TABLE IF NOT EXISTS `parking_slots` (
  `parking_slot` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`parking_slot`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking_slots`
--

INSERT INTO `parking_slots` (`parking_slot`, `status`, `email`) VALUES
(1, 'Inactive', ''),
(2, 'Inactive', ''),
(3, 'Inactive', ''),
(4, 'Inactive', ''),
(5, 'Inactive', ''),
(6, 'Inactive', ''),
(7, 'Inactive', ' '),
(8, 'Inactive', ''),
(9, 'Inactive', ''),
(10, 'Inactive', ''),
(11, 'Inactive', ''),
(12, 'Inactive', '');

-- --------------------------------------------------------

--
-- Table structure for table `smart_wallet`
--

DROP TABLE IF EXISTS `smart_wallet`;
CREATE TABLE IF NOT EXISTS `smart_wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `price` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

DROP TABLE IF EXISTS `user_account`;
CREATE TABLE IF NOT EXISTS `user_account` (
  `user_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_type` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `activated` int(11) NOT NULL,
  `number_plate` varchar(11) DEFAULT '',
  `vehicle_type` varchar(20) DEFAULT '',
  `phone` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `number_plate` (`number_plate`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `name`, `email`, `user_type`, `password`, `activated`, `number_plate`, `vehicle_type`, `phone`) VALUES
('1', 'admin', 'admin@gmail.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 1, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
