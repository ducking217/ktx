<?php

namespace App\Enums;

enum BaohongStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Done = 'done';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Chờ tiếp nhận',
            self::Processing => 'Đang xử lý',
            self::Done => 'Đã hoàn thành',
            self::Rejected => 'Từ chối',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}

