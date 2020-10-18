<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;
use OpenFoodFacts\Document;

class CategoryRepository
{
    public function getExistsCategoriesByNames(array $categoriesNames): Collection
    {
        return Category::query()
            ->whereIn('name', $categoriesNames)
            ->get();
    }

    public function getCategoriesFromDocument(Document $document): array
    {
        return array_map(
            fn($category) => trim($category),
            explode(',',$document->categories ?? '')
        );
    }

    public function getOrCreateManyByNames(array $categoriesNames): Collection
    {
        $categories = $this->getExistsCategoriesByNames($categoriesNames);

        $existCategoriesNamesMap = $categories->pluck('id', 'name')->toArray();
        $categoriesNames = array_filter(
            $categoriesNames,
            fn(string $categoryName) => !isset($existCategoriesNamesMap[$categoryName])
        );

        foreach ($categoriesNames as $categoryName) {
            $category = new Category(['name' => $categoryName,]);
            $category->saveOrFail();

            $categories->add($category);
        }

        return $categories;
    }
}
