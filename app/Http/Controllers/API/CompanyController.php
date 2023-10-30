<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company; 

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all(); // Retrieve all companies
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|url',
        ]);

        // Handle logo file upload if provided
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/logos');
            $validatedData['logo'] = $logoPath;
        }

        Company::create($validatedData); // Create a new company

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|url',
        ]);

        // Handle logo file upload if provided
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/logos');
            $validatedData['logo'] = $logoPath;
        }

        $company->update($validatedData); // Update the company

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete(); // Delete the company

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
