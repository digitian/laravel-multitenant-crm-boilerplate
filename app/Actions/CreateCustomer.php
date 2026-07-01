<?php

namespace App\Actions;

use App\Models\Customer;

class CreateCustomer
{
    /**
     * @param  array{
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     phone: ?string,
     *     country: ?string,
     *     city: ?string,
     *     postal_code: ?string,
     *     address: ?string,
     * }  $data
     */
    public function execute(array $data): Customer
    {
        return Customer::create([
            ...$data,
            'created_by' => auth()->id(),
        ]);
    }
}
