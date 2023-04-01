<?php

declare(strict_types=1);

namespace Tests\Domain\Discount\Condition;

use App\Domain\Customer\Customer;
use App\Domain\Discount\Condition\CustomerRevenueCondition;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderItem;
use App\Domain\Product\Product;
use Money\Money;
use Tests\TestCase;

final class CustomerRevenueConditionTest extends TestCase
{
    public function testItAppliesWhenRevenueIsHigher(): void
    {
        $order = $this->createOrder();

        $condition = new CustomerRevenueCondition(Money::EUR(1000));
        self::assertTrue($condition->appliesForOrder($order));
    }

    public function testItDoesNotApplyWhenRevenueIsEqual(): void
    {
        $order = $this->createOrder();

        $condition = new CustomerRevenueCondition(Money::EUR(1019.10));
        self::assertFalse($condition->appliesForOrder($order));
    }

    public function testItDoesNotApplyWhenRevenueIsLower(): void
    {
        $order = $this->createOrder();

        $condition = new CustomerRevenueCondition(Money::EUR(1019.11));
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
                    2,
                    Money::EUR(4.95),
                    Money::EUR(9.90),
                ),
            ],
            Money::EUR(9.90)
        );
    }
}
