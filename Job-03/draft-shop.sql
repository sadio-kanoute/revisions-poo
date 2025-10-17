-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 16 oct. 2025 à 10:03
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(7, 'Gants', 'https://picsum.photos/200/300', 400, 'Gants en cuir', 6, '2025-10-08 16:24:21', '2025-10-08 16:24:21', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
