<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_Preview;
use Illuminate\Http\Request;

class Product_previewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Product_management.product_preview');
    }

    public function get()
    {
        $previews = Product::all();
        return response()->json($previews, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
