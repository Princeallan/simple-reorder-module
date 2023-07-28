<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::post('add-order/{product_id}', [OrderController::class, 'addOrder']);
    Route::get('orders/{status}', [OrderController::class, 'listOrders']);
    Route::post('order/update/{order_id}/{status}', [OrderController::class, 'updateOrder']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
