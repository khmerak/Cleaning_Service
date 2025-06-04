<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Employees.position');
    }

    public function get(){
        $positions = Position::all();
        return response()->json($positions,200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
        ]);

        $position = Position::create($request->all());

        return response()->json($position, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }

        return response()->json($position, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
        ]);

        $position = Position::find($id);

        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }

        $position->update($request->all());

        return response()->json($position, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }

        $position->delete();

        return response()->json(['message' => 'Position deleted successfully'], 200);
    }
}
