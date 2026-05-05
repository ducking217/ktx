<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiPhong extends Model
{
    use HasFactory;

    protected $table = 'loai_phong';

    protected $fillable = [
        'ten_loai',
        'suc_chua',
        'gia_thang',
        'tien_nghi',
    ];

    protected $casts = [
        'suc_chua' => 'integer',
        'gia_thang' => 'integer',
        'tien_nghi' => 'array',
    ];

    public function phongs()
    {
        return $this->hasMany(Phong::class, 'loai_phong_id');
    }
}
