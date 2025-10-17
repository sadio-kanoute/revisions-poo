<?php

class Category
{
    private int $id;
    private string $name;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $description = '',
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
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

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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

    // DB helpers
    public static function findOneById(int $id)
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM category WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            return false;
        }
        $category = new self(
            (int)$row['id'],
            $row['name'] ?? '',
            $row['description'] ?? '',
            isset($row['created_at']) ? new DateTime($row['created_at']) : new DateTime(),
            isset($row['updated_at']) ? new DateTime($row['updated_at']) : new DateTime()
        );
        return $category;
    }

    public function getProducts(): array
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT id FROM product WHERE category_id = :id');
        $stmt->execute(['id' => $this->id]);
        $rows = $stmt->fetchAll();
        $out = [];
        foreach ($rows as $r) {
            require_once __DIR__ . '/../Job-11/Clothing.php';
            $p = Clothing::findOneById((int)$r['id']);
            if ($p !== false) {
                $out[] = $p;
            }
        }
        return $out;
    }
}
