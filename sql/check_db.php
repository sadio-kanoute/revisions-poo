<?php
// Vérifie que la base draft-shop et les tables ont été créées et affiche quelques données
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=draft-shop;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "Erreur PDO: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

echo "Connexion OK\n";

$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo "Tables trouvées: " . implode(', ', $tables) . PHP_EOL;

foreach (['category','product'] as $t) {
    try {
        $count = $pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
        echo "$t: $count enregistrements\n";
    } catch (Exception $e) {
        echo "Table $t introuvable\n";
    }
}

echo "Quelques produits (max 5):\n";
$stmt = $pdo->query("SELECT p.id, p.name, p.price, c.name AS category FROM product p LEFT JOIN category c ON p.category_id = c.id LIMIT 5");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo "#{$r['id']} - {$r['name']} ({$r['price']}) - category: " . ($r['category'] ?? 'NULL') . PHP_EOL;
}
