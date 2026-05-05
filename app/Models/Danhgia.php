<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Danhgia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'danhgia';

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'rating',
        'binh_luan',
        'diem',
        'noidung',
        'ngaydanhgia',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function getDiemAttribute(): int
    {
        return (int) ($this->attributes['rating'] ?? 0);
    }

    public function setDiemAttribute($value): void
    {
        $this->attributes['rating'] = (int) $value;
    }

    public function getNoidungAttribute(): ?string
    {
        return $this->attributes['binh_luan'] ?? null;
    }

    public function setNoidungAttribute($value): void
    {
        $this->attributes['binh_luan'] = $value;
    }

    public function getNgayDanhGiaAttribute(): ?string
    {
        return $this->created_at?->toDateString();
    }

    public function setNgayDanhGiaAttribute($value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $this->attributes['created_at'] = $value;
    }
}
