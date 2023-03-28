<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use App\Domain\Order\Order;
use Money\Money;

final readonly class Discount
{
    /**
     * @param DiscountCondition[] $conditions
     * @param DiscountEffect[] $effects
     */
    public function __construct(
        private string $description,
        private array $conditions,
        private array $effects,
    ) {}

    public function appliesForOrder(Order $order): bool
    {
        // @todo check if each condition is fulfilled

        return false;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAppliedAmount(Order $order): Money
    {
        return $order->total;
    }
}
