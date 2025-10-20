<?php
// Job-15: strictly follow the cahier des charges — only require Composer's
// autoloader (PSR-4). Do not fallback to legacy requires.

require __DIR__ . '/vendor/autoload.php';

echo "Job-15 ready: vendor/autoload.php required. Use App\\Abstract\\AbstractProduct, App\\Clothing and App\\Electronic via PSR-4.\n";

// Short runtime demo: instantiate a Clothing object and show some fields
// This demonstrates the Composer PSR-4 autoloader is working and classes
// under the App\ namespace are loadable.
try {
	$c = new App\Clothing(0, 'Demo Gants', [], 1299, 'Gants de démonstration', 10);
	$c->setSize('M')->setColor('Noir')->setType('Gants')->setMaterialFee(50);

	echo "\nDemo Clothing:\n";
	echo "  name: " . $c->name ?? '(no name accessible)' . "\n";
	echo "  size: " . $c->getSize() . "\n";
	echo "  color: " . $c->getColor() . "\n";
	echo "  type: " . $c->getType() . "\n";
	echo "  price (cents): " . $c->getPrice() . "\n";
} catch (Throwable $e) {
	echo "Demo failed: " . $e->getMessage() . "\n";
}

