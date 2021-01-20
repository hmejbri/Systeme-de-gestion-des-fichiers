-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 sep. 2020 à 15:55
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sna`
--

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

CREATE TABLE `fichiers` (
  `idFichier` int(11) NOT NULL,
  `nomFichier` varchar(45) NOT NULL,
  `DatePub` datetime DEFAULT NULL,
  `DateModif` datetime DEFAULT NULL,
  `emplacement` varchar(50) NOT NULL,
  `etat` enum('attente','validé','refusé','') NOT NULL,
  `commentaire` text DEFAULT NULL,
  `type` enum('flash','tableau de bord','','') DEFAULT NULL,
  `nomService` varchar(20) DEFAULT NULL,
  `cin` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

CREATE TABLE `login` (
  `cin` varchar(8) NOT NULL,
  `mdp` varchar(45) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `droit` char(1) DEFAULT NULL,
  `nomService` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`cin`, `mdp`, `nom`, `prenom`, `droit`, `nomService`) VALUES
('admin', 'P@ssw0rd', 'Administrateur', '', 'a', 'Achat,Marketing,');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `nomService` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`nomService`) VALUES
('Achat'),
('Comex'),
('Commercial'),
('Comptabilité'),
('Controle de gestion'),
('Engagement Client'),
('Force de vente'),
('GRH'),
('Informatique'),
('Laboratoire'),
('Marketing'),
('Nutrition'),
('Standard'),
('Stock'),
('Technique'),
('Transpool'),
('Trésorie');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD PRIMARY KEY (`idFichier`),
  ADD KEY `fk_nomService1` (`nomService`),
  ADD KEY `fk_cin1` (`cin`);

--
-- Index pour la table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`cin`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`nomService`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `fichiers`
--
ALTER TABLE `fichiers`
  MODIFY `idFichier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD CONSTRAINT `fk_cin1` FOREIGN KEY (`cin`) REFERENCES `login` (`cin`),
  ADD CONSTRAINT `fk_nomService1` FOREIGN KEY (`nomService`) REFERENCES `services` (`nomService`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
