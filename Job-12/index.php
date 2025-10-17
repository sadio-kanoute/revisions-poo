<?php
require_once __DIR__ . '/../Job-11/Clothing.php';
require_once __DIR__ . '/../Job-11/Electronic.php';
require_once __DIR__ . '/../Job-03/db.php';

// Job-12: demonstrate child class findAll
$clothes = Clothing::findAll();
echo "Clothing items: " . count($clothes) . "\n";
foreach ($clothes as $c) {
    echo " - " . $c->getId() . " size=" . $c->getSize() . "\n";
}
$elects = Electronic::findAll();
echo "Electronic items: " . count($elects) . "\n";
foreach ($elects as $e) {
    echo " - " . $e->getId() . " brand=" . $e->getBrand() . "\n";
}
