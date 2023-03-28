<?php

declare(strict_types=1);

namespace App\Presentation\Action;

use App\Application\Service\DiscountCalculator;
use App\Domain\Order\Order;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class DiscountAction
{
    public function __construct(
        private DiscountCalculator $discountCalculator,
    ) {}

    public function __invoke(Request $request, Response $response): Response
    {
        $requestData = (array) $request->getParsedBody();

        // @todo validate data input

        $discounts = $this->discountCalculator->calculateForOrder(Order::fromArray($requestData));

        $response->getBody()->write(\json_encode($discounts, JSON_THROW_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
