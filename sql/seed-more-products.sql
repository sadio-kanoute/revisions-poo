-- Seed additional products (ids will auto-increment)
USE `draft-shop`;

INSERT INTO `product` (`name`, `photos`, `price`, `description`, `quantity`, `created_at`, `updated_at`, `category_id`) VALUES
('Pantalon', 'https://picsum.photos/200/300', 2000, 'Un pantalon confortable', 7, NOW(), NOW(), 1),
('Pull', 'https://picsum.photos/200/300', 1500, 'Pull chaud', 4, NOW(), NOW(), 1),
('Écharpe', 'https://picsum.photos/200/300', 300, 'Écharpe stylée', 12, NOW(), NOW(), 2),
('Chaussettes', 'https://picsum.photos/200/300', 200, 'Paires de chaussettes', 20, NOW(), NOW(), 2),
('Gants', 'https://picsum.photos/200/300', 400, 'Gants en cuir', 6, NOW(), NOW(), 1);
