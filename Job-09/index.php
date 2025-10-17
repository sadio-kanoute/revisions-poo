<?php
require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/../Job-03/db.php';

// Job-09: create demo
$p = new class extends Product {};
$p->setName('New demo product')->setPrice(1234)->setQuantity(2)->setDescription('Inserted by demo');
$res = $p->create();
if ($res === false) {
    echo "Insert failed\n";
} else {
    echo "Inserted product id=" . $res->getId() . "\n";
}
