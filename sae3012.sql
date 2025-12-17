-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql-free-message.alwaysdata.net
-- Generation Time: Dec 17, 2025 at 07:32 PM
-- Server version: 10.11.14-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `free-message_sae3012`
--
CREATE DATABASE IF NOT EXISTS `free-message_sae3012` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `free-message_sae3012`;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `IdCat` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `imgSrcCat` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categorie`
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
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `IdComment` int(11) NOT NULL,
  `texte` text NOT NULL,
  `dateCom` datetime NOT NULL,
  `IdUser` int(11) NOT NULL,
  `IdMsg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`IdComment`, `texte`, `dateCom`, `IdUser`, `IdMsg`) VALUES
(7, 'j y fus pas', '2025-12-16 14:55:26', 5, 12),
(10, 'catsss', '2025-12-17 10:32:13', 5, 15);

-- --------------------------------------------------------

--
-- Table structure for table `message`
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

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`IdMsg`, `date`, `texte`, `imageSrc`, `nbrLike`, `nbrDislike`, `nbrCom`, `IdCat`, `IdUser`) VALUES
(12, '2025-12-16 14:26:04', 'Evnne 29.10.25', 'images-upload/1765891564-img_1239.jpeg', 0, 0, 1, 2, 8),
(15, '2025-12-16 14:37:12', 'lets go la team !!', 'images-upload/1765892232-inbound2450223240504529124.jpg', 2, 1, 1, 1, 10),
(16, '2025-12-16 14:39:57', 'Mon repas très appétissant ', 'images-upload/1765892397-1000032270.jpg', 0, 0, 0, 7, 12),
(17, '2025-12-16 15:02:46', 'OOR', 'images-upload/1765893766-img_1101.jpeg', 0, 0, 0, 2, 8),
(18, '2025-12-16 15:38:48', 'Une belle image', 'images-upload/1765895928-inbound3297524296415897238.jpg', 0, 0, 0, 7, 13),
(20, '2025-12-16 19:05:35', 'Z’aime zouer à Roblox', '', 3, 0, 0, 1, 15),
(21, '2025-12-16 19:11:44', 'Mon chat est magnifique ', 'images-upload/1765908704-img_0636.jpeg', 0, 0, 0, 7, 15),
(25, '2025-12-17 11:06:58', 'Joli chat ?', 'images-upload/1765966018-inbound7497506346507304448.jpg', 0, 0, 0, 7, 13),
(26, '2025-12-17 11:07:24', 'Ateez incroyable', 'images-upload/1765966044-ateez.png', 0, 0, 0, 2, 5),
(27, '2025-12-17 11:08:40', 'Max Verstappen mérité tellement la win', 'images-upload/1765966120-inbound67948327176582774.jpg', 0, 0, 0, 5, 13),
(28, '2025-12-17 11:11:38', 'blablahyjuyijuyh,jtujn', '', 2, 0, 0, 8, 5),
(29, '2025-12-17 11:12:00', 'sdqgvhjkhjsqlkd', 'images-upload/1765966320-iyf.png', 0, 1, 0, 8, 5),
(30, '2025-12-17 11:29:24', 'petit test', 'images-upload/1765967364-iyf.jpg', 1, 0, 0, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `reaction` (
  `IdReact` int(11) NOT NULL,
  `IdType` int(11) NOT NULL,
  `IdMsg` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reaction`
--

INSERT INTO `reaction` (`IdReact`, `IdType`, `IdMsg`, `IdUser`) VALUES
(19, 1, 15, 6),
(22, 1, 20, 6),
(30, 1, 15, 17),
(36, 1, 28, 5),
(39, 1, 28, 6),
(40, 2, 29, 5),
(41, 1, 30, 5),
(43, 1, 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `IdType` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`IdType`, `nom`) VALUES
(1, 'like'),
(2, 'dislike');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `IdUser` int(11) NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `biographie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`IdUser`, `identifiant`, `mdp`, `biographie`) VALUES
(4, 'test', '$2y$12$1jzU.93TcPNVnEkjm5RSou8/y51hreHfwpBa9PgJKPJYP88D7L8MC', 'Compte test'),
(5, 'cloe', '$2y$12$4mM2y/Md0qhVBAOxDJNAce1fdW4ZqvCS6njmkKbV9eyGVHR8eXqXq', 'vive la kpop'),
(6, 'Clement ', '$2y$12$uWLbtxNmaWJFJurARCvitO07PuFfD4Hli.tSTEjcfzQvGjXF51Riu', 'Co-fondateur de Free Message.'),
(7, 'no', '$2y$12$Yt3tJ9dsmwONuvxa1fLna.cvtQSTmzMO38pDojEhY3gwspXo62TU2', 'Nono'),
(8, 'helene.dmrs', '$2y$12$JpPPnMQJ9uN5CgrT1hKBB.ZJeTi2uqadzyYs2uXKJbF5M2g4nY52W', NULL),
(9, 'Lili', '$2y$12$NSy5ebaZHcyjuMUsj.7qYOSaqqH9fMiLJa97g3Zoe82D9y/0fMZIi', NULL),
(10, 'dilara', '$2y$12$RlysWKM7KbNmdav7lyhzs.Z/Du5jusNTOiooB3fCfby8doHWZ5YJi', NULL),
(11, 'Lea', '$2y$12$Sf312mXZkqsfqqdMKzmoz.bjFvafQwSCY22g2SCRUDry3i/Qz9CbC', NULL),
(12, 'Aksel', '$2y$12$tdJCnRsWOE3slzsdipdaLe0qw4VoPSBQ3DKpamoVVIw5Yy1FxVVG2', NULL),
(13, 'Pol', '$2y$12$dvef.IeOgXzUDlnRXl8a.uUi5NXhWxFJSlAjGevF8qBG.0oIOUl1.', NULL),
(14, 'azerty', '$2y$12$LJB/nNFtpCMqur0Kj6gROeYpStK.aOtlNBd0fCGwzTYOGT.732r.W', 'azertyuiopqsdghjklmwxcvbn'),
(15, 'LeBoJoJo', '$2y$12$r2VyoV9ipK7RiIbWF/C4RuxAtDkyp8VRkfek6GUBfFtNA6WNJEWYi', NULL),
(17, 'Tournicoti ', '$2y$12$8DJZz9JfQ.GbOOfCnp.LW.pE7fmt36H/aiwk9sxPiWijsIfn.Q5Ly', NULL),
(20, 'admin', '$2y$12$LCa0cEjPOmROYdhiN/ECM.VFd1wiPqwxQD/mWKUMLpkr294deZ2jq', NULL),
(22, 'Dhjdjdjd', '$2y$12$bR2b6WN9mkxBytHBGe3AI.JGjd.cfEPTC9dzgN4MxzG9VnEt4GaFC', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`IdCat`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`IdComment`),
  ADD KEY `IdUser` (`IdUser`),
  ADD KEY `IdMsg` (`IdMsg`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`IdMsg`),
  ADD KEY `IdCat` (`IdCat`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`IdReact`),
  ADD KEY `IdType` (`IdType`),
  ADD KEY `IdMsg` (`IdMsg`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`IdType`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`IdUser`),
  ADD UNIQUE KEY `identifiant` (`identifiant`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `IdCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `IdComment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `IdMsg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reaction`
--
ALTER TABLE `reaction`
  MODIFY `IdReact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `IdType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `utilisateur` (`IdUser`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`IdMsg`) REFERENCES `message` (`IdMsg`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`IdCat`) REFERENCES `categorie` (`IdCat`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`IdUser`) REFERENCES `utilisateur` (`IdUser`);

--
-- Constraints for table `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `reaction_ibfk_1` FOREIGN KEY (`IdType`) REFERENCES `type` (`IdType`),
  ADD CONSTRAINT `reaction_ibfk_2` FOREIGN KEY (`IdMsg`) REFERENCES `message` (`IdMsg`),
  ADD CONSTRAINT `reaction_ibfk_3` FOREIGN KEY (`IdUser`) REFERENCES `utilisateur` (`IdUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
