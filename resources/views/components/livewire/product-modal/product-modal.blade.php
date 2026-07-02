<div wire:ignore.self class="modal modal-blur fade" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $form->product ? 'Edit Product' : 'Create New Product' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="save" id="product-form">
                <div class="modal-body">
                    <div class="row gx-3 gy-2">

                        {{-- Input: Name --}}
                        <div class="col-md-12">
                            <label for="product_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="product_name"
                                wire:model="form.name" placeholder="Enter product name" required>
                            <x-input-error :messages="$errors->get('form.name')" />
                        </div>

                        {{-- Input: SKU --}}
                        <div class="col-md-4">
                            <label for="product_sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="product_sku" wire:model="form.sku"
                                placeholder="Enter SKU (Optional)">
                            <x-input-error :messages="$errors->get('form.sku')" />
                        </div>

                        {{-- Input: Amount --}}
                        <div class="col-md-4">
                            <label for="product_amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="product_amount" wire:model="form.amount"
                                placeholder="Enter amount" required min="0">
                            <x-input-error :messages="$errors->get('form.amount')" />
                        </div>

                        {{-- Input: Price --}}
                        <div class="col-md-4">
                            <label for="product_price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="product_price" wire:model="form.price"
                                placeholder="0.00" min="0">
                            <x-input-error :messages="$errors->get('form.price')" />
                        </div>

                    </div>

                    {{-- Divider: Description Section --}}
                    <hr class="my-3">

                    <div class="row gx-3 gy-2">
                        {{-- Textarea: Description --}}
                        <div class="col-md-12">
                            <label for="product_description" class="form-label">Description</label>
                            <textarea class="form-control" id="product_description" wire:model="form.description" rows="4" placeholder="Enter product description"></textarea>
                            <x-input-error :messages="$errors->get('form.description')" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                            <span class="visually-hidden">Saving...</span>
                        </div>
                        <span wire:loading.remove>{{ $form->product ? 'Save changes' : 'Create product' }}</span>
                        <span wire:loading>{{ $form->product ? 'Saving...' : 'Creating...' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('open-product-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('modal-product');
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
        }, 50);
    });
</script>
@endscript
