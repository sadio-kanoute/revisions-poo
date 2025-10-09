<?php

require_once __DIR__ . '/../Job-02/Category.php';
require_once __DIR__ . '/../Job-01/Product.php';

// Demo: use the instance method findOneById to hydrate $this
// Use the Product instance method findOneById (simple/basic approach)
$p = (new Product())->findOneById(7);
if ($p === false) {
    echo "Product id=7 not found\n";
} else {
    echo "findOneById(7) -> ". $p->getName() ."\n";
}

// Test getProducts for category id 1
$cat = new Category(1);
$products = $cat->getProducts();
echo "Category 1 has " . count($products) . " products\n";
foreach ($products as $prod) {
    echo "- " . $prod->getId() . " : " . $prod->getName() . "\n";
}
