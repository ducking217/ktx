<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thongbao extends Model
{
    use HasFactory;

    protected $table = 'thongbao';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'loai_thong_bao',
        'doi_tuong_nhan',
    ];

    protected $casts = [
        'doi_tuong_nhan' => 'string',
    ];
}
