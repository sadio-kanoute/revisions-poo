<?php
require_once __DIR__ . '/../Job-02/Category.php';
require_once __DIR__ . '/../Job-03/db.php';

// Job-06: get products from category id 1
$cat = Category::findOneById(1);
if ($cat === false) {
    echo "Category 1 not found\n";
    exit;
}
$products = $cat->getProducts();
echo "Products in category " . $cat->getName() . ":\n";
foreach ($products as $p) {
    echo " - " . $p->getId() . " : " . $p->getName() . "\n";
}
