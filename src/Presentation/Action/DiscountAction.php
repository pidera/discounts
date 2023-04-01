<?php

declare(strict_types=1);

namespace App\Presentation\Action;

use App\Application\Factory\OrderFactory;
use App\Application\Service\DiscountCalculator;
use App\Application\Validation\DiscountRequestConstraints;
use App\Presentation\Response\JsonResponseParser;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class DiscountAction
{
    public function __construct(
        private OrderFactory $orderFactory,
        private DiscountCalculator $discountCalculator,
        private ValidatorInterface $validator,
        private JsonResponseParser $jsonResponseParser,
    ) {}

    public function __invoke(Request $request, Response $response): Response
    {
        $requestData = (array) $request->getParsedBody();

        $violations = $this->validator->validate($requestData, DiscountRequestConstraints::getConstraints());
        if ($violations->count() > 0) {
            return $this->jsonResponseParser->parseViolations($violations, $response);
        }

        $order = $this->orderFactory->createOrderFromArray($requestData);
        $discounts = $this->discountCalculator->calculateForOrder($order);

        return $this->jsonResponseParser->parse($discounts, $response);
    }
}
