<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phong extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'phong';

    protected $fillable = [
        'tenphong',
        'tang',
        'giaphong',
        'soluongtoida',
        'succhuamax',
        'dango',
        'mota',
        'gioitinh',
        'toa_nha_id',
    ];

    /**
     * Đồng bộ hóa soluongtoida và succhuamax
     * Ưu tiên sử dụng succhuamax làm nguồn chính
     */
    public function getSoluongtoidaAttribute(): int
    {
        return (int) ($this->attributes['succhuamax'] ?? ($this->attributes['soluongtoida'] ?? 0));
    }

    public function setSoluongtoidaAttribute($value): void
    {
        $this->attributes['soluongtoida'] = $value;
        $this->attributes['succhuamax'] = $value;
    }

    public function getSucchuamaxAttribute(): int
    {
        return (int) ($this->attributes['succhuamax'] ?? ($this->attributes['soluongtoida'] ?? 0));
    }

    public function setSucchuamaxAttribute($value): void
    {
        $this->attributes['succhuamax'] = $value;
        $this->attributes['soluongtoida'] = $value;
    }

    public function danhsachsinhvien(): HasMany
    {
        return $this->hasMany(Sinhvien::class, 'phong_id');
    }

    public function danhsachhoadon(): HasMany
    {
        return $this->hasMany(Hoadon::class, 'phong_id');
    }

    public function danhsachdangky(): HasMany
    {
        return $this->hasMany(Dangky::class, 'phong_id');
    }

    public function danhsachtaisan(): HasMany
    {
        return $this->hasMany(Taisan::class, 'phong_id');
    }

    public function danhsachvattu(): HasMany
    {
        return $this->hasMany(Vattu::class, 'phong_id');
    }

    public function danhsachhopdong(): HasMany
    {
        return $this->hasMany(Hopdong::class, 'phong_id');
    }

    public function getSoNguoiDangOAttribute(): int
    {
        if (array_key_exists('danhsachsinhvien_count', $this->attributes)) {
            return (int) $this->attributes['danhsachsinhvien_count'];
        }

        if ($this->relationLoaded('danhsachsinhvien')) {
            return $this->danhsachsinhvien->count();
        }

        return $this->danhsachsinhvien()->count();
    }

    public function toanha()
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }
}
