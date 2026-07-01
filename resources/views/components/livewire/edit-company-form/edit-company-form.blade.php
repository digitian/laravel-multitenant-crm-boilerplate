<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Company</h3>
    </div>
    <div class="card-body">
        <form wire:submit="updateCompany" id="edit-company-form">
            @csrf
            @method('PUT')
            <div class="row gx-2 gy-3">

                {{-- Input: Company Name --}}
                <div class="col-md-6">
                    <label for="name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="name" wire:model="form.name" required>
                    <x-input-error :messages="$errors->get('form.name')" />
                </div>

                {{-- Input: Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" wire:model="form.email">
                    <x-input-error :messages="$errors->get('form.email')" />
                </div>

                {{-- Input: Phone --}}
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" id="phone" class="form-control" wire:model="form.phone" required
                        data-mask="(000) 000-00-00" data-mask-visible="true" placeholder="(000) 000-00-00"
                        autocomplete="off" />
                    <x-input-error :messages="$errors->get('form.phone')" />
                </div>

                {{-- Input: Website --}}
                <div class="col-md-6">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control" id="website" wire:model="form.website">
                    <x-input-error :messages="$errors->get('form.website')" />
                </div>

                {{-- Input: Country --}}
                <div class="col-md-6">
                    <livewire:input-country-select wire:model="form.country" />
                    <x-input-error :messages="$errors->get('form.country')" />
                </div>

                {{-- Input: City --}}
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" wire:model="form.city">
                    <x-input-error :messages="$errors->get('form.city')" />
                </div>

                {{-- Textarea: Address --}}
                <div class="col-md-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" wire:model="form.address" rows="3"></textarea>
                    <x-input-error :messages="$errors->get('form.address')" />
                </div>

                {{-- Input: Tax Number --}}
                <div class="col-md-6">
                    <label for="tax_number" class="form-label">Tax Number</label>
                    <input type="text" class="form-control" id="tax_number" wire:model="form.tax_number">
                    <x-input-error :messages="$errors->get('form.tax_number')" />
                </div>

                {{-- Input: VAT Number --}}
                <div class="col-md-6">
                    <label for="vat_number" class="form-label">VAT Number</label>
                    <input type="text" class="form-control" id="vat_number" wire:model="form.vat_number">
                    <x-input-error :messages="$errors->get('form.vat_number')" />
                </div>

                {{-- Select: Status --}}
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" wire:model="form.status">
                        <option value="">Select a status</option>
                        @foreach (\App\Enum\CompanyStatus::cases() as $status)
                        <option value="{{ $status->value }}">
                            {{ $status->label() }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('form.status')" />
                </div>

            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" wire:loading.attr="disabled" type="submit" form="edit-company-form">
            <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                <span class="visually-hidden">Saving...</span>
            </div>
            <span wire:loading.remove>Apply changes</span>
            <span wire:loading>Saving...</span>
        </button>
    </div>
</div>