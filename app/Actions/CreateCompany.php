<?php

namespace App\Actions;

use App\DTOs\CompanyData;
use App\Enum\CompanyStatus;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateCompany
{
    public function execute(CompanyData $data, $user = null): Company
    {
        return DB::transaction(function () use ($data, $user) {
            $company = Company::create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'country' => $data->country,
                'city' => $data->city,
                'slug' => $data->slug,
                'created_by' => $user ? $user->id : null,
                'address' => $data->address,
                'tax_number' => $data->tax_number,
                'vat_number' => $data->vat_number,
                'website' => $data->website,
                'status' => $data->status ?? CompanyStatus::active, // Default to ACTIVE if not provided
            ]);

            // Create 'admin' role for the company for future assignments
            Role::create([
                'name' => 'company_admin',
                'display_name' => 'Company Admin',
                'company_id' => $company->id,
            ]);

            return $company;
        });
    }
}
