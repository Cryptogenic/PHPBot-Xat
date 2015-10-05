-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2015 at 11:28 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phpbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `bots`
--

CREATE TABLE IF NOT EXISTS `bots` (
  `id` int(255) NOT NULL,
  `xat_id` int(255) NOT NULL,
  `pid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nick` varchar(255) NOT NULL,
  `password` longtext NOT NULL,
  `crypt_key` longtext NOT NULL,
  `lists` longtext NOT NULL,
  `settings` longtext NOT NULL,
  `accesslist` longtext NOT NULL,
  `minranks` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bots`
--

INSERT INTO `bots` (`id`, `xat_id`, `pid`, `name`, `nick`, `password`, `crypt_key`, `lists`, `settings`, `accesslist`, `minranks`) VALUES
(0, 1404875158, 0, 'TheTestingBotl0l', 'PHPBot', 'B11F14D9B3782E60', '2CD97DB5C4B65EDE', '{}', '{"room":"24572350","name":"PHPBot","avatar":"625","home":"www.nextgenupdate.com","automember":1,"autowelcome":"Welcome [nick] to [group]!","cmdchar":"!"}', '{}', '{}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
