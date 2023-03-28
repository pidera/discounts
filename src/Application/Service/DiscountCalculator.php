<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Discount\Discount;
use App\Domain\Order\Order;
use App\Presentation\View\DiscountView;

final readonly class DiscountCalculator
{
    /** @param Discount[] $discounts */
    public function __construct(
        private array $discounts,
    ) {}

    public function calculateForOrder(Order $order): array
    {
        $appliedDiscounts = [];
        foreach ($this->discounts as $discount) {
            if (!$discount->appliesForOrder($order)) {
                continue;
            }

            $appliedDiscounts[] = DiscountView::fromDiscount($discount, $order);
        }

        return $appliedDiscounts;
    }
}
