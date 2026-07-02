<?php

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ?int $orderId = null;

    #[On('confirm-delete-order')]
    public function confirmDelete(int $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $this->orderId = $order->id;
        $this->dispatch('open-delete-order-modal');
    }

    public function deleteOrder(): mixed
    {
        $order = Order::findOrFail($this->orderId);
        $orderIdStr = $this->orderId;

        $order->delete();

        flash()->success("Order <b>#{$orderIdStr}</b> deleted successfully.");

        return $this->js("setTimeout(() => { window.location.href = '".route('orders.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->orderId = null;
    }
};
