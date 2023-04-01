<?php

declare(strict_types=1);

namespace Tests\Domain\Discount\Effect;

use App\Domain\Common\Percentage;
use App\Domain\Customer\Customer;
use App\Domain\Discount\Effect\TotalPercentageEffect;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderItem;
use App\Domain\Product\Product;
use Money\Money;
use Tests\TestCase;

final class TotalPercentageEffectTest extends TestCase
{
    public function testItAppliesDiscount(): void
    {
        $order = $this->createOrder();

        $effect = new TotalPercentageEffect(new Percentage(10));
        self::assertEquals(
            Money::EUR(0.99)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );

        $effect = new TotalPercentageEffect(new Percentage(25));
        self::assertEquals(
            Money::EUR(2.475)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );
    }

    private function createOrder(): Order
    {
        return new Order(
            new OrderId('1'),
            Customer::fromArray([
                'id' => '1',
                'name' => 'Pepsi Cola',
                'since' => '2014-06-28',
                'revenue' => '1019.10',
            ]),
            [
                new OrderItem(
                    Product::fromArray([
                        'id' => 'PAT012',
                        'description' => 'Fancy product',
                        'category' => '1',
                        'price' => '4.95'
                    ]),
                    2,
                    Money::EUR(4.95),
                    Money::EUR(9.90),
                ),
            ],
            Money::EUR(9.90)
        );
    }
}
