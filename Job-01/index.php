<?php

// Inclure la définition de la classe Product (le fichier Product.php doit être dans le même dossier)
require_once __DIR__ . '/Product.php';

// -----------------------------------------------------------------------------
// Création d'une instance de Product
// - On passe les valeurs au constructeur dans l'ordre demandé par l'exercice
// - DateTime() crée une date/heure courante
// -----------------------------------------------------------------------------
$product = new Product(
    1, // id (entier naturel)
    'T-shirt', // name (chaîne)
    ['https://picsum.photos/200/300'], // photos (tableau de chaînes)
    1000, // price (entier naturel, ex. en centimes si vous préférez)
    'A beautiful T-shirt', // description (chaîne)
    10, // quantity (entier naturel)
    new DateTime(), // createdAt (DateTime)
    new DateTime() // updatedAt (DateTime)
);

// -----------------------------------------------------------------------------
// Vérification : afficher tout l'objet (utile pour le debug / test)
// var_dump affiche la structure complète de l'objet et ses propriétés privées
// -----------------------------------------------------------------------------
var_dump($product);

// -----------------------------------------------------------------------------
// Accéder aux propriétés via les getters (méthodes publiques fournies par la classe)
// - On n'accède pas directement aux propriétés privées depuis l'extérieur
// - On utilise les méthodes getX() pour récupérer les valeurs
// -----------------------------------------------------------------------------
echo "Nom : " . $product->getName() . PHP_EOL; // affiche le nom
echo "Prix : " . $product->getPrice() . PHP_EOL; // affiche le prix
echo "Photos : " . implode(', ', $product->getPhotos()) . PHP_EOL; // liste les URLs des photos

// -----------------------------------------------------------------------------
// Modifier des propriétés via les setters (méthodes publiques fournies par la classe)
// - setPrice(), setQuantity(), setUpdatedAt() mettent à jour les propriétés
// - Les setters font aussi une validation minimale (ex. entiers >= 0)
// -----------------------------------------------------------------------------
$product->setPrice(850); // on change le prix
$product->setQuantity(5); // on change la quantité
$product->setUpdatedAt(new DateTime()); // on met à jour la date de modification

// Afficher les valeurs après modification pour vérifier que les setters ont bien fonctionné
echo "Après mise à jour :\n";
echo "Prix : " . $product->getPrice() . PHP_EOL;
echo "Quantité : " . $product->getQuantity() . PHP_EOL;

