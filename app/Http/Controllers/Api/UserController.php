<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Users.user');
    }
    public function get()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,user', 
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email','role', 'password']);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'sometimes|required|string|in:admin,user',
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email', 'role']);

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
