<?php

declare(strict_types=1);

namespace Tests\Application\Factory;

use App\Application\Factory\OrderFactory;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Product\ProductRepositoryInterface;
use App\Infrastructure\Repository\InMemory\CustomerInMemoryRepository;
use App\Infrastructure\Repository\InMemory\ProductInMemoryRepository;
use Money\Money;
use Tests\TestCase;

final class OrderFactoryTest extends TestCase
{
    public function testOrderCreatedFromData(): void
    {
        $orderFactory = new OrderFactory(
            new CustomerInMemoryRepository($this->customerData()),
            new ProductInMemoryRepository($this->productData())
        );

        $order = $orderFactory->createOrderFromArray($this->orderData());

        self::assertTrue($order->id->is('1'));
        self::assertTrue($order->customer->id->is('2'));
        self::assertCount(2, $order->items);
        self::assertEquals(Money::EUR(14.95), $order->total);

        $firstItem = $order->items[0];
        self::assertTrue($firstItem->product->id->is('A101'));
        self::assertEquals(2, $firstItem->quantity);
        self::assertEquals(Money::EUR(3.34), $firstItem->unitPrice);
        self::assertEquals(Money::EUR(6.68), $firstItem->total);

        $secondItem = $order->items[1];
        self::assertTrue($secondItem->product->id->is('A204'));
        self::assertEquals(1, $secondItem->quantity);
        self::assertEquals(Money::EUR(8.27), $secondItem->unitPrice);
        self::assertEquals(Money::EUR(8.27), $secondItem->total);
    }

    private function customerData(): array
    {
        return [
            [
                'id' => '2',
                'name' => 'Iced Tea',
                'since' => '2018-11-16',
                'revenue' => '301.88'
            ],
        ];
    }

    private function productData(): array
    {
        return [
            [
                'id' => 'A101',
                'description' => 'Fancy product',
                'category' => '1',
                'price' => '14.95'
            ],
            [
                'id' => 'A204',
                'description' => 'Another product',
                'category' => '2',
                'price' => '19.32'
            ],
        ];
    }

    private function orderData(): array
    {
        return [
            'id' => '1',
            'customer-id' => '2',
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => '2',
                    'unit-price' => '3.34',
                    'total' => '6.68',
                ],
                [
                    'product-id' => 'A204',
                    'quantity' => '1',
                    'unit-price' => '8.27',
                    'total' => '8.27',
                ],
            ],
            'total' => '14.95',
        ];
    }
}
