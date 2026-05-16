<?php

namespace App\Models;

use App\Enums\ContractStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hopdong extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hopdong';

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'giuong_id',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'gia_thuc_te',
        'tien_coc',
        'trang_thai',
        'ghi_chu',
    ];

    protected $casts = [
        'sinhvien_id' => 'integer',
        'phong_id' => 'integer',
        'giuong_id' => 'integer',
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'gia_thuc_te' => 'integer',
        'tien_coc' => 'integer',
        'trang_thai' => ContractStatus::class,
    ];

    public function getGhichuAttribute(): ?string
    {
        return $this->attributes['ghi_chu'] ?? null;
    }

    public function setGhichuAttribute(mixed $value): void
    {
        $this->attributes['ghi_chu'] = $value;
    }

    public function getMaHdAttribute(): ?string
    {
        if (!$this->id) {
            return null;
        }

        return 'HD-' . str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    public function sinhvien()
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function giuong()
    {
        return $this->belongsTo(Giuong::class, 'giuong_id');
    }

    public function hoadons()
    {
        return $this->hasMany(Hoadon::class, 'hopdong_id');
    }

    // ─── Compatibility Helpers ────────────────────────────────────────────────

    /**
     * Truy xuất Phong thông qua Giuong.
     * @deprecated Dùng ->giuong->phong thay thế.
     */
    public function getPhongAttribute(): ?Phong
    {
        return $this->relationLoaded('giuong') ? $this->giuong?->phong : $this->giuong?->phong;
    }

    /**
     * Alias để Eager Load: with('phong') → đổi thành with('giuong.phong').
     * Dùng cho các chỗ cũ eager-load 'phong' trực tiếp trên hopdong.
     */
    public function phong()
    {
        return $this->hasOneThrough(
            Phong::class,
            Giuong::class,
            'id',        // giuong.id
            'id',        // phong.id
            'giuong_id', // hopdong.giuong_id
            'phong_id'   // giuong.phong_id
        );
    }

    /**
     * Chuyển đổi trạng thái hợp đồng.
     */
    public function transitionTo(string $newStatus): bool
    {
        return $this->update(['trang_thai' => $newStatus]);
    }
}
