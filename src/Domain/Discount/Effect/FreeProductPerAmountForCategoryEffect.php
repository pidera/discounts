<?php

declare(strict_types=1);

namespace App\Domain\Discount\Effect;

use App\Domain\Order\Order;
use App\Domain\Product\ProductCategoryId;
use Money\Money;

final readonly class FreeProductPerAmountForCategoryEffect
{
    public function __construct(
        private int $quantity,
        private ProductCategoryId $categoryId,
    ) {}

    public function addDiscountEffect(Money $amount, Order $order): Money
    {
        foreach ($order->items as $orderItem) {
            if ($orderItem->quantity < $this->quantity) {
                continue;
            }

            if (!$orderItem->product->categoryId->equals($this->categoryId)) {
                continue;
            }

            $amountOfFreeProducts = \floor($orderItem->quantity / $this->quantity);
            $amount = $amount->add($orderItem->unitPrice->multiply(\floor($amountOfFreeProducts)));
        }

        return $amount;
    }
}
