<?php

namespace App\Models;

use App\Enums\BaohongStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baohong extends Model
{
    use HasFactory, SoftDeletes;

    public const PAYER_STUDENT = 'sinhvien';
    public const SEVERITY_LOW = 'low';

    protected $table = 'baohong';

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'giuong_id',
        'taisan_id',
        'mo_ta',
        'hinh_anh_path',
        'trang_thai',
        'muc_do',
        'chi_phi_du_kien',
        'nguoi_chiu_phi',
    ];

    protected $casts = [
        'sinhvien_id' => 'integer',
        'phong_id' => 'integer',
        'giuong_id' => 'integer',
        'taisan_id' => 'integer',
        'trang_thai' => BaohongStatus::class,
        'muc_do' => 'string',
        'chi_phi_du_kien' => 'integer',
    ];

    public function sinhvien()
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function giuong()
    {
        return $this->belongsTo(Giuong::class, 'giuong_id');
    }

    public function taisan()
    {
        return $this->belongsTo(Taisan::class, 'taisan_id');
    }
}
