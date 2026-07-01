<?php

namespace App\Actions;

use App\DTOs\ProfileInfoData;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateProfileInfo
{
    public function execute(User $user, ProfileInfoData $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $user->update([
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'phone' => $data->phone,
                'country' => $data->country,
                'bio' => $data->bio,
                'city' => $data->city,
                'address' => $data->address,
                'zip_code' => $data->zip_code,
            ]);

            return $user;
        });
    }
}
