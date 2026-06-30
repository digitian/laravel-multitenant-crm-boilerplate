<?php

namespace App\Enum;

enum CompanyStatus: string
{
    // Statuses are: Passive, Active, Suspended, Closed
    case passive = 'passive';
    case active = 'active';
    case suspended = 'suspended';
    case closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::passive => 'Passive',
            self::active => 'Active',
            self::suspended => 'Suspended',
            self::closed => 'Closed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::passive => 'secondary',
            self::active => 'success',
            self::suspended => 'warning',
            self::closed => 'danger',
        };
    }

    public static function labels(): array
    {
        return array_map(fn ($status) => $status->label(), self::cases());
    }
}
