<?php
require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/../Job-03/db.php';
require_once __DIR__ . '/../Job-11/Clothing.php';

// Job-10: update demo - update product id 7 price
$p = Clothing::findOneById(7);
if ($p === false) { echo "Product 7 not found\n"; exit; }
$p->setPrice($p->getPrice() + 100);
if ($p->update()) {
    echo "Product 7 updated, new price: " . $p->getPrice() . "\n";
} else {
    echo "Update failed\n";
}
