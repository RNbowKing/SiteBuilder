-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 20 mars 2019 à 18:35
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sitebuilder`
--

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_adherents`
--

DROP TABLE IF EXISTS `sitebuilder_adherents`;
CREATE TABLE IF NOT EXISTS `sitebuilder_adherents` (
  `idAdherent` int(11) NOT NULL AUTO_INCREMENT,
  `nomAdherent` text NOT NULL,
  `prenomAdherent` text NOT NULL,
  `mdpAdherent` text NOT NULL,
  `emailAdherent` varchar(320) NOT NULL,
  `adresseAdherent` text,
  `journalParMail` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAdherent`),
  UNIQUE KEY `emailAdherent` (`emailAdherent`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_adherents`
--

INSERT INTO `sitebuilder_adherents` (`idAdherent`, `nomAdherent`, `prenomAdherent`, `mdpAdherent`, `emailAdherent`, `adresseAdherent`, `journalParMail`) VALUES
(1, 'Dupont', 'Jean', '$2y$10$UlIBJZq8741Utaia2OT4sORdZ8c0jq2szdmGZjdh8xMvSDX4b9.y2', 'jean.dupont@example.com', '14, rue de la fibre optique\r\nLieu-dit ADSL\r\n05948 INTERNET', 0);

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_footerlinks`
--

DROP TABLE IF EXISTS `sitebuilder_footerlinks`;
CREATE TABLE IF NOT EXISTS `sitebuilder_footerlinks` (
  `linkID` int(11) NOT NULL AUTO_INCREMENT,
  `linkText` text NOT NULL,
  `linkURL` text NOT NULL,
  PRIMARY KEY (`linkID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_footerlinks`
--

INSERT INTO `sitebuilder_footerlinks` (`linkID`, `linkText`, `linkURL`) VALUES
(7, 'Ville de BesanÃ§on', 'http://www.besancon.fr/');

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_generalsettings`
--

DROP TABLE IF EXISTS `sitebuilder_generalsettings`;
CREATE TABLE IF NOT EXISTS `sitebuilder_generalsettings` (
  `settingName` varchar(10) NOT NULL,
  `settingValue` text NOT NULL,
  PRIMARY KEY (`settingName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_generalsettings`
--

INSERT INTO `sitebuilder_generalsettings` (`settingName`, `settingValue`) VALUES
('Copyright', 'Â© 2018, Quentin Pugeat'),
('FBLink', 'https://www.facebook.com/SmartNetApps'),
('headerImg', 'img/header.jpg'),
('IGLink', 'https://www.instagram.com/smartnetapps'),
('mdpAdh', '0123456'),
('rightPanel', '<p><b>Association de la Combe Saragosse</b></p><p>34 chemin de Vieilley, 25000 BesanÃ§on</p><p>Courriel : <a href=\"mailto:associationcombesaragosse@gmail.com\" target=\"_blank\">associationcombesaragosse@gmail.com</a><br></p><h6>Directeur de la publication : Patrick Richet, prÃ©sident.</h6><h6>ComitÃ© de rÃ©daction : Commission communication</h6>'),
('SiteTitle', 'Version de dÃ©monstration de Site Builder'),
('TWLink', 'https://twitter.com/SmartNetApps');

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_historique`
--

DROP TABLE IF EXISTS `sitebuilder_historique`;
CREATE TABLE IF NOT EXISTS `sitebuilder_historique` (
  `idHistorique` int(11) NOT NULL AUTO_INCREMENT,
  `dateHeureHistorique` datetime DEFAULT NULL,
  `nomAuteurHistorique` varchar(35) NOT NULL,
  `intituleHistorique` text NOT NULL,
  `niveauHistorique` varchar(7) NOT NULL,
  PRIMARY KEY (`idHistorique`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_historique`
--

INSERT INTO `sitebuilder_historique` (`idHistorique`, `dateHeureHistorique`, `nomAuteurHistorique`, `intituleHistorique`, `niveauHistorique`) VALUES
(8, '2018-11-08 16:27:55', 'quentinpugeat', 'A supprimÃ© une section, ID 10', 'warning'),
(9, '2018-11-08 16:28:06', 'quentinpugeat', 'A supprimÃ© une page, ID 14', 'warning'),
(10, '2018-11-08 16:28:34', 'quentinpugeat', 'A modifiÃ© l\'image du haut de page.', 'info'),
(11, '2018-11-08 16:30:05', 'AdhÃ©rent : Jean-FranÃ§ois CopÃ©', 'A crÃ©e son compte.', 'info'),
(12, '2018-11-08 16:30:22', 'AdhÃ©rent : Nadine Morano', 'A crÃ©e son compte.', 'info'),
(13, '2018-11-08 16:31:17', 'AdhÃ©rent : Emmanuel Macron', 'A crÃ©e son compte.', 'info'),
(14, '2018-11-08 16:31:38', 'AdhÃ©rent : Manuel Valls', 'A crÃ©e son compte.', 'info'),
(15, '2018-11-08 16:32:56', 'AdhÃ©rent : ValÃ©rie PÃ©cresse', 'A crÃ©e son compte.', 'info'),
(16, '2018-11-08 16:33:40', 'AdhÃ©rent : Nicolas Dupont-Aignan', 'A crÃ©e son compte.', 'info'),
(17, '2018-11-08 16:39:13', 'root', 'A crÃ©e une newsletter : L\'Ã‰cho de la Combe - numÃ©ro 130', 'success'),
(18, '2018-11-08 16:47:14', 'root', 'A modifiÃ© les paramÃ¨tres d\'accÃ¨s adhÃ©rents.', 'warning'),
(19, '2018-11-08 16:48:50', 'root', 'Tentative de connexion infructueuse (mot de passe incorrect)', 'danger'),
(20, '2018-11-12 08:06:54', 'quentinpugeat', 'Tentative de modification de profil infructueuse (mot de passe incorrect)', 'danger'),
(21, '2018-11-12 08:28:31', 'quentinpugeat', 'A modifiÃ© la page ID 8', 'info'),
(22, '2018-11-12 08:29:04', 'quentinpugeat', 'A ajoutÃ© la page Titre d\'une actualitÃ© publique', 'success'),
(23, '2018-11-12 08:29:36', 'quentinpugeat', 'A ajoutÃ© la page Exemple de page indisponible', 'success'),
(24, '2018-11-12 09:56:26', 'quentinpugeat', 'A modifiÃ© le titre du site.', 'warning'),
(25, '2018-11-12 09:56:26', 'quentinpugeat', 'A modifiÃ© le lien Facebook.', 'warning'),
(26, '2018-11-12 09:56:26', 'quentinpugeat', 'A modifiÃ© le lien Twitter.', 'warning'),
(27, '2018-11-12 09:56:26', 'quentinpugeat', 'A modifiÃ© le lien Instagram.', 'warning'),
(28, '2018-11-12 09:56:27', 'quentinpugeat', 'A modifiÃ© la mention Copyright.', 'warning'),
(29, '2018-11-12 09:56:40', 'quentinpugeat', 'A modifiÃ© le titre du site.', 'warning'),
(30, '2018-11-12 09:56:41', 'quentinpugeat', 'A modifiÃ© le lien Facebook.', 'warning'),
(31, '2018-11-12 09:56:41', 'quentinpugeat', 'A modifiÃ© le lien Twitter.', 'warning'),
(32, '2018-11-12 09:56:41', 'quentinpugeat', 'A modifiÃ© le lien Instagram.', 'warning'),
(33, '2018-11-12 09:56:41', 'quentinpugeat', 'A modifiÃ© la mention Copyright.', 'warning'),
(34, '2018-11-12 09:57:19', 'quentinpugeat', 'A modifiÃ© le titre du site.', 'warning'),
(35, '2018-11-12 09:57:19', 'quentinpugeat', 'A modifiÃ© le lien Facebook.', 'warning'),
(36, '2018-11-12 09:57:19', 'quentinpugeat', 'A modifiÃ© le lien Twitter.', 'warning'),
(37, '2018-11-12 09:57:19', 'quentinpugeat', 'A modifiÃ© le lien Instagram.', 'warning'),
(38, '2018-11-12 09:57:19', 'quentinpugeat', 'A modifiÃ© la mention Copyright.', 'warning'),
(39, '2018-11-12 09:58:29', 'quentinpugeat', 'A modifiÃ© le titre du site.', 'warning'),
(40, '2018-11-12 09:58:29', 'quentinpugeat', 'A modifiÃ© le lien Facebook.', 'warning'),
(41, '2018-11-12 09:58:29', 'quentinpugeat', 'A modifiÃ© le lien Twitter.', 'warning'),
(42, '2018-11-12 09:58:29', 'quentinpugeat', 'A modifiÃ© le lien Instagram.', 'warning'),
(43, '2018-11-12 09:58:30', 'quentinpugeat', 'A modifiÃ© la mention Copyright.', 'warning'),
(44, '2018-11-12 10:01:07', 'quentinpugeat', 'A modifiÃ© le titre du site.', 'warning'),
(45, '2018-11-12 10:01:07', 'quentinpugeat', 'A modifiÃ© le lien Facebook.', 'warning'),
(46, '2018-11-12 10:01:07', 'quentinpugeat', 'A modifiÃ© le lien Twitter.', 'warning'),
(47, '2018-11-12 10:01:07', 'quentinpugeat', 'A modifiÃ© le lien Instagram.', 'warning'),
(48, '2018-11-12 10:01:08', 'quentinpugeat', 'A modifiÃ© la mention Copyright.', 'warning'),
(49, '2018-11-14 07:46:34', 'quentinpugeat', 'A modifiÃ© l\'image du haut de page.', 'info'),
(50, '2018-12-12 08:01:19', 'root', 'A supprimÃ© le compte adhÃ©rent de : Jean-FranÃ§ois CopÃ©', 'warning'),
(51, '2018-12-12 08:01:22', 'root', 'A supprimÃ© le compte adhÃ©rent de : Nadine Morano', 'warning'),
(52, '2018-12-12 08:01:27', 'root', 'A supprimÃ© le compte adhÃ©rent de : Emmanuel Macron', 'warning'),
(53, '2018-12-12 08:01:30', 'root', 'A supprimÃ© le compte adhÃ©rent de : Manuel Valls', 'warning'),
(54, '2018-12-12 08:01:33', 'root', 'A supprimÃ© le compte adhÃ©rent de : ValÃ©rie PÃ©cresse', 'warning'),
(55, '2018-12-12 08:01:37', 'root', 'A supprimÃ© le compte adhÃ©rent de : Nicolas Dupont-Aignan', 'warning'),
(56, '2018-12-12 08:03:14', 'root', 'A modifiÃ© le nom d\'utilisateur de petitredacteur', 'warning'),
(57, '2018-12-12 08:03:14', 'root', 'A modifiÃ© le mot de passe de petitredacteur', 'warning'),
(58, '2018-12-12 08:03:24', 'root', 'A modifiÃ© le mot de passe de quentinpugeat', 'warning'),
(59, '2019-03-20 17:29:55', 'root', 'A changé le mot de passe de l\'adhérent : Quentin Pugeat', 'warning'),
(60, '2019-03-20 17:30:29', 'Adhérent : Quentin Pugeat', 'A modifié son adresse e-mail.', 'warning'),
(61, '2019-03-20 17:30:41', 'Adhérent : Jean Dupont', 'A modifié son identité.', 'info'),
(62, '2019-03-20 18:17:10', 'root', 'A modifiÃ© l\'image du haut de page.', 'info'),
(63, '2019-03-20 18:18:06', 'root', 'A modifiÃ© l\'image du haut de page.', 'info'),
(64, '2019-03-20 18:19:25', 'root', 'A modifiÃ© le titre du site.', 'warning'),
(65, '2019-03-20 18:19:25', 'root', 'A modifiÃ© le lien Facebook.', 'warning'),
(66, '2019-03-20 18:19:25', 'root', 'A modifiÃ© le lien Twitter.', 'warning'),
(67, '2019-03-20 18:19:25', 'root', 'A modifiÃ© le lien Instagram.', 'warning'),
(68, '2019-03-20 18:19:25', 'root', 'A modifiÃ© la mention Copyright.', 'warning');

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_newsletters`
--

DROP TABLE IF EXISTS `sitebuilder_newsletters`;
CREATE TABLE IF NOT EXISTS `sitebuilder_newsletters` (
  `NewsletterID` int(11) NOT NULL AUTO_INCREMENT,
  `NewsletterTitle` text NOT NULL,
  `NewsletterDateTime` datetime NOT NULL,
  `NewsletterAuthor` varchar(35) NOT NULL,
  `NewsletterContent` text NOT NULL,
  `isSent` tinyint(1) NOT NULL,
  PRIMARY KEY (`NewsletterID`),
  KEY `NewsletterAuthor` (`NewsletterAuthor`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_newsletters`
--

INSERT INTO `sitebuilder_newsletters` (`NewsletterID`, `NewsletterTitle`, `NewsletterDateTime`, `NewsletterAuthor`, `NewsletterContent`, `isSent`) VALUES
(10, 'L\'Ã‰cho de la Combe - numÃ©ro 130', '2018-11-08 16:39:13', 'root', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_pages`
--

DROP TABLE IF EXISTS `sitebuilder_pages`;
CREATE TABLE IF NOT EXISTS `sitebuilder_pages` (
  `idPage` int(11) NOT NULL AUTO_INCREMENT,
  `TitrePage` text NOT NULL,
  `ContenuPage` text NOT NULL,
  `nomAuteur` varchar(35) DEFAULT NULL,
  `dateHeureCreation` datetime DEFAULT NULL,
  `NumSection` int(11) NOT NULL,
  `AfficherPage` tinyint(1) NOT NULL,
  `reserveAdherents` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPage`),
  KEY `FK_pages_sections` (`NumSection`),
  KEY `nomAuteur` (`nomAuteur`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_pages`
--

INSERT INTO `sitebuilder_pages` (`idPage`, `TitrePage`, `ContenuPage`, `nomAuteur`, `dateHeureCreation`, `NumSection`, `AfficherPage`, `reserveAdherents`) VALUES
(1, 'Accueil', '<h2>Bienvenue !</h2><h3>Ceci est le site internet de la maison de quartier.</h3><p><br></p><p>Ce site internet est encore <b>en cours de construction </b>et peut contenir des <b><span style=\"background-color: rgb(255, 255, 0);\">informations erronÃ©es et/ou Ã©tranges</span></b>.</p>', 'quentinpugeat', '2018-09-19 00:00:00', 0, 1, 0),
(4, 'PrÃ©sentation', '<p>L\'association de la Combe Saragosse a pour objectif de...</p><p>Elle est organisatrice de...<br></p>', 'quentinpugeat', '2018-09-19 00:00:00', 2, 1, 0),
(7, 'Manifestation du 23 fÃ©vrier 2012', 'Photos.<br>', 'quentinpugeat', '2018-09-19 00:00:00', 4, 1, 0),
(8, 'Titre d\'une actualitÃ© privÃ©e', 'InsÃ©rer l\'intitulÃ© !<br>', 'quentinpugeat', '2018-09-19 00:00:00', 3, 1, 1),
(13, 'FÃªte de ... le 15 novembre', '<h3><b>LIEU</b></h3><p><span style=\"background-color: rgb(255, 255, 0);\">Date</span></p><h2><u>Nom de la fÃªte</u></h2><p>Descriptif</p><p>Photos<br></p>', 'quentinpugeat', '2018-09-27 07:16:45', 9, 1, 0),
(14, 'Titre d\'une actualitÃ© publique', '(Contenu de la page)<br>', 'quentinpugeat', '2018-11-12 08:29:04', 3, 1, 0),
(15, 'Exemple de page indisponible', '<p>Si cette page s\'affiche, cela signifie que le code de Pugeat ne fonctionne pas correctement !<br></p>', 'quentinpugeat', '2018-11-12 08:29:36', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_sections`
--

DROP TABLE IF EXISTS `sitebuilder_sections`;
CREATE TABLE IF NOT EXISTS `sitebuilder_sections` (
  `NumSection` int(11) NOT NULL AUTO_INCREMENT,
  `NomSection` text NOT NULL,
  `reserveAdherents` tinyint(1) NOT NULL,
  PRIMARY KEY (`NumSection`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_sections`
--

INSERT INTO `sitebuilder_sections` (`NumSection`, `NomSection`, `reserveAdherents`) VALUES
(2, 'L\'association', 0),
(3, 'ActualitÃ©', 0),
(4, 'Photos', 1),
(9, 'Agenda', 0);

-- --------------------------------------------------------

--
-- Structure de la table `sitebuilder_utilisateurs`
--

DROP TABLE IF EXISTS `sitebuilder_utilisateurs`;
CREATE TABLE IF NOT EXISTS `sitebuilder_utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `loginUtilisateur` varchar(35) NOT NULL,
  `mdpUtilisateur` text NOT NULL,
  `estAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUtilisateur`),
  UNIQUE KEY `loginUtilisateur` (`loginUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sitebuilder_utilisateurs`
--

INSERT INTO `sitebuilder_utilisateurs` (`idUtilisateur`, `loginUtilisateur`, `mdpUtilisateur`, `estAdmin`) VALUES
(1, 'root', '$2y$10$WajgO0vpAKE7Y6VnDmiDtOp.2E25b/xIeoko6U5BctT91denhNUmC', 1),
(2, 'quentinpugeat', '$2y$10$SomN8aYMvArs31962rI.huGXlxyV.zjxUVB7WRCLnQma1oV5w.lBi', 1),
(3, 'petitredacteur', '$2y$10$ckHCl.m3mAd3Tj/hYY21J.15SEnfIlvcGZf4xOJihpgh22ry0MkLi', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `sitebuilder_newsletters`
--
ALTER TABLE `sitebuilder_newsletters`
  ADD CONSTRAINT `sitebuilder_newsletters_ibfk_1` FOREIGN KEY (`NewsletterAuthor`) REFERENCES `sitebuilder_utilisateurs` (`loginUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sitebuilder_pages`
--
ALTER TABLE `sitebuilder_pages`
  ADD CONSTRAINT `sitebuilder_pages_ibfk_1` FOREIGN KEY (`nomAuteur`) REFERENCES `sitebuilder_utilisateurs` (`loginUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
