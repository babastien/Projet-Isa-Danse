-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 24 mai 2023 à 14:32
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
  `packId` int NOT NULL,
  `code` int NOT NULL,
  `used` int NOT NULL DEFAULT '0',
  `purchasedOn` datetime NOT NULL,
  `purchasedBy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
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
(1, '', 'Je vous propose deux packs de cours, un Bachata et un Salsa.<br />\r\n<br />\r\nChaque pack contient :<br />\r\n-> 5 cours techniques détaillés<br />\r\n-> Un cours chorégraphique décliné sur 2 niveaux (1 version débutante et 1 version intermédiaire)<br />\r\n<br />\r\nLes cours aborderont des sujets essentiels pour améliorer votre style et technique en solo et duo (bien que ce soit des cours solo, j\'établis des parallèles avec les danses de couple).<br />\r\n<br />\r\nLes chorégraphies auront le rôle de mettre en pratique les thèmes traités par les cours avec une notion clef : le plaisir.<br />\r\nUne manière ludique d\'assimiler ce que vous apprenez avec un petit goût de challenge personnel.'),
(2, 'DÉTAILS SUR LE CONTENU', '• Tous les cours techniques sont différents et complémentaires.<br />\nUn seul cours est identique dans les deux packs, il s\'agit du cours sur la gestuelle de bras (j\'ai souhaité utiliser les mêmes gestuelles de bras pour les chorégraphies Salsa et Bachata).<br />\n    <br />\n• Les cours sont déjà enregistrés et mis à disposition.<br />\nChaque cours technique dure 30min et chaque cours chorégraphique dure entre 1h15-1h30.<br />\n    <br />\n• Les cours techniques sont orientés tous niveaux et les chorégraphies sont déclinées en 2 niveaux.<br />\n    <br />\n• Ces packs sont dédiés aux filles d\'un niveau débutant et/ou intermédiaire.<br />\nLes cours techniques sont orientés pour les deux niveaux. Seules les chorégraphies sont déclinées en 2 niveaux.<br />\n    <br />\n• Voici ma description des niveaux :<br />\n    <br />\nDEBUTANT<br />\n-> Tu as commencé cette année la Salsa et/ou la Bachata ET tu n\'as jamais pris de cours de danse solo.<br />\n    OU<br />\n    -> Tu as fais quelques années de Salsa et/ou de Bachata MAIS jamais de cours de Styling, tu as de la difficulté avec ça.<br />\n    <br />\nINTERMEDIAIRE<br />\n-> Tu pratiques régulièrement de la Salsa et/ou Bachata ET tu as commencé à prendre des cours de Styling. <br />\nOU<br />\n-> Peu d\'expérience en danse de couple MAIS tu as déjà pris des cours de danse solo (jazz, classique...par exemple).<br />\n    <br />\n• Vous pourrez visionner les vidéos sur votre écran télé si vous le souhaitez, la qualité des vidéos le permet.<br />\n    <br />\n• Une fois le paiement effectué, les cours sont disponibles sur votre compte sans limite de temps.');

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
(1, 'Pack Bachata', 49, 'pack-bachata.png', 'Cours techniques + choré<br />\r\n(Bachata)'),
(2, 'Pack Salsa', 49, 'pack-salsa.png', 'Cours techniques + choré<br />\r\n(Salsa)'),
(3, 'Pack Technique', 59, '', 'Tous les cours techniques sans choré<br />\r\n(Salsa & Bachata)'),
(4, 'Full Pass', 72, 'pack-fullpass.png', 'Tous les cours techniques + chorés<br />\r\n(Salsa & Bachata)');

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
(1, 'admin', '2023-05-03 10:24:34', 'Toto', 'Test', 'test@gmail.com', '$2y$10$YCtBECj.JniX1gYBurnNBOlB6IbZYXezYXflrptWVMYAd8OIKjWrK');

-- --------------------------------------------------------

--
-- Structure de la table `users_packs`
--

CREATE TABLE `users_packs` (
  `userId` int NOT NULL,
  `packId` int NOT NULL,
  `purchasedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users_packs`
--

INSERT INTO `users_packs` (`userId`, `packId`, `purchasedOn`) VALUES
(1, 1, '2023-05-03 10:34:12'),
(1, 2, '2023-05-03 10:34:13'),
(1, 3, '2023-05-03 10:34:15'),
(1, 4, '2023-05-03 16:33:36');

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE `videos` (
  `id` int NOT NULL,
  `packId` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rankOrder` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `videos`
--

INSERT INTO `videos` (`id`, `packId`, `title`, `filename`, `rankOrder`) VALUES
(1, 1, 'Bachata 1', 'extrait-chore-bachata.mp4', 1),
(2, 1, 'Bachata 2', 'extrait-chore-bachata.mp4', 2),
(3, 1, 'Bachata 3', 'extrait-chore-bachata.mp4', 3);

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
  ADD KEY `fk_users_id` (`userId`),
  ADD KEY `fk_packs_id` (`packId`);

--
-- Index pour la table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pack_id` (`packId`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `packs`
--
ALTER TABLE `packs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `fk_packs_id` FOREIGN KEY (`packId`) REFERENCES `packs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_pack_id` FOREIGN KEY (`packId`) REFERENCES `packs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
