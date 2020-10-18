<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use OpenFoodFacts\Collection;
use OpenFoodFacts\Document;

class ProductUpdater
{
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getExistProductIDsMap(Collection $products): array
    {
        $productIDs = Arr::pluck($products, '_id');
        $productExistIDs = Product::query()
            ->whereIn('external_id', $productIDs)
            ->pluck('external_id')
            ->toArray();

        return array_fill_keys($productExistIDs, true) + array_fill_keys($productIDs, false);
    }

    public function updateOrCreate(Document $document): Product
    {
        return DB::transaction(function () use ($document) {
            $product = $this->productRepository->findOrNewByDocument($document);
            $this->productRepository->updateByDocument($product, $document);

            $categories = $this->categoryRepository->getCategoriesFromDocument($document);
            $this->categoryRepository->getOrCreateManyByNames($categories);

            return $product;
        });
    }
}
