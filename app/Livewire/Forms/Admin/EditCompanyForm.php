<?php

namespace App\Livewire\Forms\Admin;

use App\DTOs\CompanyData;
use App\Enum\CompanyStatus;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditCompanyForm extends Form
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $name;

    #[Validate(['required', 'string', 'email', 'max:255'])]
    public string $email;

    #[Validate(['nullable', 'string', 'max:20'])]
    public ?string $phone = null;

    #[Validate(['nullable', 'string', 'max:255'])]
    public ?string $website = null;

    #[Validate(['nullable', 'string', 'max:255'])]
    public ?string $country = null;

    #[Validate(['nullable', 'string', 'max:255'])]
    public ?string $city = null;

    #[Validate(['nullable', 'string', 'max:500'])]
    public ?string $address = null;

    #[Validate(['nullable', 'string', 'max:50'])]
    public ?string $tax_number = null;

    #[Validate(['nullable', 'string', 'max:50'])]
    public ?string $vat_number = null;

    // Preferred to validate it dynamically from the source of truth (the enum) rather than hardcoding
    #[Validate(['required', new Enum(CompanyStatus::class)])]
    public string $status;

    public function toDto()
    {
        return new CompanyData(
            name: $this->name,
            email: $this->email,
            phone: $this->phone,
            website: $this->website,
            country: $this->country,
            city: $this->city,
            address: $this->address,
            tax_number: $this->tax_number,
            vat_number: $this->vat_number,
            status: $this->status,
        );
    }
}
