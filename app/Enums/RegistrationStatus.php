<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case Pending = 'pending';
    case ApprovedPendingPayment = 'approved_pending_payment';
    case Approved = 'approved';
    case Completed = 'completed';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Chờ xử lý',
            self::ApprovedPendingPayment => 'Chờ thanh toán',
            self::Approved => 'Đã duyệt',
            self::Completed => 'Hoàn tất',
            self::Rejected => 'Từ chối',
            self::Cancelled => 'Đã hủy',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}

