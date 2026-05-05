<?php

namespace App\Enums;

enum ContactStatus: string
{
    case Pending   = 'pending';
    case Processed = 'processed';
    case Spam      = 'spam';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Chờ xử lý',
            self::Processed => 'Đã xử lý',
            self::Spam      => 'Spam',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
