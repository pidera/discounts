<?php

declare(strict_types=1);

namespace Tests\Domain\Customer;

use App\Domain\Customer\CustomerId;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Infrastructure\Repository\InMemory\CustomerInMemoryRepository;
use Money\Money;
use Tests\TestCase;

final class CustomerRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->getContainer()->set(
            CustomerRepositoryInterface::class,
            new CustomerInMemoryRepository($this->customerData())
        );
    }

    public function testGettingCustomerByID(): void
    {
        $repository = $this->getContainer()->get(CustomerRepositoryInterface::class);

        $customer = $repository->getById(new CustomerId('2'));

        self::assertEquals('Iced Tea', $customer->name);
        self::assertEquals('2018-11-16', $customer->since->format('Y-m-d'));
        self::assertEquals(Money::EUR(301.88), $customer->revenue);
    }

    private function customerData(): array
    {
        return [
            [
                'id' => '1',
                'name' => 'Pepsi Cola',
                'since' => '2014-06-28',
                'revenue' => '89.10'
            ],
            [
                'id' => '2',
                'name' => 'Iced Tea',
                'since' => '2018-11-16',
                'revenue' => '301.88'
            ],
        ];
    }
}
