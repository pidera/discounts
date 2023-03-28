<?php

declare(strict_types=1);

namespace Tests\Presentation\Action;

use Fig\Http\Message\StatusCodeInterface;
use Tests\TestCase;

final class DiscountActionTest extends TestCase
{
    public function testAction(): void
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/');
        $response = $app->handle($request);

        $this->assertEquals(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
