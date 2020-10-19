<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected CategoryRepository $categoryRepository;

    public function setUp(): void
    {
        $this->categoryRepository = new CategoryRepository();

        parent::setUp();
    }

    public function testGetExistsCategoriesByNamesMethod(): void
    {
        Category::factory()->createMany([
            ['name' => 'Fruit',],
            ['name' => 'Meat',],
            ['name' => 'Fish',],
        ]);

        $existCategories = $this->categoryRepository->getExistsCategoriesByNames(['Fruit', 'Fish', 'Oil']);

        self::assertCount(2, $existCategories);
    }

    public function testGetOrCreateManyByNamesMethod(): void
    {
        Category::factory()->createMany([
            ['name' => 'Fruit',],
            ['name' => 'Fish',],
        ]);

        $categories = $this->categoryRepository->getOrCreateManyByNames(['Fruit', 'Oil']);

        self::assertCount(2, $categories);
        $this->assertDatabaseHas('categories', ['name' => 'Oil']);
    }
}
