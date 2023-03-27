<?php

declare(strict_types=1);

namespace App\Presentation\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class DiscountAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        return $response;
    }
}
