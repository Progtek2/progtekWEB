-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2012 at 10:55 PM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gruppe2`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address_line1` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `address_line2` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `address_line3` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `label`, `address_line1`, `address_line2`, `address_line3`, `city`, `state`, `postal_code`, `country_name`) VALUES
(1, 1, 'Hjem', 'Gullhaugveien 207', '', '', 'Bærums Verk', '', '1354', 'Norge'),
(4, 8, 'Besøksadresse', 'Lodve Langesgt. 2', 'Postboks 385', '', 'Narvik', '', '8505', 'Norge'),
(5, 8, 'Fakturaadresse', 'Høgskolen i Narvik - fakturamottak', 'Postboks 372 Alnabru', '', 'Oslo', '', '0614', 'Norge'),
(6, 1, 'Fakturaadresse', 'Helsethagan 8', '', '', 'Bærums Verk', '', '1353', 'Norge');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_number` smallint(6) NOT NULL,
  `level` smallint(6) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sort_number` (`sort_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `name`, `description`, `sort_number`, `level`, `is_active`) VALUES
(1, 0, 'Utenriks', 'Nyheter fra hele verden', 1, 0, 1),
(2, 0, 'Innenriks', 'Nyheter fra Norge', 2, 0, 1),
(3, 0, 'Sport', 'Sportsnyheter', 3, 0, 1),
(4, 3, 'Fotball', 'Fotballnyheter', 4, 1, 1),
(5, 3, 'Ski', 'Skinyheter', 7, 1, 1),
(6, 0, 'Kultur', 'Kulturnyheter', 8, 0, 1),
(7, 3, 'Sykling', 'Sykkelnyheter', 6, 1, 1),
(8, 3, 'Håndball', 'Håndballnyheter', 5, 1, 1),
(9, 6, 'Film', 'Filmnyheter', 24, 1, 1),
(10, 6, 'Musikk', 'Musikknyheter', 9, 1, 1),
(11, 6, 'Litteratur', 'Litteraturnyheter', 11, 1, 1),
(12, 6, 'Spill', 'Spill', 12, 1, 1),
(13, 6, 'TV og medier', 'TV og medier', 13, 1, 1),
(14, 6, 'Scene', 'Scene', 14, 1, 1),
(15, 6, 'Kunst', 'Kunst', 15, 1, 1),
(16, 6, 'Mat', 'Mat', 16, 1, 1),
(18, 0, 'Data og teknologi', 'Data og teknologi', 17, 0, 1),
(19, 0, 'Bil og trafikk', 'Bil og trafikk', 18, 0, 1),
(20, 0, 'Helse', 'Helse', 19, 0, 1),
(21, 0, 'Sex og samliv', 'Sex og samliv', 20, 0, 1),
(22, 0, 'Reise', 'Reise', 21, 0, 1),
(23, 0, 'Økonomi', 'Økonomi', 22, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `keyword` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Dumping data for table `keyword`
--

INSERT INTO `keyword` (`id`, `user_id`, `keyword`) VALUES
(3, 8, 'Apple'),
(4, 8, 'politiet'),
(20, 1, 'apple'),
(23, 12, 'oslo'),
(26, 1, 'Facebook'),
(27, 1, 'Bærums Verk'),
(28, 1, 'Oslobørs'),
(29, 1, 'Portugal');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `link` varchar(255) NOT NULL,
  `author` varchar(150) NOT NULL,
  `publish_date` datetime NOT NULL,
  `guid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1392 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `link`, `author`, `publish_date`, `guid`) VALUES
