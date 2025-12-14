-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 13 déc. 2025 à 16:01
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
-- Base de données : `sae3012`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `IdCat` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `imgSrcCat` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`IdCat`, `nom`, `description`, `imgSrcCat`) VALUES
(1, 'jeux video', 'Catégorie consacrée aux jeux vidéo', ''),
(2, 'musique', 'Tout ce qui concerne la musique', ''),
(3, 'films', 'Cinéma', ''),
(4, 'livres', 'Discussions autour des livres', ''),
(5, 'sport', 'Actualités et discussions sportives', ''),
(6, 'peinture et dessin', 'Arts visuels : peinture et dessin', ''),
(7, 'photographie', 'Photographie et matériel photo', ''),
(8, 'series', 'Séries TV', '');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `IdComment` int(11) NOT NULL,
  `texte` text NOT NULL,
  `dateCom` datetime NOT NULL,
  `IdUser` int(11) NOT NULL,
  `IdMsg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `IdMsg` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `texte` text NOT NULL,
  `imageSrc` varchar(255) DEFAULT NULL,
  `nbrLike` int(11) DEFAULT 0,
  `nbrDislike` int(11) DEFAULT 0,
  `nbrCom` int(100) NOT NULL,
  `IdCat` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reaction`
--

CREATE TABLE `reaction` (
  `IdReact` int(11) NOT NULL,
  `IdType` int(11) NOT NULL,
  `IdMsg` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `IdType` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`IdType`, `nom`) VALUES
(1, 'like'),
(2, 'dislike');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `IdUser` int(11) NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `biographie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IdUser`, `identifiant`, `mdp`, `biographie`) VALUES
(1, 'test', 'test', NULL),
(2, 'cloclo', 'blabla', NULL),
(3, 'cloe', 'cloe', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`IdCat`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`IdComment`),
  ADD KEY `IdUser` (`IdUser`),
  ADD KEY `IdMsg` (`IdMsg`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`IdMsg`),
  ADD KEY `IdCat` (`IdCat`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Index pour la table `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`IdReact`),
  ADD KEY `IdType` (`IdType`),
  ADD KEY `IdMsg` (`IdMsg`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`IdType`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`IdUser`),
  ADD UNIQUE KEY `identifiant` (`identifiant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `IdCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `IdComment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `IdMsg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reaction`
--
ALTER TABLE `reaction`
  MODIFY `IdReact` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `IdType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `utilisateur` (`IdUser`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`IdMsg`) REFERENCES `message` (`IdMsg`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`IdCat`) REFERENCES `categorie` (`IdCat`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`IdUser`) REFERENCES `utilisateur` (`IdUser`);

--
-- Contraintes pour la table `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `reaction_ibfk_1` FOREIGN KEY (`IdType`) REFERENCES `type` (`IdType`),
  ADD CONSTRAINT `reaction_ibfk_2` FOREIGN KEY (`IdMsg`) REFERENCES `message` (`IdMsg`),
  ADD CONSTRAINT `reaction_ibfk_3` FOREIGN KEY (`IdUser`) REFERENCES `utilisateur` (`IdUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
