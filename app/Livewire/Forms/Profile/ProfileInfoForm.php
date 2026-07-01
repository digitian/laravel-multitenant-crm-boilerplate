<?php

namespace App\Livewire\Forms\Profile;

use App\DTOs\ProfileInfoData;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileInfoForm extends Form
{
    #[Validate(['required', 'string', 'max: 50'])]
    public string $first_name = '';

    #[Validate(['required', 'string', 'max:50'])]
    public string $last_name = '';

    #[Validate(['nullable', 'string', 'max:20'])]
    public ?string $phone = null;

    #[Validate(['nullable', 'string', 'max:2'])]
    public ?string $country = null;

    #[Validate(['nullable', 'string', 'max: 500'])]
    public ?string $bio = null;

    #[Validate(['nullable', 'string', 'max: 100'])]
    public ?string $city = null;

    #[Validate(['nullable', 'string', 'max: 255'])]
    public ?string $address = null;

    #[Validate(['nullable', 'string', 'max: 10'])]
    public ?string $zip_code = null;

    public function toDto(): ProfileInfoData
    {
        return new ProfileInfoData(
            first_name: $this->first_name,
            last_name: $this->last_name,
            phone: $this->phone,
            bio: $this->bio,
            country: $this->country,
            city: $this->city,
            address: $this->address,
            zip_code: $this->zip_code
        );
    }
}
