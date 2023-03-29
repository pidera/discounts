<?php
declare(strict_types=1);

namespace Tests\Domain\Product;

use App\Domain\Product\ProductId;
use App\Infrastructure\Repository\InMemory\ProductInMemoryRepository;
use Money\Money;
use Tests\TestCase;

final class ProductRepositoryTest extends TestCase
{
    public function testGettingCustomerByID(): void
    {
        $repository = new ProductInMemoryRepository($this->productData());

        $product = $repository->getById(new ProductId('EAT042'));

        self::assertEquals('Another product', $product->description);
        self::assertTrue($product->categoryId->is('2'));
        self::assertEquals(Money::EUR(19.32), $product->price);
    }

    private function productData(): array
    {
        return [
            [
                'id' => 'PAT012',
                'description' => 'Fancy product',
                'category' => '1',
                'price' => '14.95'
            ],
            [
                'id' => 'EAT042',
                'description' => 'Another product',
                'category' => '2',
                'price' => '19.32'
            ],
        ];
    }
}
