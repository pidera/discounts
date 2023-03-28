<?php

declare(strict_types=1);

namespace App\Presentation\View;

use App\Domain\Discount\Discount;
use App\Domain\Order\Order;

final readonly class DiscountView
{
    private function __construct(
        public string $description,
        public float $amount,
    ) {}

    public static function fromDiscount(Discount $discount, Order $order): self
    {
        return new self(
            $discount->getDescription(),
            $discount->getAppliedAmount($order)->getAmount(),
        );
    }
}
