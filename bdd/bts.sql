-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 09 fév. 2026 à 11:24
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
-- Base de données : `bts`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT 'default.jpg',
  `classe` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `passions` varchar(1000) NOT NULL,
  `projet` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `nom`, `prenom`, `photo`, `classe`, `description`, `passions`, `projet`) VALUES
(1, 'issouf', 'amine', 'default.jpg', '22', 'en stage', 'manger', 'creer un jeux'),
(2, 'NASSER', 'ABOU', 'default.jpg', 'T13', 'EN VANCANCE', 'RIEN', 'PAS DE COMMANTAIRE'),
(3, 'Issouf', 'Amine', 'default.jpg', 'BTS SIO2', 'Je m\'éclate devant les jeux vidéo et je suis toujours au rendez-vous pour regarder un bon match de foot !', '     Foot     jeux video     music', 'Ma passion pour le jeu vidéo est telle qu\'elle est devenue une ambition : mon objectif est de créer mon propre jeu. Je souhaite explorer les processus de conception (game design), de programmation, pour transformer une idée en une véritable expérience .'),
(4, 'abou', 'anfia', 'default.jpg', 'T13', 'bien', 'jouer', 'aler au lycée'),
(5, 'anfane', 'soultane', '698994e15093e.PNG', 'BTS SIO2', 'bien', 'SIENTIFIQUE', 'DE VENIR PROF'),
(6, 'LEBLAN', 'xneb', '69899de29326d.PNG', 'bts sio 1', 'rien', 'RIEN', 'pas de projet'),
(7, 'fzf', 'ffrfr', 'default.jpg', 'rf', 'fr', 'refr', 'frf');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
