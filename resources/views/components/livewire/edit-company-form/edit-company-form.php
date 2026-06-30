<?php

use App\Actions\EditCompany;
use App\Livewire\Forms\Admin\EditCompanyForm;
use App\Models\Company;
use Livewire\Component;

new class extends Component
{
    public Company $company;

    public array $companyStatuses;

    public EditCompanyForm $form;

    public function mount(Company $company)
    {
        $this->form->name = $company->name;
        $this->form->email = $company->email;
        $this->form->phone = $company->phone;
        $this->form->website = $company->website;
        $this->form->country = $company->country;
        $this->form->city = $company->city;
        $this->form->address = $company->address;
        $this->form->tax_number = $company->tax_number;
        $this->form->vat_number = $company->vat_number;
        $this->form->status = $company->status->value;
    }

    public function updateCompany(EditCompany $editCompanyAction)
    {
        $this->form->validate();

        $editCompanyAction->execute($this->company, $this->form->toDto());

        flash()->success('Company updated successfully.');

        return $this->js("setTimeout(() => { window.location.href = '".route('admin.companies.edit', $this->company)."'; }, 1000);");
    }
};
