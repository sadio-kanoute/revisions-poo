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

    // Temporarily disable foreign key checks to allow DROP/CREATE ordering
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

    // Split statements naively by ";\n" — sufficient for this simple script
    $statements = preg_split('/;\s*\n/', $sql);
    foreach ($statements as $stmt) {
        $stmt = trim($stmt);
        if ($stmt === '') continue;
        $pdo->exec($stmt);
    }

    // Restore foreign key checks
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    echo "Import completed successfully.\n";
} catch (Exception $e) {
    // Attempt to restore FK checks if possible
    try {
        if (isset($pdo) && $pdo instanceof PDO) {
            $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
        }
    } catch (Exception $inner) {
        // ignore
    }
    echo "Import failed: " . $e->getMessage() . "\n";
}
