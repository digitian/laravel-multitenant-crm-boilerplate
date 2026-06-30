<?php

namespace App\Actions;

use App\DTOs\UserSocialMediaData;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserSocialMedia
{
    public function execute(User $user, UserSocialMediaData $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $user->update([
                'linkedin_url' => $data->linkedin_url,
                'facebook_url' => $data->facebook_url,
                'x_url' => $data->x_url,
                'instagram_url' => $data->instagram_url,
            ]);

            return $user;
        });
    }
}
