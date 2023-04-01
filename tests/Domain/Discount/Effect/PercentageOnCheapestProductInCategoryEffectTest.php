<?php

declare(strict_types=1);

namespace Tests\Domain\Discount\Effect;

use App\Domain\Common\Percentage;
use App\Domain\Customer\Customer;
use App\Domain\Discount\Effect\PercentageOnCheapestProductInCategoryEffect;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderItem;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCategoryId;
use Money\Money;
use Tests\TestCase;

final class PercentageOnCheapestProductInCategoryEffectTest extends TestCase
{
    public function testItAppliesDiscount(): void
    {
        $order = $this->createOrder();

        $effect = new PercentageOnCheapestProductInCategoryEffect(new Percentage(10), new ProductCategoryId('1'));
        self::assertEquals(
            Money::EUR(0.495)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );

        $effect = new PercentageOnCheapestProductInCategoryEffect(new Percentage(25), new ProductCategoryId('1'));
        self::assertEquals(
            Money::EUR(1.2375)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );

        $effect = new PercentageOnCheapestProductInCategoryEffect(new Percentage(10), new ProductCategoryId('2'));
        self::assertEquals(
            Money::EUR(0.099)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );
    }

    public function testItDoesNotApplyDiscount(): void
    {
        $order = $this->createOrder();

        $effect = new PercentageOnCheapestProductInCategoryEffect(new Percentage(10), new ProductCategoryId('3'));
        self::assertEquals(
            Money::EUR(0)->formattedString(),
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
                new OrderItem(
                    Product::fromArray([
                        'id' => 'PAT013',
                        'description' => 'Fancy product two',
                        'category' => '1',
                        'price' => '12.74'
                    ]),
                    1,
                    Money::EUR(12.74),
                    Money::EUR(12.74),
                ),
                new OrderItem(
                    Product::fromArray([
                        'id' => 'PAT013',
                        'description' => 'Fancy product two',
                        'category' => '2',
                        'price' => '0.99'
                    ]),
                    1,
                    Money::EUR(0.99),
                    Money::EUR(0.99),
                ),
            ],
            Money::EUR(23.63)
        );
    }
}
