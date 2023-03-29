<?php

declare(strict_types=1);

namespace App\Presentation\View;

use App\Domain\Discount\Discount;
use App\Domain\Order\Order;
use Money\Money;

final readonly class DiscountView implements \JsonSerializable
{
    private function __construct(
        public string $description,
        public Money $amount,
    ) {}

    public static function fromDiscount(Discount $discount, Order $order): self
    {
        return new self(
            $discount->getDescription(),
            $discount->getAppliedAmount($order),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'amount' => $this->amount->formattedString(),
        ];
    }
}
