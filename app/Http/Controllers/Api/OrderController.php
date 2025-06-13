<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Product;
use App\Models\ProductAddToCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $orders = Order::with(['orderItems.product', 'invoice'])
            ->where('user_id', $user->id)
            ->orderByDesc('order_date')
            ->get();
        return response()->json($orders);
    }
    public function showOrder(){
        return view('Product_Management.order');
    }

    public function get()
    {
        $orderItems = Order_items::with(['order', 'product'])->get();

        return response()->json($orderItems);
    }
    /**
     * Store a newly created resource in storage.
     */
    // app/Http/Controllers/OrderController.php
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        DB::beginTransaction();

        try {
            // 1. Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'order_date' => now(),
                'status' => 'pending',
                'remarks' => null,
            ]);

            // 2. Create order items and update product stock
            foreach ($request->cart as $item) {
                $product = Product::findOrFail($item['product']['id']);

                // Check if enough stock exists
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                // Subtract ordered quantity from stock
                $product->stock_quantity -= $item['quantity'];
                $product->save();

                // Create order item
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            // 3. Create invoice
            $order->invoice()->create([
                'method' => $request->payment ?? 'cash',
            ]);

            // 4. Clear user's cart
            ProductAddToCart::where('user_id', $user->id)->delete();

            DB::commit();

            return response()->json(['message' => 'Order placed successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Order failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }






    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
