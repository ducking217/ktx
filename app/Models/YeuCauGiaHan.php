<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ExtensionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class YeuCauGiaHan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'yeu_cau_gia_han';

    protected $fillable = [
        'hopdong_id',
        'sinhvien_id',
        'ngay_ket_thuc_moi',
        'ly_do',
        'trang_thai',
        'ghi_chu_admin',
    ];

    protected $casts = [
        'ngay_ket_thuc_moi' => 'date',
        'trang_thai' => ExtensionStatus::class,
    ];

    public function hopdong(): BelongsTo
    {
        return $this->belongsTo(Hopdong::class, 'hopdong_id');
    }

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }
}

