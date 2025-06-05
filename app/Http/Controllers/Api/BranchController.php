<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Branch.branch');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function get()
    {
        $branches = Branch::all();
        return response()->json($branches);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6144', // 6MB max
            'location' => 'required|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $filename = time() . '_' . '.' . $image->getClientOriginalExtension();
            $image->storeAs('branches', $filename, 'public');
            $imagePath = 'branches/' . $filename;
        }

        $branch = Branch::create([
            'branch_name' => $request->branch_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'description' => $request->description,
            'image' => $imagePath,
            'location' => $request->location,
        ]);

        return response()->json($branch, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::findOrFail($id);
        return response()->json($branch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6144',
            'location' => 'required|string|max:255',
        ]);

        $branch = Branch::findOrFail($id);

        $branch->branch_name = $request->branch_name;
        $branch->phone = $request->phone;
        $branch->email = $request->email;
        $branch->description = $request->description;
        $branch->location = $request->location;

        if ($request->hasFile('image')) {
            if ($branch->image && Storage::disk('public')->exists($branch->image)) {
                Storage::disk('public')->delete($branch->image);
            }
            $branch->image = $request->file('image')->store('branches', 'public');
        }

        $branch->save();

        return response()->json($branch);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        if ($branch->image && Storage::disk('public')->exists($branch->image)) {
            Storage::disk('public')->delete($branch->image);
        }
        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
