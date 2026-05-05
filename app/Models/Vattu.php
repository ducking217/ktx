<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vattu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vattu';

    protected $fillable = [
        'phong_id',
        'ten_vat_tu',
        'so_luong',
        'tinh_trang',
        'mo_ta',
        'ngay_mua',
        'thoi_gian_bao_hanh',
    ];

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function danhsachlichsubaotri(): HasMany
    {
        return $this->hasMany(Lichsubaotri::class, 'vattu_id');
    }

    public function getTenvattuAttribute(): string
    {
        return $this->attributes['ten_vat_tu'] ?? 'N/A';
    }

    public function getSoluongAttribute(): int
    {
        return (int) ($this->attributes['so_luong'] ?? 0);
    }

    public function getTinhtrangAttribute(): string
    {
        return (string) ($this->attributes['tinh_trang'] ?? 'N/A');
    }

    public function getMotaAttribute(): ?string
    {
        return $this->attributes['mo_ta'] ?? null;
    }
}
