<?php

namespace Tests\Unit;

use App\Http\Controllers\API\OrderController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_order_with_available_quantity()
    {
        $product = new Product();
        $product->name = "test product";
        $product->slug = "test-product";
        $product->quantity = 2;
        $product->fulfilled_orders_count = 0;
        $product->save();

        $orderController = new OrderController();
        $response = $orderController->addOrder($product->id);

        $this->assertEquals(201, $response->getStatusCode());

        $product = Product::find($product->id);
        $this->assertEquals(1, $product->quantity);

        $this->assertEquals(1, $product->fulfilled_orders_count);

        $order = Order::where('product_id', $product->id)->first();
        $this->assertEquals(str_pad($order->id, 6, '0', STR_PAD_LEFT), $order->order_number);
    }

    public function test_add_order_with_no_quantity()
    {
        $product = new Product();
        $product->name = "test product";
        $product->slug = "test-product";
        $product->quantity = 0;
        $product->fulfilled_orders_count = 0;
        $product->save();

        $orderController = new OrderController();
        $response = $orderController->addOrder($product->id);

        $this->assertEquals(403, $response->getStatusCode());

        $product = Product::find($product->id);
        $this->assertEquals(0, $product->quantity);

        $this->assertEquals(0, $product->fulfilled_orders_count);
    }
}
