<?php

namespace App\Models;

use App\Enum\CompanyStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'logo_path',
        'website',
        'address',
        'city',
        'postal_code',
        'country',
        'created_by',
        'tax_number',
        'vat_number',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => CompanyStatus::class,
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('title');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
