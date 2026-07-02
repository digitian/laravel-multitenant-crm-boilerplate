<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ProductForm extends Form
{
    public ?Product $product = null;

    public string $name = '';

    public ?string $description = null;

    public int $amount = 0;

    public ?float $price = null;

    public ?string $sku = null;

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->amount = $product->amount;
        $this->price = $product->price ? (float) $product->price : null;
        $this->sku = $product->sku;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'integer', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($this->product?->id)],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'amount' => $this->amount,
            'price' => $this->price ?: null,
            'sku' => $this->sku ?: null,
        ];
    }
}
