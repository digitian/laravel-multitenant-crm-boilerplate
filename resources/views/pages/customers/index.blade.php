@extends('layouts.authenticated.app')

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
                                        <td class="text-muted">{{ $customer->country }}</td>
                                        <td class="text-muted">{{ $customer->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#"
                                                    onclick="event.preventDefault(); Livewire.dispatch('edit-customer', { customerId: {{ $customer->id }} })">
                                                    Edit
                                                </a>
                                                <a href="{{ route('customers.show', $customer) }}">View</a>
                                                <a href="#" class="text-danger"
                                                    onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-customer', { customerId: {{ $customer->id }} })">
                                                    Delete
                                                </a>
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