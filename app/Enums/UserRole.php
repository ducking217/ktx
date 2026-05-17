<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin    = 'admin';
    case Student  = 'sinhvien';
    case Guest    = 'guest';

    public function label(): string
    {
        return match($this) {
            self::Admin    => 'Quản trị viên',
            self::Student  => 'Sinh viên',
            self::Guest    => 'Khách',
        };
    }

    public function isAdminGroup(): bool
    {
        return $this === self::Admin;
    }

    public function isStudent(): bool
    {
        return $this === self::Student;
    }

    public function isGuest(): bool
    {
        return $this === self::Guest;
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
