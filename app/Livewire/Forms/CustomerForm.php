<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CustomerForm extends Form
{
    public ?Customer $customer = null;

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public ?string $country = null;

    public string $city = '';

    public string $postal_code = '';

    public string $address = '';

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
        $this->first_name = $customer->first_name;
        $this->last_name = $customer->last_name;
        $this->email = $customer->email;
        $this->phone = $customer->phone ?? '';
        $this->country = $customer->country;
        $this->city = $customer->city ?? '';
        $this->postal_code = $customer->postal_code ?? '';
        $this->address = $customer->address ?? '';
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('customers', 'email')->ignore($this->customer?->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'size:2'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toData(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'country' => $this->country,
            'city' => $this->city ?: null,
            'postal_code' => $this->postal_code ?: null,
            'address' => $this->address ?: null,
        ];
    }
}
