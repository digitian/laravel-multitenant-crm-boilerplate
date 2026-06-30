<?php

namespace App\Actions;

use App\DTOs\CompanyData;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class EditCompany
{
    public function execute(Company $company, CompanyData $data)
    {
        return DB::transaction(function () use ($company, $data) {
            $company->update([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'country' => $data->country,
                'city' => $data->city,
                'address' => $data->address,
                'tax_number' => $data->tax_number,
                'vat_number' => $data->vat_number,
                'website' => $data->website,
                'status' => $data->status,
            ]);

            return $company;
        });
    }
}
