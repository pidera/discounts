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

        $request = $this->createRequest('POST', '/')->withParsedBody($this->orderData());
        $response = $app->handle($request);

        $this->assertEquals(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }

    private function orderData(): array
    {
        return [
            'id' => '1',
            'customer-id' => '2',
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => '2',
                    'unit-price' => '3.34',
                    'total' => '6.68',
                ],
                [
                    'product-id' => 'A204',
                    'quantity' => '1',
                    'unit-price' => '8.27',
                    'total' => '8.27',
                ],
            ],
            'total' => '14.95',
        ];
    }
}
