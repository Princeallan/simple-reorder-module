<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReOrder;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function listOrders()
    {
        $orders = Order::with(['product', 'status', 'user'])->get();

        return response()->json(['status' => true, 'data' => $orders]);
    }

    public function listReOrders($status_id)
    {
        $reorders = ReOrder::with(['product', 'status', 'user'])
            ->when($status_id, function ($q) use ($status_id) {
                $q->where('re_orders.status_id', $status_id);
            })->get();

        return response()->json(['status' => true, 'data' => $reorders]);
    }

    public function makeReOrder($order_id)
    {
        $order = Order::find($order_id);

        try {
            DB::beginTransaction();

            ReOrder::create([
                'order_id' => $order->id,
                'product_id' => $order->product_id,
                'order_number' => $order->order_number,
                'status_id' => Status::PENDING,
                'user_id' => auth()->id() ?? null
            ]);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return response()->json(['status' => true, 'message' => "Ok"], 201);
    }

    public function updateReOrder($reorder_id, $status_id)
    {
        $reorder = ReOrder::find($reorder_id);
        $product = Product::find($reorder->product_id);

        try {
            DB::beginTransaction();

            if ($product && $status_id > Status::PENDING) {
                $product->update(["order_number" => null]);
            }

            $reorder->update([
                'status_id' => $status_id
            ]);

            DB::commit();

        } catch (\Exception $exception) {

            DB::rollback();

            throw $exception;
        }

        return response()->json(['status' => true, 'message' => "Ok"], 201);
    }

    public function deleteOrder($order_id)
    {
        $order = Order::find($order_id);
        $reorders = ReOrder::where('order_id', $order->id)->get();

        if (count($reorders) > 0)
            $reorders->delete();

        $order->delete();

        return response()->json(['status' => true, 'message' => "Ok"], 201);
    }

}
