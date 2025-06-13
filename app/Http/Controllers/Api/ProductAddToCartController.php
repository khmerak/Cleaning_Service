<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductAddToCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductAddToCartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $cart = ProductAddToCart::with('product')
            ->where('user_id', $user->id)
            ->get();

        return response()->json($cart);
    }

    public function update(Request $request, $id)
    {
        $cartItem = ProductAddToCart::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return response()->json($cartItem);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $existingCartItem = ProductAddToCart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $request->quantity;
            $existingCartItem->save();
            return response()->json($existingCartItem, 200);
        }

        $cart = ProductAddToCart::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json($cart, 201);
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $existingCartItem = ProductAddToCart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $request->quantity;
            $existingCartItem->save();
            return response()->json($existingCartItem, 200);
        }

        $cart = ProductAddToCart::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json($cart, 201);
    }


    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $item = ProductAddToCart::where('id', $id)->where('user_id', $user->id)->first();
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();
        return response()->json(['message' => 'Item removed']);
    }
}
