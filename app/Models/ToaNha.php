<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToaNha extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'toa_nhas';

    protected $fillable = [
        'ten_toa_nha',
        'ma_toa_nha',
        'mo_ta',
    ];

    public function danhsachphong(): HasMany
    {
        return $this->hasMany(Phong::class, 'toa_nha_id');
    }

    public function danhsachuser(): HasMany
    {
        return $this->hasMany(User::class, 'toa_nha_id');
    }
}
