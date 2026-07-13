@extends('layouts.authenticated.app')

@section('title', 'Order #' . $order->id . ' - Order Details')

@section('content')
<div>
    {{-- Page Header --}}
    <x-page-header title="Order #{{ $order->id }}" pretitle="Order Details">
        <div class="btn-list">
            <a href="#" class="btn btn-success d-none d-md-inline-block"
                onclick="event.preventDefault(); Livewire.dispatch('edit-order', { orderId: {{ $order->id }} })">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                    <path d="M16 5l3 3" />
                </svg>
                Edit
            </a>
            <a href="#" class="btn btn-success d-md-none btn-icon"
                onclick="event.preventDefault(); Livewire.dispatch('edit-order', { orderId: {{ $order->id }} })">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                    <path d="M16 5l3 3" />
                </svg>
            </a>

            <a href="#" class="btn btn-danger d-none d-md-inline-block"
                onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-order', { orderId: {{ $order->id }} })">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
                Delete
            </a>
            <a href="#" class="btn btn-danger d-md-none btn-icon"
                onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-order', { orderId: {{ $order->id }} })">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </a>

            <a href="{{ route('orders.index') }}" class="btn btn-primary d-none d-md-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l14 0" />
                    <path d="M5 12l6 6" />
                    <path d="M5 12l6 -6" />
                </svg>
                Back to list
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-primary d-md-none btn-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l14 0" />
                    <path d="M5 12l6 6" />
                    <path d="M5 12l6 -6" />
                </svg>
            </a>
        </div>
    </x-page-header>

    {{-- Page Body --}}
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">

                {{-- Order Summary --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Summary</h3>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Status</div>
                                    <div class="datagrid-content">
                                        <span class="badge bg-{{ $order->status->color() }}-lt">{{ $order->status->label() }}</span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Estimated Delivery</div>
                                    <div class="datagrid-content">{{ $order->estimated_delivery_date ? $order->estimated_delivery_date->format('d M Y') : '—' }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Total Amount</div>
                                    <div class="datagrid-content h2 mb-0">{{ '$' . number_format($order->total_amount, 2) }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Customer</div>
                                    <div class="datagrid-content">
                                        @if($order->customer)
                                            <a href="{{ route('customers.show', $order->customer_id) }}">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</a>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Created At</div>
                                    <div class="datagrid-content">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shipping Information --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Shipping Address & Notes</h3>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Address</div>
                                    <div class="datagrid-content">{{ $order->address }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">City</div>
                                    <div class="datagrid-content">{{ $order->city ?? '—' }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Postal Code</div>
                                    <div class="datagrid-content">{{ $order->postal_code ?? '—' }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Country</div>
                                    <div class="datagrid-content">
                                        @if ($order->country)
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="flag flag-xxs flag-country-{{ strtolower($order->country) }}"></span>
                                            <span>{{ __('countries.'.$order->country) }}</span>
                                        </div>
                                        @else
                                        <span class="text-muted">Not specified</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($order->notes)
                            <div class="mt-4">
                                <h4 class="mb-2">Notes</h4>
                                <div class="text-secondary">
                                    {!! nl2br(e($order->notes)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Order Items Table --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Items</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Discount</th>
                                        <th class="text-end">Quantity</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->products as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('stock.show', $product->id) }}">{{ $product->name }}</a>
                                        </td>
                                        <td class="text-muted">{{ $product->sku ?? '-' }}</td>
                                        <td class="text-end">{{ '$' . number_format($product->pivot->price, 2) }}</td>
                                        <td class="text-end text-danger">{{ $product->pivot->discount ? '%' . number_format($product->pivot->discount, 2) : '-' }}</td>
                                        <td class="text-end">{{ $product->pivot->amount }}</td>
                                        <td class="text-end fw-bold">{{ '$' . number_format($product->pivot->total, 2) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No items in this order.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Grand Total:</td>
                                        <td class="text-end fw-bold h3 m-0">{{ '$' . number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
