<?php

namespace App\Repositories;

use App\Models\Product;
use OpenFoodFacts\Document;

class ProductRepository
{
    public function findOrNewByDocument(Document $document): Product
    {
        return Product::query()
            ->where('external_id', $document->_id)
            ->firstOrNew(['external_id' => $document->_id,]);
    }

    public function updateByDocument(Product $product, Document $document): void
    {
        $product->name = $document->product_name;
        $product->image_url = $document->image_url ?? null;
        $product->saveOrFail();
    }
}
