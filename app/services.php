<?php

declare(strict_types=1);

use App\Application\Service\DiscountCalculator;
use App\Domain\Common\Percentage;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Discount\Condition\CustomerRevenueCondition;
use App\Domain\Discount\Condition\DifferentProductsInCategoryCondition;
use App\Domain\Discount\Condition\ProductOfCategoryAmountCondition;
use App\Domain\Discount\Discount;
use App\Domain\Discount\Effect\FreeProductPerAmountForCategoryEffect;
use App\Domain\Discount\Effect\PercentageOnCheapestProductInCategoryEffect;
use App\Domain\Discount\Effect\TotalPercentageEffect;
use App\Domain\Product\ProductCategoryId;
use App\Domain\Product\ProductRepositoryInterface;
use App\Infrastructure\Repository\File\CustomerFileRepository;
use App\Infrastructure\Repository\File\ProductFileRepository;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Money\Money;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

return [
    FilesystemAdapter::class => DI\create(LocalFilesystemAdapter::class)->constructor(DI\string('{data_path}')),
    CustomerRepositoryInterface::class => \DI\autowire(CustomerFileRepository::class),
    ProductRepositoryInterface::class => \DI\autowire(ProductFileRepository::class),
    DiscountCalculator::class => \DI\factory(static fn() => new DiscountCalculator([
        new Discount(
            'Our valued customers get 10% discount on their order',
            [new CustomerRevenueCondition(Money::EUR(1000))],
            [new TotalPercentageEffect(new Percentage(10))],
        ),
        new Discount(
            'For every product of category "Switches", when you buy five, you get a sixth for free.',
            [new ProductOfCategoryAmountCondition(6, new ProductCategoryId('2'))],
            [new FreeProductPerAmountForCategoryEffect(6, new ProductCategoryId('2'))],
        ),
        new Discount(
            'If you buy two or more products of category "Tools", you get a 20% discount on the cheapest product.',
            [new DifferentProductsInCategoryCondition(2, new ProductCategoryId('1'))],
            [new PercentageOnCheapestProductInCategoryEffect(new Percentage(20), new ProductCategoryId('1'))],
        ),
    ])),
    ValidatorInterface::class => Validation::createValidator(),
];
