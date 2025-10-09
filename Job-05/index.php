<?php

// Demo Job-05 : récupérer la catégorie depuis une instance Product
require_once __DIR__ . '/../Job-01/Product.php';

$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset={$config['db']['charset']}";
$pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$idToFetch = 7;
$stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
$stmt->execute([':id' => $idToFetch]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "Produit avec id $idToFetch introuvable.\n";
    exit;
}

// Hydrater Product
$product = new Product();
$product->setId((int)$row['id']);
$product->setName($row['name']);
$product->setPhotos([$row['photos']]);
$product->setPrice((int)$row['price']);
$product->setDescription($row['description']);
$product->setQuantity((int)$row['quantity']);
$product->setCreatedAt(new DateTime($row['created_at']));
$product->setUpdatedAt(new DateTime($row['updated_at']));
$product->setCategoryId($row['category_id'] === null ? 0 : (int)$row['category_id']);

echo "Produit hydraté (Job-05) :\n";
echo "- id: " . $product->getId() . "\n";
echo "- name: " . $product->getName() . "\n";

// Utiliser la nouvelle méthode getCategory()
$cat = $product->getCategory();
if ($cat === null) {
    echo "Aucune catégorie liée.\n";
} else {
    echo "Catégorie liée :\n";
    echo "- id: " . $cat->getId() . "\n";
    echo "- name: " . $cat->getName() . "\n";
    echo "- description: " . $cat->getDescription() . "\n";
}
