<?php

require_once __DIR__ . '/../../Job-01/Product.php';

// 1) Instanciation avec tous les paramètres
$product1 = new Product(1, 'T-shirt', ['https://picsum.photos/200/300'], 1000, 'A beautiful T-shirt', 10, new DateTime(), new DateTime());

// 2) Instanciation sans paramètres (constructor optionnel)
$product2 = new Product();

// Affiche pour vérifier
var_dump($product1);
var_dump($product2);

echo "Produit 1 name: " . $product1->getName() . PHP_EOL;
echo "Produit 2 name: " . $product2->getName() . PHP_EOL;
