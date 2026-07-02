<?php

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ?int $productId = null;

    public string $productName = '';

    #[On('confirm-delete-product')]
    public function confirmDelete(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $this->productId = $product->id;
        $this->productName = $product->name;
        $this->dispatch('open-delete-product-modal');
    }

    public function deleteProduct(): mixed
    {
        $product = Product::findOrFail($this->productId);
        $name = $this->productName;

        $product->delete();

        flash()->success("Product <b>{$name}</b> deleted successfully.");

        return $this->js("setTimeout(() => { window.location.href = '".route('stock.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->productId = null;
        $this->productName = '';
    }
};
