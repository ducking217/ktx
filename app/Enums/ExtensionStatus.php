<?php

namespace App\Enums;

enum ExtensionStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Chờ xử lý',
            self::Approved => 'Đã duyệt',
            self::Rejected => 'Từ chối',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
