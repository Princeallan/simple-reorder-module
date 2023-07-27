<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function addOrder(string $product_id)
    {
        $product = Product::find($product_id);

        if ($product->quantity < 1) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
            ], 403);
        }

        $order = Order::create([
            'product_id' => $product->id,
            'status_id' => Status::PENDING
        ]);

        $order_number = Str::padLeft($order->id, '6', '0');

        $product->quantity -= 1;
        $product->fulfilled_orders_count += 1;
        $product->order_number = $order_number;
        $product->save();

        $order->order_number = $order_number;
        $order->save();

        return response()->json(['status' => true, 'message' => "Ok"], 201);

    }

    public function listOrders($status_id)
    {
        $orders = Order::query()
            ->join('products', 'orders.product_id', 'products.id')
            ->join('statuses', 'orders.status_id', 'statuses.id')
            ->when($status_id, function ($q) use ($status_id) {
                $q->where('status_id', $status_id);
            })
            ->select('orders.id', 'orders.created_at', 'products.name')
            ->get();

        return response()->json(['status' => true, 'data' => $orders]);
    }

    public function updateOrder($order_id, $status_id)
    {

    }

}
