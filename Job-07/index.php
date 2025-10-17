<?php
require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/../Job-03/db.php';
require_once __DIR__ . '/../Job-11/Clothing.php';

// Job-07: findOneById demo
$id = $argv[1] ?? 7;
$p = Clothing::findOneById((int)$id);
if ($p === false) {
    echo "Product $id not found\n";
} else {
    echo "Found product $id: " . $p->getName() . "\n";
}
