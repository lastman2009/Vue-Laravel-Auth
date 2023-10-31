<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee; 
use App\Models\Company; 

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('company')->paginate(2)->toArray();
        return array_reverse($employees);
    }

    public function create()
    {
        $companies = Company::all(['id', 'name'])->toArray();
        return array_reverse($companies);
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_id' => 'nullable|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $employee  = Employee::create($validatedData); // Create a new employee


        return response()->json([
            'message' => 'Employee created successfully.',
            'employee' => $employee,
        ], 201); // 201 status code indicates resource created
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::all(); // Retrieve all companies
        return response()->json(['employee' => $employee, 'companies' => $companies]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // Validate the incoming data
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $employee->update($validatedData); // Update the employee

        return response()->json(['message' => 'Employee updated successfully']);

    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete(); // Delete the employee
        return response()->json(['message' => 'Employee deleted successfully']);

    }
}
