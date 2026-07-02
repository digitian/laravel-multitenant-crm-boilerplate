<?php

namespace App\Enum;

enum OrderSortBy: string
{
    case CreatedAt = 'created_at';
    case EstimatedDeliveryDate = 'estimated_delivery_date';
    case TotalAmount = 'total_amount';
    case Status = 'status';
}
