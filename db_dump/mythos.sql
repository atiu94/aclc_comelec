-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2012 at 03:37 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mythos_cms`
--
ALTER DATABASE CHARACTER SET utf8 COLLATE utf8_general_ci;
-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `acc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acc_username` varchar(150) NOT NULL,
  `acc_password` varchar(32) NOT NULL,
  `acc_last_name` varchar(30) NOT NULL,
  `acc_first_name` varchar(60) NOT NULL,
  `acc_type` enum('admin','dev') NOT NULL DEFAULT 'admin',
  `acc_failed_login` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `acc_status` enum('active','locked','deleted') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `username` (`acc_username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`acc_id`, `acc_username`, `acc_password`, `acc_last_name`, `acc_first_name`, `acc_type`, `acc_failed_login`, `acc_status`) VALUES
(1, 'developer@zeaple.com', 'c35c3883065eb7aac03d0c9423f26ecb', 'Developer', 'Zeaple', 'dev', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `pag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pag_title` varchar(140) NOT NULL,
  `pct_id` int(10) unsigned DEFAULT '0',
  `pag_slug` varchar(80) DEFAULT NULL,
  `pag_content` text NOT NULL,
  `pag_date_created` datetime NOT NULL,
  `pag_date_published` datetime DEFAULT NULL,
  `pag_type` enum('editable','static') NOT NULL DEFAULT 'editable',
  `pag_status` enum('published','draft') NOT NULL DEFAULT 'published',
  PRIMARY KEY (`pag_id`),
  UNIQUE KEY `slug` (`pag_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `page_category`
--

CREATE TABLE IF NOT EXISTS `page_category` (
  `pct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pct_name` varchar(50) NOT NULL,
  PRIMARY KEY (`pct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photo_album`
--

CREATE TABLE IF NOT EXISTS `photo_album` (
  `alb_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alb_name` varchar(50) NOT NULL,
  `alb_description` text NOT NULL,
  `alb_slug` varchar(80) NOT NULL,
  PRIMARY KEY (`alb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
