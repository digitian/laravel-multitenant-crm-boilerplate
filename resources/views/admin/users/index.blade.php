@extends('layouts.admin.app')

@section('title', 'Users')

@section('content')
<div>
    {{-- Page Header --}}
    <x-page-header title="Users" pretitle="You can manage the users here">
        <a href="#" class="btn btn-primary d-none d-sm-inline-block"
            onclick="event.preventDefault(); Livewire.dispatch('create-global-user')">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Create new user
        </a>
        <a href="#" class="btn btn-primary d-sm-none btn-icon"
            onclick="event.preventDefault(); Livewire.dispatch('create-global-user')" aria-label="Create new user">
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
            <form method="GET" action="{{ route('admin.users.index') }}" id="filters-form">
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

                        {{-- Select: Company --}}
                        <div class="col-md-auto">
                            <select name="company_id" id="company_id" class="form-select" onchange="this.form.submit()">
                                <option value="">All companies</option>
                                <option value="0" @selected(request('company_id') === '0')>System</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        @selected(request('company_id') == $company->id)>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Select: Sort by --}}
                        <div class="col-md-auto">
                            <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                                <option value="created_at" @selected(request('sort_by', 'created_at') === 'created_at')>Sort by registry date</option>
                                <option value="first_name" @selected(request('sort_by') === 'first_name')>Sort by name</option>
                            </select>
                        </div>

                        {{-- Select: Order by --}}
                        <div class="col-md-auto">
                            <select name="order_by" id="order_by" class="form-select" onchange="this.form.submit()">
                                <option value="desc" @selected(request('order_by', 'desc') === 'desc')>Descending</option>
                                <option value="asc" @selected(request('order_by') === 'asc')>Ascending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Users table --}}
            <div class="row row-deck row-cards">


                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Created At</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        @if ($user->companies->isEmpty())
                                        <td>
                                            <div class="text-danger">System User</div>
                                        </td>
                                        @else
                                        <td>{{ $user->companies->pluck('name')->implode(', ') }}
                                        </td>
                                        @endif
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                        <td class="text-muted">{{ $user->phone }}</td>
                                        <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#"
                                                    onclick="event.preventDefault(); Livewire.dispatch('edit-global-user', { userId: {{ $user->id }} })">
                                                    Edit
                                                </a>
                                                <a href="#">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No users found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($users->hasPages())
                        <div class="card-footer p-2">
                            {{ $users->links() }}
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
<livewire:livewire.global-user-modal />
@endsection

@section('body_scripts')
@vite(['resources/js/tom-select-js/tom-select.base.min.js'])
@endsection