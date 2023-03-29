<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Customer\CustomerId;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderItem;
use App\Domain\Product\ProductId;
use App\Domain\Product\ProductRepositoryInterface;
use Money\Money;

final readonly class OrderFactory
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function createOrderFromArray(array $data): Order
    {
        return new Order(
            new OrderId($data['id']),
            $this->customerRepository->getById(new CustomerId($data['customer-id'])),
            \array_map(fn (array $itemData): OrderItem => new OrderItem(
                $this->productRepository->getById(new ProductId($itemData['product-id'])),
                (int) $itemData['quantity'],
                Money::EUR($itemData['unit-price']),
                Money::EUR($itemData['total']),
            ), $data['items']),
            Money::EUR($data['total']),
        );
    }
}
