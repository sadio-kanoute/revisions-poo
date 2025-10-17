<?php
require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/../Job-11/Clothing.php';

// Job-13: Product is abstract — instantiate a concrete child for the demo
$p = new Clothing();
echo "Clothing instantiated as Product concrete replacement\n";
