<?php

namespace App\Livewire\Forms\Admin;

use App\DTOs\CompanyData;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateCompanyForm extends Form
{
    #[Validate(['required', 'string', 'max:255', 'unique:companies'])]
    public string $name = '';

    #[Validate(['required', 'email', 'max:255', 'unique:companies'])]
    public string $email = '';

    #[Validate(['required', 'string', 'max:20'])]
    public string $phone = '';

    #[Validate(['nullable', 'url'])]
    public string $website = '';

    #[Validate(['required', 'string', 'max:100'])]
    public string $country = '';

    #[Validate(['required', 'string', 'max:100'])]
    public string $city = '';

    #[Validate(['required', 'string'])]
    public string $address = '';

    #[Validate(['nullable', 'string', 'max:100'])]
    public string $tax_number = '';

    #[Validate(['nullable', 'string', 'max:100'])]
    public string $vat_number = '';

    public function toDTO(): CompanyData
    {
        return new CompanyData(
            name: $this->name,
            email: $this->email,
            phone: $this->phone,
            country: $this->country,
            city: $this->city,
            slug: Str::slug($this->name),
            created_by: auth()->id(),
            address: $this->address,
            tax_number: $this->tax_number ?: null,
            vat_number: $this->vat_number ?: null,
            website: $this->website ?: null,
        );
    }
}
