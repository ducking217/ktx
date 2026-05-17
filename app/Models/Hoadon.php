<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Hoadon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hoadon';

    public const LOAI_MONTHLY = 'monthly';
    public const LOAI_DIEN_NUOC = 'dien_nuoc';
    public const LOAI_DEPOSIT = 'deposit';
    public const LOAI_REFUND  = 'refund';
    public const LOAI_EXTRA   = 'extra';
    public const LOAI_PENALTY = self::LOAI_EXTRA;

    protected $fillable = [
        'hopdong_id',
        'phong_id',
        'ma_hoa_don',
        'loai_hoadon',
        'tien_phong',
        'tien_dien',
        'tien_nuoc',
        'phi_dich_vu',
        'tong_tien',
        'trang_thai',
        'ngay_het_han',
        'ngay_thanh_toan',
        'ghi_chu',
    ];

    protected $casts = [
        'hopdong_id' => 'integer',
        'phong_id' => 'integer',
        'tien_phong' => 'integer',
        'tien_dien' => 'integer',
        'tien_nuoc' => 'integer',
        'phi_dich_vu' => 'integer',
        'tong_tien' => 'integer',
        'trang_thai' => InvoiceStatus::class,
        'ngay_het_han' => 'date',
        'ngay_thanh_toan' => 'date',
    ];

    public function hopdong()
    {
        return $this->belongsTo(Hopdong::class, 'hopdong_id');
    }

    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function thanh_toans()
    {
        return $this->hasMany(ThanhToan::class, 'hoadon_id');
    }

    public function giao_dich_gan_nhat()
    {
        return $this->hasOne(ThanhToan::class, 'hoadon_id')->latestOfMany('ngay_giao_dich');
    }

    public function giao_dich_tu_choi_gan_nhat()
    {
        return $this->hasOne(ThanhToan::class, 'hoadon_id')
            ->whereNotNull('nguoi_xac_nhan')
            ->where('ghi_chu', 'like', '%Từ chối:%')
            ->latestOfMany('ngay_giao_dich');
    }

    public function getLoaiHoadonLabelAttribute(): string
    {
        return match ((string) $this->loai_hoadon) {
            self::LOAI_MONTHLY => 'Tiền thuê tháng',
            self::LOAI_DEPOSIT => 'Tiền cọc',
            self::LOAI_REFUND => 'Hoàn cọc',
            self::LOAI_EXTRA => 'Phát sinh',
            default => 'Phát sinh',
        };
    }

    /**
     * Chuyển đổi trạng thái hóa đơn.
     */
    public function transitionTo(string $newStatus): bool
    {
        $data = ['trang_thai' => $newStatus];

        // Nếu chuyển sang paid thì bắt buộc có ngày thanh toán để khớp DB check constraint.
        if ($newStatus === InvoiceStatus::Paid->value && $this->ngay_thanh_toan === null) {
            $data['ngay_thanh_toan'] = Carbon::now();
        }

        return $this->update($data);
    }
}
