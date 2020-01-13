-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 13 jan. 2020 à 10:43
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `appconnect`
--

-- --------------------------------------------------------

--
-- Structure de la table `blablacar`
--

DROP TABLE IF EXISTS `blablacar`;
CREATE TABLE IF NOT EXISTS `blablacar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lieu` text NOT NULL,
  `email` text NOT NULL,
  `type` text NOT NULL,
  `heure` varchar(20) NOT NULL DEFAULT '8h00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `blablacar`
--

INSERT INTO `blablacar` (`id`, `lieu`, `email`, `type`, `heure`) VALUES
(1, 'Poitiers', 'menardisaac@gmail.com', 'Bus', '8h00'),
(2, 'JApon', 'isaac.menard', 'bus', '8h00'),
(3, 'rue', 'isaac.menard', 'vÃ©lo', '8h00'),
(4, 'JaunayCLan', 'isaac.menard', 'train ', '8h00'),
(5, 'ville', 'isaac.menard', 'voiture', '8h00'),
(6, 'rien', 'isaac.menard', 'rien', '8h00'),
(7, 'internat', 'isaac.menard', 'pied', '8h00'),
(8, 'choux', 'isaac.menard', 'lapin', '8h00'),
(9, 'vie', 'isaac.menard', 're', '8h00'),
(10, 'heuuu', 'isaac.menard', 'rere', '8h00'),
(11, 'JaunayCLan', 'isaac.menard', ' voiture', '8h00'),
(12, 'JaunayCLan', 'isaac.menard', ' voiture', '8h00'),
(13, 'JaunayCLan', 'isaac.menard', ' voiture', '8h00'),
(14, 'Chabournay', 'alain.tiery@lp2i-poitiers.fr', 'bus', '8h00'),
(15, 'Poitiers', 'nathalie.Poulain@lp2i-poitiers.fr', 'vélo', '8h00'),
(16, '', 'isaac.menard', '', '11:11'),
(17, 'Poitiers', 'isaac.menard', 'voiture', '08:20');

-- --------------------------------------------------------

--
-- Structure de la table `forumquestion`
--

DROP TABLE IF EXISTS `forumquestion`;
CREATE TABLE IF NOT EXISTS `forumquestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Repertoire` text NOT NULL,
  `Titre` text NOT NULL,
  `Question` text NOT NULL,
  `user` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `forumquestion`
--

INSERT INTO `forumquestion` (`id`, `Repertoire`, `Titre`, `Question`, `user`) VALUES
(1, 'idee', 'POURQUPO', 're', 'isaac.menard'),
(2, 'idee', 'Je pense que...', 'c\'est nul', 'isaac.menard'),
(3, 'idee', 'l\'avoine', 're', 'isaac.menard'),
(4, 'idee', 'l\"lol', 're', 'isaac.menard'),
(5, 'bug', 'Quand je fais ca', 'bahhh ca bug !!! nkjfbnksnbfvnznvkjnenvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv', 'isaac.menard'),
(6, 'bug', 'tadaaa', 'c\'est trop coool', 'isaac.menard');

-- --------------------------------------------------------

--
-- Structure de la table `forumreponse`
--

DROP TABLE IF EXISTS `forumreponse`;
CREATE TABLE IF NOT EXISTS `forumreponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text NOT NULL,
  `titre` text NOT NULL,
  `reponse` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `forumreponse`
--

INSERT INTO `forumreponse` (`id`, `user`, `titre`, `reponse`) VALUES
(1, 'isaac.menard', 'POURQUPO', 'je sais pas'),
(2, 'isaac.menard', 'Quand je fais ca', 'c\'est vrai ?'),
(3, 'isaac.menard', 'Quand je fais ca', 'nan');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(1000) NOT NULL,
  `mot_de_passe` varchar(1000) NOT NULL,
  `pdp` text,
  `division` text,
  `couple` text,
  `devise` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `mail`, `mot_de_passe`, `pdp`, `division`, `couple`, `devise`) VALUES
(1, 'isaac.menard', '$2y$12$lrVLgdkpOQNEGWrNCaDE1e7n.UYciJKYpGX2J64izs9JOyF3SdUyS', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
