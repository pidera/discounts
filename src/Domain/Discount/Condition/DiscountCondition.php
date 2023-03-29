<?php

declare(strict_types=1);

namespace App\Domain\Discount\Condition;

use App\Domain\Order\Order;

interface DiscountCondition
{
    public function appliesForOrder(Order $order): bool;
}
