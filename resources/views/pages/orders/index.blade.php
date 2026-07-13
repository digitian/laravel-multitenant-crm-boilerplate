@extends('layouts.authenticated.app')

@section('title', 'Orders')

@section('content')
<div>
    {{-- Page Header --}}
    <x-page-header title="Orders" pretitle="Manage customer orders">
        <a href="#" class="btn btn-primary d-none d-sm-inline-block"
            onclick="event.preventDefault(); Livewire.dispatch('create-order')">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Create new order
        </a>
        <a href="#" class="btn btn-primary d-sm-none btn-icon"
            onclick="event.preventDefault(); Livewire.dispatch('create-order')" aria-label="Create new order">
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
            <form method="GET" action="{{ route('orders.index') }}" id="orders-filters-form">
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
                                    placeholder="Search order ID or customer..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Select: Sort by --}}
                        <div class="col-md-auto">
                            <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                                <option value="created_at" @selected(request('sort_by', 'created_at' )==='created_at' )>
                                    Sort by date</option>
                                <option value="estimated_delivery_date" @selected(request('sort_by')==='estimated_delivery_date' )>Sort by delivery date</option>
                                <option value="total_amount" @selected(request('sort_by')==='total_amount' )>Sort by amount</option>
                                <option value="status" @selected(request('sort_by')==='status' )>Sort by status</option>
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

            {{-- Orders table --}}
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Delivery Date</th>
                                <th>Total Amount</th>
                                <th>Created At</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <th>#{{ $order->id }}</th>
                                <td>
                                    @if($order->customer)
                                        <a href="{{ route('customers.show', $order->customer_id) }}">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</a>
                                    @else
                                        <span class="text-muted">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->status->color() }}-lt">{{ $order->status->label() }}</span>
                                </td>
                                <td class="text-muted">{{ $order->estimated_delivery_date ? $order->estimated_delivery_date->format('d M Y') : '-' }}</td>
                                <td>{{ '$' . number_format($order->total_amount, 2) }}</td>
                                <td class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="dropdown">

                                        {{-- Dropdown Button: Actions --}}
                                        <button type="button" class="btn btn-icon" id="order-dropdown-{{ $order->id }}" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dots">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M11 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M18 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            </svg>
                                        </button>

                                        {{-- Dropdown Menu: Actions --}}
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="order-dropdown-{{ $order->id }}">
                                            <span class="dropdown-header">Actions</span>

                                            {{-- Dropdown item: View --}}
                                            <li>
                                                <a class="dropdown-item" href="{{ route('orders.show', $order) }}">
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
                                                    onclick="event.preventDefault(); Livewire.dispatch('edit-order', { orderId: {{ $order->id }} })">
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
                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-order', { orderId: {{ $order->id }} })">
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
                                <td colspan="7" class="text-center text-muted">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($orders->hasPages())
                <div class="card-footer p-2">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<livewire:livewire.order-modal />
<livewire:livewire.delete-order-modal />
@endsection

@section('body_scripts')
@vite(['resources/js/tom-select-js/tom-select.base.min.js', 'resources/css/tabler/tabler-flags.min.css'])
@endsection