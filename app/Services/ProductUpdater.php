<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;
use OpenFoodFacts\Collection;

class ProductUpdater
{
    public function getExistProductIDsMap(Collection $products): array
    {
        $productIDs = Arr::pluck($products, '_id');
        $productExistIDs = Product::query()
            ->whereIn('external_id', $productIDs)
            ->pluck('external_id')
            ->toArray();

        return array_fill_keys($productExistIDs, true) + array_fill_keys($productIDs, false);
    }
}
