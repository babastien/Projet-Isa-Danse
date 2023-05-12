-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 03 mai 2023 à 13:56
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `isa_danse`
--

-- --------------------------------------------------------

--
-- Structure de la table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `id` int NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `confirmation` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gift`
--

CREATE TABLE `gift` (
  `id` int NOT NULL,
  `pack_id` int NOT NULL,
  `code` int NOT NULL,
  `used` int NOT NULL DEFAULT '0',
  `purchased_on` datetime NOT NULL,
  `purchased_by` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `homepage`
--

CREATE TABLE `homepage` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `homepage`
--

INSERT INTO `homepage` (`id`, `title`, `content`) VALUES
(1, NULL, 'Je vous propose <b>deux packs</b> de cours, un <b>Bachata</b> et un <b>Salsa</b>.<br>\r\n    <br>\r\n    Chaque pack contient :<br>\r\n    -> 5 cours techniques détaillés<br>\r\n    -> Un cours chorégraphique décliné sur 2 niveaux (1 version débutante et 1 version intermédiaire)<br><br>\r\n    Les <u>cours</u> aborderont des sujets essentiels pour améliorer votre style et technique en solo et duo (bien que ce soit des cours solo, j\'établis des parallèles avec les danses de couple).<br>\r\n    <br>\r\n    Les <u>chorégraphies</u> auront le rôle de mettre en pratique les thèmes traités par les cours avec une notion clef : le plaisir.<br>\r\n    Une manière ludique d\'assimiler ce que vous apprenez avec un petit goût de challenge personnel.'),
(2, 'DÉTAILS SUR LE CONTENU', '• Tous les cours techniques sont <b>différents</b> et <b>complémentaires</b>.<br>\r\n    Un seul cours est identique dans les deux packs, il s\'agit du cours sur la gestuelle de bras (j\'ai souhaité utiliser les mêmes gestuelles de bras pour les chorégraphies Salsa et Bachata).<br>\r\n    <br>\r\n    • Les cours sont déjà enregistrés et mis à disposition.<br>\r\n    Chaque cours technique dure <b>30min</b> et chaque cours chorégraphique dure entre <b>1h15-1h30</b>.<br>\r\n    <br>\r\n    • Les cours techniques sont orientés tous niveaux et les chorégraphies sont déclinées en 2 niveaux.<br>\r\n    <br>\r\n    • Ces packs sont dédiés aux filles d\'un niveau <b>débutant</b> et/ou <b>intermédiaire</b>.<br>\r\n    Les cours techniques sont orientés pour les deux niveaux. Seules les chorégraphies sont déclinées en 2 niveaux.<br>\r\n    <br>\r\n    • Voici ma description des niveaux :<br>\r\n    <br>\r\n    <b>DEBUTANT</b><br>\r\n    -> Tu as commencé cette année la Salsa et/ou la Bachata ET tu n\'as jamais pris de cours de danse solo.<br>\r\n    OU<br>\r\n    -> Tu as fais quelques années de Salsa et/ou de Bachata MAIS jamais de cours de Styling, tu as de la difficulté avec ça.<br>\r\n    <br>\r\n    <b>INTERMEDIAIRE</b><br>\r\n    -> Tu pratiques régulièrement de la Salsa et/ou Bachata ET tu as commencé à prendre des cours de Styling. <br>\r\n    OU<br>\r\n    -> Peu d\'expérience en danse de couple MAIS tu as déjà pris des cours de danse solo (jazz, classique...par exemple).<br>\r\n    <br>\r\n    • Vous pourrez visionner les vidéos sur votre écran télé si vous le souhaitez, la qualité des vidéos le permet.<br>\r\n    <br>\r\n    • Une fois le paiement effectué, les cours sont disponibles sur votre compte sans limite de temps.');

-- --------------------------------------------------------

--
-- Structure de la table `packs`
--

CREATE TABLE `packs` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `packs`
--

INSERT INTO `packs` (`id`, `title`, `price`, `image`, `description`) VALUES
(1, 'Pack Bachata', 49, 'images/pack-bachata.png', 'Cours techniques + choré<br>(Bachata)'),
(2, 'Pack Salsa', 49, 'images/pack-salsa.png', 'Cours techniques + choré<br>(Salsa)'),
(3, 'Pack Technique', 59, '', 'Tous les cours techniques sans choré<br>(Salsa & Bachata)'),
(4, 'Full Pass', 72, 'images/pack-fullpass.png', 'Tous les cours techniques + chorés<br>(Salsa & Bachata)');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `createdAt` datetime NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role`, `createdAt`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'admin', '2023-05-03 10:24:34', 'Toto', 'Admin', 'admin@gmail.com', '$2y$10$UFu.QD89U1eYI/.dvVPdf./XsXG/D1Aa9Z1Bn4iimH3.ylxCF.p3G');

-- --------------------------------------------------------

--
-- Structure de la table `users_packs`
--

CREATE TABLE `users_packs` (
  `user_id` int NOT NULL,
  `pack_id` int NOT NULL,
  `purchased_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users_packs`
--

INSERT INTO `users_packs` (`user_id`, `pack_id`, `purchased_on`) VALUES
(1, 1, '2023-05-03 10:34:12'),
(1, 2, '2023-05-03 10:34:13'),
(1, 3, '2023-05-03 10:34:15'),
(1, 4, '2023-05-03 10:34:17');

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE `videos` (
  `id` int NOT NULL,
  `pack_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rank_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `videos`
--

INSERT INTO `videos` (`id`, `pack_id`, `title`, `filename`, `rank_order`) VALUES
(1, 1, 'Bachata 1', 'videos/extrait-chore-bachata.mp4', 1),
(2, 1, 'Bachata 2', 'videos/extrait-chore-bachata.mp4', 2),
(3, 1, 'Bachata 3', 'videos/extrait-chore-bachata.mp4', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `homepage`
--
ALTER TABLE `homepage`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `packs`
--
ALTER TABLE `packs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_packs`
--
ALTER TABLE `users_packs`
  ADD KEY `fk_users_id` (`user_id`),
  ADD KEY `fk_packs_id` (`pack_id`);

--
-- Index pour la table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pack_id` (`pack_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gift`
--
ALTER TABLE `gift`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `homepage`
--
ALTER TABLE `homepage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `packs`
--
ALTER TABLE `packs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `users_packs`
--
ALTER TABLE `users_packs`
  ADD CONSTRAINT `fk_packs_id` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_pack_id` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
