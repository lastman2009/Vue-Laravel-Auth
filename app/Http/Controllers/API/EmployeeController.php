<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee; 

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); // Retrieve all employees
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $companies = Company::all(); // Retrieve all companies
        return view('employees.create', compact('companies'));
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        Employee::create($validatedData); // Create a new employee

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::all(); // Retrieve all companies
        return view('employees.edit', compact('employee', 'companies'));
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

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete(); // Delete the employee

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
