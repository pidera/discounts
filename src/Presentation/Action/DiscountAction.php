<?php

declare(strict_types=1);

namespace App\Presentation\Action;

use App\Application\Factory\OrderFactory;
use App\Application\Service\DiscountCalculator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class DiscountAction
{
    public function __construct(
        private OrderFactory $orderFactory,
        private DiscountCalculator $discountCalculator,
    ) {}

    public function __invoke(Request $request, Response $response): Response
    {
        $requestData = (array) $request->getParsedBody();

        // @todo validate data input

        $order = $this->orderFactory->createOrderFromArray($requestData);
        $discounts = $this->discountCalculator->calculateForOrder($order);

        $response->getBody()->write(\json_encode($discounts, JSON_THROW_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
