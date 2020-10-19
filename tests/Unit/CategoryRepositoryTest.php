<?php

namespace Tests\Unit;

use App\Repositories\CategoryRepository;
use OpenFoodFacts\Document;
use PHPUnit\Framework\TestCase;

class CategoryRepositoryTest extends TestCase
{
    protected CategoryRepository $categoryRepository;

    public function setUp(): void
    {
        $this->categoryRepository = new CategoryRepository();

        parent::setUp();
    }

    public function testGetCategoriesFromDocumentMethod(): void
    {
        $document = new Document([
            'categories' => "   Milk, Meat, Cosmetics ",
        ]);

        self::assertSame(
            ['Milk', 'Meat', 'Cosmetics'],
            $this->categoryRepository->getCategoriesFromDocument($document)
        );
    }
}
