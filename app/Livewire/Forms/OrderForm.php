<?php

namespace App\Livewire\Forms;

use App\Enum\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Form;

class OrderForm extends Form
{
    public ?Order $order = null;

    public ?int $customer_id = null;

    public string $status = 'pending';

    public ?string $estimated_delivery_date = null;

    public ?string $address = null;

    public ?string $city = null;

    public ?string $postal_code = null;

    public ?string $country = null;

    public ?string $notes = null;

    public array $items = [];

    public function setOrder(Order $order): void
    {
        $this->order = $order;
        $this->customer_id = $order->customer_id;
        $this->status = $order->status->value;
        $this->estimated_delivery_date = $order->estimated_delivery_date?->format('Y-m-d');
        $this->address = $order->address;
        $this->city = $order->city;
        $this->postal_code = $order->postal_code;
        $this->country = $order->country;
        $this->notes = $order->notes;

        $this->items = $order->products->map(function (Product $product) {
            return [
                'product_id' => $product->id,
                'amount' => $product->pivot->amount,
                'price' => (float) $product->pivot->price,
                'discount' => (float) $product->pivot->discount,
            ];
        })->toArray();
    }

    public function loadCustomerAddress(): void
    {
        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
            if ($customer) {
                $this->address = $customer->address;
                $this->city = $customer->city;
                $this->postal_code = $customer->postal_code;
                $this->country = $customer->country;
            }
        }
    }

    public function addItem(): void
    {
        $this->items[] = [
            'product_id' => null,
            'amount' => 1,
            'price' => 0,
            'discount' => 0,
        ];
    }

    public function removeItem(int $index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'status' => ['required', Rule::enum(OrderStatus::class)],
            'estimated_delivery_date' => ['nullable', 'date'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'size:2'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.amount' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.discount' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toData(): array
    {
        return [
            'customer_id' => $this->customer_id,
            'status' => OrderStatus::from($this->status),
            'estimated_delivery_date' => $this->estimated_delivery_date ?: null,
            'address' => $this->address,
            'city' => $this->city ?: null,
            'postal_code' => $this->postal_code ?: null,
            'country' => $this->country ?: null,
            'notes' => $this->notes ?: null,
            'items' => $this->items,
        ];
    }
}
