<div wire:ignore.self class="modal modal-blur fade" id="modal-add-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="modal-title">Add New User</h5>
                    <span class="badge bg-blue-lt">{{ $company->name }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="createUser" id="create-user-form">
                <div class="modal-body">
                    <div class="row gx-3 gy-2">

                        {{-- Input: Name --}}
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" wire:model="form.first_name"
                                placeholder="Enter first name" required>
                            <x-input-error :messages="$errors->get('form.first_name')" />
                        </div>

                        {{-- Input: Last Name --}}
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" wire:model="form.last_name"
                                placeholder="Enter last name" required>
                            <x-input-error :messages="$errors->get('form.last_name')" />
                        </div>

                        {{-- Input: Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" wire:model="form.email"
                                placeholder="Enter email" required>
                            <x-input-error :messages="$errors->get('form.email')" />
                        </div>

                        {{-- Input: Phone --}}
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" id="phone" class="form-control" wire:model="form.phone"
                                data-mask="(000) 000-00-00" data-mask-visible="true" placeholder="(000) 000-00-00"
                                autocomplete="off" />
                            <x-input-error :messages="$errors->get('form.phone')" />
                        </div>

                        {{-- Input: Password --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" wire:model="form.password"
                                placeholder="Enter password" required>
                            <x-input-error :messages="$errors->get('form.password')" />
                            <small class="form-hint">The password must be at least 8 characters long.</small>
                        </div>

                        {{-- Input: Confirm Password --}}
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                wire:model="form.password_confirmation" placeholder="Confirm password" required>
                            <x-input-error :messages="$errors->get('form.password_confirmation')" />
                        </div>

                        {{-- Input: Title --}}
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" wire:model="form.title"
                                placeholder="Enter title">
                            <x-input-error :messages="$errors->get('form.title')" />
                        </div>

                        {{-- Select (Multiple): Roles --}}
                        <div class="col-md-6">
                            <label for="select-roles" class="form-label">Roles</label>
                            <div wire:ignore>
                                <select id="select-roles" class="form-select" placeholder="Select roles" multiple>
                                    @foreach ($companyRoles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->display_name ? $role->display_name : ucfirst($role->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('form.roles')" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                            <span class="visually-hidden">Adding...</span>
                        </div>
                        <span wire:loading.remove>Add user</span>
                        <span wire:loading>Adding...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    const el = document.getElementById('select-roles')

    if (el && !el.tomselect) {
        const tomselect = new TomSelect(el, {
            copyClassesToDropdown: false,
            dropdownParent: 'body',
        })

        tomselect.on('change', (values) => {
            $wire.$set('form.roles', values)
        })
    }
</script>
@endscript