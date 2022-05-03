-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 mai 2022 à 15:29
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
-- Base de données : `tretrello`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie_categories` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categories` varchar(80) DEFAULT NULL,
  `ordre` int(255) NOT NULL,
  `id_projet_projet` int(11) DEFAULT NULL,
  `id_utilisateur_utilisateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_categorie_categories`),
  KEY `FK_categories_id_projet_projet` (`id_projet_projet`),
  KEY `FK_categories_id_utilisateur_utilisateur` (`id_utilisateur_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaire_commentaires` int(11) NOT NULL AUTO_INCREMENT,
  `date_commentaires` date DEFAULT NULL,
  `texte_commentaires` varchar(255) DEFAULT NULL,
  `id_utilisateur_utilisateur` int(11) DEFAULT NULL,
  `id_taches_taches` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_commentaire_commentaires`),
  KEY `FK_commentaires_id_utilisateur_utilisateur` (`id_utilisateur_utilisateur`),
  KEY `FK_commentaires_id_taches_taches` (`id_taches_taches`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `id_fichier_fichiers` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fichiers` varchar(255) DEFAULT NULL,
  `user_nom_fichier` varchar(255) DEFAULT NULL,
  `date_fichiers` date DEFAULT NULL,
  `id_taches_taches` int(11) DEFAULT NULL,
  `id_utilisateur_utilisateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fichier_fichiers`),
  KEY `FK_fichiers_id_taches_taches` (`id_taches_taches`),
  KEY `FK_fichiers_id_utilisateur_utilisateur` (`id_utilisateur_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

DROP TABLE IF EXISTS `taches`;
CREATE TABLE IF NOT EXISTS `taches` (
  `id_taches_taches` int(11) NOT NULL AUTO_INCREMENT,
  `nom_taches` varchar(80) DEFAULT NULL,
  `date_taches` date DEFAULT NULL,
  `description_taches` varchar(255) DEFAULT NULL,
  `duree_taches` int(11) DEFAULT NULL,
  `id_categorie_categories` int(11) DEFAULT NULL,
  `id_utilisateur_utilisateur` int(11) DEFAULT NULL,
  `id_projet_projet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_taches_taches`),
  KEY `FK_taches_id_categorie_categories` (`id_categorie_categories`),
  KEY `FK_taches_id_utilisateur_utilisateur` (`id_utilisateur_utilisateur`),
  KEY `FK_taches_id_projet_projet` (`id_projet_projet`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `mail_utilisateur` varchar(60) DEFAULT NULL,
  `password_utilisateur` varchar(255) DEFAULT NULL,
  `nom_utilisateur` varchar(50) DEFAULT NULL,
  `prenom_utilisateur` varchar(50) DEFAULT NULL,
  `photo_utilisateur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FK_categories_id_projet_projet` FOREIGN KEY (`id_projet_projet`) REFERENCES `projet` (`id_projet_projet`),
  ADD CONSTRAINT `FK_categories_id_utilisateur_utilisateur` FOREIGN KEY (`id_utilisateur_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur_utilisateur`);

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `FK_commentaires_id_taches_taches` FOREIGN KEY (`id_taches_taches`) REFERENCES `taches` (`id_taches_taches`),
  ADD CONSTRAINT `FK_commentaires_id_utilisateur_utilisateur` FOREIGN KEY (`id_utilisateur_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur_utilisateur`);

--
-- Contraintes pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD CONSTRAINT `FK_fichiers_id_taches_taches` FOREIGN KEY (`id_taches_taches`) REFERENCES `taches` (`id_taches_taches`),
  ADD CONSTRAINT `FK_fichiers_id_utilisateur_utilisateur` FOREIGN KEY (`id_utilisateur_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur_utilisateur`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_projet_id_utilisateur_utilisateur` FOREIGN KEY (`id_utilisateur_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur_utilisateur`);

--
-- Contraintes pour la table `taches`
--
ALTER TABLE `taches`
  ADD CONSTRAINT `FK_taches_id_categorie_categories` FOREIGN KEY (`id_categorie_categories`) REFERENCES `categories` (`id_categorie_categories`),
  ADD CONSTRAINT `FK_taches_id_projet_projet` FOREIGN KEY (`id_projet_projet`) REFERENCES `projet` (`id_projet_projet`),
  ADD CONSTRAINT `FK_taches_id_utilisateur_utilisateur` FOREIGN KEY (`id_utilisateur_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
