<?php

declare(strict_types=1);

use App\Domain\Customer\CustomerRepositoryInterface;
use App\Infrastructure\Repository\File\CustomerFileRepository;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;

return [
    FilesystemAdapter::class => DI\create(LocalFilesystemAdapter::class)->constructor(DI\string('{data_path}')),
    CustomerRepositoryInterface::class => \DI\autowire(CustomerFileRepository::class),
];
