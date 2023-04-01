<?php

declare(strict_types=1);

namespace App\Presentation\Response;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class JsonResponseParser
{
    public function parse(array $values, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(\json_encode($values, JSON_THROW_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function parseViolations(
        ConstraintViolationListInterface $violationList,
        ResponseInterface $response
    ): ResponseInterface {
        $violations = [];

        foreach ($violationList as $violation) {
            \assert($violation instanceof ConstraintViolation);
            $violations[] = [
                'field' => $violation->getPropertyPath(),
                'error' => $violation->getMessage(),
            ];
        }

        return $this->parse($violations, $response)->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}
