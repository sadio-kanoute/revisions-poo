<?php
// Simple importer to execute Job-03/draft-shop.sql using PDO.
require_once __DIR__ . '/db.php';

$file = __DIR__ . '/draft-shop.sql';
if (!file_exists($file)) {
    echo "SQL file not found: $file\n";
    exit(1);
}

try {
    $sql = file_get_contents($file);
    $pdo = getPDO();

    // Split statements naively by ";\n" — sufficient for this simple script
    $statements = preg_split('/;\s*\n/', $sql);
    foreach ($statements as $stmt) {
        $stmt = trim($stmt);
        if ($stmt === '') continue;
        $pdo->exec($stmt);
    }
    echo "Import completed successfully.\n";
} catch (Exception $e) {
    echo "Import failed: " . $e->getMessage() . "\n";
}
