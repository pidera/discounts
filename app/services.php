<?php

declare(strict_types=1);

use App\Application\Service\DiscountCalculator;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Product\ProductRepositoryInterface;
use App\Infrastructure\Repository\File\CustomerFileRepository;
use App\Infrastructure\Repository\File\ProductFileRepository;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;

return [
    FilesystemAdapter::class => DI\create(LocalFilesystemAdapter::class)->constructor(DI\string('{data_path}')),
    CustomerRepositoryInterface::class => \DI\autowire(CustomerFileRepository::class),
    ProductRepositoryInterface::class => \DI\autowire(ProductFileRepository::class),
    DiscountCalculator::class => \DI\create(DiscountCalculator::class)->constructor([]),
];
