-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2017 at 02:42 PM
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
-- Table structure for table `AccountInfo`
--

CREATE TABLE IF NOT EXISTS `AccountInfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `add_street` varchar(1000) NOT NULL,
  `zip` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `appart_num` int(11) NOT NULL,
  `home_phone` varchar(50) NOT NULL,
  `cell_phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ssn` int(11) NOT NULL,
  `insur_comp` varchar(100) NOT NULL,
  `insur_group_id` int(11) NOT NULL,
  `insur_policy_num` int(11) NOT NULL,
  `emerg_first` varchar(100) NOT NULL,
  `emerg_last` varchar(100) NOT NULL,
  `emerg_phone` varchar(50) NOT NULL,
  `gender` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `AccountInfo`
--

INSERT INTO `AccountInfo` (`id`, `user_id`, `middle_name`, `dob`, `add_street`, `zip`, `state`, `city`, `appart_num`, `home_phone`, `cell_phone`, `email`, `ssn`, `insur_comp`, `insur_group_id`, `insur_policy_num`, `emerg_first`, `emerg_last`, `emerg_phone`, `gender`) VALUES
(1, 2, 'asdf', '2017-07-12', 'asdf', 45678, 'asdf', 'asdf', 123, '555-5555', '555-5555', 'asdf', 321654987, 'asdf', 21, 3213546, 'asdf', 'asdf', '555-5555', ''),
(2, 4, 'squish', '2017-07-12', '345 highway street', 45689, 'tom land', 'city', 45, '1234567896', '1234567896', 'frogger.gmail', 1, 'Dont get run over', 12, 32145, 'grogger', 'emerglast', '1245421234', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
