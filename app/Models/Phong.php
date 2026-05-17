<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phong extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'phong';

    protected $fillable = [
        'toa_nha_id',
        'loai_phong_id',
        'ten_phong',
        'tang',
        'gioi_tinh_han_che',
        'trang_thai',
    ];

    protected $casts = [
        'toa_nha_id' => 'integer',
        'loai_phong_id' => 'integer',
        'tang' => 'integer',
        'gioi_tinh_han_che' => Gender::class,
    ];

    public function toanha()
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }

    public function loaiphong()
    {
        return $this->belongsTo(LoaiPhong::class, 'loai_phong_id');
    }

    public function giuongs()
    {
        return $this->hasMany(Giuong::class, 'phong_id');
    }

    public function taisans()
    {
        return $this->hasMany(Taisan::class, 'phong_id');
    }

    public function vattus()
    {
        return $this->hasMany(Vattu::class, 'phong_id');
    }

    public function baohongs()
    {
        return $this->hasMany(Baohong::class, 'phong_id');
    }

    public function getTenphongAttribute()
    {
        return $this->attributes['ten_phong'] ?? 'N/A';
    }

    public function getToaAttribute()
    {
        return $this->toanha?->ten_toa_nha ?? 'N/A';
    }

    public function getGiaphongAttribute()
    {
        return $this->loaiphong?->gia_thang ?? 0;
    }

    public function getGioitinhAttribute()
    {
        return $this->gioi_tinh_han_che?->label() ?? 'N/A';
    }

    public function getSucchuamaxAttribute()
    {
        return $this->loaiphong?->suc_chua ?? 0;
    }

    /**
     * CẢNH BÁO: Không dùng trong vòng lặp danh sách (ví dụ: Landing list) vì sẽ gây N+1 query.
     * Hãy preload số đếm bằng withCount() trong query và dùng attribute đã đếm sẵn.
     */
    public function getDangoAttribute()
    {
        return $this->giuongs()->where('trang_thai', \App\Enums\BedStatus::Occupied)->count();
    }
}
