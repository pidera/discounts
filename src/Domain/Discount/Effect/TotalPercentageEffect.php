<?php

declare(strict_types=1);

namespace App\Domain\Discount\Effect;

use App\Domain\Common\Percentage;
use App\Domain\Order\Order;
use Money\Money;

final readonly class TotalPercentageEffect implements DiscountEffect
{
    public function __construct(
        private Percentage $percentage,
    ) {}

    public function addDiscountEffect(Money $amount, Order $order): Money
    {
        return $amount->add($order->total->multiply($this->percentage->toFloat()));
    }
}
