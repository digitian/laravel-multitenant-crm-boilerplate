<?php

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ?int $customerId = null;

    public string $customerName = '';

    #[On('confirm-delete-customer')]
    public function confirmDelete(int $customerId): void
    {
        $customer = Customer::findOrFail($customerId);
        $this->customerId = $customer->id;
        $this->customerName = $customer->first_name.' '.$customer->last_name;
        $this->dispatch('open-delete-customer-modal');
    }

    public function deleteCustomer(): mixed
    {
        $customer = Customer::findOrFail($this->customerId);
        $name = $this->customerName;

        $customer->delete();

        flash()->success("Customer <b>{$name}</b> deleted successfully.");

        return $this->js("setTimeout(() => { window.location.href = '".route('customers.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->customerId = null;
        $this->customerName = '';
    }
};
