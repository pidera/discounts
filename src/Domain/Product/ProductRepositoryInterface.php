<?php
declare(strict_types=1);

namespace App\Domain\Product;

interface ProductRepositoryInterface
{
    public function getById(ProductId $id): Product;
}
