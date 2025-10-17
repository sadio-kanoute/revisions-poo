<?php
// Only require legacy global Product if it's not already provided (by aliases or composer autoload)
if (!class_exists('Product')) {
    require_once __DIR__ . '/../Job-01/Product.php';
}
require_once __DIR__ . '/../Job-14/StockableInterface.php';

class Electronic extends Product implements StockableInterface
{
    private ?string $brand = null;
    private int $warranty_fee = 0;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public function getBrand(): ?string { return $this->brand; }
    public function getWarrantyFee(): int { return $this->warranty_fee; }

    public function setBrand(?string $b): self { $this->brand = $b; return $this; }
    public function setWarrantyFee(int $f): self { $this->warranty_fee = $f; return $this; }

    public static function findOneById(int $id)
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        try {
            $stmt = $pdo->prepare('SELECT p.*, e.brand, e.warranty_fee FROM product p LEFT JOIN electronic e ON p.id = e.product_id WHERE p.id = :id');
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
            if (!$row) return false;
        } catch (\PDOException $e) {
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
                $eObj = new self((int)$rowBase['id'], $rowBase['name'] ?? '', $photosBase, (int)$rowBase['price'], $rowBase['description'] ?? '', (int)$rowBase['quantity'], $createdAtBase, $updatedAtBase);
                $eObj->setCategoryId((int)($rowBase['category_id'] ?? 0));
                return $eObj;
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

        $e = new self((int)$row['id'], $row['name'] ?? '', $photos, (int)$row['price'], $row['description'] ?? '', (int)$row['quantity'], $createdAt, $updatedAt);
        $e->setCategoryId((int)($row['category_id'] ?? 0));
        $e->setBrand($row['brand'] ?? null);
        $e->setWarrantyFee((int)($row['warranty_fee'] ?? 0));
        return $e;
    }

    public static function findAll(): array
    {
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        try {
            $stmt = $pdo->query('SELECT p.*, e.brand, e.warranty_fee FROM product p LEFT JOIN electronic e ON p.id = e.product_id');
            $rows = $stmt->fetchAll();
            $out = [];
            foreach ($rows as $row) {
                $e = self::findOneById((int)$row['id']);
                if ($e !== false) $out[] = $e;
            }
            return $out;
        } catch (\PDOException $e) {
            if ($e->getCode() === '42S02' || strpos($e->getMessage(), 'doesn\'t exist') !== false) {
                // fallback: query product table directly and instantiate Electronic
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
                    $eObj = new self((int)$b['id'], $b['name'] ?? '', $photosB, (int)$b['price'], $b['description'] ?? '', (int)$b['quantity'], $createdAtB, $updatedAtB);
                    $eObj->setCategoryId((int)($b['category_id'] ?? 0));
                    $out[] = $eObj;
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
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        $stmt = $pdo->prepare('REPLACE INTO electronic (product_id, brand, warranty_fee) VALUES (:product_id, :brand, :warranty_fee)');
        $stmt->execute([
            'product_id' => $this->getId(),
            'brand' => $this->brand,
            'warranty_fee' => $this->warranty_fee,
        ]);
        return $this;
    }

    public function update()
    {
        $res = parent::update();
        if ($res === false) return false;
        require_once __DIR__ . '/../Job-03/db.php';
        $pdo = getPDO();
        $stmt = $pdo->prepare('REPLACE INTO electronic (product_id, brand, warranty_fee) VALUES (:product_id, :brand, :warranty_fee)');
        return $stmt->execute([
            'product_id' => $this->getId(),
            'brand' => $this->brand,
            'warranty_fee' => $this->warranty_fee,
        ]);
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
