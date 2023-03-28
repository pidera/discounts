<?php

declare(strict_types=1);

namespace App\Domain\Customer;

use Money\Money;

final readonly class Customer
{
    private function __construct(
        public CustomerId $id,
        public string $name,
        public \DateTimeImmutable $since,
        public Money $revenue,
    ) {}

    public static function fromArray(array $data): self
    {
        if (($since = \DateTimeImmutable::createFromFormat('Y-m-d', $data['since'])) === false) {
            throw new \DomainException('Could not create Customer with invalid since date');
        }

        return new self(
            new CustomerId($data['id']),
            $data['name'],
            $since,
            Money::EUR($data['revenue']),
        );
    }
}
