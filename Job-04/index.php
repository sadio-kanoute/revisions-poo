<?php

require_once __DIR__ . '/../Job-01/Product.php';
$config = require __DIR__ . '/../config.php';

$dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset={$config['db']['charset']}";
$pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$idToFetch = 7;
$stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
$stmt->execute([':id' => $idToFetch]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "Produit avec id $idToFetch introuvable. Produits existants :\n";
    $list = $pdo->query('SELECT id, name FROM product ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($list as $r) {
        echo "{$r['id']} - {$r['name']}\n";
    }
    exit;
}

// Hydrater l'objet Product
$product = new Product();
$product->setId((int)$row['id']);
$product->setName($row['name']);
// photos stored as TEXT — if multiple, adapt (here assume single URL)
$product->setPhotos([$row['photos']]);
$product->setPrice((int)$row['price']);
$product->setDescription($row['description']);
$product->setQuantity((int)$row['quantity']);
$product->setCreatedAt(new DateTime($row['created_at']));
$product->setUpdatedAt(new DateTime($row['updated_at']));
$product->setCategoryId($row['category_id'] === null ? 0 : (int)$row['category_id']);

echo "Produit hydraté depuis la DB :\n";
var_dump($product);

// Récupérer et afficher la catégorie associée via Product::getCategory()
$category = $product->getCategory();
if ($category === null) {
    echo "Aucune catégorie trouvée pour ce produit.\n";
} else {
    echo "Catégorie associée :\n";
    var_dump($category);
}
