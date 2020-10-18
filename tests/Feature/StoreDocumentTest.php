<?php

namespace Tests\Feature;

use App\Services\ProductUpdater;
use Mockery;
use Mockery\MockInterface;
use OpenFoodFacts\Api;
use OpenFoodFacts\Document;
use OpenFoodFacts\Exception\ProductNotFoundException;
use Tests\TestCase;

class StoreDocumentTest extends TestCase
{
    public function testStoreResponseWhenProductNotFound(): void
    {
        $this->instance(Api::class, Mockery::mock(Api::class, function (MockInterface $mock) {

            $mock
                ->shouldReceive('getProduct')
                ->once()
                ->andThrow(new ProductNotFoundException('mock_message'));
        }));

        $response = $this->post(route('document.store', ['id' => 123,], false));

        $response->assertJson(['error' => 'mock_message',]);
        $response->assertNotFound();
    }

    public function testStoreResponseWhenApiThrowInvalidArgumentException(): void
    {
        $this->instance(Api::class, Mockery::mock(Api::class, function (MockInterface $mock) {

            $mock
                ->shouldReceive('getProduct')
                ->once()
                ->andThrow(new \InvalidArgumentException());
        }));

        $response = $this->post(route('document.store', ['id' => 123,], false));

        $response->assertStatus(400);
    }

    public function testValidStoreResponse(): void
    {
        $document = new Document([]);

        $this->instance(Api::class, Mockery::mock(Api::class, function (MockInterface $mock) use ($document) {
            $mock
                ->shouldReceive('getProduct')
                ->once()
                ->andReturn($document);
        }));

        $this->instance(ProductUpdater::class, Mockery::mock(ProductUpdater::class, function (MockInterface $mock) use ($document) {
            $mock
                ->shouldReceive('updateOrCreate')
                ->with($document)
                ->once();
        }));

        $response = $this->post(route('document.store', ['id' => 123,], false));

        $response->assertOk();
    }
}
