@extends('layouts.authenticated.app')

@section('title', 'Customers')

@section('content')
<div>
    {{-- Page Header --}}
    <x-page-header title="Customers" pretitle="Manage your customer records">
        <a href="#" class="btn btn-primary d-none d-sm-inline-block"
            onclick="event.preventDefault(); Livewire.dispatch('create-customer')">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Create new customer
        </a>
        <a href="#" class="btn btn-primary d-sm-none btn-icon"
            onclick="event.preventDefault(); Livewire.dispatch('create-customer')" aria-label="Create new customer">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
        </a>
    </x-page-header>

    {{-- Page Body --}}
    <div class="page-body">
        <div class="container-xl">

            {{-- Filters --}}
            <form method="GET" action="{{ route('customers.index') }}" id="customers-filters-form">
                <div class="card card-body p-2 mb-2">
                    <div class="row gx-3 gy-2">

                        {{-- Input: Search --}}
                        <div class="col-md-auto">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by name or email..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Select: Sort by --}}
                        <div class="col-md-auto">
                            <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                                <option value="created_at" @selected(request('sort_by', 'created_at' )==='created_at' )>
                                    Sort by registry date</option>
                                <option value="first_name" @selected(request('sort_by')==='first_name' )>Sort by name
                                </option>
                                <option value="email" @selected(request('sort_by')==='email' )>Sort by email</option>
                            </select>
                        </div>

                        {{-- Select: Order by --}}
                        <div class="col-md-auto">
                            <select name="order_by" id="order_by" class="form-select" onchange="this.form.submit()">
                                <option value="desc" @selected(request('order_by', 'desc' )==='desc' )>Descending
                                </option>
                                <option value="asc" @selected(request('order_by')==='asc' )>Ascending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Customers table --}}
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>Created At</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $customer)
                                    <tr>
                                        <th>{{ $customer->id }}</th>
                                        <td>{{ $customer->first_name }}</td>
                                        <td>{{ $customer->last_name }}</td>
                                        <td class="text-muted">{{ $customer->email }}</td>
                                        <td class="text-muted">{{ $customer->phone }}</td>
                                        <td class="text-muted">
                                            @if ($customer->country)
                                            <div class="col-md-auto d-flex align-items-center gap-1">
                                                <span
                                                    class="flag flag-xxs flag-country-{{ $customer->country }}"></span>
                                                <span>{{ __('countries.'.$customer->country) }}</span>
                                            </div>
                                            @else
                                            <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td class="text-muted">{{ $customer->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="dropdown">

                                                {{-- Dropdown Button: Actions --}}
                                                <button type="button" class="btn btn-icon" id="customer-dropdown-{{ $customer->id }}" data-bs-toggle="dropdown" aria-expanded="false"  data-bs-popper-config='{"strategy":"fixed"}'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dots">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                        <path d="M11 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                        <path d="M18 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    </svg>
                                                </button>

                                                {{-- Dropdown Menu: Actions --}}
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customer-dropdown-{{ $customer->id }}">
                                                    <span class="dropdown-header">Actions</span>

                                                    {{-- Dropdown item: View --}}
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('customers.show', $customer) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                            </svg>
                                                            View
                                                        </a>
                                                    </li>

                                                    {{-- Dropdown item: Edit --}}
                                                    <li>
                                                        <a href="#" class="dropdown-item"
                                                            onclick="event.preventDefault(); Livewire.dispatch('edit-customer', { customerId: {{ $customer->id }} })">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                            Edit
                                                        </a>
                                                    </li>

                                                    {{-- Dropdown item: Delete --}}
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-customer', { customerId: {{ $customer->id }} })">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No customers found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($customers->hasPages())
                        <div class="card-footer p-2">
                            {{ $customers->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<livewire:livewire.customer-modal />
<livewire:livewire.delete-customer-modal />
@endsection

@section('body_scripts')
@vite(['resources/js/tom-select-js/tom-select.base.min.js', 'resources/css/tabler/tabler-flags.min.css'])
@endsection