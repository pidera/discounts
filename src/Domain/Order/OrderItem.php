<?php

declare(strict_types=1);

namespace App\Domain\Order;

use App\Domain\Product\Product;
use Money\Money;

final readonly class OrderItem
{
    public function __construct(
        public Product $product,
        public int $quantity,
        public Money $unitPrice,
        public Money $total,
    ) {}
}
