<?php

declare(strict_types=1);

namespace Tests\Domain\Discount\Condition;

use App\Domain\Customer\Customer;
use App\Domain\Discount\Condition\ProductOfCategoryAmountCondition;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderItem;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCategoryId;
use Money\Money;
use Tests\TestCase;

final class ProductsOfCategoryAmountConditionTest extends TestCase
{
    public function testItAppliesWhenAmountIsHigher(): void
    {
        $order = $this->createOrder();

        $condition = new ProductOfCategoryAmountCondition(2, new ProductCategoryId('1'));
        self::assertTrue($condition->appliesForOrder($order));
    }

    public function testItAppliesWhenAmountIsEqual(): void
    {
        $order = $this->createOrder();

        $condition = new ProductOfCategoryAmountCondition(3, new ProductCategoryId('1'));
        self::assertTrue($condition->appliesForOrder($order));
    }

    public function testItDoesNotApplyWhenAmountIsLower(): void
    {
        $order = $this->createOrder();

        $condition = new ProductOfCategoryAmountCondition(4, new ProductCategoryId('1'));
        self::assertFalse($condition->appliesForOrder($order));
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
                    3,
                    Money::EUR(4.95),
                    Money::EUR(14.85),
                ),
            ],
            Money::EUR(14.85)
        );
    }
}
