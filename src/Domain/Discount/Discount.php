<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use App\Domain\Discount\Condition\DiscountCondition;
use App\Domain\Discount\Effect\DiscountEffect;
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
        foreach ($this->conditions as $condition) {
            if (!$condition->appliesForOrder($order)) {
                return false;
            }
        }

        return true;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAppliedAmount(Order $order): Money
    {
        $amount = Money::EUR(0);
        foreach ($this->effects as $effect) {
            $amount = $effect->addDiscountEffect($amount, $order);
        }

        return $amount;
    }
}
