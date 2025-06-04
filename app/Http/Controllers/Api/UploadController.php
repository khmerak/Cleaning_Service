<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Setting.upload');
    }
    public function get()
    {
        $uploads = Upload::all();
        return response()->json($uploads, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6144',
        ]);

        // Save image if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploads', $filename, 'public');
            $imagePath = 'uploads/' . $filename;
        }

        // Save data to DB
        $upload = Upload::create([
            'position' => $request->position,
            'image' => $imagePath,
        ]);

        return response()->json($upload, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $upload = Upload::findOrFail($id);
        return response()->json($upload, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6144', // 6MB max
            'position' => 'required|string|max:255',
        ]);

        $upload = Upload::findOrFail($id);
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($upload->image && Storage::disk('public')->exists($upload->image)) {
                Storage::disk('public')->delete($upload->image);
            }
            $upload->image = $request->file('image')->store('uploads', 'public');
        }
        $upload->position = $request->position;
        $upload->save();

        return response()->json($upload, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $upload = Upload::findOrFail($id);
        if ($upload->image) {
            Storage::disk('public')->delete($upload->image);
        }
        $upload->delete();
        return response()->json(['message' => 'Upload deleted successfully'], 200);
    }
}
