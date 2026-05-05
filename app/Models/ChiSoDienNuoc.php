<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiSoDienNuoc extends Model
{
    use HasFactory;

    protected $table = 'chi_so_dien_nuoc';

    protected $fillable = [
        'phong_id',
        'loai',
        'chi_so_cu',
        'chi_so_moi',
        'thang',
        'nam',
    ];

    protected $casts = [
        'phong_id' => 'integer',
        'chi_so_cu' => 'integer',
        'chi_so_moi' => 'integer',
        'thang' => 'integer',
        'nam' => 'integer',
    ];

    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
    
    public function getSuDungAttribute()
    {
        return $this->chi_so_moi - $this->chi_so_cu;
    }
}
