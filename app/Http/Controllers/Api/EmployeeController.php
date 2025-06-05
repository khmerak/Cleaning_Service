<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Employees.employee');
    }

    public function get()
    {
        $employees = Employee::all();
        return response()->json($employees, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'branch_id' => 'required|exists:branches,id',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6011',
            'email' => 'required|email|unique:employees,email',
            'position_id' => 'required|exists:positions,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('employees', $filename, 'public');
            $imagePath = 'employees/' . $filename;
        }

        $employee = Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'branch_id' => $request->input('branch_id'),
            'address' => $request->input('address'),
            'date_of_birth' => $request->input('date_of_birth'),
            'hire_date' => $request->input('hire_date'),
            'salary' => $request->input('salary'),
            'status' => $request->input('status'),
            'profile_picture' => $imagePath,
            'email' => $request->input('email'),
            'position_id' => $request->input('position_id'),
        ]);

        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'branch_id' => 'required|exists:branches,id',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6011',
            'email' => 'required|email|unique:employees,email,' . $id,
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->first_name = $request->input('first_name');
        $employee->last_name = $request->input('last_name');
        $employee->phone = $request->input('phone');
        $employee->branch_id = $request->input('branch_id');
        $employee->address = $request->input('address');
        $employee->date_of_birth = $request->input('date_of_birth');
        $employee->hire_date = $request->input('hire_date');
        $employee->salary = $request->input('salary');
        $employee->status = $request->input('status');
        $employee->email = $request->input('email');
        $employee->position_id = $request->input('position_id');

        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($employee->profile_picture && Storage::disk('public')->exists($employee->profile_picture)) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $employee->profile_picture = $request->file('profile_picture')->store('employees', 'public');
        }

        $employee->save();

        return response()->json($employee, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        // Delete old image if it exists
        if ($employee->profile_picture && Storage::disk('public')->exists($employee->profile_picture)) {
            Storage::disk('public')->delete($employee->profile_picture);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }
}
