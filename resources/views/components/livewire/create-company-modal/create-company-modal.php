<?php

use App\Actions\CreateCompany;
use App\Livewire\Forms\Admin\CreateCompanyForm;
use Livewire\Component;

new class extends Component
{
    public CreateCompanyForm $form;

    public function createCompany(CreateCompany $action): void
    {
        $this->form->validate();

        $company = $action->execute($this->form->toDTO());

        flash()->success("Company <b>{$company->name}</b> created successfully.");

        $this->js("setTimeout(() => { window.location.href = '".route('admin.companies.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
    }
};
