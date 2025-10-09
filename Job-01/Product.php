<?php

/**
 * Classe Product
 *
 * Représente un produit dans une boutique. Cette classe contient des propriétés
 * privées (accessibles uniquement depuis la classe) et des méthodes publiques
 * (getters/setters) pour lire et modifier ces propriétés.
 *
 * - Les propriétés privées protègent les données de l'objet.
 * - Les getters lisent les valeurs depuis l'extérieur.
 * - Les setters modifient les valeurs et peuvent valider les données.
 */
class Product
{
    private int $id = 0;
    private string $name = '';
    /** @var string[] */
    private array $photos = [];
    private int $price = 0;
    private string $description = '';
    private int $quantity = 0;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private int $category_id = 0;

    /**
     * Product constructor.
     *
     * @param int $id
     * @param string $name
     * @param string[] $photos
     * @param int $price
     * @param string $description
     * @param int $quantity
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        ?int $category_id = null
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setPhotos($photos);
        $this->setPrice($price);
        $this->setDescription($description);
        $this->setQuantity($quantity);
        $this->setCreatedAt($createdAt ?? new DateTime());
        $this->setUpdatedAt($updatedAt ?? new DateTime());
        if ($category_id !== null) {
            $this->setCategoryId($category_id);
        }
    }

    // ----------------------------
    // GETTERS
    // ----------------------------
    // Les getters retournent la valeur d'une propriété privée.

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @return string[] */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    // ----------------------------
    // SETTERS (avec validation minimale)
    // ----------------------------
    // Les setters permettent de modifier les propriétés. Ici, on vérifie que
    // certains champs numériques sont des entiers naturels (>= 0). En cas
    // d'erreur, on lève une exception pour signaler un mauvais usage.

    public function setId(int $id): void
    {
        if ($id < 0) {
            throw new InvalidArgumentException('id must be a natural number (>= 0)');
        }
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** @param string[] $photos */
    public function setPhotos(array $photos): void
    {
        // Ensure every element is a string
        foreach ($photos as $p) {
            if (!is_string($p)) {
                throw new InvalidArgumentException('photos must be an array of strings');
            }
        }
        $this->photos = $photos;
    }

    public function setPrice(int $price): void
    {
        if ($price < 0) {
            throw new InvalidArgumentException('price must be a natural number (>= 0)');
        }
        $this->price = $price;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException('quantity must be a natural number (>= 0)');
        }
        $this->quantity = $quantity;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setCategoryId(int $category_id): void
    {
        if ($category_id < 0) {
            throw new InvalidArgumentException('category_id must be a natural number (>= 0)');
        }
        $this->category_id = $category_id;
    }

    /**
     * Retourne l'objet Category associé ou null si introuvable.
     * Utilise la configuration dans config.php pour se connecter à la base.
     */
    public function getCategory(): ?object
    {
        if ($this->category_id <= 0) {
            return null;
        }

        $categoryFile = __DIR__ . '/../Job-02/Category.php';
        if (!file_exists($categoryFile)) {
            throw new RuntimeException('Category.php introuvable.');
        }
        require_once $categoryFile;

        $configFile = __DIR__ . '/../config.php';
        if (!file_exists($configFile)) {
            throw new RuntimeException('config.php introuvable.');
        }
        $config = require $configFile;

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['db']['host'], $config['db']['dbname'], $config['db']['charset']);
        $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $stmt = $pdo->prepare('SELECT * FROM category WHERE id = :id');
        $stmt->execute([':id' => $this->category_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $cat = new Category();
        $cat->setId((int)$row['id']);
        $cat->setName($row['name']);
        $cat->setDescription($row['description']);
        $cat->setCreatedAt(new DateTime($row['created_at']));
        $cat->setUpdatedAt(new DateTime($row['updated_at']));

        return $cat;
    }

    /**
     * Hydrate the current Product instance using the given id.
     * Returns $this on success, or false if no row with the id exists.
     *
     * @param int $id
     * @return Product|false
     */
    public function findOneById(int $id)
    {
        $configFile = __DIR__ . '/../config.php';
        if (!file_exists($configFile)) {
            throw new RuntimeException('config.php introuvable.');
        }
        $config = require $configFile;

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['db']['host'], $config['db']['dbname'], $config['db']['charset']);
        $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return false;
        }

        $this->setId((int)$row['id']);
        $this->setName($row['name']);
        $this->setPhotos([$row['photos']]);
        $this->setPrice((int)$row['price']);
        $this->setDescription($row['description']);
        $this->setQuantity((int)$row['quantity']);
        $this->setCreatedAt(new DateTime($row['created_at']));
        $this->setUpdatedAt(new DateTime($row['updated_at']));
        $this->setCategoryId($row['category_id'] === null ? 0 : (int)$row['category_id']);

        return $this;
    }
}
