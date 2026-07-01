<div wire:ignore.self class="modal modal-blur fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="modal-title">Edit User</h5>
                    @if ($companyName)
                    <span class="badge bg-blue-lt">{{ $companyName }}</span>
                    @endif
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="updateUser" id="edit-user-form">
                <div class="modal-body">
                    <div class="row gx-3 gy-2">

                        {{-- Input: First Name --}}
                        <div class="col-md-6">
                            <label for="edit_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" wire:model="form.first_name"
                                placeholder="Enter first name" required>
                            <x-input-error :messages="$errors->get('form.first_name')" />
                        </div>

                        {{-- Input: Last Name --}}
                        <div class="col-md-6">
                            <label for="edit_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" wire:model="form.last_name"
                                placeholder="Enter last name" required>
                            <x-input-error :messages="$errors->get('form.last_name')" />
                        </div>

                        {{-- Input: Email --}}
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" wire:model="form.email"
                                placeholder="Enter email" required>
                            <x-input-error :messages="$errors->get('form.email')" />
                        </div>

                        {{-- Input: Phone --}}
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Phone</label>
                            <input type="tel" id="edit_phone" class="form-control" wire:model="form.phone"
                                data-mask="(000) 000-00-00" data-mask-visible="true" placeholder="(000) 000-00-00"
                                autocomplete="off" />
                            <x-input-error :messages="$errors->get('form.phone')" />
                        </div>

                        {{-- Input: Title --}}
                        <div class="col-md-6">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title" wire:model="form.title"
                                placeholder="Enter title">
                            <x-input-error :messages="$errors->get('form.title')" />
                        </div>

                        {{-- Select (Multiple): Roles --}}
                        <div class="col-md-6">
                            <label for="edit-select-roles" class="form-label">Roles</label>
                            <div wire:ignore>
                                <select id="edit-select-roles" class="form-select" placeholder="Select roles" multiple>
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
                    <button type="button" class="btn btn-danger me-auto" wire:click="removeFromCompany"
                        wire:confirm="Are you sure you want to remove this user from the company?">
                        Remove from company
                    </button>
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm text-info me-2" role="status" wire:loading>
                            <span class="visually-hidden">Saving...</span>
                        </div>
                        <span wire:loading.remove>Save changes</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    let editTomSelect = null;

    function initEditTomSelect(selectedValues = []) {
        const el = document.getElementById('edit-select-roles');
        if (!el) return;

        // Destroy existing instance if it exists
        if (editTomSelect) {
            editTomSelect.destroy();
            editTomSelect = null;
        }

        editTomSelect = new TomSelect(el, {
            copyClassesToDropdown: false,
            dropdownParent: 'body',
            items: selectedValues,
        });

        editTomSelect.on('change', (values) => {
            $wire.$set('form.roles', values);
        });
    }

    // When the modal opens, initialize TomSelect with the user's current roles
    $wire.on('open-edit-user-modal', () => {
        // Wait for next tick so Livewire has updated the DOM
        setTimeout(() => {
            const modal = document.getElementById('modal-edit-user');
            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();

            // Get the roles from the Livewire component
            const roles = $wire.form.roles || [];
            initEditTomSelect(roles);
        }, 100);
    });

    // When the modal closes, destroy TomSelect (form reset handled globally)
    const editModal = document.getElementById('modal-edit-user');
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', () => {
            if (editTomSelect) {
                editTomSelect.destroy();
                editTomSelect = null;
            }
        });
    }
</script>
@endscript