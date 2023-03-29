<?php

declare(strict_types=1);

namespace App\Domain\Common;

abstract readonly class AbstractId
{
    public function __construct(
        public string $id,
    ) {}

    public function equals(self $other): bool
    {
        return $this->id === $other->id;
    }

    public function is(string $id): bool
    {
        return $this->id === $id;
    }
}
