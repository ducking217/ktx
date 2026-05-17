<?php

namespace App\Enums;

enum Gender: string
{
    case Male   = 'male';
    case Female = 'female';
    case Other  = 'other';
    case Any    = 'any';

    public function label(): string
    {
        return match($this) {
            self::Male   => 'Nam',
            self::Female => 'Nữ',
            self::Other  => 'Khác',
            self::Any    => 'Không phân biệt',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
    
    public static function fromVietnamese(string $value): ?self
    {
        return match($value) {
            'Nam' => self::Male,
            'Nữ'  => self::Female,
            default => null,
        };
    }
}
