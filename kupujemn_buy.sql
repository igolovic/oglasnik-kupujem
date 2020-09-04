-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 04. Sep 2020 um 23:45
-- Server-Version: 8.0.18
-- PHP-Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kupujemn_buy`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buy_ad`
--

DROP TABLE IF EXISTS `buy_ad`;
CREATE TABLE IF NOT EXISTS `buy_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buy_ad`
--

INSERT INTO `buy_ad` (`id`, `title`, `text`, `user_id`, `start_date`, `duration`, `status`, `category_id`) VALUES
(3, 'Kanister 200 L', 'Trebam kanister od 200 L, plaćam 150000 HRK.', 1, '2020-05-07 13:05:40', 7, 1, 18),
(2, 'Role - rolke!', 'Kupujem role u dobrom stanju!!!\r\nBroj 47.\r\nDo 400 HRK.', 1, '2020-05-07 13:03:25', 120, 1, 16),
(4, 'Badminton loptice', 'Kupujem loptice za badminton, nove ili rabljene, dajem 50 kuna.', 1, '2020-05-07 13:06:14', 7, 1, 16),
(5, 'Udomljavam psa', 'Uzimam psa, bilo koje dobi ili izgleda :)', 1, '2020-05-07 13:08:20', 120, 1, 11),
(6, 'Tražim stan za najam', 'Tražim namješteni stan do 70 kvadrata u Varaždinu za najam, plaćam do 1500 HRK mjesečno.', 1, '2020-05-07 13:09:50', 120, 1, 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buy_ad_county`
--

DROP TABLE IF EXISTS `buy_ad_county`;
CREATE TABLE IF NOT EXISTS `buy_ad_county` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `county_id` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buy_ad_county`
--

INSERT INTO `buy_ad_county` (`id`, `ad_id`, `county_id`, `name`) VALUES
(6, 2, 6, ''),
(5, 2, 2, ''),
(4, 2, 1, ''),
(8, 4, 6, ''),
(9, 5, -1, ''),
(10, 6, 6, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buy_category`
--

DROP TABLE IF EXISTS `buy_category`;
CREATE TABLE IF NOT EXISTS `buy_category` (
  `name` text NOT NULL,
  `description` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buy_category`
--

INSERT INTO `buy_category` (`name`, `description`, `id`) VALUES
('Auto-moto', 'Sve vezano uz aute i motore', 1),
('Nekretnine', 'Sve vezano uz nekretnine', 2),
('Kućni ljubimci', 'Udomljavanje i sve za Vaše ljubimce', 11),
('Nautika', 'Brodovi, čamci, tabkeri, nema čega nema...', 5),
('Hrana i piće', 'Sve Vaše želje vezane uz klopu i cugu', 6),
('Sve za dom', 'Sve što trebate za Vašu kuću ili stan', 10),
('Informatika', 'Informatičke stvarčice svih vrsta...', 9),
('Mobiteli', 'Razni mobovi, novi i korišteni', 12),
('Audio-video, foto', 'Linije, kamere, foto oprema', 13),
('Glazbala', 'Sve za svirku', 14),
('Literatura', 'Puno toga zanimljivoga za čitati', 15),
('Sportska oprema', 'Sve za sport, profi i rekreacija', 16),
('Antikviteti', 'Razne starine, staro ali vrijedno', 17),
('Alati', 'Sve za profiće i kućne majstore', 18),
('Obleka', 'Sve što Vam treba za šik izgled i ugodno nošenje', 19),
('Poslovi', 'Poslovi - od stalnih do privremenih i povremenih', 21),
('Turizam', 'Apartmani i ostalo', 22),
('Vjenčanja i proslave', 'Sve vezano za vjenčanja i proslave', 23),
('Najam stanova i kuća', 'Ovdje možete upisati svoje oglase vezane za potražnju stana ili kuće', 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buy_county`
--

DROP TABLE IF EXISTS `buy_county`;
CREATE TABLE IF NOT EXISTS `buy_county` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buy_county`
--

INSERT INTO `buy_county` (`id`, `name`) VALUES
(1, 'Zagrebačka'),
(2, 'Krapinsko-zagorska'),
(3, 'Sisačko-moslavačka'),
(4, 'Karlovačka'),
(5, 'Varaždinska'),
(6, 'Koprivničko-križevačka'),
(7, 'Bjelovarsko-bilogorska'),
(8, 'Primorsko-goranska'),
(9, 'Ličko-senjska'),
(10, 'Virovitičko-podravska'),
(11, 'Požeško-slavonska'),
(12, 'Brodsko-posavska'),
(13, 'Zadarska'),
(14, 'Osječko-baranjska'),
(15, 'Šibensko-kninska'),
(16, 'Vukovarsko-srijemska'),
(17, 'Splitsko-dalmatinska'),
(18, 'Istarska'),
(19, 'Dubrovačko-neretvanska'),
(20, 'Međimurska'),
(21, 'Grad Zagreb');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buy_user`
--

DROP TABLE IF EXISTS `buy_user`;
CREATE TABLE IF NOT EXISTS `buy_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `last_name` text NOT NULL,
  `county_id` int(11) NOT NULL,
  `city` text NOT NULL,
  `postal_code` int(11) NOT NULL,
  `street_name` text NOT NULL,
  `street_number` text NOT NULL,
  `telephone1` text NOT NULL,
  `telephone2` text NOT NULL,
  `unique_id` text NOT NULL,
  `confirmed` int(11) NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buy_user`
--

INSERT INTO `buy_user` (`id`, `username`, `password`, `name`, `last_name`, `county_id`, `city`, `postal_code`, `street_name`, `street_number`, `telephone1`, `telephone2`, `unique_id`, `confirmed`, `email`) VALUES
(1, 'ivan', 'test', 'Ivan', 'Golović', 6, 'Varaždin', 42000, 'Ulica Zelena', '1 A', '5663567', '444444444', '5eb3ddb457fb44.17206845', 1, 'test@test.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
