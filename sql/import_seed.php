<?php
// Importer le fichier sql/seed-more-products.sql
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$sqlFile = __DIR__ . '/seed-more-products.sql';

if (!file_exists($sqlFile)) {
    echo "Fichier SQL introuvable: $sqlFile\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "Impossible de lire le fichier SQL.\n";
    exit(1);
}

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, 'draft-shop');
if ($mysqli->connect_errno) {
    echo "Erreur de connexion MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error . "\n";
    exit(1);
}

if ($mysqli->multi_query($sql)) {
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());

    if ($mysqli->errno) {
        echo "Import seeds terminé avec erreurs: (" . $mysqli->errno . ") " . $mysqli->error . "\n";
    } else {
        echo "Import seeds terminé avec succès.\n";
    }
} else {
    echo "Échec de l'exécution du seed SQL: (" . $mysqli->errno . ") " . $mysqli->error . "\n";
}

$mysqli->close();
