<?php

namespace App\Models;

use App\Enums\ContractStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hopdong extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hopdong';

    public static function trangThaiDangHieuLuc(): string
    {
        return \App\Enums\ContractStatus::Active->value;
    }

    public static function trangThaiDaThanhLy(): string
    {
        return \App\Enums\ContractStatus::Terminated->value;
    }


    private const ALLOWED_TRANSITIONS = [
        'active' => [
            'expired',
            'terminated',
        ],
        'expired' => [
            'terminated',
        ],
        'terminated' => [],
    ];

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'giaphong_luc_ky',
        'trang_thai',
        'ghichu',
        'toa_nha_id',
    ];
    protected $casts = [
        'trang_thai' => ContractStatus::class,
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
    ];

    public function getMaHdAttribute(): string
    {
        return 'CONTRACT' . str_pad((string)$this->id, 6, '0', STR_PAD_LEFT);
    }

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function canTransitionTo(string|ContractStatus $targetState): bool
    {
        $currentState = $this->trang_thai instanceof ContractStatus 
            ? $this->trang_thai->value 
            : $this->trang_thai;

        $targetValue = $targetState instanceof ContractStatus 
            ? $targetState->value 
            : $targetState;

        if (! array_key_exists($currentState, self::ALLOWED_TRANSITIONS)) {
            return false;
        }

        return in_array($targetValue, self::ALLOWED_TRANSITIONS[$currentState], true);
    }

    public function transitionTo(string|ContractStatus $targetState, ?string $note = null): bool
    {
        $targetValue = $targetState instanceof ContractStatus 
            ? $targetState->value 
            : $targetState;

        if (! $this->canTransitionTo($targetValue)) {
            return false;
        }

        return $this->update([
            'trang_thai' => $targetValue,
            'ghichu' => $note,
        ]);
    }

    public function toanha(): BelongsTo
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }
}
