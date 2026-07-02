@extends('layouts.authenticated.app')

@section('content')
<div>
    {{-- Page Header --}}
    <x-page-header title="{{ $product->name }}" pretitle="Product Details">
        <div class="btn-list">

            {{-- Button: Edit (desktop) --}}
            <a href="#" class="btn btn-success d-none d-md-inline-block"
                onclick="event.preventDefault(); Livewire.dispatch('edit-product', { productId: {{ $product->id }} })">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                    <path d="M16 5l3 3" />
                </svg>
                Edit
            </a>

            {{-- Button: Edit (mobile) --}}
            <a href="#" class="btn btn-success d-md-none btn-icon"
                onclick="event.preventDefault(); Livewire.dispatch('edit-product', { productId: {{ $product->id }} })">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                    <path d="M16 5l3 3" />
                </svg>
            </a>

            {{-- Button: Delete (desktop) --}}
            <a href="#" class="btn btn-danger d-none d-md-inline-block"
                onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-product', { productId: {{ $product->id }} })">
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

            {{-- Button: Delete (mobile) --}}
            <a href="#" class="btn btn-danger d-md-none btn-icon"
                onclick="event.preventDefault(); Livewire.dispatch('confirm-delete-product', { productId: {{ $product->id }} })">
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

            {{-- Button: Back to list (desktop) --}}
            <a href="{{ route('stock.index') }}" class="btn btn-primary d-none d-md-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l14 0" />
                    <path d="M5 12l6 6" />
                    <path d="M5 12l6 -6" />
                </svg>
                Back to list
            </a>

            {{-- Button: Back to list (mobile) --}}
            <a href="{{ route('stock.index') }}" class="btn btn-primary d-md-none btn-icon">
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

                {{-- Product Information --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Name</div>
                                    <div class="datagrid-content">{{ $product->name }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">SKU</div>
                                    <div class="datagrid-content">{{ $product->sku ?? '—' }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Amount</div>
                                    <div class="datagrid-content">{{ $product->amount }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Price</div>
                                    <div class="datagrid-content">{{ $product->price ? number_format($product->price, 2) : '—' }}</div>
                                </div>
                            </div>
                            
                            @if($product->description)
                            <div class="mt-4">
                                <h4 class="mb-2">Description</h4>
                                <div class="text-secondary">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Record Information --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Record Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Created By</div>
                                    <div class="datagrid-content">
                                        @if ($product->createdBy)
                                        {{ $product->createdBy->first_name }} {{ $product->createdBy->last_name }}
                                        @else
                                        <span class="text-muted">—</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Created At</div>
                                    <div class="datagrid-content">{{ $product->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $product->updated_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<livewire:livewire.product-modal />
<livewire:livewire.delete-product-modal />
@endsection
