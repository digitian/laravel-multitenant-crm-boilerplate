<?php

use App\Actions\CreateOrder;
use App\Actions\UpdateOrder;
use App\Livewire\Forms\OrderForm;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public OrderForm $form;

    public Collection $customers;

    public Collection $products;

    public function mount(): void
    {
        $this->customers = Customer::orderBy('first_name')->get();
        $this->products = Product::orderBy('name')->get();
    }

    public function updatedFormCustomerId(): void
    {
        $this->form->loadCustomerAddress();
    }

    #[On('edit-order')]
    public function editOrder(int $orderId): void
    {
        $order = Order::with('products')->findOrFail($orderId);
        $this->form->setOrder($order);
        $this->dispatch('open-order-modal');
    }

    #[On('create-order')]
    public function createOrderModal(): void
    {
        $this->resetForm();
        $this->form->addItem(); // Default one empty item
        $this->dispatch('open-order-modal');
    }

    public function save(CreateOrder $createAction, UpdateOrder $updateAction): mixed
    {
        $this->form->validate();

        $data = $this->form->toData();

        if ($this->form->order) {
            $order = $updateAction->execute($this->form->order, $data);
            flash()->success('Order <b>#'.$order->id.'</b> updated successfully.');
        } else {
            $order = $createAction->execute($data);
            flash()->success('Order <b>#'.$order->id.'</b> created successfully.');
        }

        return $this->js("setTimeout(() => { window.location.href = '".route('orders.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
    }
};
