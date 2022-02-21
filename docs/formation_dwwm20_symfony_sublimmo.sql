-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 21 fév. 2022 à 08:23
-- Version du serveur : 5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `formation_dwwm20_symfony_sublimmo`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `maison_id` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `maison_id`, `comment`) VALUES
(2, 19, 'la surface du terrain n\'est pas précise, elle a été calculée à partir d\'une vue aérienne');

-- --------------------------------------------------------

--
-- Structure de la table `commercial`
--

CREATE TABLE `commercial` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commercial`
--

INSERT INTO `commercial` (`id`, `name`) VALUES
(1, 'Prof. Gerald Conroy'),
(2, 'Dr. Alford Ondricka II'),
(3, 'Gerson Rogahn'),
(4, 'Elda Heathcote Sr.'),
(5, 'Blake Murphy Jr.'),
(6, 'David HURTREL');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220208134813', '2022-02-09 09:01:22', 73),
('DoctrineMigrations\\Version20220208144056', '2022-02-09 09:01:22', 63),
('DoctrineMigrations\\Version20220208152113', '2022-02-09 09:01:22', 58);

-- --------------------------------------------------------

--
-- Structure de la table `maison`
--

CREATE TABLE `maison` (
  `id` int(11) NOT NULL,
  `commercial_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `surface` int(11) NOT NULL,
  `rooms` int(11) NOT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `img1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `maison`
--

INSERT INTO `maison` (`id`, `commercial_id`, `title`, `description`, `surface`, `rooms`, `bedrooms`, `price`, `img1`, `img2`) VALUES
(19, 4, 'Jolie maison de campagne', 'Maison de campagne en bordure de rivière avec grand jardin arboré.', 100, 8, 4, 123000, '1644593810-1.jpg', '1644593826-2.jpg'),
(20, 4, 'Grande maison en quartier résidentiel', 'Grande maison en quartier résidentiel. Quartier calme avec écoles et commerces.', 150, 8, 4, 250000, '1645431053-1.jpg', NULL),
(21, 1, 'Maison cubique d\'architecte', 'Maison cubique d\'architecte datant de 2020. Quartier calme et sécurisé.', 145, 9, 5, 300000, '1645431097-1.jpg', NULL),
(22, 6, 'Maison de style colonial', 'Maison de style colonial sur grand terrain arboré. Proche de la mer et de toute commodité.', 123, 7, 3, 235000, '1645431165-1.jpg', NULL),
(23, 2, 'Ancienne chapelle', 'Ancienne chapelle transformée en habitation. Proche de la forêt de Chaux.', 57, 4, 3, 156000, '1645431235-1.jpg', NULL),
(24, 2, 'Maison d\'architecte', 'Maison d\'architecte récente avec piscine et vue sur la montagne.', 90, 4, 2, 560000, '1645431305-1.jpg', NULL),
(25, 3, 'Maison en briques', 'Maison en brique dans le style \"Nord de France\" dans nouveau quartier.', 86, 5, 3, 167000, '1645431396-1.jpg', '1645431396-2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C9D67D8AF` (`maison_id`);

--
-- Index pour la table `commercial`
--
ALTER TABLE `commercial`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `maison`
--
ALTER TABLE `maison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F90CB66D7854071C` (`commercial_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commercial`
--
ALTER TABLE `commercial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `maison`
--
ALTER TABLE `maison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C9D67D8AF` FOREIGN KEY (`maison_id`) REFERENCES `maison` (`id`);

--
-- Contraintes pour la table `maison`
--
ALTER TABLE `maison`
  ADD CONSTRAINT `FK_F90CB66D7854071C` FOREIGN KEY (`commercial_id`) REFERENCES `commercial` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
