<?php

declare(strict_types=1);

namespace App\Application\Validation;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

final class DiscountRequestConstraints
{
    public static function getConstraints(): Collection
    {
        return new Collection([
            'id' => new Type('string'),
            'customer-id' => new Type('string'),
            'items' => [
                new Type('array'),
                new Count(['min' => 1]),
                new All([
                    new Collection([
                        'product-id' => new Type('string'),
                        'quantity' => new Positive(),
                        'unit-price' => new Positive(),
                        'total' => new Positive(),
                    ]),
                ]),
            ],
            'total' => new Positive(),
        ]);
    }
}
