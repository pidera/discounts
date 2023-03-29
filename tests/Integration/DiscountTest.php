<?php

declare(strict_types=1);

namespace Tests\Integration;

use Fig\Http\Message\StatusCodeInterface;
use Money\Money;
use Tests\TestCase;

final class DiscountTest extends TestCase
{
    /** @dataProvider orderData */
    public function testAction(array $requestData, array $responseData): void
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('POST', '/')->withParsedBody($requestData);
        $response = $app->handle($request);

        $this->assertEquals(StatusCodeInterface::STATUS_OK, $response->getStatusCode());

        $response->getBody()->rewind();
        $this->assertEquals($responseData, \json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR));
    }

    public static function orderData(): array
    {
        return [
            [
                'request' => [
                    'id' => '1',
                    'customer-id' => '1',
                    'items' => [
                        [
                            'product-id' => 'B102',
                            'quantity' => '10',
                            'unit-price' => '4.99',
                            'total' => '49.90',
                        ],
                    ],
                    'total' => '49.90',
                ],
                'response' => [],
            ],
            [
                'request' => [
                    'id' => '2',
                    'customer-id' => '2',
                    'items' => [
                        [
                            'product-id' => 'B102',
                            'quantity' => '5',
                            'unit-price' => '4.99',
                            'total' => '24.95',
                        ],
                    ],
                    'total' => '24.95',
                ],
                'response' => [
                    [
                        'description' => 'Our valued customers get 10% discount on their order',
                        'amount' => Money::EUR(2.495)->getAmount(),
                    ]
                ],
            ],
            [
                'request' => [
                    'id' => '3',
                    'customer-id' => '3',
                    'items' => [
                        [
                            'product-id' => 'A101',
                            'quantity' => '2',
                            'unit-price' => '9.75',
                            'total' => '19.50',
                        ],
                        [
                            'product-id' => 'A102',
                            'quantity' => '1',
                            'unit-price' => '49.50',
                            'total' => '49.50',
                        ],
                    ],
                    'total' => '69.00',
                ],
                'response' => [],
            ],
        ];
    }
}
