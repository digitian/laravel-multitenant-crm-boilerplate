<div wire:ignore.self class="modal modal-blur fade" id="modal-order" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $form->order ? 'Edit Order' : 'Create New Order' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="save" id="order-form">
                <div class="modal-body">
                    
                    {{-- Order Information Section --}}
                    <div class="row gx-3 gy-2">
                        <div class="col-md-4">
                            <label class="form-label">Customer</label>
                            <select class="form-select" wire:model.live="form.customer_id" required>
                                <option value="">Select a customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->email }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('form.customer_id')" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Estimated Delivery Date</label>
                            <input type="date" class="form-control" wire:model="form.estimated_delivery_date">
                            <x-input-error :messages="$errors->get('form.estimated_delivery_date')" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" wire:model="form.status" required>
                                @foreach(\App\Enum\OrderStatus::cases() as $status)
                                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('form.status')" />
                        </div>
                    </div>

                    <hr class="my-3">
                    
                    {{-- Address Section --}}
                    <h4 class="mb-2">Shipping Address</h4>
                    <div class="row gx-3 gy-2">
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" wire:model="form.address" placeholder="Address" required>
                            <x-input-error :messages="$errors->get('form.address')" />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" wire:model="form.city" placeholder="City">
                            <x-input-error :messages="$errors->get('form.city')" />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" wire:model="form.postal_code" placeholder="Postal Code">
                            <x-input-error :messages="$errors->get('form.postal_code')" />
                        </div>
                        <div class="col-md-2">
                            <livewire:input-country-select wire:model="form.country" />
                            <x-input-error :messages="$errors->get('form.country')" />
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- Products Section --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="m-0">Order Items</h4>

                        {{-- Desktop button --}}
                        <button type="button" class="btn btn-outline-primary d-none d-md-inline-block" wire:click="form.addItem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            Add Item
                        </button>

                        {{-- Mobile button --}}
                        <button type="button" class="btn btn-icon btn-outline-primary d-md-none" wire:click="form.addItem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        </button>
                    </div>
                    
                    @foreach($form->items as $index => $item)
                        @php $hasProduct = !empty($form->items[$index]['product_id']); @endphp
                        <div class="row gx-2 gy-2 align-items-end mb-2 p-2 border rounded bg-light" wire:key="item-{{ $index }}">
                            <div class="col-md-4">
                                <label class="form-label">Product</label>
                                <select class="form-select" wire:model.live="form.items.{{ $index }}.product_id" required>
                                    <option value="">Select product...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('form.items.'.$index.'.product_id')" />
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Quantity</label>
                                <input type="number" step="1" class="form-control" wire:model.live="form.items.{{ $index }}.amount" min="1" required @disabled(!$hasProduct)>
                                <x-input-error :messages="$errors->get('form.items.'.$index.'.amount')" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Discount (%)</label>
                                <input type="number" step="0.01" class="form-control" wire:model.live="form.items.{{ $index }}.discount" min="0" max="100" required @disabled(!$hasProduct)>
                                <x-input-error :messages="$errors->get('form.items.'.$index.'.discount')" />
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Price</label>
                                <div class="form-control-plaintext fw-bold">
                                    @php
                                        $itemPrice    = (float) ($form->items[$index]['price'] ?? 0);
                                        $itemDiscount = max(0, min(100, (float) ($form->items[$index]['discount'] ?? 0)));
                                        $itemAmount   = max(1, (int) ($form->items[$index]['amount'] ?? 1));
                                    @endphp
                                    {{ '$' . number_format($itemPrice * (1 - $itemDiscount / 100) * $itemAmount, 2) }}
                                </div>
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-icon btn-outline-danger" wire:click="form.removeItem({{ $index }})" aria-label="Remove item" @if(count($form->items) <= 1) disabled @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @php
                        $grandTotal = 0;
                        foreach ($form->items as $item) {
                            $p = (float) ($item['price'] ?? 0);
                            $d = max(0, min(100, (float) ($item['discount'] ?? 0)));
                            $a = max(1, (int) ($item['amount'] ?? 1));
                            $grandTotal += $p * (1 - $d / 100) * $a;
                        }
                    @endphp
                    <div class="text-end mb-3">
                        <strong class="h3">Grand Total: {{ '$' . number_format($grandTotal, 2) }}</strong>
                    </div>

                    {{-- Notes Section --}}
                    <div class="row gx-3 gy-2">
                        <div class="col-md-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" wire:model="form.notes" rows="3" placeholder="Additional notes about the order..."></textarea>
                            <x-input-error :messages="$errors->get('form.notes')" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                            <span class="visually-hidden">Saving...</span>
                        </div>
                        <span wire:loading.remove>{{ $form->order ? 'Save changes' : 'Create order' }}</span>
                        <span wire:loading>{{ $form->order ? 'Saving...' : 'Creating...' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('open-order-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('modal-order');
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
        }, 50);
    });
</script>
@endscript
