<?php

namespace App\Actions;

use App\Models\Product;

class CreateProduct
{
    /**
     * @param  array{
     *     name: string,
     *     description: ?string,
     *     amount: int,
     *     price: ?float,
     *     sku: ?string,
     * }  $data
     */
    public function execute(array $data): Product
    {
        return Product::create([
            ...$data,
            'created_by' => auth()->id(),
        ]);
    }
}
