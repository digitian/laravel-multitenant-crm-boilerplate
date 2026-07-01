<?php

namespace App\Http\Controllers\Authenticated;

use App\Enum\CustomerSortBy;
use App\Enum\SortDirection;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers with filtering and sorting.
     */
    public function index(Request $request): View
    {
        $sortBy = $request->enum('sort_by', CustomerSortBy::class) ?? CustomerSortBy::CreatedAt;
        $orderBy = $request->enum('order_by', SortDirection::class) ?? SortDirection::Desc;

        $customers = Customer::select('id', 'first_name', 'last_name', 'email', 'phone', 'country', 'created_at')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $search = '%'.$request->string('search').'%';
                $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            }))
            ->orderBy($sortBy->value, $orderBy->value)
            ->paginate(20)
            ->withQueryString();

        return view('pages.customers.index', compact('customers'));
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer): View
    {
        $customer->load('createdBy:id,first_name,last_name');

        return view('pages.customers.show', compact('customer'));
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $name = $customer->first_name.' '.$customer->last_name;

        $customer->delete();

        flash()->success("Customer <b>{$name}</b> deleted successfully.");

        return redirect()->route('customers.index');
    }
}
