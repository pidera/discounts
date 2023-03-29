<?php

declare(strict_types=1);

use App\Application\Service\DiscountCalculator;
use App\Domain\Common\Percentage;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Discount\Condition\CustomerRevenueCondition;
use App\Domain\Discount\Discount;
use App\Domain\Discount\Effect\TotalPercentageEffect;
use App\Domain\Product\ProductRepositoryInterface;
use App\Infrastructure\Repository\File\CustomerFileRepository;
use App\Infrastructure\Repository\File\ProductFileRepository;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Money\Money;

$discountDefinitions = [
    new Discount(
        'Our valued customers get 10% discount on their order',
        [new CustomerRevenueCondition(Money::EUR(1000))],
        [new TotalPercentageEffect(new Percentage(10))],
    ),
];

return [
    FilesystemAdapter::class => DI\create(LocalFilesystemAdapter::class)->constructor(DI\string('{data_path}')),
    CustomerRepositoryInterface::class => \DI\autowire(CustomerFileRepository::class),
    ProductRepositoryInterface::class => \DI\autowire(ProductFileRepository::class),
    DiscountCalculator::class => \DI\create(DiscountCalculator::class)->constructor($discountDefinitions),
];
