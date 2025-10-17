<?php
namespace App;

// Lightweight PSR-4 bridge: include the legacy class and extend it so code can opt-in
require_once __DIR__ . '/../../Job-01/Product.php';

class Product extends \Product
{
}
