<?php

use App\Actions\CreateUser;
use App\Livewire\Forms\Admin\CreateUserForm;
use App\Models\Company;
use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new class extends Component
{
    public CreateUserForm $form;

    public Company $company;

    public Collection $companyRoles;

    public function mount()
    {
        $this->companyRoles = Role::where('company_id', $this->company->id)->get();
    }

    public function createUser(CreateUser $action)
    {
        $this->form->validate();

        // Execute the action via DTO
        $user = $action->execute($this->form->toDTO(), $this->company);

        flash()->success('User <b>'.$user->first_name.'</b> created successfully');

        return $this->js("setTimeout(() => { window.location.href = '".route('admin.companies.edit', $this->company)."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
    }
};
