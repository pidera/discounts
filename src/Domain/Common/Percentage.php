<?php

declare(strict_types=1);

namespace App\Domain\Common;

final readonly class Percentage
{
    public function __construct(
        private int $percentage,
    ) {
        if ($this->percentage < 0) {
            throw new \DomainException('Percentage cannot be lower than 0');
        }

        if ($this->percentage > 100) {
            throw new \DomainException('Percentage cannot be higher than 100');
        }
    }

    public function toFloat(): float
    {
        return $this->percentage / 100;
    }
}
