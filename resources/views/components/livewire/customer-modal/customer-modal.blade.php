<div wire:ignore.self class="modal modal-blur fade" id="modal-customer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $form->customer ? 'Edit Customer' : 'Create New Customer' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="save" id="customer-form">
                <div class="modal-body">
                    <div class="row gx-3 gy-2">

                        {{-- Input: First Name --}}
                        <div class="col-md-6">
                            <label for="customer_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="customer_first_name"
                                wire:model="form.first_name" placeholder="Enter first name" required>
                            <x-input-error :messages="$errors->get('form.first_name')" />
                        </div>

                        {{-- Input: Last Name --}}
                        <div class="col-md-6">
                            <label for="customer_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="customer_last_name" wire:model="form.last_name"
                                placeholder="Enter last name" required>
                            <x-input-error :messages="$errors->get('form.last_name')" />
                        </div>

                        {{-- Input: Email --}}
                        <div class="col-md-6">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="customer_email" wire:model="form.email"
                                placeholder="Enter email" required>
                            <x-input-error :messages="$errors->get('form.email')" />
                        </div>

                        {{-- Input: Phone --}}
                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label">Phone</label>
                            <input type="tel" id="customer_phone" class="form-control" wire:model="form.phone"
                                data-mask="(000) 000-00-00" data-mask-visible="true" placeholder="(000) 000-00-00"
                                autocomplete="off" />
                            <x-input-error :messages="$errors->get('form.phone')" />
                        </div>

                    </div>

                    {{-- Divider: Address Section --}}
                    <hr class="my-3">

                    <div class="row gx-3 gy-2">

                        {{-- Select: Country --}}
                        <div class="col-md-6">
                            <livewire:input-country-select wire:model="form.country" />
                            <x-input-error :messages="$errors->get('form.country')" />
                        </div>

                        {{-- Input: City --}}
                        <div class="col-md-6">
                            <label for="customer_city" class="form-label">City</label>
                            <input type="text" class="form-control" id="customer_city" wire:model="form.city"
                                placeholder="Enter city">
                            <x-input-error :messages="$errors->get('form.city')" />
                        </div>

                        {{-- Input: Postal Code --}}
                        <div class="col-md-6">
                            <label for="customer_postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="customer_postal_code"
                                wire:model="form.postal_code" placeholder="Enter postal code">
                            <x-input-error :messages="$errors->get('form.postal_code')" />
                        </div>

                        {{-- Input: Address --}}
                        <div class="col-md-6">
                            <label for="customer_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="customer_address" wire:model="form.address"
                                placeholder="Enter address">
                            <x-input-error :messages="$errors->get('form.address')" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                            <span class="visually-hidden">Saving...</span>
                        </div>
                        <span wire:loading.remove>{{ $form->customer ? 'Save changes' : 'Create customer' }}</span>
                        <span wire:loading>{{ $form->customer ? 'Saving...' : 'Creating...' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('open-customer-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('modal-customer');
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
        }, 50);
    });
</script>
@endscript