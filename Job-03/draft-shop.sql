-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 oct. 2025 à 08:47
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `draft-shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Vêtements', 'Catégorie pour vêtements', '2025-10-08 10:12:19', '2025-10-08 10:12:19'),
(2, 'Accessoires', 'Catégorie pour accessoires', '2025-10-08 10:12:19', '2025-10-08 10:12:19');

-- --------------------------------------------------------

--
-- Structure de la table `clothing`
--

DROP TABLE IF EXISTS `clothing`;
CREATE TABLE IF NOT EXISTS `clothing` (
  `product_id` int UNSIGNED NOT NULL,
  `size` varchar(32) DEFAULT NULL,
  `color` varchar(64) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `material_fee` int DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `clothing`
--

INSERT INTO `clothing` (`product_id`, `size`, `color`, `type`, `material_fee`) VALUES
(7, 'M', 'Noir', 'Gants', 50);

-- --------------------------------------------------------

--
-- Structure de la table `electronic`
--

DROP TABLE IF EXISTS `electronic`;
CREATE TABLE IF NOT EXISTS `electronic` (
  `product_id` int UNSIGNED NOT NULL,
  `brand` varchar(128) DEFAULT NULL,
  `warranty_fee` int DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `electronic`
--

INSERT INTO `electronic` (`product_id`, `brand`, `warranty_fee`) VALUES
(2, 'ACME Electronics', 24);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `photos` text,
  `price` int NOT NULL,
  `description` text,
  `quantity` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `photos`, `price`, `description`, `quantity`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'T-shirt', 'https://picsum.photos/200/300', 1000, 'A beautiful T-shirt', 10, '2025-10-08 10:12:19', '2025-10-08 10:12:19', 1),
(2, 'Casquette', 'https://picsum.photos/200/300', 500, 'Une casquette stylée', 5, '2025-10-08 10:12:19', '2025-10-08 10:12:19', 2),
(3, 'Pantalon', 'https://picsum.photos/200/300', 2000, 'Un pantalon confortable', 7, '2025-10-08 16:24:21', '2025-10-08 16:24:21', 1),
(4, 'Pull', 'https://picsum.photos/200/300', 1500, 'Pull chaud', 4, '2025-10-08 16:24:21', '2025-10-08 16:24:21', 1),
(5, 'Écharpe', 'https://picsum.photos/200/300', 300, 'Écharpe stylée', 12, '2025-10-08 16:24:21', '2025-10-08 16:24:21', 2),
(6, 'Chaussettes', 'https://picsum.photos/200/300', 200, 'Paires de chaussettes', 20, '2025-10-08 16:24:21', '2025-10-08 16:24:21', 2),
(7, 'Gants', '["https:\/\/picsum.photos\/200\/300"]', 1000, 'Gants en cuir', 6, '2025-10-08 16:24:21', '2025-10-17 14:26:03', 1),
(11, 'New demo product', '[]', 1234, 'Inserted by demo', 2, '2025-10-16 13:23:42', '2025-10-16 13:23:42', NULL),
(12, 'New demo product', '[]', 1234, 'Inserted by demo', 2, '2025-10-17 07:46:57', '2025-10-17 07:46:57', NULL),
(13, 'New demo product', '[]', 1234, 'Inserted by demo', 2, '2025-10-17 08:05:24', '2025-10-17 08:05:24', NULL),
(14, 'New demo product', '[]', 1234, 'Inserted by demo', 2, '2025-10-17 08:21:27', '2025-10-17 08:21:27', NULL),
(15, 'New demo product', '[]', 1234, 'Inserted by demo', 2, '2025-10-17 14:11:53', '2025-10-17 14:11:53', NULL),
(16, 'New demo product', '[]', 1234, 'Inserted by demo', 2, '2025-10-17 14:25:49', '2025-10-17 14:25:49', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `clothing`
--
ALTER TABLE `clothing`
  ADD CONSTRAINT `fk_clothing_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `electronic`
--
ALTER TABLE `electronic`
  ADD CONSTRAINT `fk_electronic_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
