<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taisan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'taisan';

    protected $fillable = [
        'phong_id',
        'ten_tai_san',
        'ma_tai_san',
        'so_luong',
        'tinh_trang',
    ];

    protected $casts = [
        'phong_id' => 'integer',
        'so_luong' => 'integer',
    ];

    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function getTentaisanAttribute(): string
    {
        return $this->attributes['ten_tai_san'] ?? 'N/A';
    }

    public function getSoluongAttribute(): int
    {
        return (int) ($this->attributes['so_luong'] ?? 0);
    }

    public function getTinhtrangAttribute(): string
    {
        return (string) ($this->attributes['tinh_trang'] ?? 'N/A');
    }
}
