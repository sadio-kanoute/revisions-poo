-- Add child tables for clothing and electronic products
-- Run this in your MySQL (draft-shop) database to create the tables and insert sample rows.

DROP TABLE IF EXISTS `clothing`;
CREATE TABLE `clothing` (
  `product_id` int UNSIGNED NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `material_fee` int DEFAULT 0,
  PRIMARY KEY (`product_id`),
  CONSTRAINT `fk_clothing_product` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `electronic`;
CREATE TABLE `electronic` (
  `product_id` int UNSIGNED NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `warranty_fee` int DEFAULT 0,
  PRIMARY KEY (`product_id`),
  CONSTRAINT `fk_electronic_product` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample inserts for existing products (adjust as needed)
INSERT INTO `clothing` (`product_id`, `size`, `color`, `type`, `material_fee`) VALUES
(1, 'M', 'Blue', 'T-shirt', 100),
(3, 'L', 'Black', 'Pantalon', 200),
(4, 'S', 'Grey', 'Pull', 150),
(7, 'M', 'Brown', 'Gants', 50);

INSERT INTO `electronic` (`product_id`, `brand`, `warranty_fee`) VALUES
(2, 'Acme', 12),
(6, 'ElectroCorp', 24);
