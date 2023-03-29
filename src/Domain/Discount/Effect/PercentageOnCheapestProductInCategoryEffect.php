<?php

declare(strict_types=1);

namespace App\Domain\Discount\Effect;

use App\Domain\Common\Percentage;
use App\Domain\Order\Order;
use App\Domain\Product\ProductCategoryId;
use Money\Money;

final readonly class PercentageOnCheapestProductInCategoryEffect implements DiscountEffect
{
    public function __construct(
        private Percentage $percentage,
        private ProductCategoryId $categoryId,
    ) {}

    public function addDiscountEffect(Money $amount, Order $order): Money
    {
        $cheapestOrderItem = null;
        foreach ($order->items as $orderItem) {
            if (!$orderItem->product->categoryId->equals($this->categoryId)) {
                continue;
            }

            $cheapestOrderItem ??= $orderItem;

            if ($orderItem->unitPrice->lessThan($cheapestOrderItem->unitPrice)) {
                $cheapestOrderItem = $orderItem;
            }
        }

        if ($cheapestOrderItem === null) {
            return $amount;
        }

        return $amount->add($cheapestOrderItem->unitPrice->multiply($this->percentage->toFloat()));
    }
}
