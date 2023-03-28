<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerId;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Exception\NotFoundException;

final readonly class CustomerInMemoryRepository implements CustomerRepositoryInterface
{
    public function __construct(
        public array $customers,
    ) {}

    public function getById(CustomerId $id): Customer
    {
        foreach ($this->customers as $customerData) {
            if (!$id->is($customerData['id'])) {
                continue;
            }

            return Customer::fromArray($customerData);
        }

        throw new NotFoundException();
    }
}
