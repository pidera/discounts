<?php

declare(strict_types=1);

namespace App\Domain\Product;

use Money\Money;

final readonly class Product
{
    private function __construct(
        public ProductId $id,
        public string $description,
        public ProductCategoryId $categoryId,
        public Money $price,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            new ProductId($data['id']),
            $data['description'],
            new ProductCategoryId($data['category']),
            Money::EUR($data['price']),
        );
    }
}
