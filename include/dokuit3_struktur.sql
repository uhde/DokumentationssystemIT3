-- phpMyAdmin SQL Dump

-- Erstellungszeit: 29. April 2013 um 14:12


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `dokuit3`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE IF NOT EXISTS `benutzer` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `benutzername` varchar(30) NOT NULL,
  `einstellung_dns` varchar(3) NOT NULL default 'ip',
  `allekunden_sichtbar` varchar(5) NOT NULL default 'FALSE',
  `allegeraete_sichtbar` varchar(5) NOT NULL default 'FALSE',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer_kunden_einstellung`
--

CREATE TABLE IF NOT EXISTS `benutzer_kunden_einstellung` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `benutzerid` int(11) NOT NULL,
  `kundenid` int(11) NOT NULL default '1',
  `sichtbar` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Zum Speichern, ob ein Kunde bei einem bestimmten Benutzer an' AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bilder`
--

CREATE TABLE IF NOT EXISTS `bilder` (
  `id` bigint(21) NOT NULL auto_increment,
  `kunde` bigint(21) NOT NULL default '0',
  `name` varchar(60) collate latin1_german1_ci NOT NULL default '',
  `url` text collate latin1_german1_ci NOT NULL,
  `bemerkung` text collate latin1_german1_ci,
  `loeschen` tinyint(1) NOT NULL default '1',
  `loeschentime` int(10) unsigned default NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `name` (`name`,`bemerkung`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dokumente`
--

CREATE TABLE IF NOT EXISTS `dokumente` (
  `id` bigint(21) NOT NULL auto_increment,
  `kunde` bigint(21) NOT NULL default '0',
  `name` varchar(60) collate latin1_german1_ci NOT NULL default '',
  `url` text collate latin1_german1_ci NOT NULL,
  `bemerkung` text collate latin1_german1_ci,
  `loeschen` tinyint(1) NOT NULL default '1',
  `loeschentime` int(10) unsigned default NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `name` (`name`,`bemerkung`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `geraete`
--

CREATE TABLE IF NOT EXISTS `geraete` (
  `id` bigint(21) NOT NULL auto_increment,
  `kunde` bigint(21) NOT NULL default '0',
  `kategorie` bigint(21) NOT NULL default '0',
  `system` varchar(30) collate latin1_german1_ci default NULL,
  `bs` varchar(50) collate latin1_german1_ci default NULL,
  `pc` varchar(30) collate latin1_german1_ci default NULL,
  `sn` varchar(30) collate latin1_german1_ci default NULL,
  `produktnummer` varchar(20) collate latin1_german1_ci default NULL,
  `garantie` varchar(40) collate latin1_german1_ci default NULL,
  `name` varchar(40) collate latin1_german1_ci NOT NULL default '',
  `adresse` varchar(100) collate latin1_german1_ci default NULL,
  `ipv4` varchar(17) collate latin1_german1_ci default NULL,
  `dnstimestamp` varchar(12) collate latin1_german1_ci default NULL,
  `port` varchar(10) collate latin1_german1_ci default NULL,
  `benutzer` varchar(30) collate latin1_german1_ci default NULL,
  `zimmer` varchar(30) collate latin1_german1_ci default NULL,
  `drucker` text collate latin1_german1_ci,
  `router` varchar(15) collate latin1_german1_ci default NULL,
  `irdpport` varchar(30) collate latin1_german1_ci default NULL,
  `programme` text collate latin1_german1_ci,
  `vncpasswort` varchar(20) collate latin1_german1_ci default NULL,
  `login` varchar(20) collate latin1_german1_ci default NULL,
  `passwort` varchar(20) collate latin1_german1_ci default NULL,
  `ftplogin` text collate latin1_german1_ci,
  `ftppasswort` varchar(200) collate latin1_german1_ci default NULL,
  `ftpdir` varchar(200) collate latin1_german1_ci default NULL,
  `ds_check` tinyint(1) NOT NULL default '0',
  `bemerkung` text collate latin1_german1_ci,
  `tv_id` varchar(30) collate latin1_german1_ci default NULL,
  `tv_pwd` varchar(30) collate latin1_german1_ci NOT NULL default '$Team7981%',
  `mac_adresse` varchar(17) collate latin1_german1_ci default NULL,
  `xurl` varchar(200) collate latin1_german1_ci default NULL,
  `loeschen` tinyint(1) NOT NULL default '1',
  `loeschentime` int(10) unsigned default NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `name` (`name`,`system`,`produktnummer`,`pc`,`benutzer`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1729 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `geraete_login`
--

CREATE TABLE IF NOT EXISTS `geraete_login` (
  `id` int(11) NOT NULL auto_increment,
  `geraete_id` int(11) NOT NULL,
  `programm_id` int(11) NOT NULL,
  `login` text NOT NULL,
  `passwort` varchar(40) default NULL,
  `aktiv` tinyint(1) NOT NULL,
  `bemerkung` text,
  `loeschen` tinyint(1) NOT NULL default '1',
  `loeschentime` int(10) unsigned default NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2835 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorien`
--

CREATE TABLE IF NOT EXISTS `kategorien` (
  `id` bigint(21) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `Skript` varchar(200) collate latin1_german1_ci NOT NULL default 'fernwart.php5',
  `showsort` tinyint(4) NOT NULL default '1',
  `fernwart` tinyint(1) NOT NULL default '0',
  `bemerkung` text collate latin1_german1_ci,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ktg_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunden`
--

CREATE TABLE IF NOT EXISTS `kunden` (
  `id` bigint(21) NOT NULL auto_increment,
  `kuerzel` varchar(5) collate latin1_german1_ci default NULL,
  `name` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `starturl` varchar(255) collate latin1_german1_ci NOT NULL default '\\\\uhdsrv01\\vol1\\Usr\\Texte\\Techdoku\\Kunden\\',
  `routerip` varchar(15) collate latin1_german1_ci default NULL,
  `bemerkung` text collate latin1_german1_ci,
  `strasse` varchar(80) collate latin1_german1_ci default NULL,
  `hausnummer` varchar(80) collate latin1_german1_ci default NULL,
  `plz` varchar(80) collate latin1_german1_ci default NULL,
  `ort` varchar(80) collate latin1_german1_ci NOT NULL default '',
  `telefon` varchar(80) collate latin1_german1_ci default NULL,
  `fax` varchar(80) collate latin1_german1_ci default NULL,
  `asp1_name` varchar(80) collate latin1_german1_ci default NULL,
  `asp1_telefon` varchar(80) collate latin1_german1_ci default NULL,
  `asp1_mail` varchar(80) collate latin1_german1_ci default NULL,
  `asp2_name` varchar(80) collate latin1_german1_ci default NULL,
  `asp2_telefon` varchar(80) collate latin1_german1_ci default NULL,
  `asp2_mail` varchar(80) collate latin1_german1_ci default NULL,
  `wartung` text collate latin1_german1_ci,
  `dyndns_domain` varchar(200) collate latin1_german1_ci default NULL,
  `vnc_repeater` varchar(5) collate latin1_german1_ci NOT NULL default '5901',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kd_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `programme`
--

CREATE TABLE IF NOT EXISTS `programme` (
  `id` bigint(21) NOT NULL auto_increment,
  `name` varchar(30) collate latin1_german1_ci NOT NULL default '',
  `url` text collate latin1_german1_ci NOT NULL,
  `port` varchar(5) collate latin1_german1_ci default NULL,
  `repeater_port` varchar(5) collate latin1_german1_ci default NULL,
  `use_internet` tinyint(1) NOT NULL default '0',
  `bemerkung` varchar(200) collate latin1_german1_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `prg_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routing`
--

CREATE TABLE IF NOT EXISTS `routing` (
  `id` bigint(21) NOT NULL auto_increment,
  `kunde` bigint(21) NOT NULL default '0',
  `name` varchar(60) collate latin1_german1_ci NOT NULL default '',
  `ziel` text collate latin1_german1_ci,
  `maske` text collate latin1_german1_ci,
  `gateway` text collate latin1_german1_ci,
  `bemerkung` text collate latin1_german1_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zugangsdaten`
--

CREATE TABLE IF NOT EXISTS `zugangsdaten` (
  `id` bigint(21) NOT NULL auto_increment,
  `kunde` bigint(21) NOT NULL default '0',
  `titel` varchar(60) collate latin1_german1_ci NOT NULL default '',
  `login` varchar(200) collate latin1_german1_ci default NULL,
  `passwort` varchar(200) collate latin1_german1_ci default NULL,
  `zusatz` text collate latin1_german1_ci,
  `url` text collate latin1_german1_ci,
  `bemerkung` text collate latin1_german1_ci,
  `loeschen` tinyint(1) NOT NULL default '1',
  `loeschentime` int(10) unsigned default NULL COMMENT 'Hier kommt ein Timestamp aus PHP rein.',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `titel` (`titel`,`zusatz`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=355 ;
