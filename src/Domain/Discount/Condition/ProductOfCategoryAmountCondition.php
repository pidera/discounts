<?php

declare(strict_types=1);

namespace App\Domain\Discount\Condition;

use App\Domain\Order\Order;
use App\Domain\Product\ProductCategoryId;

final readonly class ProductOfCategoryAmountCondition implements DiscountCondition
{
    public function __construct(
        private int $quantity,
        private ProductCategoryId $categoryId,
    ) {}

    public function appliesForOrder(Order $order): bool
    {
        foreach ($order->items as $orderItem) {
            if ($orderItem->quantity < $this->quantity) {
                continue;
            }

            if (!$orderItem->product->categoryId->equals($this->categoryId)) {
                continue;
            }

            return true;
        }

        return false;
    }
}
