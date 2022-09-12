<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    /**
     * Выдача полного списка товаров
     */
    public function getAllProducts(): JsonResponse
    {
        return response()->json(Product::all());
    }
}
