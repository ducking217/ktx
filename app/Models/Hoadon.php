<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hoadon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hoadon';

    // Phân loại hóa đơn
    public const LOAI_MONTHLY = 'monthly';   // Hóa đơn tháng thường
    public const LOAI_DEPOSIT = 'deposit';   // Phí thế chân
    public const LOAI_PENALTY  = 'penalty';   // Phí bồi thường lỗi thiết bị
    public const LOAI_REFUND   = 'refund';    // Hoàn tiền cọc
    
    public static function trangThaiQuaHan(): string
    {
        return \App\Enums\InvoiceStatus::Overdue->value;
    }

    public static function trangThaiChuaThanhToan(): string
    {
        return \App\Enums\InvoiceStatus::Pending->value;
    }


    private const ALLOWED_TRANSITIONS = [
        'pending_confirmation' => [
            'pending',
        ],
        'pending' => [
            'paid',
            'overdue',
        ],
        'overdue' => [
            'paid',
        ],
        'paid' => [],
    ];

    protected $fillable = [
        'phong_id',
        'sinhvien_id',
        'loai_hoadon',
        'thang',
        'nam',
        'chisodiencu',
        'chisodienmoi',
        'chisonuoccu',
        'chisonuocmoi',
        'tongtien',
        'tienphong',
        'tiendien',
        'tiennuoc',
        'phidichvu',
        'tienphat',
        'trangthaithanhtoan',
        'ngay_thanh_toan',
        'ngayxuat',
        'calculation_details',
        'toa_nha_id',
    ];

    protected $casts = [
        'trangthaithanhtoan' => \App\Enums\InvoiceStatus::class,
        'ngay_thanh_toan' => 'datetime',
        'calculation_details' => 'array',
    ];

    public function getMaHdAttribute(): string
    {
        return 'HD' . str_pad((string)$this->id, 6, '0', STR_PAD_LEFT);
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function transitionTo(string $newStatus): bool
    {
        $currentStatus = $this->trangthaithanhtoan->value ?? $this->trangthaithanhtoan;
        
        if (isset(self::ALLOWED_TRANSITIONS[$currentStatus]) && in_array($newStatus, self::ALLOWED_TRANSITIONS[$currentStatus])) {
            return $this->update(['trangthaithanhtoan' => $newStatus]);
        }

        return false;
    }

    public function toanha(): BelongsTo
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }
}
