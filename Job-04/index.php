<?php
require_once __DIR__ . '/../Job-01/Product.php';
require_once __DIR__ . '/../Job-03/db.php';

// Job-04: hydrate product with id 7
try {
    require_once __DIR__ . '/../Job-11/Clothing.php';
    $p = Clothing::findOneById(7);
    if ($p === false) {
        echo "Product id=7 not found\n";
    } else {
        echo "Hydrated product id=7:\n";
        var_dump([
            'id' => $p->getId(),
            'name' => $p->getName(),
            'price' => $p->getPrice(),
        ]);
    }
} catch (Exception $e) {
    echo "DB error: " . $e->getMessage();
}
