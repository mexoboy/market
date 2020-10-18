<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\ProductUpdater;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use OpenFoodFacts\Api;

class SearchController extends Controller
{
    public function index(SearchRequest $request, Api $openFoodsApi, ProductUpdater $productUpdater)
    {
        if (!$request->searchQuery()) {
            return view('search');
        }

        $products = $openFoodsApi->search($request->searchQuery(), $request->page(), $request->limit());

        return view('search-results', [
            'searchQuery' => $request->searchQuery(),
            'paginator' => new LengthAwarePaginator(
                $products,
                $products->searchCount(),
                $request->limit(),
                $request->page(),
                [
                    'query' => ['search' => $request->searchQuery(),],
                ]
            ),
            'existProductsIDs' => $productUpdater->getExistProductIDsMap($products),
        ]);
    }
}
