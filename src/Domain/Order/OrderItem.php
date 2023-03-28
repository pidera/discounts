<?php

declare(strict_types=1);

namespace App\Domain\Order;

use App\Domain\Product\ProductId;
use Money\Money;

final readonly class OrderItem
{
    private function __construct(
        public ProductId $productId,
        public int $quantity,
        public Money $unitPrice,
        public Money $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            new ProductId($data['product-id']),
            (int) $data['quantity'],
            Money::EUR($data['unit-price']),
            Money::EUR($data['total']),
        );
    }
}
