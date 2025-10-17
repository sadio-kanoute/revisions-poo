<?php

// Use legacy non-namespaced files so the project runs without composer.
require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/../Job-02/Category.php';
require_once __DIR__ . '/../Job-03/db.php';

// Load legacy child classes
require_once __DIR__ . '/../Job-11/Clothing.php';
require_once __DIR__ . '/../Job-11/Electronic.php';

// Example usage for Job-01: instantiate with full constructor
$product = new Clothing(
    1,
    'T-shirt',
    ['img1.jpg', 'img2.jpg'],
    1999,
    'A comfortable cotton t-shirt',
    10,
    new DateTime('2025-01-01 10:00:00'),
    new DateTime('2025-01-15 12:00:00')
);

// Dump product properties using getters
echo "Product created via full constructor:\n";
var_dump([
    'id' => $product->getId(),
    'category_id' => $product->getCategoryId(),
    'name' => $product->getName(),
    'photos' => $product->getPhotos(),
    'price' => $product->getPrice(),
    'description' => $product->getDescription(),
    'quantity' => $product->getQuantity(),
    'createdAt' => $product->getCreatedAt()->format('c'),
    'updatedAt' => $product->getUpdatedAt()->format('c'),
]);

$product2 = new Clothing();
$product2->setName('Default hoodie')->setPrice(2999)->setQuantity(5);

echo "\nProduct created via empty constructor + setters:\n";
var_dump([
    'id' => $product2->getId(),
    'category_id' => $product2->getCategoryId(),
    'name' => $product2->getName(),
    'photos' => $product2->getPhotos(),
    'price' => $product2->getPrice(),
    'description' => $product2->getDescription(),
    'quantity' => $product2->getQuantity(),
    'createdAt' => $product2->getCreatedAt()->format('c'),
    'updatedAt' => $product2->getUpdatedAt()->format('c'),
]);

// --- Demo: hydrate from DB (product with id=7)
echo "\nAttempting to load product id=7 from database...\n";
try {
    $p = Clothing::findOneById(7);
    if ($p === false) {
        echo "Product with id=7 not found in DB. Check your DB content.\n";
    } else {
        echo "Product loaded from DB:\n";
        var_dump([
            'id' => $p->getId(),
            'name' => $p->getName(),
            'category_id' => $p->getCategoryId(),
            'price' => $p->getPrice(),
            'quantity' => $p->getQuantity(),
        ]);

        $cat = $p->getCategory();
        if ($cat === null || $cat === false) {
            echo "No category found for this product.\n";
        } else {
            echo "Category for product:\n";
            var_dump([
                'id' => $cat->getId(),
                'name' => $cat->getName(),
            ]);

            echo "Products in this category:\n";
            $others = $cat->getProducts();
            foreach ($others as $o) {
                echo " - id=" . $o->getId() . " name=" . $o->getName() . "\n";
            }
        }
    }
} catch (Exception $e) {
    echo "Database error (see Job-03/db.php config). Exception: " . $e->getMessage() . "\n";
}

// Demo: Clothing/Electronic specific find
echo "\nDemo: find child typed products:\n";
$clothing = Clothing::findOneById(7);
if ($clothing !== false) {
    echo "Clothing 7: "; var_dump(['id' => $clothing->getId(), 'size' => $clothing->getSize(), 'color' => $clothing->getColor()]);
}
$elect = Electronic::findOneById(9);
if ($elect !== false) {
    echo "Electronic 9: "; var_dump(['id' => $elect->getId(), 'brand' => $elect->getBrand(), 'warranty' => $elect->getWarrantyFee()]);
}

echo "\nIf you need to populate the DB automatically, open Job-03/import.php in your browser or run via CLI: php Job-03/import.php\n";
