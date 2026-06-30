<?php

use App\Livewire\Forms\Admin\EditUserForm;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new class extends Component
{
    public EditUserForm $form;

    public ?int $userId = null;

    public ?int $companyId = null;

    public string $companyName = '';

    public Collection $companyRoles;

    public function mount()
    {
        $this->companyRoles = collect();
    }

    #[On('edit-user')]
    public function loadUser(int $userId, int $companyId)
    {
        $this->userId = $userId;
        $this->companyId = $companyId;

        $user = User::findOrFail($userId);
        $company = Company::findOrFail($companyId);

        $this->companyName = $company->name;
        $this->companyRoles = Role::where('company_id', $companyId)->get();

        $this->form->first_name = $user->first_name;
        $this->form->last_name = $user->last_name;
        $this->form->email = $user->email;
        $this->form->phone = $user->phone ?? '';

        // Read title from pivot
        $pivotTitle = $user->companies()->where('company_id', $companyId)->first()?->pivot?->title;
        $this->form->title = $pivotTitle ?? '';

        // Get the user's current roles for this company
        $this->form->roles = $user->getRolesForCompany($companyId)->pluck('id')->map(fn ($id) => (string) $id)->toArray();

        $this->dispatch('open-edit-user-modal');
    }

    public function updateUser()
    {
        $this->form->validate();

        $user = User::findOrFail($this->userId);

        $user->update([
            'first_name' => $this->form->first_name,
            'last_name' => $this->form->last_name,
            'email' => $this->form->email,
            'phone' => $this->form->phone,
        ]);

        // Update title on the pivot
        $user->companies()->updateExistingPivot($this->companyId, [
            'title' => $this->form->title,
        ]);

        // Sync roles within the company's team context
        $roles = Role::whereIn('id', $this->form->roles)
            ->where('company_id', $this->companyId)
            ->get();

        if ($roles->isEmpty()) {
            throw new Exception('The selected roles are not valid for this company.');
        }

        setPermissionsTeamId($this->companyId);
        $user->syncRoles($roles);

        flash()->success("User <b>{$user->first_name}</b> updated successfully.");

        return $this->js("setTimeout(() => { window.location.href = '".route('admin.companies.edit', $this->companyId)."'; }, 1000);");
    }

    public function removeFromCompany()
    {
        $user = User::findOrFail($this->userId);

        // Remove the user's roles for this company
        setPermissionsTeamId($this->companyId);
        $user->syncRoles([]);

        // Detach the user from the company
        $user->companies()->detach($this->companyId);

        flash()->success("User <b>{$user->first_name}</b> removed from company successfully.");

        return $this->js("setTimeout(() => { window.location.href = '".route('admin.companies.edit', $this->companyId)."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
        $this->userId = null;
        $this->companyId = null;
        $this->companyName = '';
        $this->companyRoles = collect();
    }
};
