<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::latest()->get();

        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Display a listing of the resource.
     */
    public function storeProduct(ProductRequest $request)
    {

        try {
            DB::beginTransaction();
            Product::create([
                "name" => $request['name'],
                "slug" => Str::slug($request['name']),
                "quantity" => $request['quantity'] ?? 1,
                "uom" => $request['uom'] ?? null,
                "user_id" => auth()->id()
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }

        return response()->json(['status' => true, 'message' => 'Product Successfully saved'], 201);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function getProductData(Product $product)
    {
        return response()->json(['status' => true, 'data' => $product], 201);
    }

    public function updateProduct(Request $request, Product $product)
    {
        try {

            DB::beginTransaction();

            $product->update([
                "name" => $request['name'],
                "slug" => Str::slug($request['name']),
                "quantity" => $request['quantity'] ?? 1,
                "uom" => $request['uom'] ?? null,
                "user_id" => auth()->id()
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }

        return response()->json(['status' => true, 'message' => 'Product Successfully update'], 201);

    }

    public function deleteProduct(Product $product)
    {
        $product->orders()->delete();
        $product->reorders()->delete();

        $product->delete();

        return response()->json(['status' => true, 'message' => "Ok"], 201);
    }


}
