-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2017 at 02:43 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mzb440`
--

-- --------------------------------------------------------

--
-- Table structure for table `MedicalChart`
--

CREATE TABLE IF NOT EXISTS `MedicalChart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `vitals_date` date NOT NULL,
  `blood_press` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `temp` int(11) NOT NULL,
  `blood_sugar` int(11) NOT NULL,
  `diagnosis` varchar(1000) NOT NULL,
  `treatment` varchar(1000) NOT NULL,
  `prescription` varchar(1000) NOT NULL,
  `lab_test` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `MedicalChart`
--

INSERT INTO `MedicalChart` (`id`, `person_id`, `doctor_id`, `vitals_date`, `blood_press`, `weight`, `height`, `temp`, `blood_sugar`, `diagnosis`, `treatment`, `prescription`, `lab_test`) VALUES
(1, 2, 5, '2017-07-26', 123456, 2147483647, 20, 456, 456, 'died', 'none', 'all', 'many');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
