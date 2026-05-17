<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dangky extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dangky';

    public const GHI_CHU_TRA_PHONG = 'TRA_PHONG';
    public const GHI_CHU_TRA_PHONG_PREFIX = self::GHI_CHU_TRA_PHONG . '%';

    protected $fillable = [
        'user_id',
        'ho_ten',
        'email',
        'phone_encrypted',
        'id_card_encrypted',
        'gender',
        'dob',
        'anh_the_path',
        'anh_cccd_path',
        'toa_nha_id',
        'loai_phong_id',
        'phong_id',
        'trang_thai',
        'ghi_chu',
        'lookup_token',
        'token_expires_at',
    ];

    protected $hidden = [
        'phone_encrypted',
        'id_card_encrypted',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'toa_nha_id' => 'integer',
        'loai_phong_id' => 'integer',
        'phong_id' => 'integer',
        'dob' => 'date',
        'token_expires_at' => 'datetime',
        'trang_thai' => RegistrationStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toanha()
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }

    public function loaiphong()
    {
        return $this->belongsTo(LoaiPhong::class, 'loai_phong_id');
    }

    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function getSoDienThoaiAttribute()
    {
        try {
            return $this->phone_encrypted ? decrypt($this->phone_encrypted) : null;
        } catch (\Exception $e) {
            return $this->phone_encrypted;
        }
    }

    public function getCccdAttribute()
    {
        try {
            return $this->id_card_encrypted ? decrypt($this->id_card_encrypted) : null;
        } catch (\Exception $e) {
            return $this->id_card_encrypted;
        }
    }

    /**
     * Chuyển đổi trạng thái đơn đăng ký.
     */
    public function transitionTo(string $newStatus, ?string $reason = null): bool
    {
        $data = ['trang_thai' => $newStatus];
        if ($reason) {
            $data['ghi_chu'] = $reason;
        }
        return $this->update($data);
    }
}
