<?php

namespace App\Enum;

enum SupportRequestStatus: string
{
    case pending = 'pending';
    case assigned = 'assigned';
    case resolved = 'resolved';
    case closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::pending => 'Pending',
            self::assigned => 'Assigned',
            self::resolved => 'Resolved',
            self::closed => 'Closed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::pending => 'warning',
            self::assigned => 'info',
            self::resolved => 'success',
            self::closed => 'danger',
        };
    }

    public static function labels(): array
    {
        return array_map(fn ($status) => $status->label(), self::cases());
    }
}
