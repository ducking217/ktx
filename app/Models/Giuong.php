<?php

namespace App\Models;

use App\Enums\BedStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Giuong extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'giuong';

    protected $fillable = [
        'phong_id',
        'ma_giuong',
        'trang_thai',
    ];

    protected $casts = [
        'phong_id' => 'integer',
        'trang_thai' => BedStatus::class,
    ];

    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function hopdongs()
    {
        return $this->hasMany(Hopdong::class, 'giuong_id');
    }

    public function current_hopdong()
    {
        return $this->hasOne(Hopdong::class, 'giuong_id')->where('trang_thai', 'active');
    }
}
