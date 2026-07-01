<?php

namespace App\Enum;

enum CompanySortBy: string
{
    case CreatedAt = 'created_at';
    case Name = 'name';
    case Users = 'users';
}
