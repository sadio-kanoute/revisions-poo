<?php
// Petit script pour importer le fichier SQL draft-shop.sql dans MySQL
// Usage: php import.php
// Configurez vos identifiants ci-dessous avant de lancer.

$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = ''; // mettez votre mot de passe MySQL
$sqlFile = __DIR__ . '/draft-shop.sql';

if (!file_exists($sqlFile)) {
    echo "Fichier SQL introuvable: $sqlFile\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "Impossible de lire le fichier SQL.\n";
    exit(1);
}

$mysqli = new mysqli($dbHost, $dbUser, $dbPass);
if ($mysqli->connect_errno) {
    echo "Erreur de connexion MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error . "\n";
    exit(1);
}

// Multi query pour exécuter tout le fichier SQL
if ($mysqli->multi_query($sql)) {
    do {
        if ($result = $mysqli->store_result()) {
            // libère le jeu de résultats
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());

    if ($mysqli->errno) {
        echo "Import terminé avec erreurs: (" . $mysqli->errno . ") " . $mysqli->error . "\n";
    } else {
        echo "Import SQL terminé avec succès.\n";
    }
} else {
    echo "Échec de l'exécution du script SQL: (" . $mysqli->errno . ") " . $mysqli->error . "\n";
}

$mysqli->close();
