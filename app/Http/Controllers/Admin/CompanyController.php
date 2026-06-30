<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CreateCompany;
use App\DTOs\CompanyData;
use App\Enum\CompanyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCompanyRequest;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = Company::select(['id', 'name', 'email', 'phone', 'country', 'created_at'])->with('users')->latest()->paginate(2);

        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCompanyRequest $request, CreateCompany $createCompanyAction)
    {
        // Validate the data using the CreateCompanyRequest
        $validatedData = $request->validated();

        // Use CompanyData DTO to encapsulate the validated data
        $validatedData = new CompanyData(
            name: $validatedData['name'],
            email: $validatedData['email'],
            phone: $validatedData['phone'],
            country: $validatedData['country'],
            city: $validatedData['city'],
            slug: \Str::slug($validatedData['name']),
            created_by: auth()->user()->id,
            address: $validatedData['address'] ?? null,
            tax_number: $validatedData['tax_number'] ?? null,
            vat_number: $validatedData['vat_number'] ?? null,
            website: $validatedData['website'] ?? null,
            status: $validatedData['status'] ?? null,
        );

        $company = $createCompanyAction->execute($validatedData);

        // Notify the user of successful creation
        notyf()->success('Company &quot;<b>'.$company->name.'</b>&quot; created successfully.');

        return redirect()->route('admin.companies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $companyStatuses = CompanyStatus::labels();
        $users = $company->users()->paginate(20);

        return view('admin.companies.edit', compact(['company', 'companyStatuses', 'users']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        notyf()->success('Company deleted successfully.');

        return redirect()->route('admin.companies.index');
    }

    public function storeUser(Company $company, CreateUserRequest $request)
    {
        dd($request->all());
    }
}
