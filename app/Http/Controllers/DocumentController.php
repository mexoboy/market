<?php

namespace App\Http\Controllers;

use App\Services\ProductUpdater;
use Illuminate\Routing\Controller;
use OpenFoodFacts\Api;
use OpenFoodFacts\Exception\ProductNotFoundException;

class DocumentController extends Controller
{
    public function store(string $id, Api $api, ProductUpdater $productUpdater)
    {
        try {
            $document = $api->getProduct($id);
            $productUpdater->updateOrCreate($document);

            return response('');
        } catch (ProductNotFoundException $e) {
            $statusCode = 404;
        } catch (\Exception $e) {
            $statusCode = 400;
        }

        report($e);

        return response()->json([
            'error' => $e->getMessage(),
        ], $statusCode);
    }
}
