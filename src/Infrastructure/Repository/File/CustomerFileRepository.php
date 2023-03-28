<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\File;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerId;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Exception\NotFoundException;

final readonly class CustomerFileRepository extends FileRepository implements CustomerRepositoryInterface
{
    public function getById(CustomerId $id): Customer
    {
        foreach ($this->getData() as $customerData) {
            if (!$id->is($customerData['id'])) {
                continue;
            }

            return Customer::fromArray($customerData);
        }

        throw new NotFoundException();
    }

    public function getFilename(): string
    {
        return 'customers.json';
    }
}
