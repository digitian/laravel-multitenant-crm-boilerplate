<?php

namespace App\Actions;

use App\DTOs\UserData;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateUser
{
    public function execute(UserData $data, Company $company): User
    {
        return DB::transaction(function () use ($data, $company) {
            $user = User::create([
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'password' => bcrypt($data->password),
                'phone' => $data->phone,
                'address' => $data->address,
                'city' => $data->city,
                'country' => $data->country,
                'zip_code' => $data->zip_code,
                'title' => $data->title,
            ]);

            // Get the role names for spatie role assignment and check if they belong to the company
            $roles = Role::whereIn('id', $data->roles)
                ->where('company_id', $company->id)
                ->get();

            // Associate the user with the company (store title on pivot)
            $user->companies()->attach($company->id, [
                'title' => $data->title,
            ]);

            if ($roles->isEmpty()) {
                throw new \Exception('The selected roles are not valid for this company.');
            }

            setPermissionsTeamId($company->id);
            $user->syncRoles($roles);

            return $user;
        });
    }
}
