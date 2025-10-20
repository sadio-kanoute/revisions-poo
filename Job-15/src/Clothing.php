<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;
use DateTime;

class Clothing extends AbstractProduct implements StockableInterface
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

    // Note: persistence methods intentionally omitted in PSR-4 demo; the legacy
    // Job-01/Product and Job-03/db.php provide database helpers. If you want
    // DB methods here, we can implement them and call getPDO() similarly.

    public static function findOneById(int $id)
    {
        // Delegate to legacy code to avoid duplication if present
        if (class_exists('\\Product')) {
            return \Product::findOneById($id);
        }
        return false;
    }

    public static function findAll(): array
    {
        if (class_exists('\\Product')) {
            return \Product::findAll();
        }
        return [];
    }

    public function create() { /* left intentionally empty for demo */ }
    public function update() { /* left intentionally empty for demo */ }

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
