@extends('layouts.admin.app')

@section('content')
<div>
    {{-- Page Header --}}
    <x-page-header :title="$company->name" pretitle="Modify company details">
        <div class="btn-list">
            {{-- Button: Delete Company --}}
            <button class="btn btn-danger d-none d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-delete-company">
                Delete Company
            </button>
            <button class="btn btn-icon btn-danger d-sm-none" data-bs-toggle="modal"
                data-bs-target="#modal-delete-company" aria-label="Delete Company">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </button>

            {{-- Button: Back to Company List --}}
            <a href="{{ route('admin.companies.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
                Back to company list
            </a>
            <a href="{{ route('admin.companies.index') }}" class="btn btn-primary d-sm-none btn-icon"
                aria-label="Back to company list">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
            </a>
        </div>
    </x-page-header>

    {{-- Page Body --}}
    <div class="page-body">
        <div class="container-xl">

            {{-- Card: Company Info --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Company Info</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">

                        {{-- Data: Company Name --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Company Name</div>
                            <div class="datagrid-content">{{ $company->name }}</div>
                        </div>

                        {{-- Data: Email --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Email</div>
                            <div class="datagrid-content">{{ $company->email }}</div>
                        </div>

                        {{-- Data: Phone --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Phone</div>
                            <div class="datagrid-content">{{ $company->phone }}</div>
                        </div>

                        {{-- Data: Country --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Country</div>
                            <div class="datagrid-content">{{ $company->country }}</div>
                        </div>

                        {{-- Data: City --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">City</div>
                            <div class="datagrid-content">{{ $company->city }}</div>
                        </div>

                        {{-- Data: Address --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Address</div>
                            <div class="datagrid-content">{{ $company->address }}</div>
                        </div>

                        {{-- Data: Website --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Website</div>
                            <div class="datagrid-content">{{ $company->website ? $company->website : 'Not provided' }}
                            </div>
                        </div>

                        {{-- Data: Registry Date --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Registry Date</div>
                            <div class="datagrid-content">
                                {{ $company->registry_date ? $company->registry_date : 'Not provided' }}</div>
                        </div>

                        {{-- Data: Tax Number --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Tax Number</div>
                            <div class="datagrid-content">
                                {{ $company->tax_number ? $company->tax_number : 'Not provided' }}</div>
                        </div>

                        {{-- Data: VAT Number --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">VAT Number</div>
                            <div class="datagrid-content">
                                {{ $company->vat_number ? $company->vat_number : 'Not provided' }}</div>
                        </div>

                        {{-- Data: Status --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Status</div>
                            <div class="datagrid-content">
                                <span
                                    class="badge bg-{{ $company->status ? $company->status->color() : 'secondary' }} text-{{ $company->status ? $company->status->color() : 'secondary' }}-fg">
                                    {{ $company->status ? $company->status->label() : 'Not found' }}
                                </span>
                            </div>
                        </div>

                        {{-- Data: Users --}}
                        <div class="datagrid-item">
                            <div class="datagrid-title">Users</div>
                            <div class="datagrid-content">
                                <div class="avatar-list avatar-list-stacked">
                                    @forelse($company->users as $user)
                                    @if ($user->profile_picture_path)
                                    <span class="avatar avatar-xs rounded"
                                        style="background-image: url({{ $user->profile_picture_path }})"></span>
                                    @else
                                    <span class="avatar avatar-xs rounded">{{ strtoupper(substr($user->first_name . ' '
                                        . $user->last_name, 0, 2)) }}</span>
                                    @endif
                                    @empty
                                    <span class="text-muted">No users</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: General Stats Cards --}}
            <div class="row row-deck row-cards">

                {{-- First column: Edit Form --}}
                <div class="col-xl-6">
                    <livewire:livewire.edit-company-form :company="$company" :company-statuses="$companyStatuses" />
                </div>

                {{-- Second column: Edit Users --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Company Users</h3>
                            <div class="card-actions">
                                <a href="#" class="btn btn-primary d-none d-sm-inline-block" aria-label="Add new user"
                                    data-bs-toggle="modal" data-bs-target="#modal-add-user">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Add new user
                                </a>
                                <a href="#" class="btn btn-icon btn-primary d-sm-none" aria-label="Add new user"
                                    data-bs-toggle="modal" data-bs-target="#modal-add-user">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th class="w-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td class="text-secondary">
                                                {{ $user->pivot->title ? $user->pivot->title : 'Not provided' }}
                                            </td>
                                            <td class="text-secondary"><a href="#" class="text-reset">{{ $user->email
                                                    }}</a>
                                            </td>
                                            <td class="text-secondary">
                                                @php
                                                $userRoles = $user->getRolesForCompany($company->id);
                                                @endphp
                                                @if ($userRoles->isNotEmpty())
                                                {{ $userRoles->map(fn($r) => $r->display_name ?:
                                                ucfirst($r->name))->implode(', ') }}
                                                @else
                                                <span class="text-muted">No role assigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" x-data
                                                    x-on:click.prevent="$dispatch('edit-user', { userId: {{ $user->id }}, companyId: {{ $company->id }} })">Edit</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($users->hasPages())
                        <div class="card-footer">
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
{{-- Modal: Add User --}}
<livewire:livewire.create-user-form :company="$company" />
<livewire:livewire.edit-user-modal />

{{-- Modal: Delete Company --}}
<div class="modal modal-blur fade" id="modal-delete-company" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                <h3>Are you sure?</h3>
                <div class="text-secondary">Do you really want to delete this company? This action cannot be undone.
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Cancel
                            </a></div>
                        <div class="col">
                            <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    Yes, delete it
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('body_scripts')
@vite(['resources/js/tom-select-js/tom-select.base.min.js', 'resources/css/tabler/tabler-flags.min.css'])
@endsection