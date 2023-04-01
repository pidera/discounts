<?php

declare(strict_types=1);

namespace Tests\Domain\Discount\Effect;

use App\Domain\Customer\Customer;
use App\Domain\Discount\Effect\FreeProductPerAmountForCategoryEffect;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderItem;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCategoryId;
use Money\Money;
use Tests\TestCase;

final class FreeProductPerAmountForCategoryEffectTest extends TestCase
{
    public function testItAppliesDiscount(): void
    {
        $order = $this->createOrder();

        $effect = new FreeProductPerAmountForCategoryEffect(16, new ProductCategoryId('1'));
        self::assertEquals(
            Money::EUR(4.95)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );

        $effect = new FreeProductPerAmountForCategoryEffect(8, new ProductCategoryId('1'));
        self::assertEquals(
            Money::EUR(9.90)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );

        $effect = new FreeProductPerAmountForCategoryEffect(4, new ProductCategoryId('1'));
        self::assertEquals(
            Money::EUR(19.80)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );

        $effect = new FreeProductPerAmountForCategoryEffect(3, new ProductCategoryId('1'));
        self::assertEquals(
            Money::EUR(24.75)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );
    }

    public function testItDoesNotApplyDiscount(): void
    {
        $order = $this->createOrder();

        $effect = new FreeProductPerAmountForCategoryEffect(17, new ProductCategoryId('1'));
        self::assertEquals(
            Money::EUR(0)->formattedString(),
            $effect->addDiscountEffect(Money::EUR(0), $order)->formattedString()
        );

        $effect = new FreeProductPerAmountForCategoryEffect(1, new ProductCategoryId('2'));
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
                    16,
                    Money::EUR(4.95),
                    Money::EUR(79.20),
                ),
            ],
            Money::EUR(79.20)
        );
    }
}
