<?php

require_once __DIR__ . '/AbstractProduct.php';

abstract class Product extends AbstractProduct
{
    // properties moved to AbstractProduct

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->category_id = 0;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

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

    // --- Database related methods (basic implementations)
    public static function findOneById(int $id)
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();

        $stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            return false;
        }

        // hydrate photos: DB may store a JSON array or a single URL string
        $photos = [];
        if (!empty($row['photos'])) {
            $decoded = json_decode($row['photos'], true);
            if (is_array($decoded)) {
                $photos = $decoded;
            } else {
                // treat as single URL string
                $photos = [$row['photos']];
            }
        }

        $createdAt = isset($row['created_at']) ? new DateTime($row['created_at']) : new DateTime();
        $updatedAt = isset($row['updated_at']) ? new DateTime($row['updated_at']) : new DateTime();

        $product = new static(
            (int)$row['id'],
            $row['name'] ?? '',
            $photos,
            (int)$row['price'],
            $row['description'] ?? '',
            (int)$row['quantity'],
            $createdAt,
            $updatedAt
        );
        $product->setCategoryId((int)($row['category_id'] ?? 0));
        return $product;
    }

    public static function findAll(): array
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        $stmt = $pdo->query('SELECT * FROM product');
        $rows = $stmt->fetchAll();
        $out = [];
        foreach ($rows as $row) {
            $photos = [];
            if (!empty($row['photos'])) {
                $decoded = json_decode($row['photos'], true);
                if (is_array($decoded)) {
                    $photos = $decoded;
                }
            }
            $createdAt = isset($row['created_at']) ? new DateTime($row['created_at']) : new DateTime();
            $updatedAt = isset($row['updated_at']) ? new DateTime($row['updated_at']) : new DateTime();

            $p = new static(
                (int)$row['id'],
                $row['name'] ?? '',
                $photos,
                (int)$row['price'],
                $row['description'] ?? '',
                (int)$row['quantity'],
                $createdAt,
                $updatedAt
            );
            $p->setCategoryId((int)($row['category_id'] ?? 0));
            $out[] = $p;
        }
        return $out;
    }

    public function create()
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();

        $stmt = $pdo->prepare('INSERT INTO product (category_id, name, photos, price, description, quantity, created_at, updated_at) VALUES (:category_id, :name, :photos, :price, :description, :quantity, :created_at, :updated_at)');

        $photosJson = json_encode($this->photos);
        $result = $stmt->execute([
            'category_id' => $this->category_id ?: null,
            'name' => $this->name,
            'photos' => $photosJson,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ]);

        if ($result) {
            $this->id = (int)$pdo->lastInsertId();
            return $this;
        }
        return false;
    }

    public function update()
    {
        if (!$this->id) {
            return false;
        }
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();

        $stmt = $pdo->prepare('UPDATE product SET category_id = :category_id, name = :name, photos = :photos, price = :price, description = :description, quantity = :quantity, updated_at = :updated_at WHERE id = :id');

        $photosJson = json_encode($this->photos);
        $result = $stmt->execute([
            'category_id' => $this->category_id ?: null,
            'name' => $this->name,
            'photos' => $photosJson,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
            'id' => $this->id,
        ]);

        return $result;
    }

    public function getCategory()
    {
        if (!$this->category_id) {
            return null;
        }
        // lazy require
        require_once __DIR__ . '/../Job-02/Category.php';
        return Category::findOneById($this->category_id);
    }

    // Setters
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->category_id = $categoryId;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setPhotos(array $photos): self
    {
        $this->photos = $photos;
        return $this;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
