-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 28 avr. 2022 à 10:36
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tretrelo`
--

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `id_projet_projet` int(11) NOT NULL AUTO_INCREMENT,
  `nom_projet` varchar(80) DEFAULT NULL,
  `date_creation_projet` date DEFAULT NULL,
  `description_projet` varchar(255) DEFAULT NULL,
  `terminer_projet` tinyint(1) DEFAULT NULL,
  `id_utilisateur_utilisateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_projet_projet`),
  KEY `FK_projet_id_utilisateur_utilisateur` (`id_utilisateur_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_projet_id_utilisateur_utilisateur` FOREIGN KEY (`id_utilisateur_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
