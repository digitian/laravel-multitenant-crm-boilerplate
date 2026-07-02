<?php

namespace App\Actions;

use App\Models\Product;

class UpdateProduct
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
    public function execute(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }
}
