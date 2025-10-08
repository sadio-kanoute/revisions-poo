<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=draft-shop;charset=utf8mb4','root','', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo 'Erreur connexion: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}

$stmt = $pdo->query('SELECT id, name FROM product ORDER BY id');
foreach ($stmt as $r) {
    echo $r['id'] . ' - ' . $r['name'] . PHP_EOL;
}
