<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CreateCompany;
use App\DTOs\CompanyData;
use App\Enum\CompanySortBy;
use App\Enum\CompanyStatus;
use App\Enum\SortDirection;
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
    public function index(Request $request): View
    {
        $sortBy = $request->enum('sort_by', CompanySortBy::class) ?? CompanySortBy::CreatedAt;
        $orderBy = $request->enum('order_by', SortDirection::class) ?? SortDirection::Desc;

        $companies = Company::select(['id', 'name', 'email', 'phone', 'country', 'created_at'])
            ->with('users')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($sortBy === CompanySortBy::Users, function ($q) use ($orderBy) {
                $q->withCount('users')->orderBy('users_count', $orderBy->value);
            }, fn ($q) => $q->orderBy($sortBy->value, $orderBy->value))
            ->paginate(20)
            ->withQueryString();

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
