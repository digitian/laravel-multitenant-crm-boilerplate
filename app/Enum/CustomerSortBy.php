<?php

namespace App\Enum;

enum CustomerSortBy: string
{
    case CreatedAt = 'created_at';
    case Name = 'first_name';
    case Email = 'email';
}
