<?php

namespace App\Livewire\Forms\Profile;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileInfoForm extends Form
{
    #[Validate(['required', 'string', 'max: 50'])]
    public string $first_name;

    #[Validate(['required', 'string', 'max:50'])]
    public string $last_name;

    #[Validate(['nullable', 'string', 'max:20'])]
    public ?string $phone = null;

    #[Validate(['nullable', 'string', 'max:2'])]
    public ?string $country;

    #[Validate(['nullable', 'string', 'max: 200'])]
    public ?string $bio;
}
