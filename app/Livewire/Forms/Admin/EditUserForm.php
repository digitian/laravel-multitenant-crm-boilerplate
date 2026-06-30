<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Attributes\Validate;
use Livewire\Form;

class EditUserForm extends Form
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $first_name = '';

    #[Validate(['required', 'string', 'max:255'])]
    public string $last_name = '';

    #[Validate(['required', 'email'])]
    public string $email = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public string $phone = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public string $title = '';

    #[Validate([
        'roles' => ['required', 'array', 'min:1'],
        'roles.*' => ['exists:roles,id'],
    ])]
    public array $roles = [];
}
