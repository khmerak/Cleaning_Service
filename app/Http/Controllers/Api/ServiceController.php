<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Services.service');
    }

    public function get()
    {
        $services = Service::with('service_category')->get();
        return response()->json($services, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:service_categories,id', // or 'categories' depending on your table
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6144', // 6MB max
        ]);

        $data = $request->only(['service_name', 'description', 'price', 'category_id', 'type']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($data);

        return response()->json(['message' => 'Service created successfully', 'data' => $service], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:service_categories,id',
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6144', // 6MB max
        ]);

        $service = Service::findOrFail($id);
        $service->service_name = $request->input('service_name');
        $service->description = $request->input('description');
        $service->price = $request->input('price');
        $service->category_id = $request->input('category_id');
        $service->type = $request->input('type');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $service->image = $request->file('image')->store('services', 'public');
        }

        $service->save();

        return response()->json(['message' => 'Service updated successfully', 'data' => $service], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,string $id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully'], 200);
    }
}
