<?php

/**
 * Classe Category
 * Représente une catégorie de produits.
 */
class Category
{
    private int $id = 0;
    private string $name = '';
    private string $description = '';
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $description = '',
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setDescription($description);
        $this->setCreatedAt($createdAt ?? new DateTime());
        $this->setUpdatedAt($updatedAt ?? new DateTime());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Retourne un tableau d'instances Product associées à cette catégorie.
     * Si aucun produit n'est lié, retourne un tableau vide.
     *
     * @return Product[]
     */
    public function getProducts(): array
    {
        // Charger la classe Product
        $productFile = __DIR__ . '/../Job-01/Product.php';
        if (!file_exists($productFile)) {
            throw new RuntimeException('Product.php introuvable.');
        }
        require_once $productFile;

        // Charger config
        $configFile = __DIR__ . '/../config.php';
        if (!file_exists($configFile)) {
            throw new RuntimeException('config.php introuvable.');
        }
        $config = require $configFile;

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['db']['host'], $config['db']['dbname'], $config['db']['charset']);
        $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $stmt = $pdo->prepare('SELECT * FROM product WHERE category_id = :id');
        $stmt->execute([':id' => $this->id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($rows as $row) {
            $p = new Product();
            $p->setId((int)$row['id']);
            $p->setName($row['name']);
            $p->setPhotos([$row['photos']]);
            $p->setPrice((int)$row['price']);
            $p->setDescription($row['description']);
            $p->setQuantity((int)$row['quantity']);
            $p->setCreatedAt(new DateTime($row['created_at']));
            $p->setUpdatedAt(new DateTime($row['updated_at']));
            $p->setCategoryId($row['category_id'] === null ? 0 : (int)$row['category_id']);
            $products[] = $p;
        }

        return $products;
    }
}
