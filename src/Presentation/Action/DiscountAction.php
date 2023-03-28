<?php

declare(strict_types=1);

namespace App\Presentation\Action;

use App\Domain\Order\Order;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class DiscountAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $requestData = (array) $request->getParsedBody();

        // @todo validate data input

        $order = Order::fromArray($requestData);

        // @todo calculate discounts for provided order and return in response

        return $response;
    }
}
