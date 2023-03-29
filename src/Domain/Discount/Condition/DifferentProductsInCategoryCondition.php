<?php

declare(strict_types=1);

namespace App\Domain\Discount\Condition;

use App\Domain\Order\Order;
use App\Domain\Product\ProductCategoryId;

final readonly class DifferentProductsInCategoryCondition implements DiscountCondition
{
    public function __construct(
        private int $amount,
        private ProductCategoryId $categoryId,
    ) {}

    public function appliesForOrder(Order $order): bool
    {
        $amountOfProducts = 0;
        foreach ($order->items as $orderItem) {
            if (!$orderItem->product->categoryId->equals($this->categoryId)) {
                continue;
            }

            $amountOfProducts++;
        }

        return $amountOfProducts >= $this->amount;
    }
}
