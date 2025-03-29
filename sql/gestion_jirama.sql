-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 24 mars 2025 à 20:08
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_jirama`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `CodeCli` varchar(10) NOT NULL,
  `Nom` varchar(15) NOT NULL,
  `Prenom` varchar(15) NOT NULL,
  `Sexe` enum('MASCULIN','FEMININ') DEFAULT NULL,
  `Quartier` varchar(15) NOT NULL,
  `Niveau` enum('VIP','FIDELE','REGULIER','NOUVEAU') DEFAULT NULL,
  `Mail` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

CREATE TABLE `compteur` (
  `CodeCompteur` varchar(10) NOT NULL,
  `CodeCli` varchar(10) NOT NULL,
  `Type` enum('ELECTRICTE','EAU') NOT NULL,
  `Pu` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payer`
--

CREATE TABLE `payer` (
  `Idpaye` varchar(10) NOT NULL,
  `CodeCli` varchar(10) NOT NULL,
  `Date_paiement` date NOT NULL,
  `Montant` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `releve`
--

CREATE TABLE `releve` (
  `CodeReleve` varchar(10) NOT NULL,
  `CodeCompteur` varchar(10) NOT NULL,
  `Valeur` int(3) NOT NULL,
  `Date_releve` date NOT NULL,
  `Date_presentation` date DEFAULT NULL,
  `Date_limite_paiement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`CodeCli`);

--
-- Index pour la table `compteur`
--
ALTER TABLE `compteur`
  ADD PRIMARY KEY (`CodeCompteur`),
  ADD KEY `CodeCli` (`CodeCli`);

--
-- Index pour la table `payer`
--
ALTER TABLE `payer`
  ADD PRIMARY KEY (`Idpaye`),
  ADD KEY `CodeCli` (`CodeCli`);

--
-- Index pour la table `releve`
--
ALTER TABLE `releve`
  ADD PRIMARY KEY (`CodeReleve`),
  ADD KEY `CodeCompteur` (`CodeCompteur`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `compteur`
--
ALTER TABLE `compteur`
  ADD CONSTRAINT `compteur_ibfk_1` FOREIGN KEY (`CodeCli`) REFERENCES `client` (`CodeCli`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payer`
--
ALTER TABLE `payer`
  ADD CONSTRAINT `payer_ibfk_1` FOREIGN KEY (`CodeCli`) REFERENCES `client` (`CodeCli`) ON DELETE CASCADE;

--
-- Contraintes pour la table `releve`
--
ALTER TABLE `releve`
  ADD CONSTRAINT `releve_ibfk_1` FOREIGN KEY (`CodeCompteur`) REFERENCES `compteur` (`CodeCompteur`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
