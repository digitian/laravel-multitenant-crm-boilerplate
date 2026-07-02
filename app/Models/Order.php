<?php

namespace App\Models;

use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'created_by',
        'status',
        'estimated_delivery_date',
        'address',
        'city',
        'postal_code',
        'country',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'estimated_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'orderable')
            ->withPivot(['amount', 'price', 'discount', 'total'])
            ->withTimestamps();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
