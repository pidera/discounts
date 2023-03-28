<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Exception\NotFoundException;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Domain\Product\ProductRepositoryInterface;

final readonly class ProductInMemoryRepository implements ProductRepositoryInterface
{
    public function __construct(
        public array $products,
    ) {}

    public function getById(ProductId $id): Product
    {
        foreach ($this->products as $productData) {
            if (!$id->is($productData['id'])) {
                continue;
            }

            return Product::fromArray($productData);
        }

        throw new NotFoundException();
    }
}
