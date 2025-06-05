<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service_category as ModelsService_category;
use Illuminate\Http\Request;

class Service_Category extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Services.category');
    }

    public function get()
    {
        $service_categories = ModelsService_category::all();

        return response()->json($service_categories, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_category_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $service_category = ModelsService_category::create([
            'service_category_name' => $request->input('service_category_name'),
            'description' => $request->input('description'),
        ]);

        return response()->json(['message' => 'Service category created successfully', 'data' => $service_category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service_category = ModelsService_category::findOrFail($id);

        return response()->json($service_category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'service_category_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        $service_category = ModelsService_category::findOrFail($id);
        $service_category->update([
            'service_category_name' => $request->input('service_category_name'),
            'description' => $request->input('description'),
        ]);
        return response()->json(['message' => 'Service category updated successfully', 'data' => $service_category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service_category = ModelsService_category::findOrFail($id);
        $service_category->delete();

        return response()->json(['message' => 'Service category deleted successfully'], 200);
    }
}
