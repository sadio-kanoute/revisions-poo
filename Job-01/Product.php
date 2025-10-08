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
}
