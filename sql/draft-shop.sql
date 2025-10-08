-- Create database
CREATE DATABASE IF NOT EXISTS `draft-shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `draft-shop`;

-- Category table
CREATE TABLE IF NOT EXISTS `category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product table
CREATE TABLE IF NOT EXISTS `product` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `photos` TEXT,
  `price` INT NOT NULL,
  `description` TEXT,
  `quantity` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`),
  CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample inserts
INSERT INTO `category` (`name`, `description`, `created_at`, `updated_at`) VALUES
('Vêtements', 'Catégorie pour vêtements', NOW(), NOW()),
('Accessoires', 'Catégorie pour accessoires', NOW(), NOW());

INSERT INTO `product` (`name`, `photos`, `price`, `description`, `quantity`, `created_at`, `updated_at`, `category_id`) VALUES
('T-shirt', 'https://picsum.photos/200/300', 1000, 'A beautiful T-shirt', 10, NOW(), NOW(), 1),
('Casquette', 'https://picsum.photos/200/300', 500, 'Une casquette stylée', 5, NOW(), NOW(), 2);
