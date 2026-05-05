<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToaNha extends Model
{
    use HasFactory;

    protected $table = 'toa_nha';

    protected $fillable = [
        'ten_toa_nha',
        'ma_toa_nha',
        'gioi_tinh',
        'dia_chi',
        'mo_ta',
        'so_phong',
        'so_tang',
    ];

    protected $casts = [
        'so_phong' => 'integer',
        'so_tang' => 'integer',
        'gioi_tinh' => Gender::class,
    ];

    public function phongs()
    {
        return $this->hasMany(Phong::class, 'toa_nha_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'toa_nha_id');
    }
}
