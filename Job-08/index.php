<?php
require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/../Job-03/db.php';
require_once __DIR__ . '/../Job-11/Clothing.php';

// Job-08: findAll demo
$all = Clothing::findAll();
echo "Total products: " . count($all) . "\n";
foreach ($all as $p) {
    echo " - " . $p->getId() . " : " . $p->getName() . "\n";
}
