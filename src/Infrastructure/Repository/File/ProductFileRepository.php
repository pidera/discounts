<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\File;

use App\Domain\Exception\NotFoundException;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Domain\Product\ProductRepositoryInterface;

final readonly class ProductFileRepository extends FileRepository implements ProductRepositoryInterface
{
    public function getById(ProductId $id): Product
    {
        foreach ($this->getData() as $productData) {
            if (!$id->is($productData['id'])) {
                continue;
            }

            return Product::fromArray($productData);
        }

        throw new NotFoundException();
    }

    public function getFilename(): string
    {
        return 'products.json';
    }
}
