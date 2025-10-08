<?php

/*
 * Job 03 — MCD et base de données
 *
 * 1) MCD rapide (description)
 *
 * Entité Category
 *  - id (PK)
 *  - name
 *  - description
 *  - created_at
 *  - updated_at
 *
 * Entité Product
 *  - id (PK)
 *  - name
 *  - photos
 *  - price
 *  - description
 *  - quantity
 *  - created_at
 *  - updated_at
 *  - category_id (FK -> category.id)
 *
 * Relation : Category 1 --- * Product
 *
 * 2) Créer la base et les tables
 *
 * Le script SQL est disponible dans le dépôt : sql/draft-shop.sql
 * Pour l'importer via phpMyAdmin :
 *  - Ouvrir phpMyAdmin (ex. http://localhost/phpmyadmin)
 *  - Cliquer sur "Importer" et choisir le fichier sql/draft-shop.sql
 *  - Lancer l'import
 *
 * 3) Insérer des données
 * - Vous pouvez utiliser phpMyAdmin ou exécuter des requêtes depuis PHP (PDO)
 * - Exemple d'insertion se trouve déjà dans sql/draft-shop.sql (INSERTs)
 *
 * 4) Vérifier les données
 * - Requête pour lister les produits avec leur catégorie :
 *   SELECT p.*, c.name AS category_name
 *   FROM product p
 *   LEFT JOIN category c ON p.category_id = c.id;
 */

echo "Job 03 - MCD et instructions SQL\n";
echo "Le fichier SQL est : sql/draft-shop.sql\n";
echo "Pour la suite, importer le SQL via phpMyAdmin ou utiliser PDO depuis PHP.\n";
