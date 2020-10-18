<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenFoodFacts\Document;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProductRepository $productRepository;

    public function setUp(): void
    {
        $this->productRepository = new ProductRepository();

        parent::setUp();
    }

    public function testFindOrNewByDocumentWhenProductNotExist(): void
    {
        $document = new Document([
            '_id' => '123',
        ]);

        $product = $this->productRepository->findOrNewByDocument($document);

        self::assertNull($product->id);
        self::assertSame('123', $product->external_id);
    }

    public function testFindOrNewByDocumentWhenProductExist(): void
    {
        /** @var Product $product */
        $product = Product::factory()->createOne([
            'external_id' => '123',
        ]);

        $document = new Document([
            '_id' => '123',
        ]);

        $findResult = $this->productRepository->findOrNewByDocument($document);

        self::assertSame($product->id, $findResult->id);
        self::assertSame('123', $findResult->external_id);
    }

    public function testUpdateByDocument(): void
    {
        /** @var Product $product */
        $product = Product::factory()->createOne([
            'external_id' => '123',
        ]);

        $document = new Document([
            'product_name' => 'Apple',
            'image_url' => 'apple.jpg',
        ]);

        $this->productRepository->updateByDocument($product, $document);

        $this->assertDatabaseHas('products', [
            'external_id' => '123',
            'name' => 'Apple',
            'image_url' => 'apple.jpg',
        ]);
    }
}