(1223, '- Nord-Korea er så ille at det høres usannsynlig ut. Det er et svart hull i moderne sivilisasjonen', 'Nord-Korea ekspert klarer ikke å forklare hvor ille situasjonen er i diktaturet.', 'http://www.dagbladet.no/2012/11/27/nyheter/nord_korea/utenriks/atomprogram/kim_jong-il/24560859/', '', '2012-11-27 11:41:00', 'http://www.dagbladet.no/2012/11/27/nyheter/nord_korea/utenriks/atomprogram/kim_jong-il/24560859/'),
(1224, 'Hun fikk nytt ansikt etter at hunden gnagde av hennes eget', 'Isabelle Dinoire forteller om livet etter verdens første ansiktstransplantasjon.', 'http://www.dagbladet.no/2012/11/27/nyheter/ansiktsoperasjon/utenriks/ansiktstransplantasjon/isabelle_denoire/24561364/', '', '2012-11-27 10:51:00', 'http://www.dagbladet.no/2012/11/27/nyheter/ansiktsoperasjon/utenriks/ansiktstransplantasjon/isabelle_denoire/24561364/'),
(1225, 'Nå nekter vietnameserne å stemple de nye kinesiske passene', 'Protesterer mot Kinas pass-frekkis.', 'http://www.dagbladet.no/2012/11/27/nyheter/utenriks/kina/vietnam/pass/24560813/', '', '2012-11-27 08:00:00', 'http://www.dagbladet.no/2012/11/27/nyheter/utenriks/kina/vietnam/pass/24560813/'),
(1226, 'Arafats levninger er hentet opp av graven', 'Levningene etter den palestinske lederen Yasser Arafat ble tirsdag hentet opp av graven i Ramallah på Vestbredden.', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/utenriks/israel/gaza/24560623/', '', '2012-11-27 07:29:00', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/utenriks/israel/gaza/24560623/'),
(1227, 'Fant massegraver etter narkokrig', 'Ved Mexicos USA-grense.', 'http://www.dagbladet.no/2012/11/27/nyheter/utenriks/narkokrigen_i_mexico/24560497/', '', '2012-11-27 06:54:00', 'http://www.dagbladet.no/2012/11/27/nyheter/utenriks/narkokrigen_i_mexico/24560497/'),
(1228, 'Får krisehjelp før jul', 'EU vedtok utbetalinger til Hellas på 321 milliarder kroner.  EU-minister: - Løfte om en bedre framtid.', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/utenriks/hellas/euro_and_greece/24560024/', '', '2012-11-27 05:36:00', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/utenriks/hellas/euro_and_greece/24560024/'),
(1229, '- Han sto i senga da kvinnen kom ut av dusjen', 'Stockholmspolitiet jakter fasadeklatrer som antas å stå bak minst 28 innbrudd.', 'http://www.dagbladet.no/2012/11/26/nyheter/utenriks/krim/stockholm/24559548/', '', '2012-11-26 23:59:00', 'http://www.dagbladet.no/2012/11/26/nyheter/utenriks/krim/stockholm/24559548/'),
(1230, 'Fant ekstreme livsformer i Antarktis', 'Bakterier som har vært isolert under ekstreme forhold flere tusen år.', 'http://www.dagbladet.no/2012/11/26/nyheter/utenriks/antarktis/biologi/ekstremofiler/24557864/', '', '2012-11-26 23:16:00', 'http://www.dagbladet.no/2012/11/26/nyheter/utenriks/antarktis/biologi/ekstremofiler/24557864/'),
(1231, 'M23 har hemmelig støtte, millioner på bok og overlegen slagkraft i jungelen', 'Opprørsgruppa som herjer i Øst-Kongo truer med å marsjere mot Kongos hovedstad.', 'http://www.dagbladet.no/2012/11/26/nyheter/kongo/m23/utenriks/borgerkrig/24557930/', '', '2012-11-26 22:44:00', 'http://www.dagbladet.no/2012/11/26/nyheter/kongo/m23/utenriks/borgerkrig/24557930/'),
(1232, 'Presidenten diskuterte Moland og French med britenes Afrika-minister', 'Kongos president Joseph Kabila møtte Storbritannias Afrika-minister Mark Simmons.', 'http://www.dagbladet.no/2012/11/26/nyheter/politikk/kongo-saken/utenriks/tjostolv_moland/24557630/', '', '2012-11-26 20:22:00', 'http://www.dagbladet.no/2012/11/26/nyheter/politikk/kongo-saken/utenriks/tjostolv_moland/24557630/'),
(1233, 'Han kan bli Edvard Munch på film ', '(VG Nett) Tysk-irske Michael Fassbender er høyaktuell til rollen som den norske maleren i en ny film om kunstneren. ', 'http://www.vg.no/film/artikkel.php?artid=10048256', '', '2012-11-27 16:45:00', 'http://www.vg.no/film/artikkel.php?artid=10048256'),
(1234, 'Bondi Beach ble blodig rød ', '(VG Nett) Røde alger forvandlet Australske strender til en scene fra Haisommer. Den verdenskjente Bondi Beach stenges på grunn av røde alger. ', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048289', '', '2012-11-27 16:36:00', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048289'),
(1235, 'Varsler knallhardt maktdrama i Oslo Ap i kveld ', '(VG Nett) Det brygger opp til en kamp om makt når Arbeiderpartiets topper samler seg til nominasjonsmøte tirsdag. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048287', '', '2012-11-27 16:30:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048287'),
(1236, '13 års fengsel for nabodrap i Orkdal ', 'En 27 år gammel mann er dømt til 13 års fengsel for å ha drept naboen sin i Orkdal i oktober i fjor. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048288', '', '2012-11-27 16:25:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048288'),
(1237, 'Vil ha treetasjers megafly', '(VG Nett) Emirates Airline ønsker å ha fly som kan ta opp til 800 passasjerer.', 'http://www.vg.no/reise/artikkel.php?artid=10048286', '', '2012-11-27 15:54:00', 'http://www.vg.no/reise/artikkel.php?artid=10048286'),
(1238, 'Faremo: Ikke inhabil om surrogati ', 'Statsminister Jens Stoltenberg (Ap) og justisminister Grete Faremo (Ap) konkluderer på hver sin måte i spørsmålet om habilitet og surrogati. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048284', '', '2012-11-27 15:46:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048284'),
(1239, 'Ny rapport: Flere sykehus-ventelister lyver ', '(VG Nett) Her har pasienter måttet vente 121 dager lengre på kneprotese-operasjon enn ventelistene tilsier. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048257', '', '2012-11-27 15:40:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048257'),
(1240, 'Brann i firemannsbolig i Tønsberg ', 'Nødetatene ble tirsdag ettermiddag varslet om brann i en firemannsbolig i Tønsberg.', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048283', '', '2012-11-27 15:26:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048283'),
(1241, 'Solbakken legger press på seg selv etter tøff periode ', '(VG Nett) Ståle Solbakken (44) har ikke vunnet med Wolverhampton på åtte kamper. Nå innrømmer han at hans karriere er inne i en «kritisk fase». ', 'http://www.vg.no/sport/fotball/artikkel.php?artid=10048261', '', '2012-11-27 15:25:00', 'http://www.vg.no/sport/fotball/artikkel.php?artid=10048261'),
(1242, 'Riksrevisjonen kritiserer sykehusomstilling ', 'Eierne var klar over at det lå store risikomomenter i en omstilling av Oslo universitetssykehus. Men de greide ikke å ta risikomomentene inn over seg, sier riksrevisor Jørgen Kosmo. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048282', '', '2012-11-27 15:23:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048282'),
(1243, 'Dommen i saken mot Rune Øygard faller i desember', 'Tiltalt for overgrep mot ei mindreårig jente.', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/rune_oygard/arbeiderpartiet/overgrep/24569223/', '', '2012-11-27 15:27:00', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/rune_oygard/arbeiderpartiet/overgrep/24569223/'),
(1244, 'Reidun (88) ville ikke være alene på julaften. Responsen var enorm', 'Satte inn annonse i avisa.', 'http://www.dagbladet.no/2012/11/27/nyheter/julaften/innenriks/ensomhet/24566023/', '', '2012-11-27 14:58:00', 'http://www.dagbladet.no/2012/11/27/nyheter/julaften/innenriks/ensomhet/24566023/'),
(1245, 'Hang ut navngitte ungdommers angivelige sexliv på Twitter', '- Dette kan få svært skadelige følger.', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/twitter/offentlighet/24568737/', '', '2012-11-27 14:37:00', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/twitter/offentlighet/24568737/'),
(1246, 'Birken-syklist tatt for å smugle doping', 'Prøvde å få inn EPO-pulver, som brukes til bloddoping.', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/doping/tollvesenet/24548925/', '', '2012-11-27 12:50:00', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/doping/tollvesenet/24548925/'),
(1247, 'Riksrevisjonen er nådeløs mot Helse Sør-Øst og departementet', 'Kraftig kritikk av sykehussammenslåingen i Oslo.', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/politikk/riksrevisjonen/regjeringen/24564196/', '', '2012-11-27 12:41:00', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/politikk/riksrevisjonen/regjeringen/24564196/'),
(1248, 'Utelukker ikke mistillit', 'De mener han forklarte seg godt om 22. juli. Likevel vil ikke opposisjonen utelukke at de vil be statsministeren om å gå.', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/innenriks/regjeringen/arbeiderpartiet/24557262/', '', '2012-11-27 10:21:00', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/innenriks/regjeringen/arbeiderpartiet/24557262/'),
(1249, 'Nektet politiet helikopter etter terroralarm mot Stortinget', 'Det var statssekretær Pål Lønseth som nektet politiet helikopterhjelp fra Forsvaret da terrorekspertene i høst fryktet et terrorattentat i Oslo.', 'http://www.dagbladet.no/2012/11/27/nyheter/terror/22_juli/innenriks/politikk/24559963/', '', '2012-11-27 07:14:00', 'http://www.dagbladet.no/2012/11/27/nyheter/terror/22_juli/innenriks/politikk/24559963/'),
(1250, 'Fikk servert 22. juli- scenario to år før', 'Regjeringen bestilte hemmelig risikoanalyse.', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/innenriks/22_juli_regjeringskvartalet/24560254/', '', '2012-11-27 06:13:00', 'http://www.dagbladet.no/2012/11/27/nyheter/politikk/innenriks/22_juli_regjeringskvartalet/24560254/'),
(1251, 'Kritikk, men ikke kameraderi', 'Riksadvokaten henleggelse anmeldelse av politimester.', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/politiets_utlendingsenhet/spesialenheten_for_politisaker/ingrid_wirum/24560103/', '', '2012-11-27 05:56:00', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/politiets_utlendingsenhet/spesialenheten_for_politisaker/ingrid_wirum/24560103/'),
(1252, 'Jente (14) funnet etter stor leteaksjon i Kristiansund', 'Meldt savnet i går.', 'http://www.dagbladet.no/2012/11/26/nyheter/leteaksjon/innenriks/savnet/24559165/', '', '2012-11-26 22:41:00', 'http://www.dagbladet.no/2012/11/26/nyheter/leteaksjon/innenriks/savnet/24559165/'),
(1253, '- Madison Square Garden bør døpes «Cottos Mekka»', '(VG Nett) For nordmenn flest er Miguel Cotto (32) relativt ukjent, men i «boksesportens Mekka», New York, er han den store kongen. Så stor at enkelte mener Madison Square Garden bør oppkalles etter ham.', 'http://www.vg.no/sport/boksing/artikkel.php?artid=10048269', '', '2012-11-27 15:05:00', 'http://www.vg.no/sport/boksing/artikkel.php?artid=10048269'),
(1254, '- Absolutt ikke naturlig for meg å sende slike e-poster ', 'ULLEVAAL (VG Nett) Christina Vukicevic (25) ville ikke forhørt seg om doping slik hennes egen far gjorde for ti år siden. ', 'http://www.vg.no/sport/friidrett/artikkel.php?artid=10048254', '', '2012-11-27 13:44:00', 'http://www.vg.no/sport/friidrett/artikkel.php?artid=10048254'),
(1255, 'AaFK-kapteinen mener Rekdal var for negativ ', 'ÅLESUND (VG Nett) Kaptein Daniel Arnefjord sier Aalesunds sparkede trener Kjetil Rekdal for ofte var negativ og for lite konstruktiv i kritikken mot spillerne. ', 'http://www.vg.no/sport/fotball/norsk/artikkel.php?artid=10048259', '', '2012-11-27 13:39:00', 'http://www.vg.no/sport/fotball/norsk/artikkel.php?artid=10048259'),
(1256, 'Johansen overtar Ull/Kisa etter Erlandsen ', '(VG Nett) Etter det VG Nett erfarer, blir Roar Johansen (44) ny trener i Ull/Kisa. ', 'http://www.vg.no/sport/fotball/norsk/1-divisjon/artikkel.php?artid=10048262', '', '2012-11-27 13:31:00', 'http://www.vg.no/sport/fotball/norsk/1-divisjon/artikkel.php?artid=10048262'),
(1257, 'Hoff: - Rekdal kom med personangrep ', 'ÅLESUND/OSLO (VG Nett) Aalesund-direktør Henrik Hoff mener sparkede Kjetil Rekdal kom med flere personangrep mot ham den siste tiden. ', 'http://www.vg.no/sport/fotball/artikkel.php?artid=10048236', '', '2012-11-27 11:24:00', 'http://www.vg.no/sport/fotball/artikkel.php?artid=10048236'),
(1258, 'Vukicevics ekskone: - Jeg har kun et ønske om å få frem sannheten ', '(VG Nett) Turid Syftestad fastholder at hun ikke ønsker å hevne seg mot sin tidligere mann, Petar Vukicevic. ', 'http://www.vg.no/sport/friidrett/artikkel.php?artid=10048246', '', '2012-11-27 11:13:00', 'http://www.vg.no/sport/friidrett/artikkel.php?artid=10048246'),
(1259, 'Aafk-ekspert om sparkingen: - Var uenige om det meste ', '(VG Nett) Sportsredaktør Helge Skuseth (59) i lokalavisen Sunnmørsposten mener sparkingen av Kjetil Rekdal (44) var helt nødvendig for klubben. ', 'http://www.vg.no/sport/fotball/norsk/artikkel.php?artid=10048239', '', '2012-11-27 10:23:00', 'http://www.vg.no/sport/fotball/norsk/artikkel.php?artid=10048239'),
(1260, 'Christina: - Verst at påstandene kommer fra vår mor ', 'ULLEVAAL (VG Nett) Søskenparet Christina (25) og Vladimir (21) Vukicevic er krystallklare i sin støtte til pappa Petar Vukicevic (56) i dag - og går rett i strupen på sin mor. ', 'http://www.vg.no/sport/friidrett/artikkel.php?artid=10048229', '', '2012-11-27 09:51:00', 'http://www.vg.no/sport/friidrett/artikkel.php?artid=10048229'),
(1261, 'Italiensk motstand for Lødrup ', '(VG Nett) Gullfavoritt Andreas Lødrup (27) går sin første kamp i EM mot italienske Alessandro Manfredi. ', 'http://www.vg.no/sport/artikkel.php?artid=10048235', '', '2012-11-27 09:30:00', 'http://www.vg.no/sport/artikkel.php?artid=10048235'),
(1262, 'Drillos møter Ukraina i Spania i februar', 'Blir siste motstander før kvaliken starter igjen.', 'http://www.dagbladet.no/2012/11/27/sport/fotball/landslaget/drillo/24568954/', '', '2012-11-27 14:46:00', 'http://www.dagbladet.no/2012/11/27/sport/fotball/landslaget/drillo/24568954/'),
(1263, 'Russisk OL-mester dopingetterforskes', 'Svetlana Kriveljova har både VM- og OL-gull.', 'http://www.dagbladet.no/2012/11/27/sport/friidrett/doping/svetlana_kriveljova/24568861/', '', '2012-11-27 14:43:00', 'http://www.dagbladet.no/2012/11/27/sport/friidrett/doping/svetlana_kriveljova/24568861/'),
(1264, '- Jeg ville legge opp', 'Kombinertløper Magnus Moan (29) var så langt nede at han ikke orket tanken på å konkurrere. Nå er vinnerskallen tilbake.', 'http://www.dagbladet.no/2012/11/27/sport/klubben_i_mitt_hjerte/magnus_moan/kombinert/24552657/', '', '2012-11-27 13:57:00', 'http://www.dagbladet.no/2012/11/27/sport/klubben_i_mitt_hjerte/magnus_moan/kombinert/24552657/'),
(1265, 'Snart bruker de store gutta EPO i sandkassa', 'Esten O. Sæther kommenterer', 'http://www.dagbladet.no/2012/11/27/sport/sykkel/doping/birkebeinerrittet/24565883/', '', '2012-11-27 13:42:00', 'http://www.dagbladet.no/2012/11/27/sport/sykkel/doping/birkebeinerrittet/24565883/'),
(1266, '- Til og med sønnene mine spiller bedre enn dere', 'Zlatans melding til PSG-kompisene.', 'http://www.dagbladet.no/2012/11/27/sport/zlatan_ibrahimovic/fotball/psg/24564730/', '', '2012-11-27 12:14:00', 'http://www.dagbladet.no/2012/11/27/sport/zlatan_ibrahimovic/fotball/psg/24564730/'),
(1267, 'AaFK «kom ikke utenom» å sparke Rekdal', '- Vi snakker om en personalsak.', 'http://www.dagbladet.no/2012/11/27/sport/fotball/tippeligaen/aalesund/rekdal/24563411/', '', '2012-11-27 11:48:00', 'http://www.dagbladet.no/2012/11/27/sport/fotball/tippeligaen/aalesund/rekdal/24563411/'),
(1268, 'Norges mest populære klubb?', 'Brann har nesten hentet inn RBK i Klubben i mitt hjerte.', 'http://www.dagbladet.no/2012/11/27/sport/klubben_i_mitt_hjerte_2012/brann/rosenborg/24562808/', '', '2012-11-27 11:36:00', 'http://www.dagbladet.no/2012/11/27/sport/klubben_i_mitt_hjerte_2012/brann/rosenborg/24562808/'),
(1269, 'Tillit til Schalke 04; her er tirsdagens oddstips', 'Bundesliga, Premier League og Serie A på programmet i dag.', 'http://www.dagbladet.no/2012/11/27/sport/oddsekspert/oddstips/tipping/spill/24562465/', '', '2012-11-27 10:29:00', 'http://www.dagbladet.no/2012/11/27/sport/oddsekspert/oddstips/tipping/spill/24562465/'),
(1270, '- Det verste er at det kommer fra vår mor', 'Christina Vukicevic og broren snakket om epost-saken for første gang.', 'http://www.dagbladet.no/2012/11/27/sport/christina_vukicevic/friidrett/hekk/petar_vukicevic/24562102/', '', '2012-11-27 09:42:00', 'http://www.dagbladet.no/2012/11/27/sport/christina_vukicevic/friidrett/hekk/petar_vukicevic/24562102/'),
(1272, 'Nå er svenskene mette - ber Northug roe seg', '- Det holder nå, skriver Expressen etter helgas sprell.', 'http://www.dagbladet.no/2012/11/27/sport/langrenn/ski/vintersport/petter_northug/24560760/', '', '2012-11-27 08:04:00', 'http://www.dagbladet.no/2012/11/27/sport/langrenn/ski/vintersport/petter_northug/24560760/'),
(1274, 'Kim Jong-un er «verdens mest sexy»', 'Men det trodde avisen til det kinesiske kommunistpartiet, som ikke skjønte humoren til satireavisen «The Onion».', 'http://www.nrk.no/kultur-og-underholdning/1.8835012', '', '2012-11-27 16:36:15', 'http://www.nrk.no/kultur-og-underholdning/1.8835012'),
(1275, 'Vil myke opp lisensreglene', 'Hvis huset ditt brenner ned skal du få slippe å betale TV-lisens. Dette er et av forslagene som skal forenkle dagens lisensregler.', 'http://www.nrk.no/kultur-og-underholdning/1.8834809', '', '2012-11-27 14:10:27', 'http://www.nrk.no/kultur-og-underholdning/1.8834809'),
(1276, 'Her lager de julepynt av søppel', 'Et vanlig sykkelhjul og et hjul fra en rullestol kan bli en strålende taklampe. I Bodø lager ungdomsskoleelever julepynt av det bedriftene i byen kaster.', 'http://www.nrk.no/nyheter/distrikt/nordland/1.8822565', '', '2012-11-27 10:10:33', 'http://www.nrk.no/nyheter/distrikt/nordland/1.8822565'),
(1279, 'Ingen 3.rundekamper for Runar', '', 'http://www.handball.no/p1.asp?p=38150&from=rss', '', '2012-11-27 16:46:00', 'http://www.handball.no/p1.asp?p=38150&from=rss'),
(1280, 'En annerledes dag', '', 'http://www.handball.no/p1.asp?p=38149&from=rss', '', '2012-11-27 16:24:00', 'http://www.handball.no/p1.asp?p=38149&from=rss'),
(1281, 'Blir Gordon-Levitt den nye Batman?', 'Ferske rykter bygger opp under slutten på <em>The Dark Knight Rises</em>.', 'http://p3.no/filmpolitiet/2012/11/blir-gordon-levitt-den-nye-batman/', 'Rune Håkonsen', '2012-11-27 13:10:59', 'http://p3.no/filmpolitiet/2012/11/blir-gordon-levitt-den-nye-batman/'),
(1282, 'Millionbot til Rolling Stones', 'Jubileumskonserten varte for lenge.', 'http://www.dagbladet.no/2012/11/27/kultur/musikk/rolling_stones/24567020/', '', '2012-11-27 15:32:00', 'http://www.dagbladet.no/2012/11/27/kultur/musikk/rolling_stones/24567020/'),
(1283, 'Slik er Rune Rudbergs nye liv', 'Har til og med stumpet røyken.', 'http://www.dagbladet.no/2012/11/27/kjendis/rune_rudberg/musikk/artist/rusfri/24561686/', '', '2012-11-27 11:18:00', 'http://www.dagbladet.no/2012/11/27/kjendis/rune_rudberg/musikk/artist/rusfri/24561686/'),
(1284, 'Neil og den teknologiske drømmefabrikken', 'Det mest oppsiktsvekkende fra Neil Young i år er verken selvbiografien eller fuzzfesten «Psychedelic Pill». Det er teknologigründeren Young som flyr aller høyest.', 'http://www.dagbladet.no/2012/11/27/kultur/analog_digital/musikk/neil_young/teknologi/24547438/', '', '2012-11-27 10:24:00', 'http://www.dagbladet.no/2012/11/27/kultur/analog_digital/musikk/neil_young/teknologi/24547438/'),
(1285, '- Jeg har blitt truet med politianmeldelser', 'Magnus Eliassen har bare brukt 300 kroner på mat i år.', 'http://www.dagbladet.no/2012/11/26/kjendis/sirkus_eliassen/magnus_eliassen/bodo/musikk/24545580/', '', '2012-11-26 20:39:00', 'http://www.dagbladet.no/2012/11/26/kjendis/sirkus_eliassen/magnus_eliassen/bodo/musikk/24545580/'),
(1287, 'Nintendo Wii Mini kjem i desember', 'Den japanske spelgiganten oppdaterer Wii like etter Wii U-lansering.', 'http://p3.no/filmpolitiet/2012/11/nintendo-wii-mini-kjem-i-desember/', 'Andreas Hadsel Opsvik', '2012-11-27 12:25:16', 'http://p3.no/filmpolitiet/2012/11/nintendo-wii-mini-kjem-i-desember/'),
(1288, 'Wii U-salg slår Nintendos egne rekorder', '– Jeg tror ikke den kommer til å bli en suksess, forteller Atari-grunnlegger i intervju.', 'http://p3.no/filmpolitiet/2012/11/wii-u-salg-slar-nintendos-egne-rekorder/', 'Rune Håkonsen', '2012-11-27 10:18:46', 'http://p3.no/filmpolitiet/2012/11/wii-u-salg-slar-nintendos-egne-rekorder/'),
(1290, 'Løfter sløret av det neste «Hitman»', 'En håndfull bilder er lekket.', 'http://www.pressfire.no/nyheter/PC/6180/Lfter-slret-av-det-neste-Hitman', '', '2012-11-27 15:14:31', 'http://www.pressfire.no/nyheter/PC/6180/Lfter-slret-av-det-neste-Hitman'),
(1291, 'Wii Mini bekreftet gjennom lekkasje', 'Slik ser den ut.', 'http://www.pressfire.no/nyheter/Wii/6178/wii-mini-bekreftet-i-lekkasje', '', '2012-11-27 13:11:22', 'http://www.pressfire.no/nyheter/Wii/6178/wii-mini-bekreftet-i-lekkasje'),
(1292, 'Pc-eiere trygler om å få «GTA V»', 'Startet underskriftskampanje for å overbevise Rockstar.', 'http://www.pressfire.no/nyheter/PS3/6176/48-000-pc-eiere-trygler-om-f-GTA-V', '', '2012-11-27 12:04:18', 'http://www.pressfire.no/nyheter/PS3/6176/48-000-pc-eiere-trygler-om-f-GTA-V'),
(1293, '- Wii U er praktisk talt utsolgt', 'Nintendo er strålende fornøyd med konsollens debutuke.', 'http://www.pressfire.no/nyheter/WiiU/6175/-Wii-U-er-praktisk-talt-utsolgt', '', '2012-11-27 10:48:31', 'http://www.pressfire.no/nyheter/WiiU/6175/-Wii-U-er-praktisk-talt-utsolgt'),
(1296, 'Wii U UK Launch Guide', 'Everything you need to know for Friday, all in once place.', 'http://www.ign.com/articles/2012/11/27/wii-u-uk-launch-guide', '', '2012-11-27 15:22:32', 'http://www.ign.com/articles/2012/11/27/wii-u-uk-launch-guide'),
(1297, 'Yoshida: Another Mistake Like FF14 Would "Destroy" Square', 'Yoshida has spoken about why he thinks Final Fantasy XIV failed, and what another mistake would cost Square.', 'http://www.ign.com/articles/2012/11/27/yoshida-another-mistake-like-ff14-would-destroy-square', '', '2012-11-27 15:17:32', 'http://www.ign.com/articles/2012/11/27/yoshida-another-mistake-like-ff14-would-destroy-square'),
(1298, 'UPDATE: Wii Mini Confirmed as Canadian Exclusive', 'Following the earlier image on Best Buy''s Canadian website, Nintendo has confirmed the existence of the Wii Mini', 'http://www.ign.com/articles/2012/11/27/retailer-confirms-nintendo-wii-mini-details', '', '2012-11-27 12:45:54', 'http://www.ign.com/articles/2012/11/27/retailer-confirms-nintendo-wii-mini-details'),
(1299, 'Peter Molyneux Details The Influences Behind Godus', 'From Populous and Dungeon Keeper to Black &amp; White, Molyneux wants stuff from each for Godus.', 'http://www.ign.com/articles/2012/11/27/peter-molyneux-details-the-influences-behind-godus', '', '2012-11-27 12:20:33', 'http://www.ign.com/articles/2012/11/27/peter-molyneux-details-the-influences-behind-godus'),
(1300, 'Watch IPL 5 on IGN', 'The best players in the world gather to compete in StarCraft II, League of Legends, and ShootMania. Watch it all.', 'http://www.ign.com/articles/2012/11/27/watch-ipl-5-live-on-ign', '', '2012-11-27 02:47:05', 'http://www.ign.com/articles/2012/11/27/watch-ipl-5-live-on-ign'),
(1301, 'Little Inferno PC Review', 'Initially it’s a pleasure to burn every item I receive in Little Inferno, but that swiftly changes as time goes on.', 'http://www.ign.com/articles/2012/11/27/little-inferno-pc-review', '', '2012-11-27 02:30:11', 'http://www.ign.com/articles/2012/11/27/little-inferno-pc-review'),
(1302, 'Halo 4 DLC, Two Models of Next Xbox, Wii Mini Rumors', 'Rumor Central: Halo 4 DLC dated; two models of next Xbox; Wii Mini; RE Revelations for consoles. Plus, no multiplayer for BioShock Infinite.', 'http://www.ign.com/videos/2012/11/26/ign-daily-fix-112612', '', '2012-11-27 01:50:00', 'http://www.ign.com/videos/2012/11/26/ign-daily-fix-112612'),
(1303, 'GTA 5 PC Petition Hits 40,000 Signatures', 'More than 40,000 fans have now signed a petition asking Rockstar for a PC version of Grand Theft Auto V. Have you signed?', 'http://www.ign.com/articles/2012/11/27/grand-theft-auto-v-pc-petition-hits-40000-signatures', '', '2012-11-27 01:34:47', 'http://www.ign.com/articles/2012/11/27/grand-theft-auto-v-pc-petition-hits-40000-signatures'),
(1304, 'PlanetSide 2 Review in Progress Commentary 2', 'Our impressions of SOE''s massive shooter as we continue to play for review.', 'http://feeds.ign.com/~r/ign/pc-videos/~3/2say-D-RDRw/planetside-2-review-in-progress-commentary-2', '', '2012-11-27 01:15:00', 'http://feeds.ign.com/~r/ign/pc-videos/~3/2say-D-RDRw/planetside-2-review-in-progress-commentary-2'),
(1305, 'Jetpack Joyride PS Mini Review', 'Smash mobile hit Jetpack Joyride is now available as a PS Mini! But with no online leaderboards and a higher price tag, is it worth it?', 'http://www.ign.com/articles/2012/11/27/jetpack-joyride-ps-mini-review', '', '2012-11-27 01:12:23', 'http://www.ign.com/articles/2012/11/27/jetpack-joyride-ps-mini-review'),
(1306, 'Has The Long Console Generation Damaged Gaming?', 'Opinion: Microsoft and Sony''s timidity in launching new consoles may be harming gaming''s growth.', 'http://www.ign.com/articles/2012/11/27/has-the-longest-console-generation-damaged-gaming', '', '2012-11-27 01:09:47', 'http://www.ign.com/articles/2012/11/27/has-the-longest-console-generation-damaged-gaming'),
(1307, 'Little Chomp Review', 'Little Chomp is not the kiddy forest romp it appears to be. This is an expertly-tuned touchcreen climber that is not to be missed.', 'http://www.ign.com/articles/2012/11/26/little-chomp-review', '', '2012-11-27 00:38:42', 'http://www.ign.com/articles/2012/11/26/little-chomp-review'),
(1308, 'ZombiU walkthrough Part 31 - Load Out', 'Join IGN as we take you through the world of ZombiU. This is part 31 of the walkthrough, Load Out. Retrieve everything from your safe house and head to the tower of London and wait to be Picked up.', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/e5Nk3Lh8PfM/zombiu-walkthrough-part-31-load-out', '', '2012-11-27 00:35:00', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/e5Nk3Lh8PfM/zombiu-walkthrough-part-31-load-out'),
(1309, 'ZombiU Walkthrough Part 30 - Retrieve The Panacea Part D', 'Join IGN as we take you through the world of ZombiU, This is Part 30 of the walkthrough, Retrieve The Panacea Part D. Escaping the bunkers after triggering the alarm, you must return to the safe house and collect your gear.', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/RmKC04vndew/zombiu-walkthrough-part-30-retrieve-the-panacea-part-d', '', '2012-11-27 00:31:00', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/RmKC04vndew/zombiu-walkthrough-part-30-retrieve-the-panacea-part-d'),
(1310, 'ZombiU walkthrough Part 29 - Retrieve The Panacea Part C', 'Join IGN as we take you through the world of ZombiU, This is part 29 of the walkthrough, Retrieve The Panacea Part C. Once you reach the queens quarters you must download the Panacea recipe than you must escape the bunker.', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/qZrWNeH4c84/zombiu-walkthrough-part-29-retrieve-the-panacea-part-c', '', '2012-11-27 00:30:00', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/qZrWNeH4c84/zombiu-walkthrough-part-29-retrieve-the-panacea-part-c'),
(1311, 'ZombiU Walkthrough Part 28 - Retrieve The Panacea Part B', 'Join IGN as we take you through the world of ZombiU. This is Part 28 of the walkthrough, Retrieve The Panacea Part B. After entering the queens quarters you find the doc as a zombi and you must kill him to retrieve his eye.', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/9nSNOuGYXv4/zombiu-walkthrough-part-28-retrieve-the-panacea-part-b', '', '2012-11-27 00:25:00', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/9nSNOuGYXv4/zombiu-walkthrough-part-28-retrieve-the-panacea-part-b'),
(1312, 'ZombiU Walkthrough Part 27 - Retrieve The Panacea Part A', 'Join IGN as we take you through the world of ZombiU. This is part 27 of the walkthrough, Retrieve The Panacea Part A. The doctor tells you the Panacea is ready and asks you to meet him in the Queens Quarters.', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/jBIwIDOkG5Q/zombiu-walkthrough-part-27-retrieve-the-panacea-part-a', '', '2012-11-27 00:25:00', 'http://feeds.ign.com/~r/ign/wii-u-videos/~3/jBIwIDOkG5Q/zombiu-walkthrough-part-27-retrieve-the-panacea-part-a'),
(1313, 'LEGO Lord of the Rings Vita/3DS Review', 'Are the portable versions of LEGO The Lord of the Rings any good? Let''s find out.', 'http://www.ign.com/articles/2012/11/26/lego-the-lord-of-the-rings-vita3ds-review', '', '2012-11-26 23:39:33', 'http://www.ign.com/articles/2012/11/26/lego-the-lord-of-the-rings-vita3ds-review'),
(1314, 'Halo 4 - Spartan Ops Didact''s Hand Legendary Walkthrough Part 5 - The Didact''s Gift', 'Our orders are to defend Galileo Base and secure the Didact''s Gift.', 'http://www.ign.com/videos/2012/11/26/halo-4-spartan-ops-didacts-hand-legendary-walkthrough-part-5-the-didacts-gift', '', '2012-11-26 23:35:00', 'http://www.ign.com/videos/2012/11/26/halo-4-spartan-ops-didacts-hand-legendary-walkthrough-part-5-the-didacts-gift'),
(1315, 'One Simple Question Trailer', 'PlanetSide 2 has one simple question: Can your FPS do this?', 'http://feeds.ign.com/~r/ign/pc-videos/~3/tray3Xh_BMs/planetside-2-one-simple-question-trailer', '', '2012-11-26 22:57:00', 'http://feeds.ign.com/~r/ign/pc-videos/~3/tray3Xh_BMs/planetside-2-one-simple-question-trailer'),
(1316, '- Elizabeth Taylor var full under innspilling', 'Lindsay Lohan mener filmdivaen var verre enn henne.', 'http://www.dagbladet.no/2012/11/27/kjendis/lindsay_lohan/film/tv_og_medier/24545715/', '', '2012-11-27 08:43:00', 'http://www.dagbladet.no/2012/11/27/kjendis/lindsay_lohan/film/tv_og_medier/24545715/'),
(1317, 'Sjokolademousse', 'Pascal Dupuy koser seg med sjokoladedessert i Førkveld.', 'http://www.nrk.no/mat/1.8834597', '', '2012-11-27 15:36:20', 'http://www.nrk.no/mat/1.8834597'),
(1318, 'Marengs', 'Pascal Dupuy serverer marengs i Førkveld.', 'http://www.nrk.no/mat/1.8834519', '', '2012-11-27 15:34:58', 'http://www.nrk.no/mat/1.8834519'),
(1319, 'Bryllupskake', 'Blomsterbergs bryllupskake i fem etasjer er laget av valnøttbunner med trøffelkrem og blåbærbomber. På marsipanen er det pyntet med marsipanroser.', 'http://www.nrk.no/mat/1.8834801', '', '2012-11-27 14:47:51', 'http://www.nrk.no/mat/1.8834801'),
(1320, 'Trio pannacotta', 'En deilig dessert som også de med gluten-, egg- eller nøtteallergi kan nyte. Her får du en base på vaniljepannacotta som du kan variere og utvide etter eget ønske. Vær kreativ og lek deg med frukt og smak!', 'http://www.nrk.no/mat/1.8834443', '', '2012-11-27 11:28:49', 'http://www.nrk.no/mat/1.8834443'),
(1321, 'Ikke la deg lure av Facebook-paranoia', '<p> Facebook har endret sine personvernvilkår igjen. Men mange har misforstått betydningen av endringene. </p><img width=''1'' height=''1'' src=''http://dn.no.feedsportal.com/c/33154/f/538612/s/2602eaf8/mf.gif'' border=''0''/><div class=''mf-viral''><table border=''0''><tr><td valign=''middle''><a href="http://share.feedsportal.com/viral/sendEmail.cfm?lang=en&title=Ikke+la+deg+lure+av+Facebook-paranoia&link=http%3A%2F%2Fwww.dagensit.no%2Farticle2516669.ece" target="_blank"><img src="http://res3.feedsportal.com/images/emailthis2.gif" border="0" /></a></td><td valign=''middle''><a href="http://res.feedsportal.com/viral/bookmark.cfm?title=Ikke+la+deg+lure+av+Facebook-paranoia&link=http%3A%2F%2Fwww.dagensit.no%2Farticle2516669.ece" target="_blank"><img src="http://res3.feedsportal.com/images/bookmark.gif" border="0" /></a></td></tr></table></div>', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2602eaf8/l/0L0Sdagensit0Bno0Carticle25166690Bece/story01.htm', 'Magnus Eidem', '2012-11-27 15:15:26', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2602eaf8/l/0L0Sdagensit0Bno0Carticle25166690Bece/story01.htm'),
(1322, 'Telenor kan bli Indias fjerde største', '<p> Er i samtaler med Tata. </p><img width=''1'' height=''1'' src=''http://dn.no.feedsportal.com/c/33154/f/538612/s/2601c5c9/mf.gif'' border=''0''/><div class=''mf-viral''><table border=''0''><tr><td valign=''middle''><a href="http://share.feedsportal.com/viral/sendEmail.cfm?lang=en&title=Telenor++kan+bli+Indias+fjerde+st%C3%B8rste&link=http%3A%2F%2Fwww.dagensit.no%2Farticle2516734.ece" target="_blank"><img src="http://res3.feedsportal.com/images/emailthis2.gif" border="0" /></a></td><td valign=''middle''><a href="http://res.feedsportal.com/viral/bookmark.cfm?title=Telenor++kan+bli+Indias+fjerde+st%C3%B8rste&link=http%3A%2F%2Fwww.dagensit.no%2Farticle2516734.ece" target="_blank"><img src="http://res3.feedsportal.com/images/bookmark.gif" border="0" /></a></td></tr></table></div>', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2601c5c9/l/0L0Sdagensit0Bno0Carticle25167340Bece/story01.htm', 'TDN Finans', '2012-11-27 13:07:55', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2601c5c9/l/0L0Sdagensit0Bno0Carticle25167340Bece/story01.htm'),
(1323, 'Vollvik mister partner', '<p> Idar Vollviks partner fra Chess-tiden, Svein Johnsen, forlater Ludo Group. </p><img width=''1'' height=''1'' src=''http://dn.no.feedsportal.com/c/33154/f/538612/s/2600ad9d/mf.gif'' border=''0''/><div class=''mf-viral''><table border=''0''><tr><td valign=''middle''><a href="http://share.feedsportal.com/viral/sendEmail.cfm?lang=en&title=Vollvik+mister+partner&link=http%3A%2F%2Fwww.dn.no%2Fforsiden%2Fnaringsliv%2Farticle2516526.ece" target="_blank"><img src="http://res3.feedsportal.com/images/emailthis2.gif" border="0" /></a></td><td valign=''middle''><a href="http://res.feedsportal.com/viral/bookmark.cfm?title=Vollvik+mister+partner&link=http%3A%2F%2Fwww.dn.no%2Fforsiden%2Fnaringsliv%2Farticle2516526.ece" target="_blank"><img src="http://res3.feedsportal.com/images/bookmark.gif" border="0" /></a></td></tr></table></div>', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2600ad9d/l/0L0Sdn0Bno0Cforsiden0Cnaringsliv0Carticle25165260Bece/story01.htm', 'DN.no', '2012-11-27 10:47:52', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2600ad9d/l/0L0Sdn0Bno0Cforsiden0Cnaringsliv0Carticle25165260Bece/story01.htm'),
(1325, 'Oslo Børs steg 0,17 prosent', '<p>Gresk løsning ga ikke store utslag i aksjemarkedet. </p><p> </p>', 'http://e24.no/boers-og-finans/boersrapport/oslo-boers-steg-0-17-prosent/20305002', 'Even Landre', '2012-11-27 16:41:10', 'http://e24.no/boers-og-finans/boersrapport/oslo-boers-steg-0-17-prosent/20305002'),
(1326, 'Giske-høringen vokser og vokser', '<p>Stortingets kontrollkomité har valgt å kalle inn hele valgkomiteer til Giske-høringen.<br /></p>', 'http://e24.no/makro-og-politikk/giske-hoeringen-vokser-og-vokser/20304999', 'Marius Lorentzen', '2012-11-27 16:06:31', 'http://e24.no/makro-og-politikk/giske-hoeringen-vokser-og-vokser/20304999'),
(1327, 'Nervøs handel i New York', '<p>Aksjemarkedet gikk småpessimistisk ut av startblokken. <br /></p><p></p>', 'http://e24.no/boers-og-finans/boersrapport/nervoes-handel-i-new-york/20304992', 'Even Landre', '2012-11-27 15:41:26', 'http://e24.no/boers-og-finans/boersrapport/nervoes-handel-i-new-york/20304992'),
(1328, '- Telenor i samtaler om fusjon i India', '<p>Kan bli fjerde størst i gigantmarkedet.<br /></p><p></p>', 'http://e24.no/naeringsliv/telenor-i-samtaler-om-fusjon-i-india/20304973', 'Anders Park Framstad', '2012-11-27 14:54:21', 'http://e24.no/naeringsliv/telenor-i-samtaler-om-fusjon-i-india/20304973'),
(1329, 'OECD:- Verdensøkonomien er langt fra reddet', '<p>OECD advarer mot et mulig finansielt sjokk.<br /></p>', 'http://e24.no/makro-og-politikk/oecd-verdensoekonomien-er-langt-fra-reddet/20304914', 'Anders Park Framstad', '2012-11-27 14:42:19', 'http://e24.no/makro-og-politikk/oecd-verdensoekonomien-er-langt-fra-reddet/20304914'),
(1330, 'Undrer seg over ved NRKs pengebruk', '<p>Riksrevisjonen mener Hadia Tajik har «betydelige muligheter» for å bedre oppfølgingen av NRK.</p><p> </p>', 'http://e24.no/media/undrer-seg-over-ved-nrks-pengebruk/20304913', 'E24', '2012-11-27 14:40:05', 'http://e24.no/media/undrer-seg-over-ved-nrks-pengebruk/20304913'),
(1331, 'TV 2 og Canal Digital møtes igjen onsdag', '<p>Canal Digital og TV 2 skal møtes onsdag. Et møte som var planlagt tirsdag, ble av praktiske årsaker utsatt.    </p>', 'http://e24.no/media/tv-2-og-canal-digital-moetes-igjen-onsdag/20304961', 'NTB', '2012-11-27 14:20:37', 'http://e24.no/media/tv-2-og-canal-digital-moetes-igjen-onsdag/20304961'),
(1332, 'Oljefondet «tjente» 132 millioner på Hellas i 3. kvartal', '<p>Nå kan Oljefondet hente inn enda litt mer av sitt greske tap.<br /></p>', 'http://e24.no/makro-og-politikk/oljefondet-tjente-132-millioner-paa-hellas-i-3-kvartal/20304804', 'Johann D. Sundberg', '2012-11-27 13:54:01', 'http://e24.no/makro-og-politikk/oljefondet-tjente-132-millioner-paa-hellas-i-3-kvartal/20304804'),
(1333, 'Britisk økonomi vokser igjen', '<p>    Den britiske økonomien vokste med 1 prosent i tredje kvartal, men det anses bare som et lite pusterom i en ellers anstrengt situasjon.    </p>', 'http://e24.no/makro-og-politikk/britisk-oekonomi-vokser-igjen/20304946', 'NTB', '2012-11-27 13:35:14', 'http://e24.no/makro-og-politikk/britisk-oekonomi-vokser-igjen/20304946'),
(1334, 'VW satser enorme summer', '<p>Mens mange europeiske bilprodusenter stopper produksjon og sier opp tusenvis, satser Volkswagen-gruppen flere hundre milliarder på nye fabrikker og modeller.<br /></p>', 'http://e24.no/bil/vw-satser-enorme-summer/20304844', 'Morten Abrahamsen', '2012-11-27 12:49:30', 'http://e24.no/bil/vw-satser-enorme-summer/20304844'),
(1335, 'Slår ned på enorme lønnsgap i statlige styrer', '<p>Riksrevisjonen er kritisk til de store lønnsforskjellene til styremedlemmer i statseide selskaper.<br /></p><p></p>', 'http://e24.no/makro-og-politikk/slaar-ned-paa-enorme-loennsgap-i-statlige-styrer/20304881', 'Marius Lorentzen', '2012-11-27 12:31:14', 'http://e24.no/makro-og-politikk/slaar-ned-paa-enorme-loennsgap-i-statlige-styrer/20304881'),
(1336, '– Berlusconi gjør comeback med nytt parti', '<p>    Silvio Berlusconi kommer senere denne uken til å gjøre comeback i italiensk politikk med et nytt parti, hevder enkelte av den tidligere statsministerens tilhengere.    </p>', 'http://e24.no/makro-og-politikk/berlusconi-gjoer-comeback-med-nytt-parti/20304878', 'NTB', '2012-11-27 11:46:26', 'http://e24.no/makro-og-politikk/berlusconi-gjoer-comeback-med-nytt-parti/20304878'),
(1337, 'Solaktivitet kan true oljeboring i nord', '<p> Høy solaktivitet fører\ntil økt variasjon i jordens magnetfelt. Det kan få store konsekvenser for\nboreaktiviteter i Barentshavet. </p><p> </p>', 'http://e24.no/energi/solaktivitet-kan-true-oljeboring-i-nord/20304875', 'Tale Sundlisæter - Teknisk Ukeblad', '2012-11-27 11:36:02', 'http://e24.no/energi/solaktivitet-kan-true-oljeboring-i-nord/20304875'),
(1338, 'Saxo Bank sier opp hver femte ansatt', '<p>Den danske banken kvitter seg med 266 ansatte.<br /></p>', 'http://e24.no/boers-og-finans/saxo-bank-sier-opp-hver-femte-ansatt/20304841', 'E24', '2012-11-27 11:26:15', 'http://e24.no/boers-og-finans/saxo-bank-sier-opp-hver-femte-ansatt/20304841'),
(1339, 'Norges Bank frykter for 170.000 boliglånskunder', '<p>Norges Bank: «Særlig stor risiko for boligprisfall» i Norge hvis resten av Europa ikke kommer på bedringens vei.<br /></p><p></p>', 'http://e24.no/makro-og-politikk/norges-bank-frykter-for-170-000-boliglaanskunder/20304817', 'Kristin Norli', '2012-11-27 10:53:52', 'http://e24.no/makro-og-politikk/norges-bank-frykter-for-170-000-boliglaanskunder/20304817'),
(1340, 'Spareviljen på topp', '<p>Ikke siden kriseperioden i 1998 har så mange hatt lyst til å nedbetale gjeld.<br /></p>', 'http://e24.no/makro-og-politikk/spareviljen-paa-topp/20304791', 'Line Midtsjø', '2012-11-27 10:35:01', 'http://e24.no/makro-og-politikk/spareviljen-paa-topp/20304791'),
(1341, 'BW Offshore oppgraderes til kjøp', '<p>Melgerhus hever anbefaling etter tallene i går.    </p>', 'http://e24.no/boers-og-finans/bw-offshore-oppgraderes-til-kjoep/20304836', 'E. Storm - StockLink iMarkedet', '2012-11-27 10:25:32', 'http://e24.no/boers-og-finans/bw-offshore-oppgraderes-til-kjoep/20304836'),
(1342, 'Selvaag: - Det er ingen boligboble', '<p>    Derfor kan det ikke være en boligboble nå, mener sjef i boligbyggeren Selvaag.    </p>', 'http://e24.no/eiendom/selvaag-det-er-ingen-boligboble/20304833', 'Asgeir Nilsen - StockLink iMarkedet', '2012-11-27 10:23:44', 'http://e24.no/eiendom/selvaag-det-er-ingen-boligboble/20304833'),
(1343, 'Ericsson saksøker Samsung', '<p>    Svenske Ericsson saksøker sørkoreanske Samsung for patentjuks. Konflikten dreier som det såkalte FRAND-patentet.    </p>', 'http://e24.no/it/ericsson-saksoeker-samsung/20304818', 'NTB', '2012-11-27 09:55:43', 'http://e24.no/it/ericsson-saksoeker-samsung/20304818'),
(1344, 'Sjeføkonom: - Norske boligpriser kan godt falle 40 prosent', '<p>- Nei, det er ikke dette jeg tror kommer til å skje, men det er ikke urealistisk, sier Harald Magnus Andreassen i First Securities.<br /></p><p></p>', 'http://e24.no/eiendom/sjefoekonom-norske-boligpriser-kan-godt-falle-40-prosent/20304781', 'Hans Iver Odenrud', '2012-11-27 09:26:19', 'http://e24.no/eiendom/sjefoekonom-norske-boligpriser-kan-godt-falle-40-prosent/20304781'),
(1346, 'Nyter du denne utsikten, er du mest sannsynlig god og mett', 'Under palmene her blir du kokk på tre timer.', 'http://www.dagbladet.no/2012/11/27/tema/reise/sol_og_badeferie/mat/mat_og_drikke/24354018/', '', '2012-11-27 13:21:00', 'http://www.dagbladet.no/2012/11/27/tema/reise/sol_og_badeferie/mat/mat_og_drikke/24354018/'),
(1347, 'Eldre fedre kan få tykke barn ', '(VG Nett) Menn som får barn når de er over 50 år, har større sjanse til å få fete barn. ', 'http://www.vg.no/helse/artikkel.php?artid=10048233', '', '2012-11-27 16:52:00', 'http://www.vg.no/helse/artikkel.php?artid=10048233'),
(1348, 'Sjeldent naturfenomen gjorde svømmetur til «blodbad»', 'Myndighetene ber folk holde seg unna blodrødt vann.', 'http://www.dagbladet.no/2012/11/27/nyheter/utenriks/australie/bondi_beach/24568657/', '', '2012-11-27 16:47:00', 'http://www.dagbladet.no/2012/11/27/nyheter/utenriks/australie/bondi_beach/24568657/'),
(1349, 'Slik vil NRK endre lisensen ', '(VG Nett) NRKs egen arbeidsgruppe har fremmet en rekke forslag til endringer i innkrevingen av lisensavgiften. Om, og når, de eventuelt vil tre i kraft er ennå uklart. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048251', '', '2012-11-27 17:29:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048251'),
(1350, 'Massedemonstrasjon mot Mursi i Kairo', 'Titusener av mennesker samlet seg tirsdag ettermiddag på Tahrir-plassen i Egypts hovedstad Kairo for å delta i en massedemonstrasjon mot president Mohamed Mursi.', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048296', '', '2012-11-27 17:21:00', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048296'),
(1351, 'Her overrumpler Frp-toppen Stortinget med plakatstunt', '(VG Nett) Med sprittusj og store, gule papp-plakater skaffet Frp-politiker Christian Tybring-Gjedde seg noe å skilte med i finansdebatten.', 'http://www.vg.no/nyheter/innenriks/norsk-politikk/artikkel.php?artid=10048290', '', '2012-11-27 17:18:00', 'http://www.vg.no/nyheter/innenriks/norsk-politikk/artikkel.php?artid=10048290'),
(1352, 'Rekdal: - Ser ingen grunn til å skyte brannfakler ', 'ÅLESUND/OSLO (VG Nett) Kjetil Rekdal (44) mener han kunne tjent på å ta en kamp med klubben som sparket ham i media. Men den avtroppende treneren sier seg allerede ferdig med Aalesund. ', 'http://www.vg.no/sport/fotball/norsk/artikkel.php?artid=10048293', '', '2012-11-27 17:04:00', 'http://www.vg.no/sport/fotball/norsk/artikkel.php?artid=10048293'),
(1353, 'Se de utrolige bildene: Bondi Beach ble «bloody beach»', '(VG Nett) Slik ser det ut når røde alger forvandlet verdenskjente Bondi Beach til det som mest av alt ser ut som en scene fra Haisommer. ', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048289', '', '2012-11-27 16:36:00', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048289'),
(1354, '- Pinlig å være stortings-representant i dag', 'Frps Christian Tybring-Gjedde hadde plakatshow på Stortingets talerstol.', 'http://www.dagbladet.no/2012/11/27/nyheter/christian_tybring-gjedde/frp/politikk/innenriks/24571713/', '', '2012-11-27 17:34:00', 'http://www.dagbladet.no/2012/11/27/nyheter/christian_tybring-gjedde/frp/politikk/innenriks/24571713/'),
(1355, '- Det føles som jeg har forrådt fransk fotball', 'U21-spiller utestengt i to år etter bytur før tapet mot Norge.', 'http://www.dagbladet.no/2012/11/27/sport/fotball/wissam_ben_yedder/24572222/', '', '2012-11-27 17:25:00', 'http://www.dagbladet.no/2012/11/27/sport/fotball/wissam_ben_yedder/24572222/'),
(1356, '- I de 17 årene jeg var gift med Petar, var doping et naturlig tema i hverdagen', 'Vukicevics eks-kone synes det var tøft å høre barnas versjon i dag.', 'http://www.dagbladet.no/2012/11/27/sport/friidrett/doping/turid_syftestad/petar_vukicevic/24571805/', '', '2012-11-27 17:12:00', 'http://www.dagbladet.no/2012/11/27/sport/friidrett/doping/turid_syftestad/petar_vukicevic/24571805/'),
(1357, 'Dishonored Dunwall City Trials DLC Dated and Priced', 'Dishonored''s first piece of DLC has been fully detailed and is due to arrive next month.', 'http://www.ign.com/articles/2012/11/27/dishonored-dunwall-city-trials-dlc-dated-and-priced', '', '2012-11-27 16:31:16', 'http://www.ign.com/articles/2012/11/27/dishonored-dunwall-city-trials-dlc-dated-and-priced'),
(1358, 'Tilbake på øya der hun ble misbrukt', 'Herbjørg Wassmo – en av Norges mest kjente forfattere – dro på sin første reise hjem til barndommens øy. Der har hun ikke vært siden hun stod fram som misbrukt.', 'http://www.nrk.no/nyheter/kultur/litteratur/1.8703613', '', '2012-11-27 17:49:36', 'http://www.nrk.no/nyheter/kultur/litteratur/1.8703613'),
(1359, 'Seabird henter penger', '<p>Emisjon i seismikkselskap.<br /></p>', 'http://e24.no/boers-og-finans/seabird-henter-penger/20305041', 'Jostein Nissen-Meyer - StockLink iMarkedet', '2012-11-27 17:48:11', 'http://e24.no/boers-og-finans/seabird-henter-penger/20305041'),
(1360, 'Få topp- karakter på eksamen ', 'Suksessoppskriften er nemlig ikke verre enn fokus, søvn, trening og pauser. ', 'http://www.vg.no/nyheter/innenriks/elevavisen/artikkel.php?artid=10048292', '', '2012-11-27 17:57:00', 'http://www.vg.no/nyheter/innenriks/elevavisen/artikkel.php?artid=10048292'),
(1361, 'To nye tilfeller av sjelden salmonella ', '(VG Nett) Til sammen ti personer har blitt smittet av den uvanlige, Salmonella Mikawasima. Smittekilden er fremdeles ukjent. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048291', '', '2012-11-27 17:54:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048291'),
(1362, 'Trønder slo alarm om finsk doping og fikk lide resten av livet', '- Pappa burde vært hedret, sier Hallgeir Lundemo.', 'http://www.dagbladet.no/2012/11/27/sport/doping/ski/24570534/', '', '2012-11-27 18:02:00', 'http://www.dagbladet.no/2012/11/27/sport/doping/ski/24570534/'),
(1363, 'NRK øker lisensen - produserer mindre', 'Får krass kritikk av Riksrevisjonen.', 'http://www.dagbladet.no/2012/11/27/kultur/tv_og_medier/nrk/riksrevisjonen/kulturpolitikk/24569158/', '', '2012-11-27 17:58:00', 'http://www.dagbladet.no/2012/11/27/kultur/tv_og_medier/nrk/riksrevisjonen/kulturpolitikk/24569158/'),
(1364, 'Full forvirring mellom Riksrevisjonen og Helsedepartementet', '<p>Riksrevisjonen: - Vi har ikke fått noen rapport. Helsedepartementet: - De spurte oss aldri. E24 fikk rapporten etter en kjapp telefon.<br /></p>', 'http://e24.no/makro-og-politikk/full-forvirring-mellom-riksrevisjonen-og-helsedepartementet/20305022', 'Terje Normann', '2012-11-27 17:53:59', 'http://e24.no/makro-og-politikk/full-forvirring-mellom-riksrevisjonen-og-helsedepartementet/20305022'),
(1365, '- Vitner om katastrofal mangel på kunnskap ', 'Kringkastingssjef Hans-Tore Bjerkaas går hardt ut mot Riksrevisjonens rapport. ', 'http://www.vg.no/rampelys/artikkel.php?artid=10048299', '', '2012-11-27 18:16:00', 'http://www.vg.no/rampelys/artikkel.php?artid=10048299'),
(1366, 'Israel ber Norge droppe FN-støtte til Abbas', 'Det er et paradoks hvis Norge, landet bak Oslo-avtalen, støtter palestinernes forsøk på å skaffe seg oppgradert status i FN, mener Israels Oslo-ambassadør.', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048300', '', '2012-11-27 18:09:00', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048300'),
(1367, 'NRK-sjefen slår tilbake mot Riksrevisjonen', ' \n<p>– Riksrevisjonen vet ikke hva de snakker om, sier NRK-sjef Hans-Tore Bjerkaas.<br /></p>', 'http://e24.no/media/nrk-sjefen-slaar-tilbake-mot-riksrevisjonen/20305055', 'NTB', '2012-11-27 18:04:18', 'http://e24.no/media/nrk-sjefen-slaar-tilbake-mot-riksrevisjonen/20305055'),
(1368, 'Her overrumpler Frp-toppen Stortinget med plakatstunt ', '(VG Nett) Med sprittusj og store, gule papp-plakater skaffet Frp-politiker Christian Tybring-Gjedde seg noe å skilte med i finansdebatten. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048290', '', '2012-11-27 17:18:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048290'),
(1369, 'To menn tiltalt for Bergen-voldtekt', 'To menn på 21 og 23 år er tiltalt for å ha voldtatt en kvinne i en trapp ved Den Nationale Scene (DNS) i Bergen sentrum.', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048303', '', '2012-11-27 18:30:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048303'),
(1370, 'Kunst for millioner under hammeren', 'Polarhistorie, pop art og klassisk kunst selges til høystbydende hos Blomquist kunsthandel i Oslo i kveld.', 'http://www.nrk.no/kultur-og-underholdning/1.8835289', '', '2012-11-27 18:30:15', 'http://www.nrk.no/kultur-og-underholdning/1.8835289');
INSERT INTO `news` (`id`, `title`, `description`, `link`, `author`, `publish_date`, `guid`) VALUES
(1371, 'Bokanmeldelse: Roslund & Hellström: «To soldater» ', 'Brutal fortelling fra ekstremt voldelig miljø. ', 'http://www.vg.no/rampelys/artikkel.php?artid=10048266', '', '2012-11-27 18:45:00', 'http://www.vg.no/rampelys/artikkel.php?artid=10048266'),
(1372, 'Bokanmeldelse: Gerd-Liv Valla: «Gi meg de brennende hjerter» ', 'Hvis det fortsatt fins noen i Norge som ikke skjønner hvorfor tidligere LO-leder Gerd-Liv Valla ble en så kontroversiell person, er hennes memoarer et godt sted å begynne. ', 'http://www.vg.no/rampelys/artikkel.php?artid=10048275', '', '2012-11-27 18:44:00', 'http://www.vg.no/rampelys/artikkel.php?artid=10048275'),
(1373, 'Lyser ut stillingen som sjef for Politiets Utlendingsenhet ', '(VG Nett) Politidirektoratet har lyst ut stillingen som sjef for Politiets Utlendingsenhet (PU). ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048267', '', '2012-11-27 18:41:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048267'),
(1374, 'Reidun (88): - Nå gruer jeg meg ikke til julen lenger ', '(VG Nett) Hun har gruet seg til nok en ensom jul i hele år, men det var helt til hun satte inn en annonse i Aften. ', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048301', '', '2012-11-27 18:38:00', 'http://www.vg.no/nyheter/innenriks/artikkel.php?artid=10048301'),
(1375, 'Svendsen klipte lagkameratens hår: - Det ser j*** ut! ', 'ÖSTERSUND (VG Nett) Skiskyttertalentet Erlend Bjøntegaard (22) har ikke vært til frisør på over to år. I dag lot han Emil Hegle Svendsen (27) klippe seg. ', 'http://www.vg.no/sport/ski/skiskyting/artikkel.php?artid=10048294', '', '2012-11-27 18:36:00', 'http://www.vg.no/sport/ski/skiskyting/artikkel.php?artid=10048294'),
(1376, 'You Decide: Halo 4 vs Call of Duty: Black Ops 2', 'Is Halo 4 the better game or is Call of Duty: Black Ops 2 unstoppable?  We want to know what you think. Cast your vote across multiple categories.', 'http://www.ign.com/articles/2012/11/27/you-decide-halo-4-vs-call-of-duty-black-ops-2', '', '2012-11-27 17:20:10', 'http://www.ign.com/articles/2012/11/27/you-decide-halo-4-vs-call-of-duty-black-ops-2'),
(1377, 'UPDATE: Wii Mini Confirmed For Canada', 'Following the earlier image on Best Buy''s Canadian website, Nintendo has confirmed the existence of the Wii Mini', 'http://www.ign.com/articles/2012/11/27/retailer-confirms-nintendo-wii-mini-details', '', '2012-11-27 12:45:54', 'http://www.ign.com/articles/2012/11/27/retailer-confirms-nintendo-wii-mini-details'),
(1378, 'Google-brillen har fått konkurranse', '<p>Men hvor vil brilleteknologien passe inn?</p>', 'http://e24.no/it/google-brillen-har-faatt-konkurranse/20305074', 'Tale Sundlisæter - Teknisk Ukeblad', '2012-11-27 18:43:49', 'http://e24.no/it/google-brillen-har-faatt-konkurranse/20305074'),
(1379, 'Store kutt i vente i Portugal', '<p>Store skatteøkninger og dype kutt er oppskriften i Portugals statsbudsjett for neste år.    </p>', 'http://e24.no/makro-og-politikk/store-kutt-i-vente-i-portugal/20305054', 'NTB', '2012-11-27 18:37:51', 'http://e24.no/makro-og-politikk/store-kutt-i-vente-i-portugal/20305054'),
(1380, 'Bokanmeldelse: Sverre Mørkhagen: «Drømmen om Amerika, bind II» ', 'I første bind om den norske utvandringen til Amerika, «Farvel Norge» (2009), var det først og fremst årsakene til folkeforflyttingen som ble tematisert. I andre bind, som nå foreligger, følger vi skjebnen til de første bølgene av migranter etter at de ankom det forjettede land. ', 'http://www.vg.no/rampelys/artikkel.php?artid=10048271', '', '2012-11-27 18:46:00', 'http://www.vg.no/rampelys/artikkel.php?artid=10048271'),
(1381, 'Chelsea beklager til Clattenburg og familien ', 'Som en avslutning på anklagene fra Chelsea mot dommer Mark Clattenburg beklaget tirsdag klubben overfor dommeren og hans familie.', 'http://www.vg.no/sport/fotball/artikkel.php?artid=10048304', '', '2012-11-27 18:46:00', 'http://www.vg.no/sport/fotball/artikkel.php?artid=10048304'),
(1382, 'Mangler plan for skolebibliotek', 'Det er ikke lenger noen selvfølge med et godt skolebibliotek. Da blir barna dårligere til å lese, mener forskere.', 'http://www.nrk.no/kultur-og-underholdning/1.8834742', '', '2012-11-27 18:56:17', 'http://www.nrk.no/kultur-og-underholdning/1.8834742'),
(1383, 'Overraskelsen «Hotline Miami» får oppfølger ', 'Utvikleren gjør om planlagt ekstrainnhold til nytt spill. ', 'http://www.vg.no/spill/artikkel.php?artid=10048264', '', '2012-11-27 19:02:00', 'http://www.vg.no/spill/artikkel.php?artid=10048264'),
(1384, '- Den japanske spillindustrien reiser seg igjen ', 'Square Enix-topp tror Japan snart måler seg med Vesten igjen. ', 'http://www.vg.no/spill/artikkel.php?artid=10048263', '', '2012-11-27 18:59:00', 'http://www.vg.no/spill/artikkel.php?artid=10048263'),
(1385, 'To menn tiltalt for voldtekt i Bergen', 'Skal ha voldtatt en kvinne i trappa ved Den Nationale Scene.', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/voldtekt/bergen/24573197/', '', '2012-11-27 18:51:00', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/voldtekt/bergen/24573197/'),
(1386, 'Nå angrer Chelsea på hvordan de behandlet Clattenburg', 'Møtte Premier League-dommerne i dag.', 'http://www.dagbladet.no/2012/11/27/sport/fotball/premier_league/mark_clattenburg/chelsea/24572803/', '', '2012-11-27 18:53:00', 'http://www.dagbladet.no/2012/11/27/sport/fotball/premier_league/mark_clattenburg/chelsea/24572803/'),
(1387, '- Jeg synes bare det er helt sjukt', 'Sportssjefen i Sykkelforbundet opprørt over at en mosjonsutøver er koblet til en bloddopingsak.', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/doping/tollvesenet/sykling/24562984/', '', '2012-11-27 19:09:00', 'http://www.dagbladet.no/2012/11/27/nyheter/innenriks/doping/tollvesenet/sykling/24562984/'),
(1388, 'Telenor-kunder klager på dårlig Netflix-kvalitet', '<p> Mange opplever kornete bilde når de ser film på Netflix. Men det skyldes ikke en dårlig tjeneste, bare dårlig samarbeid med Telenor. </p><img width=''1'' height=''1'' src=''http://dn.no.feedsportal.com/c/33154/f/538612/s/2604da00/mf.gif'' border=''0''/><div class=''mf-viral''><table border=''0''><tr><td valign=''middle''><a href="http://share.feedsportal.com/viral/sendEmail.cfm?lang=en&title=Telenor-kunder+klager+p%C3%A5+d%C3%A5rlig+Netflix-kvalitet&link=http%3A%2F%2Fwww.dagensit.no%2Farticle2515911.ece" target="_blank"><img src="http://res3.feedsportal.com/images/emailthis2.gif" border="0" /></a></td><td valign=''middle''><a href="http://res.feedsportal.com/viral/bookmark.cfm?title=Telenor-kunder+klager+p%C3%A5+d%C3%A5rlig+Netflix-kvalitet&link=http%3A%2F%2Fwww.dagensit.no%2Farticle2515911.ece" target="_blank"><img src="http://res3.feedsportal.com/images/bookmark.gif" border="0" /></a></td></tr></table></div>', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2604da00/l/0L0Sdagensit0Bno0Carticle25159110Bece/story01.htm', 'Magnus Eidem', '2012-11-27 18:05:47', 'http://dn.no.feedsportal.com/c/33154/f/538612/s/2604da00/l/0L0Sdagensit0Bno0Carticle25159110Bece/story01.htm'),
(1389, 'Minst 12 drept av bilbomber i Irak', 'Angrepsbølge mot sjiamuslimer.', 'http://www.dagbladet.no/2012/11/27/nyheter/krig_og_konflikter/utenriks/irak/24573231/', '', '2012-11-27 18:51:00', 'http://www.dagbladet.no/2012/11/27/nyheter/krig_og_konflikter/utenriks/irak/24573231/'),
(1390, 'Gasslekkasje forårsaket dødsbrann i Tyskland ', '(VG Nett) Det var lekkasjer fra en ovn som startet den tragiske verkstedbrannen, som kostet 14 mennesker livet sørvest i Tyskland. ', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048306', '', '2012-11-27 19:22:00', 'http://www.vg.no/nyheter/utenriks/artikkel.php?artid=10048306'),
(1391, '35 må gå i Dagbladet', 'For å spare penger til digital satsing.', 'http://www.dagbladet.no/2012/11/27/kultur/dagbladet/aviser/tv_og_medier/medier/24569679/', '', '2012-11-27 19:03:00', 'http://www.dagbladet.no/2012/11/27/kultur/dagbladet/aviser/tv_og_medier/medier/24569679/');

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE IF NOT EXISTS `News` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `desc` text NOT NULL,
  `link` text NOT NULL,
  `auther` text NOT NULL,
  `guid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news_category`
--

CREATE TABLE IF NOT EXISTS `news_category` (
  `news_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`news_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news_category`
--

INSERT INTO `news_category` (`news_id`, `category_id`) VALUES
(1223, 1),
(1224, 1),
(1225, 1),
(1226, 1),
(1227, 1),
(1228, 1),
(1229, 1),
(1230, 1),
(1231, 1),
(1232, 1),
(1348, 1),
(1389, 1),
(1233, 2),
(1234, 2),
(1235, 2),
(1236, 2),
(1237, 2),
(1238, 2),
(1239, 2),
(1240, 2),
(1241, 2),
(1242, 2),
(1243, 2),
(1244, 2),
(1245, 2),
(1246, 2),
(1247, 2),
(1248, 2),
(1249, 2),
(1250, 2),
(1251, 2),
(1252, 2),
(1347, 2),
(1349, 2),
(1350, 2),
(1351, 2),
(1352, 2),
(1353, 2),
(1354, 2),
(1360, 2),
(1361, 2),
(1365, 2),
(1366, 2),
(1368, 2),
(1369, 2),
(1371, 2),
(1372, 2),
(1373, 2),
(1374, 2),
(1375, 2),
(1380, 2),
(1381, 2),
(1383, 2),
(1384, 2),
(1385, 2),
(1387, 2),
(1390, 2),
(1253, 3),
(1254, 3),
(1255, 3),
(1256, 3),
(1257, 3),
(1258, 3),
(1259, 3),
(1260, 3),
(1261, 3),
(1262, 3),
(1263, 3),
(1264, 3),
(1265, 3),
(1266, 3),
(1267, 3),
(1268, 3),
(1269, 3),
(1270, 3),
(1355, 3),
(1356, 3),
(1362, 3),
(1386, 3),
(1272, 5),
(1274, 6),
(1275, 6),
(1276, 6),
(1358, 6),
(1370, 6),
(1382, 6),
(1279, 8),
(1280, 8),
(1281, 9),
(1282, 10),
(1283, 10),
(1284, 10),
(1285, 10),
(1287, 12),
(1288, 12),
(1290, 12),
(1291, 12),
(1292, 12),
(1293, 12),
(1296, 12),
(1297, 12),
(1298, 12),
(1299, 12),
(1300, 12),
(1301, 12),
(1302, 12),
(1303, 12),
(1304, 12),
(1305, 12),
(1306, 12),
(1307, 12),
(1308, 12),
(1309, 12),
(1310, 12),
(1311, 12),
(1312, 12),
(1313, 12),
(1314, 12),
(1315, 12),
(1357, 12),
(1376, 12),
(1377, 12),
(1316, 13),
(1363, 13),
(1391, 13),
(1317, 16),
(1318, 16),
(1319, 16),
(1320, 16),
(1321, 18),
(1322, 18),
(1323, 18),
(1325, 18),
(1326, 18),
(1327, 18),
(1328, 18),
(1329, 18),
(1330, 18),
(1331, 18),
(1332, 18),
(1333, 18),
(1334, 18),
(1335, 18),
(1336, 18),
(1337, 18),
(1338, 18),
(1339, 18),
(1340, 18),
(1341, 18),
(1342, 18),
(1343, 18),
(1344, 18),
(1359, 18),
(1364, 18),
(1367, 18),
(1378, 18),
(1379, 18),
(1388, 18),
(1346, 22);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) CHARACTER SET latin1 NOT NULL,
  `given_name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `additional_name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `family_name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` set('Male','Female','Unknown') CHARACTER SET latin1 DEFAULT NULL,
  `password` char(40) CHARACTER SET latin1 NOT NULL,
  `register_date` datetime NOT NULL,
  `last_login_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `number_of_logins` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) CHARACTER SET latin1 NOT NULL,
  `php_session_id` varchar(32) CHARACTER SET latin1 NOT NULL,
  `user_did_logout` tinyint(1) NOT NULL DEFAULT '1',
  `group` enum('User','Admin','Moderator') CHARACTER SET latin1 NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `given_name`, `additional_name`, `family_name`, `email`, `birthday`, `gender`, `password`, `register_date`, `last_login_date`, `number_of_logins`, `ip`, `php_session_id`, `user_did_logout`, `group`) VALUES
(8, 'username', 'Ola', '', 'Norman', 'ola.nordmann@epost.no', '2012-05-01', 'Male', '', '2012-11-21 20:29:19', '2012-11-27 21:30:01', 21, '158.39.125.20', '', 0, 'User'),



-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE IF NOT EXISTS `user_category` (
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`category_id`),
  KEY `user_category_ibfk_2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_category`
--

INSERT INTO `user_category` (`user_id`, `category_id`) VALUES
(8, 1),
(12, 1),
(10, 2),
(12, 2),
(10, 3),
(12, 3),
(12, 4),
(12, 5),
(10, 6),
(12, 6),
(12, 7),
(10, 8),
(12, 8),
(8, 9),
(12, 9),
(1, 10),
(12, 10),
(12, 11),
(8, 12),
(12, 12),
(1, 13),
(8, 13),
(12, 13),
(12, 14),
(1, 15),
(12, 15),
(12, 16),
(1, 18),
(8, 18),
(12, 18),
(12, 19),
(12, 20),
(12, 21),
(12, 22),
(12, 23);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `keyword`
--
ALTER TABLE `keyword`
  ADD CONSTRAINT `keyword_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `news_category`
--
ALTER TABLE `news_category`
  ADD CONSTRAINT `news_category_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `news_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `user_category`
--
ALTER TABLE `user_category`
  ADD CONSTRAINT `user_category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
