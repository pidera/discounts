<?php

declare(strict_types=1);

namespace App\Domain\Order;

use App\Domain\Customer\Customer;
use Money\Money;

final readonly class Order
{
    /** @param OrderItem[] $items */
    public function __construct(
        public OrderId $id,
        public Customer $customer,
        public array $items,
        public Money $total,
    ) {}
}
