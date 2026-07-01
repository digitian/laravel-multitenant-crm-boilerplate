<?php

namespace App\Http\Controllers\Admin;

use App\Enum\SortDirection;
use App\Enum\UserSortBy;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sortBy = $request->enum('sort_by', UserSortBy::class) ?? UserSortBy::CreatedAt;
        $orderBy = $request->enum('order_by', SortDirection::class) ?? SortDirection::Desc;

        $users = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'created_at')
            ->with('companies:id,name')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $search = '%'.$request->string('search').'%';
                $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            }))
            ->when($request->filled('company_id'), function ($q) use ($request) {
                $companyId = $request->integer('company_id');
                if ($companyId === 0) {
                    $q->whereDoesntHave('companies');
                } else {
                    $q->whereHas('companies', fn ($q) => $q->where('companies.id', $companyId));
                }
            })
            ->orderBy($sortBy->value, $orderBy->value)
            ->paginate(20)
            ->withQueryString();

        $companies = Company::select('id', 'name')->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'companies'));
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
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
