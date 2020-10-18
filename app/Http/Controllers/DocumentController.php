<?php

namespace App\Http\Controllers;

use App\Services\ProductUpdater;
use Illuminate\Routing\Controller;
use OpenFoodFacts\Api;

class DocumentController extends Controller
{
    public function store(string $id, Api $api, ProductUpdater $productUpdater)
    {
        $document = $api->getProduct($id);
        $productUpdater->updateOrCreate($document);
    }
}
