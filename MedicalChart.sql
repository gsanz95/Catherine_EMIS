-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 03, 2017 at 10:41 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group`
--

-- --------------------------------------------------------

--
-- Table structure for table `MedicalChart`
--

CREATE TABLE `MedicalChart` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `vitals_date` varchar(11) NOT NULL,
  `blood_press` varchar(8) NOT NULL,
  `weight` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `temp` int(11) NOT NULL,
  `blood_sugar` int(11) NOT NULL,
  `diagnosis` varchar(1000) NOT NULL,
  `treatment` varchar(1000) NOT NULL,
  `prescription` varchar(1000) NOT NULL,
  `lab_test` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MedicalChart`
--

INSERT INTO `MedicalChart` (`id`, `person_id`, `doctor_id`, `vitals_date`, `blood_press`, `weight`, `height`, `temp`, `blood_sugar`, `diagnosis`, `treatment`, `prescription`, `lab_test`) VALUES
(1, 2, 5, '2017-07-26', '123/456', 2147483647, 20, 456, 456, 'died', 'none', 'all', 'many');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `MedicalChart`
--
ALTER TABLE `MedicalChart`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `MedicalChart`
--
ALTER TABLE `MedicalChart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
