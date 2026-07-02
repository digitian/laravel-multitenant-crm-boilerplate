<?php

namespace App\Enum;

enum ProductSortBy: string
{
    case CreatedAt = 'created_at';
    case Name = 'name';
    case Amount = 'amount';
    case Price = 'price';
}
