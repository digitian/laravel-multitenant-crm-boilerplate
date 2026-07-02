<?php

use App\Actions\CreateProduct;
use App\Actions\UpdateProduct;
use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public ProductForm $form;

    #[On('edit-product')]
    public function editProduct(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $this->form->setProduct($product);
        $this->dispatch('open-product-modal');
    }

    #[On('create-product')]
    public function createProductModal(): void
    {
        $this->resetForm();
        $this->dispatch('open-product-modal');
    }

    public function save(CreateProduct $createAction, UpdateProduct $updateAction): mixed
    {
        $this->form->validate();

        $data = $this->form->toData();

        if ($this->form->product) {
            $product = $updateAction->execute($this->form->product, $data);
            flash()->success('Product <b>'.$product->name.'</b> updated successfully.');
        } else {
            $product = $createAction->execute($data);
            flash()->success('Product <b>'.$product->name.'</b> created successfully.');
        }

        return $this->js("setTimeout(() => { window.location.href = '".route('stock.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
    }
};
