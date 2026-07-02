@extends('layouts.authenticated.app')

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
            <div class="row row-deck row-cards">
                <div class="col-12">
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
                                        <td>{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#"
                                                    onclick="event.preventDefault(); Livewire.dispatch('edit-order', { orderId: {{ $order->id }} })">
                                                    Edit
                                                </a>
                                                <a href="{{ route('orders.show', $order) }}">View</a>
                                                <a href="#" class="text-danger"
                                                    onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-order', { orderId: {{ $order->id }} })">
                                                    Delete
                                                </a>
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