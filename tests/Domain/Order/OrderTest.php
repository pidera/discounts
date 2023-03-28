<?php

declare(strict_types=1);

namespace Tests\Domain\Order;

use App\Domain\Order\Order;
use Money\Money;
use Tests\TestCase;

final class OrderTest extends TestCase
{
    public function testOrderCreatedFromData(): void
    {
        $order = Order::fromArray($this->orderData());

        self::assertTrue($order->id->is('1'));
        self::assertTrue($order->customerId->is('2'));
        self::assertCount(2, $order->items);
        self::assertEquals(Money::EUR(14.95), $order->total);

        $firstItem = $order->items[0];
        self::assertTrue($firstItem->productId->is('A101'));
        self::assertEquals(2, $firstItem->quantity);
        self::assertEquals(Money::EUR(3.34), $firstItem->unitPrice);
        self::assertEquals(Money::EUR(6.68), $firstItem->total);

        $secondItem = $order->items[1];
        self::assertTrue($secondItem->productId->is('A204'));
        self::assertEquals(1, $secondItem->quantity);
        self::assertEquals(Money::EUR(8.27), $secondItem->unitPrice);
        self::assertEquals(Money::EUR(8.27), $secondItem->total);
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
