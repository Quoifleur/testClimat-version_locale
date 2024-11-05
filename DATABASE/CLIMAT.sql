-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : testcljclimat.mysql.db
-- Généré le : dim. 27 oct. 2024 à 19:42
-- Version du serveur : 8.0.37-29
-- Version de PHP : 8.1.29
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `testcljclimat`
--
-- --------------------------------------------------------
--
-- Structure de la table `CLIMAT`
--
CREATE TABLE
  `climat` (
    `id` int (10) UNSIGNED NOT NULL,
    `COMPTEclef` varchar(64) DEFAULT NULL,
    `COMPTEvisibilite` tinyint (1) DEFAULT '0',
    `AC` varchar(32) DEFAULT NULL,
    `SAVE` int (11) DEFAULT NULL,
    `RAM` int (11) DEFAULT NULL,
    `DATEcollecte` year (4) DEFAULT '0000',
    `DATEentre` date DEFAULT NULL,
    `TEMPORALITEperiode` varchar(9) DEFAULT NULL,
    `TEMPORALITEmois` varchar(128) DEFAULT NULL,
    `TEMPORALITEsaison` varchar(24) DEFAULT NULL,
    `NOMlocalisation` varchar(255) DEFAULT NULL,
    `NOMgenerique` varchar(255) DEFAULT NULL,
    `POSITIONhemisphere` varchar(8) DEFAULT NULL,
    `POSITIONx` decimal(20, 10) DEFAULT NULL,
    `POSITIONy` decimal(20, 10) DEFAULT NULL,
    `POSITIONz` decimal(20, 10) DEFAULT NULL,
    `NORMALEte` varchar(256) DEFAULT NULL,
    `NORMALEpr` varchar(256) DEFAULT NULL,
    `NORMALE2` varchar(256) DEFAULT NULL,
    `NORMALE3` varchar(256) DEFAULT NULL,
    `NORMALE4` varchar(256) DEFAULT NULL,
    `RESULTATkoge` varchar(256) DEFAULT NULL,
    `RESULTATgaus` varchar(256) DEFAULT NULL,
    `RESULTATmart` varchar(256) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `CLIMAT`
--
--
-- Index pour les tables déchargées
--
--
-- Index pour la table `CLIMAT`
--
ALTER TABLE `CLIMAT` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--
--
-- AUTO_INCREMENT pour la table `CLIMAT`
--
ALTER TABLE `CLIMAT` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 12;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;