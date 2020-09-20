-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 20. Sep 2020 um 21:19
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buy_ad`
--

INSERT INTO `buy_ad` (`id`, `title`, `text`, `user_id`, `start_date`, `duration`, `status`, `category_id`) VALUES
(3, 'Kanister 200 L', 'Trebam kanister od 200 L, plaćam 150000 HRK.', 1, '2020-05-07 13:05:40', 7, 1, 18),
(2, 'Role - rolke!', 'Kupujem role u dobrom stanju!!!\r\nBroj 47.\r\nDo 400 HRK.', 1, '2020-05-07 13:03:25', 120, 1, 16),
(4, 'Badminton loptice', 'Kupujem loptice za badminton, nove ili rabljene, dajem 50 kuna.', 1, '2020-05-07 13:06:14', 7, 1, 16),
(5, 'Udomljavam psa', 'Uzimam psa, bilo koje dobi ili izgleda :)', 1, '2020-05-07 13:08:20', 120, 1, 11),
(6, 'Tražim stan za najam', 'Tražim namješteni stan do 70 kvadrata u Varaždinu za najam, plaćam do 1500 HRK mjesečno.', 1, '2020-05-07 13:09:50', 120, 1, 24),
(7, 'Auto', 'Trebam auto, rabljeni, do 50000 km.', 1, '2020-09-20 21:47:53', 120, 1, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `buy_ad_county`
--

INSERT INTO `buy_ad_county` (`id`, `ad_id`, `county_id`, `name`) VALUES
(150, 7, 21, ''),
(149, 7, 20, ''),
(106, 2, 4, ''),
(11, 3, 1, ''),
(148, 7, 19, ''),
(72, 5, 1, ''),
(147, 7, 18, ''),
(12, 3, 3, ''),
(146, 7, 17, ''),
(16, 4, -1, ''),
(145, 7, 16, ''),
(108, 2, 19, ''),
(107, 2, 5, ''),
(105, 6, 20, ''),
(104, 6, 18, ''),
(103, 6, 16, ''),
(102, 6, 15, ''),
(101, 6, 11, ''),
(100, 6, 10, ''),
(99, 6, 9, ''),
(98, 6, 8, ''),
(97, 6, 7, ''),
(96, 6, 6, ''),
(95, 6, 5, ''),
(94, 6, 4, ''),
(93, 6, 3, ''),
(73, 5, 2, ''),
(74, 5, 3, ''),
(75, 5, 4, ''),
(76, 5, 5, ''),
(77, 5, 6, ''),
(78, 5, 7, ''),
(79, 5, 8, ''),
(80, 5, 9, ''),
(81, 5, 10, ''),
(82, 5, 11, ''),
(83, 5, 12, ''),
(84, 5, 13, ''),
(85, 5, 14, ''),
(86, 5, 15, ''),
(87, 5, 16, ''),
(88, 5, 17, ''),
(89, 5, 18, ''),
(90, 5, 19, ''),
(91, 5, 20, ''),
(92, 5, 21, ''),
(144, 7, 15, ''),
(143, 7, 14, ''),
(142, 7, 13, ''),
(141, 7, 12, ''),
(140, 7, 11, ''),
(139, 7, 10, ''),
(138, 7, 9, ''),
(137, 7, 8, ''),
(136, 7, 7, ''),
(135, 7, 6, ''),
(134, 7, 5, ''),
(133, 7, 4, ''),
(132, 7, 3, ''),
(131, 7, 2, ''),
(130, 7, 1, '');

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
(1, 'Grad Zagreb'),
(2, 'Zagrebačka županija'),
(3, 'Krapinsko-zagorska županija'),
(4, 'Sisačko-moslavačka županija'),
(5, 'Karlovačka županija'),
(6, 'Varaždinska županija'),
(7, 'Koprivničko-križevačka županija'),
(8, 'Bjelovarsko-bilogorska županija'),
(9, 'Primorsko-goranska županija'),
(10, 'Ličko-senjska županija'),
(11, 'Virovitičko-podravska županija'),
(12, 'Požeško-slavonska županija'),
(13, 'Brodsko-posavska županija'),
(14, 'Zadarska županija'),
(15, 'Osječko-baranjska županija'),
(16, 'Šibensko-kninska županija'),
(17, 'Vukovarsko-srijemska županija'),
(18, 'Splitsko-dalmatinska županija'),
(19, 'Istarska županija'),
(20, 'Dubrovačko-neretvanska županija'),
(21, 'Međimurska županija');

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
(1, 'ivan', 'test', 'Ivan', 'Golović', 6, 'Varaždin', 42000, 'Ulica Zelena', '1 A', '5663567', '444444444', '5eb3ddb457fb44.17206845', 1, 'igolovic@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
