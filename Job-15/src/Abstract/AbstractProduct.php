<?php
namespace App\Abstract;

use DateTime;

abstract class AbstractProduct
{
    protected int $id;
    protected int $category_id;
    protected string $name;
    protected array $photos;
    protected int $price;
    protected string $description;
    protected int $quantity;
    protected DateTime $createdAt;
    protected DateTime $updatedAt;

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

    abstract public static function findOneById(int $id);
    abstract public static function findAll(): array;
    abstract public function create();
    abstract public function update();
}
