<?php

// Charger la classe Product
require_once __DIR__ . '/Product.php';

// Crée un produit avec les valeurs demandées
$product = new Product(
    1, // id
    'T-shirt', // name
    ['https://picsum.photos/200/300'], // photos
    1000, // price
    'A beautiful T-shirt', // description
    10, // quantity
    new DateTime(), // createdAt
    new DateTime() // updatedAt
);

// Affiche l'objet complet (pratique pour vérifier les données)
var_dump($product);

// Lire des propriétés via les getters
echo "Nom : " . $product->getName() . PHP_EOL;
echo "Prix : " . $product->getPrice() . PHP_EOL;
echo "Photos : " . implode(', ', $product->getPhotos()) . PHP_EOL;

// Modifier quelques valeurs
$product->setPrice(850);
$product->setQuantity(5);
$product->setUpdatedAt(new DateTime());

// Affiche les valeurs après modification
echo "Après mise à jour :\n";
echo "Prix : " . $product->getPrice() . PHP_EOL;
echo "Quantité : " . $product->getQuantity() . PHP_EOL;

