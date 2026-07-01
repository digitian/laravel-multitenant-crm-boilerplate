<div wire:ignore.self class="modal modal-blur fade" id="modal-new-company" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="createCompany" id="create-company-form">
                <div class="modal-body">
                    <div class="alert alert-info mb-3" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                    <path d="M12 9h.01"></path>
                                    <path d="M11 12h1v4h1"></path>
                                </svg>
                            </div>
                            <div>
                                Please fill in the required fields marked with an asterisk (*). You can always edit the
                                company details later.
                            </div>
                        </div>
                    </div>
                    <div class="row gx-3 gy-2">

                        {{-- Input: Company Name --}}
                        <div class="col-md-6">
                            <label for="company_name" class="form-label">Company Name *</label>
                            <input type="text" class="form-control" id="company_name" wire:model="form.name"
                                placeholder="Company Name" required>
                            <x-input-error :messages="$errors->get('form.name')" />
                        </div>

                        {{-- Input: Company E-mail --}}
                        <div class="col-md-6">
                            <label for="company_email" class="form-label">E-mail *</label>
                            <input type="email" class="form-control" id="company_email" wire:model="form.email"
                                placeholder="E-mail" required>
                            <x-input-error :messages="$errors->get('form.email')" />
                        </div>

                        {{-- Input: Company Phone --}}
                        <div class="col-md-6">
                            <label for="company_phone" class="form-label">Phone *</label>
                            <input type="tel" id="company_phone" class="form-control" wire:model="form.phone"
                                data-mask="(000) 000-00-00" data-mask-visible="true" placeholder="(000) 000-00-00"
                                autocomplete="off" required />
                            <x-input-error :messages="$errors->get('form.phone')" />
                        </div>

                        {{-- Input: Company Website --}}
                        <div class="col-md-6">
                            <label for="company_website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="company_website" wire:model="form.website"
                                placeholder="Website">
                            <x-input-error :messages="$errors->get('form.website')" />
                        </div>

                        {{-- Input: Company Country --}}
                        <div class="col-md-6">
                            <livewire:input-country-select wire:model="form.country" />
                            <x-input-error :messages="$errors->get('form.country')" />
                        </div>


                        {{-- Input: Company City --}}
                        <div class="col-md-6">
                            <label for="company_city" class="form-label">City *</label>
                            <input type="text" class="form-control" id="company_city" wire:model="form.city"
                                placeholder="City" required>
                            <x-input-error :messages="$errors->get('form.city')" />
                        </div>

                        {{-- Textarea: Company Address --}}
                        <div class="col-12">
                            <label for="company_address" class="form-label">Address *</label>
                            <textarea class="form-control" id="company_address" wire:model="form.address"
                                placeholder="Address" rows="3" required></textarea>
                            <x-input-error :messages="$errors->get('form.address')" />
                        </div>

                        {{-- Input: Company Tax Number --}}
                        <div class="col-md-6">
                            <label for="company_tax_number" class="form-label">Tax Number</label>
                            <input type="text" class="form-control" id="company_tax_number" wire:model="form.tax_number"
                                placeholder="Tax Number">
                            <x-input-error :messages="$errors->get('form.tax_number')" />
                        </div>

                        {{-- Input: Company VAT Number --}}
                        <div class="col-md-6">
                            <label for="company_vat_number" class="form-label">VAT Number</label>
                            <input type="text" class="form-control" id="company_vat_number" wire:model="form.vat_number"
                                placeholder="VAT Number">
                            <x-input-error :messages="$errors->get('form.vat_number')" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                            <span class="visually-hidden">Saving...</span>
                        </div>
                        <span wire:loading.remove>Create</span>
                        <span wire:loading>Creating...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>