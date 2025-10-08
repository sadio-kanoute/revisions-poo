<?php

require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/Category.php';

// Création d'une catégorie
$cat = new Category(1, 'Vêtements', 'Catégorie pour vêtements');

// Création d'un produit en associant la catégorie via category_id
$product = new Product(
    1,
    'T-shirt',
    ['https://picsum.photos/200/300'],
    1000,
    'A beautiful T-shirt',
    10,
    new DateTime(),
    new DateTime(),
    $cat->getId()
);

var_dump($cat);
var_dump($product);
