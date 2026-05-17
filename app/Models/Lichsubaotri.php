<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lichsubaotri extends Model
{
    use HasFactory;

    public const STATUS_DONE = 'done';

    protected $table = 'lich_su_bao_tri';

    protected $fillable = [
        'vattu_id',
        'phong_id',
        'ngay_bao_tri',
        'noi_dung',
        'chi_phi',
        'don_vi_thuc_hien',
        'nguoi_thuc_hien',
        'trang_thai',
    ];

    public function vattu(): BelongsTo
    {
        return $this->belongsTo(Vattu::class, 'vattu_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
}
