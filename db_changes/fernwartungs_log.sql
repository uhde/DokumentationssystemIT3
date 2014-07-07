-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 07. Jul 2014 um 15:09
-- Server Version: 5.5.37
-- PHP-Version: 5.4.4-14+deb7u11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `dokuit3`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fernwartungs_log`
--

CREATE TABLE IF NOT EXISTS `fernwartungs_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ziel` varchar(50) NOT NULL,
  `start_zeit` int(11) NOT NULL,
  `end_zeit` int(11) NOT NULL,
  `benutzer` varchar(20) NOT NULL,
  `kunde` int(11) NOT NULL,
  `dauer` int(11) NOT NULL,
  `programm` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
