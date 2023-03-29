<?php

declare(strict_types=1);

namespace App\Domain\Discount\Effect;

use App\Domain\Order\Order;
use Money\Money;

interface DiscountEffect
{
    public function addDiscountEffect(Money $amount, Order $order): Money;
}
