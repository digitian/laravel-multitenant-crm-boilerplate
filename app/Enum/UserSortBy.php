<?php

namespace App\Enum;

enum UserSortBy: string
{
    case CreatedAt = 'created_at';
    case Name = 'first_name';
}
