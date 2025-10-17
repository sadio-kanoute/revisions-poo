<?php
// Only require legacy global Product if it's not already provided (by aliases or composer autoload)
if (!class_exists('Product')) {
    require_once __DIR__ . '/../Job-01/Product.php';
}
require_once __DIR__ . '/../Job-14/StockableInterface.php';

class Clothing extends Product implements StockableInterface
{
    private ?string $size = null;
    private ?string $color = null;
    private ?string $type = null;
    private int $material_fee = 0;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public function getSize(): ?string { return $this->size; }
    public function getColor(): ?string { return $this->color; }
    public function getType(): ?string { return $this->type; }
    public function getMaterialFee(): int { return $this->material_fee; }

    public function setSize(?string $s): self { $this->size = $s; return $this; }
    public function setColor(?string $c): self { $this->color = $c; return $this; }
    public function setType(?string $t): self { $this->type = $t; return $this; }
    public function setMaterialFee(int $f): self { $this->material_fee = $f; return $this; }

    // Override findOneById to return Clothing instance
    public static function findOneById(int $id)
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        try {
            $stmt = $pdo->prepare('SELECT p.*, c.size, c.color, c.type, c.material_fee FROM product p LEFT JOIN clothing c ON p.id = c.product_id WHERE p.id = :id');
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
            if (!$row) return false;
        } catch (\PDOException $e) {
            // If the clothing table doesn't exist (SQLSTATE 42S02) or any other DB error,
            // fall back to loading the base product and convert to a Clothing instance.
            if ($e->getCode() === '42S02' || strpos($e->getMessage(), 'doesn\'t exist') !== false) {
                // fallback: read base product row directly to avoid calling Product::findOneById (abstract)
                $stmt2 = $pdo->prepare('SELECT * FROM product WHERE id = :id');
                $stmt2->execute(['id' => $id]);
                $rowBase = $stmt2->fetch();
                if (!$rowBase) return false;
                $photosBase = [];
                if (!empty($rowBase['photos'])) {
                    $decoded = json_decode($rowBase['photos'], true);
                    if (is_array($decoded)) $photosBase = $decoded; else $photosBase = [$rowBase['photos']];
                }
                $createdAtBase = isset($rowBase['created_at']) ? new DateTime($rowBase['created_at']) : new DateTime();
                $updatedAtBase = isset($rowBase['updated_at']) ? new DateTime($rowBase['updated_at']) : new DateTime();
                $c = new self((int)$rowBase['id'], $rowBase['name'] ?? '', $photosBase, (int)$rowBase['price'], $rowBase['description'] ?? '', (int)$rowBase['quantity'], $createdAtBase, $updatedAtBase);
                $c->setCategoryId((int)($rowBase['category_id'] ?? 0));
                return $c;
            }
            throw $e;
        }

        $photos = [];
        if (!empty($row['photos'])) {
            $decoded = json_decode($row['photos'], true);
            if (is_array($decoded)) {
                $photos = $decoded;
            } else {
                $photos = [$row['photos']];
            }
        }

        $createdAt = isset($row['created_at']) ? new DateTime($row['created_at']) : new DateTime();
        $updatedAt = isset($row['updated_at']) ? new DateTime($row['updated_at']) : new DateTime();

        $c = new self((int)$row['id'], $row['name'] ?? '', $photos, (int)$row['price'], $row['description'] ?? '', (int)$row['quantity'], $createdAt, $updatedAt);
        $c->setCategoryId((int)($row['category_id'] ?? 0));
        $c->setSize($row['size'] ?? null);
        $c->setColor($row['color'] ?? null);
        $c->setType($row['type'] ?? null);
        $c->setMaterialFee((int)($row['material_fee'] ?? 0));
        return $c;
    }

    public static function findAll(): array
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        try {
            $stmt = $pdo->query('SELECT p.*, c.size, c.color, c.type, c.material_fee FROM product p LEFT JOIN clothing c ON p.id = c.product_id');
            $rows = $stmt->fetchAll();
            $out = [];
            foreach ($rows as $row) {
                $c = self::findOneById((int)$row['id']);
                if ($c !== false) $out[] = $c;
            }
            return $out;
        } catch (\PDOException $e) {
            // If clothing table missing, fall back to products and cast them to Clothing
            if ($e->getCode() === '42S02' || strpos($e->getMessage(), 'doesn\'t exist') !== false) {
                // fallback: query product table directly and instantiate Clothing
                $stmt2 = $pdo->query('SELECT * FROM product');
                $rows2 = $stmt2->fetchAll();
                $out = [];
                foreach ($rows2 as $b) {
                    $photosB = [];
                    if (!empty($b['photos'])) {
                        $decoded = json_decode($b['photos'], true);
                        if (is_array($decoded)) $photosB = $decoded; else $photosB = [$b['photos']];
                    }
                    $createdAtB = isset($b['created_at']) ? new DateTime($b['created_at']) : new DateTime();
                    $updatedAtB = isset($b['updated_at']) ? new DateTime($b['updated_at']) : new DateTime();
                    $c = new self((int)$b['id'], $b['name'] ?? '', $photosB, (int)$b['price'], $b['description'] ?? '', (int)$b['quantity'], $createdAtB, $updatedAtB);
                    $c->setCategoryId((int)($b['category_id'] ?? 0));
                    $out[] = $c;
                }
                return $out;
            }
            throw $e;
        }
    }

    public function create()
    {
        $res = parent::create();
        if ($res === false) return false;
        // insert clothing row
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        try {
            $stmt = $pdo->prepare('REPLACE INTO clothing (product_id, size, color, type, material_fee) VALUES (:product_id, :size, :color, :type, :material_fee)');
            $stmt->execute([
                'product_id' => $this->getId(),
                'size' => $this->size,
                'color' => $this->color,
                'type' => $this->type,
                'material_fee' => $this->material_fee,
            ]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '42S02' || strpos($e->getMessage(), 'doesn\'t exist') !== false) {
                // child table missing - ignore
            } else {
                throw $e;
            }
        }
        return $this;
    }

    public function update()
    {
        $res = parent::update();
        if ($res === false) return false;
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        try {
            $stmt = $pdo->prepare('REPLACE INTO clothing (product_id, size, color, type, material_fee) VALUES (:product_id, :size, :color, :type, :material_fee)');
            return $stmt->execute([
                'product_id' => $this->getId(),
                'size' => $this->size,
                'color' => $this->color,
                'type' => $this->type,
                'material_fee' => $this->material_fee,
            ]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '42S02' || strpos($e->getMessage(), 'doesn\'t exist') !== false) {
                // child table missing — ignore and return true since base update succeeded
                return true;
            }
            throw $e;
        }
    }

    // StockableInterface
    public function addStocks(int $stock): self
    {
        $this->quantity += $stock;
        return $this;
    }

    public function removeStocks(int $stock): self
    {
        $this->quantity = max(0, $this->quantity - $stock);
        return $this;
    }
}
