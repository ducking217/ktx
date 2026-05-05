<?php

namespace App\Models;

use App\Enums\DisciplineLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kyluat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kyluat';

    protected $fillable = [
        'sinhvien_id',
        'tieu_de',
        'noi_dung',
        'muc_do',
        'ngay_vi_pham',
        'hinh_thuc_xu_ly',
    ];

    protected $casts = [
        'sinhvien_id' => 'integer',
        'muc_do' => DisciplineLevel::class,
        'ngay_vi_pham' => 'date',
    ];

    public function sinhvien()
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }
}
