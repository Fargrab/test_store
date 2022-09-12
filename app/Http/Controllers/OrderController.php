<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\OrderService $orderService
     * @return JsonResponse
     */
    public function setOrder(Request $request, OrderService $orderService): JsonResponse
    {
        $result = $orderService->createOrder($request->all());
        return response()->json($result);
    }
}
