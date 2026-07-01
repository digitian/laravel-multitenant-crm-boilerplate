<?php

use App\Actions\CreateCustomer;
use App\Actions\UpdateCustomer;
use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public CustomerForm $form;

    #[On('edit-customer')]
    public function editCustomer(int $customerId): void
    {
        $customer = Customer::findOrFail($customerId);
        $this->form->setCustomer($customer);
        $this->dispatch('open-customer-modal');
    }

    #[On('create-customer')]
    public function createCustomerModal(): void
    {
        $this->resetForm();
        $this->dispatch('open-customer-modal');
    }

    public function save(CreateCustomer $createAction, UpdateCustomer $updateAction): mixed
    {
        $this->form->validate();

        $data = $this->form->toData();

        if ($this->form->customer) {
            $customer = $updateAction->execute($this->form->customer, $data);
            flash()->success('Customer <b>'.$customer->first_name.'</b> updated successfully.');
        } else {
            $customer = $createAction->execute($data);
            flash()->success('Customer <b>'.$customer->first_name.'</b> created successfully.');
        }

        return $this->js("setTimeout(() => { window.location.href = '".route('customers.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
    }
};
