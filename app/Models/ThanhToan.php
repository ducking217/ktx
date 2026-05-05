<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    use HasFactory;

    protected $table = 'thanh_toan';

    protected $fillable = [
        'hoadon_id',
        'nguoi_xac_nhan',
        'phuong_thuc',
        'ma_giao_dich',
        'so_tien',
        'ngay_giao_dich',
        'ghi_chu',
    ];

    protected $casts = [
        'hoadon_id' => 'integer',
        'nguoi_xac_nhan' => 'integer',
        'so_tien' => 'integer',
        'ngay_giao_dich' => 'datetime',
    ];

    public function hoadon()
    {
        return $this->belongsTo(Hoadon::class, 'hoadon_id');
    }
}
