<?php

namespace App\Actions;

use App\Models\Customer;

class UpdateCustomer
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
    public function execute(Customer $customer, array $data): Customer
    {
        $customer->update($data);

        return $customer;
    }
}
