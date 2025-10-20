<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;

class Electronic extends AbstractProduct implements StockableInterface
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
