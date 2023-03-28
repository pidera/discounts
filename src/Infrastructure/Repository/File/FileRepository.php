<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\File;

use League\Flysystem\FilesystemAdapter;

abstract readonly class FileRepository
{
    public function __construct(
        private FilesystemAdapter $adapter
    ) {}

    abstract public function getFilename(): string;

    public function getData(): array
    {
        return \json_decode($this->adapter->read($this->getFilename()), true, 512, JSON_THROW_ON_ERROR);
    }
}
