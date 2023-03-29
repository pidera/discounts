<?php

declare(strict_types=1);

namespace App\Domain\Discount\Condition;

use App\Domain\Order\Order;
use Money\Money;

final readonly class CustomerRevenueCondition implements DiscountCondition
{
    public function __construct(
        private Money $minRevenue,
    ) {}

    public function appliesForOrder(Order $order): bool
    {
        return $order->customer->revenue->greaterThan($this->minRevenue);
    }
}
