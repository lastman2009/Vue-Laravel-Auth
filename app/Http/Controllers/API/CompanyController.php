<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company; 
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(2)->toArray();
        return array_reverse($companies);
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
            $logoPath = Str::after($logoPath, 'public/');
            $validatedData['logo'] = 'storage/' .$logoPath;
        }
        $company = Company::create($validatedData); // Create a new company

        return response()->json([
            'message' => 'Company created successfully.',
            'company' => $company,
        ], 201); // 201 status code indicates resource created
    }

    public function show($id)
    {

        $company = Company::find($id);
        return response()->json($company);
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
            $logoPath = Str::after($logoPath, 'public/');
            $validatedData['logo'] = 'storage/' .$logoPath;
        }
        $company->update($validatedData); // Update the company

        return response()->json(['message' => 'Company updated successfully']);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        if ($company) {
            $company->delete(); // Delete the company
            return response()->json(['message' => 'Company deleted successfully']);
        } else {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }
}
