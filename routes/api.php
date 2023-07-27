<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class,'index']); //->middleware('auth:sanctum');
Route::post('add-order/{product_id}', [OrderController::class,'addOrder']); //->middleware('auth:sanctum');
Route::get('orders/{status}', [OrderController::class,'listOrders']); //->middleware('auth:sanctum');
Route::post('order/update/{order_id}/{status}', [OrderController::class,'updateOrder']); //->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
