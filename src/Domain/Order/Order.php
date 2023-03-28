<?php

declare(strict_types=1);

namespace App\Domain\Order;

use App\Domain\Customer\CustomerId;
use Money\Money;

final readonly class Order
{
    /** @param OrderItem[] $items */
    private function __construct(
        public OrderId $id,
        public CustomerId $customerId,
        public array $items,
        public Money $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            new OrderId($data['id']),
            new CustomerId($data['customer-id']),
            \array_map(OrderItem::fromArray(...), $data['items']),
            Money::EUR($data['total']),
        );
    }
}
