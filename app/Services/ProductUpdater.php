<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use OpenFoodFacts\Collection;
use OpenFoodFacts\Document;

class ProductUpdater
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
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
            /** @var Product $product */
            $product = Product::query()
                ->where('external_id', $document->_id)
                ->firstOrNew(['external_id' => $document->_id,]);

            $product->name = $document->product_name;
            $product->image_url = $document->image_url ?? null;
            $product->saveOrFail();

            $categories = $this->categoryRepository->getCategoriesFromDocument($document);
            $this->categoryRepository->getOrCreateManyByNames($categories);

            return $product;
        });
    }
}
