-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2016 at 09:15 PM
-- Server version: 5.6.21-log
-- PHP Version: 5.6.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `merchant`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_rewards`
--

CREATE TABLE IF NOT EXISTS `wp_rewards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month` int(11) DEFAULT '0',
  `earn` int(11) DEFAULT '0',
  `redeem` int(11) DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `total` int(11) DEFAULT '0',
  `reward` varchar(255) DEFAULT NULL,
  `data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_rewards`
--

INSERT INTO `wp_rewards` (`id`, `user_id`, `month`, `earn`, `redeem`, `date`, `total`, `reward`, `data`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 500, 100, '2016-08-02 00:00:00', 400, 'kh98ilj', 'a:9:{s:4:"mode";a:1:{i:0;s:6:"Flight";}s:4:"type";s:10:"Round-Trip";s:4:"from";s:3:"fds";s:2:"to";s:8:"safdsfds";s:5:"leave";s:6:"fdsfds";s:6:"return";s:9:"fdsfdsfds";s:6:"adults";s:1:"1";s:8:"children";s:1:"0";s:7:"seniors";s:1:"0";}', '2016-08-06 16:20:33', '2016-08-08 03:24:04'),
(2, 1, 8, 100, 0, '2016-08-24 00:00:00', 100, 'w43tsfds', 'a:9:{s:4:"mode";a:3:{i:0;s:6:"Flight";i:1;s:5:"Hotel";i:2;s:3:"Car";}s:4:"type";s:10:"Round-Trip";s:4:"from";s:9:"fdsfdas a";s:2:"to";s:13:"safdsfdsfda a";s:5:"leave";s:6:"fdsfds";s:6:"return";s:9:"fdsfdsfds";s:6:"adults";s:1:"1";s:8:"children";s:1:"0";s:7:"seniors";s:1:"0";}', '2016-08-06 16:20:59', '2016-08-08 03:24:34'),
(3, 1, 0, 0, 0, NULL, 0, NULL, 'a:9:{s:4:"mode";a:1:{i:0;s:6:"Flight";}s:4:"type";s:10:"Round-Trip";s:4:"from";s:13:"fdsfdsatr432q";s:2:"to";s:6:"fsafas";s:5:"leave";s:6:"fdsaf2";s:6:"return";s:8:"rfadfafd";s:6:"adults";s:1:"1";s:8:"children";s:1:"0";s:7:"seniors";s:1:"0";}', '2016-08-06 16:23:43', NULL),
(4, 1, 0, 0, 0, NULL, 0, NULL, 'a:9:{s:4:"mode";a:1:{i:0;s:6:"Flight";}s:4:"type";s:10:"Round-Trip";s:4:"from";s:7:"fdawr32";s:2:"to";s:11:"dsafsafw3rf";s:5:"leave";s:6:"sdfasf";s:6:"return";s:10:"a3rfwfasda";s:6:"adults";s:1:"1";s:8:"children";s:1:"0";s:7:"seniors";s:1:"0";}', '2016-08-06 16:24:19', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
