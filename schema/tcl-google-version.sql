-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2012 at 04:44 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chan0260`
--

-- --------------------------------------------------------

--
-- Table structure for table `tenniscourtlocator`
--

CREATE TABLE IF NOT EXISTS `tenniscourtlocator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `street_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rate_count` int(11) NOT NULL,
  `rate_total` int(11) NOT NULL,
  `isindoor` tinyint(1) NOT NULL,
  `isoutdoor` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tenniscourtlocator`
--

INSERT INTO `tenniscourtlocator` (`id`, `name`, `longitude`, `latitude`, `street_address`, `rate_count`, `rate_total`, `isindoor`, `isoutdoor`) VALUES
(1, 'St. James Tennis Club', -75.691462, 45.401809, '183 Third Ave.', 0, 0, 0, 0),
(2, 'Ottawa Tennis & Lawn Bowling Club', -75.687491, 45.388577, '176 Cameron Ave.', 0, 0, 0, 0),
(3, 'Rideau Tennis Club', -75.669499, 45.426854, '1 Donald Street', 0, 0, 0, 0),
(4, 'Ottawa New Edinburgh Club', -75.685965, 45.450308, '504 Rockcliffe Driveway', 0, 0, 0, 0),
(5, 'Tennis Center West Ottawa', -75.797775, 45.362787, '120 Greenview Ave.', 0, 0, 0, 0),
(6, 'Carleton Tennis Centre', -75.697517, 45.383532, '1125 Colonel By Dr.', 0, 0, 0, 0),
(7, 'Dara Tennis Club', -75.548741, 45.288961, '49-A Maple Dr.', 0, 0, 0, 0),
(8, 'Super Dome', -75.575414, 45.442983, '1660 Bearbrook Rd.', 0, 0, 0, 0),
(9, 'Elmdale Tennis', -75.730759, 45.397508, '184 Holland Ave.', 0, 0, 0, 0);
