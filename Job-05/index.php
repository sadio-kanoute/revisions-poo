<?php
require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/../Job-03/db.php';
require_once __DIR__ . '/../Job-11/Clothing.php';

// Job-05: getCategory from product id=7
$p = Clothing::findOneById(7);
if ($p === false) {
    echo "Product 7 not found\n";
    exit;
}
$cat = $p->getCategory();
if ($cat === null || $cat === false) {
    echo "No category\n";
} else {
    echo "Category for product 7: " . $cat->getName() . "\n";
}
