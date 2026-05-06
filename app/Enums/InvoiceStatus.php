<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case Unpaid = 'unpaid';
    case PendingConfirmation = 'pending_confirmation';
    case Paid = 'paid';
    case Overdue = 'overdue';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Unpaid => 'Chưa thanh toán',
            self::PendingConfirmation => 'Chờ xác nhận',
            self::Paid => 'Đã thanh toán',
            self::Overdue => 'Quá hạn',
            self::Cancelled => 'Đã hủy',
        };
    }

    public function badgeClass(?string $invoiceType = null): string
    {
        $isRefund = $invoiceType === 'refund';

        return match ($this) {
            self::Paid => 'saas-badge-success',
            self::PendingConfirmation => 'saas-badge-info',
            self::Overdue => 'saas-badge-error',
            self::Cancelled => 'saas-badge-info',
            self::Unpaid => $isRefund ? 'saas-badge-info' : 'saas-badge-warning',
        };
    }

    public function displayLabel(?string $invoiceType = null): string
    {
        $isRefund = $invoiceType === 'refund';
        if (! $isRefund) {
            return $this->label();
        }

        return match ($this) {
            self::PendingConfirmation => 'Chờ hoàn tiền',
            self::Paid => 'Đã hoàn tiền',
            default => $this->label(),
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
