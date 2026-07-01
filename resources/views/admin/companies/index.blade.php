@extends('layouts.admin.app')

@section('content')
<div>
    {{-- Page Header --}}
    <x-page-header title="Companies" pretitle="You can manage the companies here">
        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
            data-bs-target="#modal-new-company">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Create new company
        </a>
        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
            data-bs-target="#modal-new-company" aria-label="Create new company">
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
            <form method="GET" action="{{ route('admin.companies.index') }}" id="filters-form">
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
                                    placeholder="Search for a company..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Select: Sort by --}}
                        <div class="col-md-auto">
                            <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                                <option value="created_at" @selected(request('sort_by', 'created_at' )==='created_at' )>
                                    Sort by registry date</option>
                                <option value="name" @selected(request('sort_by')==='name' )>Sort by name</option>
                                <option value="users" @selected(request('sort_by')==='users' )>Sort by users</option>
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


            {{-- Companies table --}}
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Users</th>
                                <th>E-mail</th>
                                <th>Phone</th>
                                <th>Country</th>
                                <th>Registry Date</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr>
                                <th>{{ $company->id }}</th>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->users->count() }}</td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->phone }}</td>
                                <td>{{ __('countries.' . $company->country) }}</td>
                                <td>{{ $company->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.companies.edit', $company) }}">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No companies found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($companies->hasPages())
                <div class="card-footer p-2">
                    {{ $companies->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<livewire:livewire.create-company-modal />
@endsection

@section('body_scripts')
@vite(['resources/js/tom-select-js/tom-select.base.min.js', 'resources/css/tabler/tabler-flags.min.css'])
@endsection