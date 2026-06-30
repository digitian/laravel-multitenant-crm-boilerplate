<div wire:ignore.self class="modal modal-blur fade" id="modal-global-user" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $form->user ? 'Edit User' : 'Create New User' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="save" id="global-user-form">
                <div class="modal-body">
                    <div class="row gx-3 gy-2">

                        {{-- Input: First Name --}}
                        <div class="col-md-6">
                            <label for="global_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="global_first_name" wire:model="form.first_name"
                                placeholder="Enter first name" required>
                            <x-input-error :messages="$errors->get('form.first_name')" />
                        </div>

                        {{-- Input: Last Name --}}
                        <div class="col-md-6">
                            <label for="global_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="global_last_name" wire:model="form.last_name"
                                placeholder="Enter last name" required>
                            <x-input-error :messages="$errors->get('form.last_name')" />
                        </div>

                        {{-- Input: Email --}}
                        <div class="col-md-6">
                            <label for="global_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="global_email" wire:model="form.email"
                                placeholder="Enter email" required>
                            <x-input-error :messages="$errors->get('form.email')" />
                        </div>

                        {{-- Input: Phone --}}
                        <div class="col-md-6">
                            <label for="global_phone" class="form-label">Phone</label>
                            <input type="tel" id="global_phone" class="form-control" wire:model="form.phone"
                                data-mask="(000) 000-00-00" data-mask-visible="true" placeholder="(000) 000-00-00"
                                autocomplete="off" />
                            <x-input-error :messages="$errors->get('form.phone')" />
                        </div>

                        {{-- Input: Password --}}
                        <div class="col-md-6">
                            <label for="global_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="global_password" wire:model="form.password"
                                placeholder="Enter password" @if(!$form->user) required @endif>
                            <x-input-error :messages="$errors->get('form.password')" />
                            @if($form->user)
                                <small class="form-hint">Leave blank to keep current password. Must be at least 8 characters long.</small>
                            @else
                                <small class="form-hint">The password must be at least 8 characters long.</small>
                            @endif
                        </div>

                        {{-- Input: Confirm Password --}}
                        <div class="col-md-6">
                            <label for="global_password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="global_password_confirmation"
                                wire:model="form.password_confirmation" placeholder="Confirm password" @if(!$form->user) required @endif>
                            <x-input-error :messages="$errors->get('form.password_confirmation')" />
                        </div>

                    </div>

                    {{-- Divider: Company Assignment Section --}}
                    <hr class="my-3">

                    {{-- Checkbox: Global User --}}
                    <div class="mb-3">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model.live="form.is_global_user"
                                @disabled(!empty($form->companies))>
                            <span class="form-check-label">
                                Global User
                                <small class="form-hint d-block mt-0">
                                    Global users have access to the admin dashboard and are not assigned to any company.
                                </small>
                            </span>
                        </label>
                    </div>

                    {{-- Section: Company Users --}}
                    @if (!$form->is_global_user)
                    {{-- Select (Multiple): Assign to Company --}}
                    <div class="mb-3">
                        <label for="select-global-companies" class="form-label">Assign to Company</label>
                        <div wire:ignore x-data="tomSelect('form.companies')">
                            <select id="select-global-companies" x-ref="select" class="form-select"
                                placeholder="Select companies" multiple>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('form.companies')" />
                    </div>

                    {{-- Per-Company Assignment Rows --}}
                    @foreach ($form->company_assignments as $companyId => $assignment)
                    @php
                    $companyName = $this->getCompanyName((int) $companyId);
                    $companyRoles = $companyRolesMap[$companyId] ?? [];
                    @endphp
                    <div class="card mb-2" wire:key="company-assignment-{{ $companyId }}">
                        <div class="card-header p-2">
                            <h3 class="card-title fs-4">{{ $companyName }}</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="row gx-3 gy-2">
                                {{-- Roles for this company --}}
                                <div class="col-md-6">
                                    <label class="form-label">Roles</label>
                                    <div wire:ignore
                                        x-data="tomSelect('form.company_assignments.{{ $companyId }}.roles')">
                                        <select class="form-select company-role-select" x-ref="select"
                                            data-company-id="{{ $companyId }}" multiple placeholder="Select roles">
                                            @foreach ($companyRoles as $role)
                                            <option value="{{ $role['id'] }}" @if(in_array($role['id'],
                                                $assignment['roles'] ?? [])) selected @endif>
                                                {{ $role['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error
                                        :messages="$errors->get('form.company_assignments.' . $companyId . '.roles')" />
                                </div>

                                {{-- Title for this company --}}
                                <div class="col-md-6">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control"
                                        wire:model="form.company_assignments.{{ $companyId }}.title"
                                        placeholder="e.g. Sales Manager">
                                    <x-input-error
                                        :messages="$errors->get('form.company_assignments.' . $companyId . '.title')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if (empty($form->companies))
                    <small class="form-hint text-muted">Select a company to configure roles and title.</small>
                    @endif
                    @endif

                    {{-- Section: Global User --}}
                    @if ($form->is_global_user)
                    <div class="row gx-3 gy-2">
                        {{-- Global Roles --}}
                        <div class="col-md-6">
                            <label for="select-global-roles" class="form-label">Roles</label>
                            <div wire:ignore x-data="tomSelect('form.roles')">
                                <select id="select-global-roles" x-ref="select" class="form-select"
                                    placeholder="Select roles" multiple>
                                    @foreach ($globalRoles as $role)
                                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('form.roles')" />
                        </div>

                        {{-- Global Title --}}
                        <div class="col-md-6">
                            <label for="global_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="global_title" wire:model="form.title"
                                placeholder="e.g. System Administrator">
                            <x-input-error :messages="$errors->get('form.title')" />
                        </div>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.class="disabled">
                        {{ $form->user ? 'Save Changes' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('tomSelect', (modelName) => ({
        ts: null,
        init() {
            const check = setInterval(() => {
                if (window.TomSelect) {
                    clearInterval(check);
                    this.ts = new TomSelect(this.$refs.select, {
                        copyClassesToDropdown: false,
                        dropdownParent: 'body',
                    });
                    
                    // Sync initial value from Livewire
                    let initial = $wire.$get(modelName);
                    if (initial) {
                        this.ts.setValue(initial, true);
                    }

                    // Watch for Livewire state changes and update Tom Select
                    $wire.$watch(modelName, (value) => {
                        if (this.ts) {
                            this.ts.setValue(value, true);
                        }
                    });

                    this.ts.on('change', (val) => {
                        let values = [];
                        if (Array.isArray(val)) {
                            values = val;
                        } else if (val) {
                            values = val.split(',');
                        }
                        $wire.$set(modelName, values.filter(Boolean));
                    });
                    $wire.on('companies-reset', () => {
                        if (this.ts) {
                            this.ts.clear(true);
                        }
                    });
                }
            }, 50);
        }
    }));

    $wire.on('open-global-user-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('modal-global-user');
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
        }, 50);
    });
</script>
@endscript