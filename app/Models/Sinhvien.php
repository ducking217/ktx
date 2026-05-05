<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sinhvien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sinhvien';

    protected $fillable = [
        'user_id',
        'ma_sinh_vien',
        'lop',
        'khoa',
        'ngay_nhap_hoc',
        'anh_the_path',
        'anh_cccd_path',
    ];

    protected $casts = [
        'user_id'       => 'integer',
        'ngay_nhap_hoc' => 'date',
    ];

    // ─── Core Relationships ────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hopdongs()
    {
        return $this->hasMany(Hopdong::class, 'sinhvien_id');
    }

    public function current_hopdong()
    {
        return $this->hasOne(Hopdong::class, 'sinhvien_id')
            ->where('trang_thai', \App\Enums\ContractStatus::Active->value);
    }

    public function baohongs()
    {
        return $this->hasMany(Baohong::class, 'sinhvien_id');
    }

    public function kyluats()
    {
        return $this->hasMany(Kyluat::class, 'sinhvien_id');
    }

    public function danhgias()
    {
        return $this->hasMany(Danhgia::class, 'sinhvien_id');
    }

    public function dangkys()
    {
        return $this->hasMany(Dangky::class, 'user_id', 'user_id');
    }

    // ─── Compatibility Aliases (Strangler Fig Pattern) ────────────────────────

    /**
     * @deprecated Dùng ->user thay thế
     */
    public function taikhoan()
    {
        return $this->user();
    }

    /**
     * Alias đồng nhất cho masinhvien (v1) và ma_sinh_vien (v2).
     * PHP method names are case-insensitive, so we use one canonical accessor.
     */
    public function getMaSinhVienAttribute($value): ?string
    {
        // Ưu tiên giá trị truyền vào (từ DB column ma_sinh_vien), 
        // sau đó thử lấy từ attribute raw nếu code legacy gán vào key cũ.
        return $value ?? $this->attributes['ma_sinh_vien'] ?? $this->attributes['masinhvien'] ?? null;
    }

    /**
     * @deprecated Dùng ->user->phone thay thế
     */
    public function getSodienthoaiAttribute(): ?string
    {
        return $this->user?->phone;
    }

    /**
     * @deprecated Dùng ->user->gender thay thế
     */
    public function getGioitinhAttribute()
    {
        return $this->user?->gender?->label();
    }

    /**
     * @deprecated Dùng ->phong_hien_tai() thay thế
     */
    public function getPhongAttribute()
    {
        return $this->phong_hien_tai();
    }

    /**
     * Lấy phòng hiện tại của sinh viên thông qua chuỗi Hopdong → Giuong → Phong.
     */
    public function phong_hien_tai(): ?Phong
    {
        return $this->current_hopdong?->giuong?->phong;
    }
}
