<?php

namespace App\Livewire\Forms\Admin;

use App\DTOs\UserData;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateUserForm extends Form
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $first_name = '';

    #[Validate(['required', 'string', 'max:255'])]
    public string $last_name = '';

    #[Validate(['required', 'email', 'unique:users,email'])]
    public string $email = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public string $phone = '';

    #[Validate(['required', 'string', 'min:8'])]
    public string $password = '';

    #[Validate(['required', 'string', 'min:8', 'same:password'])]
    public string $password_confirmation = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public string $title = '';

    #[Validate([
        'roles' => ['required', 'array', 'min:1'],
        'roles.*' => ['exists:roles,id'],
    ])]
    public array $roles = [];

    public function toDTO()
    {
        return new UserData(
            first_name: $this->first_name,
            last_name: $this->last_name,
            email: $this->email,
            phone: $this->phone,
            password: $this->password,
            title: $this->title,
            roles: $this->roles,
        );
    }
}
